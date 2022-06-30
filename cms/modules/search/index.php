<?php
defined('IN_CMS') or exit('No permission resources.');
if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists'));
pc_base::load_sys_class('form','',0);
pc_base::load_sys_class('format','',0);
class index {
    function __construct() {
        $this->input = pc_base::load_sys_class('input');
        $this->db = pc_base::load_model('search_model');
        $this->content_db = pc_base::load_model('content_model');
    }

    /**
     * 关键词搜索
     */
    public function init() {
        //获取siteid
        $siteid = $this->input->request('siteid') && trim($this->input->request('siteid')) ? intval($this->input->request('siteid')) : 1;
        $SEO = seo($siteid);

        //搜索配置
        $search_setting = getcache('search');
        $setting = $search_setting[$siteid];

        $search_model = getcache('search_model_'.$siteid);
        $type_module = getcache('type_module_'.$siteid);
        $sitelist  = getcache('sitelist','commons');
        $default_style = $sitelist[$siteid]['default_style'];

        if($this->input->get('q')) {
            if(!trim($this->input->get('q'))) {
                header('Location: '.APP_PATH.'index.php?m=search');exit;
            }
            $typeid = empty($this->input->get('typeid')) ? 0 : intval($this->input->get('typeid'));
            $time = empty($this->input->get('time')) || !in_array($this->input->get('time'),array('all','day','month','year','week')) ? 'all' : trim($this->input->get('time'));
            $page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
            $pagesize = 10;
            $q = safe_replace(trim($this->input->get('q')));
            $q = new_html_special_chars(clearhtml($q));
            $q = str_replace('%', '', $q); //过滤'%'，用户全文搜索
            $search_q = $q; //搜索原内容
            $sql_time = $sql_tid = '';
            if($typeid) $sql_tid = ' AND typeid = '.$typeid;
            //按时间搜索
            if($time == 'day') {
                $search_time = SYS_TIME - 86400;
                $sql_time = ' AND adddate > '.$search_time;
            } elseif($time == 'week') {
                $search_time = SYS_TIME - 604800;
                $sql_time = ' AND adddate > '.$search_time;
            } elseif($time == 'month') {
                $search_time = SYS_TIME - 2592000;
                $sql_time = ' AND adddate > '.$search_time;
            } elseif($time == 'year') {
                $search_time = SYS_TIME - 31536000;
                $sql_time = ' AND adddate > '.$search_time;
            } else {
                $search_time = 0;
                $sql_time = '';
            }
            if($page==1 && !$setting['sphinxenable']) {
                //精确搜索
                $commend = $this->db->get_one("`siteid`= '$siteid' $sql_tid $sql_time AND `data` like '%".$this->db->escape($q)."%'");
            } else {
                $commend = '';
            }
            //如果开启sphinx
            if($setting['sphinxenable']) {
                $sphinx = pc_base::load_app_class('search_interface', '', 0);
                $sphinx = new search_interface();

                $offset = $pagesize*($page-1);
                $res = $sphinx->search($q, array($siteid), array($typeid), array($search_time, SYS_TIME), $offset, $pagesize, '@weight desc');
                $totalnums = $res['total'];
                //如果结果不为空
                if(!empty($res['matches'])) {
                    $result = $res['matches'];
                }
            } else {
                pc_base::load_sys_class('segment', '', 0);
                $segment = new segment();
                //分词结果
                $segment_q = $segment->get_keyword($segment->split_result($q));
                //如果分词结果为空
                if(!empty($segment_q)) {
                    $sql = "`siteid`= '$siteid' AND `typeid` = '$typeid' $sql_time AND MATCH (`data`) AGAINST ('$segment_q' IN BOOLEAN MODE)";
                } else {
                    $sql = "`siteid`= '$siteid' $sql_tid $sql_time AND `data` like '%".$this->db->escape($q)."%'";
                }
                $result = $this->db->listinfo($sql, 'searchid DESC', $page, 10);
            }
            //var_dump($result);
            //如果结果不为空
            if(!empty($result) || !empty($commend['id'])) {
                foreach($result as $_v) {
                    if($_v['typeid']) $sids[$_v['typeid']][] = $_v['id'];
                }

                if(!empty($commend['id'])) {
                    if($commend['typeid']) $sids[$commend['typeid']][] = $commend['id'];
                }
                $model_type_cache = getcache('type_model_'.$siteid,'search');
                $model_type_cache = array_flip($model_type_cache);
                $data = array();
                foreach($sids as $_k=>$_val) {
                    $tid = $_k;
                    $ids = array_unique($_val);

                    $where = to_sqls($ids, '', 'id');
                    //获取模型id
                    $modelid = $model_type_cache[$tid];

                    //是否读取其他模块接口
                    if($modelid) {
                        $this->content_db->set_model($modelid);

                        /**
                         * 如果表名为空，则为黄页模型
                         */
                        if(empty($this->content_db->model_tablename)) {
                            $this->content_db = pc_base::load_model('yp_content_model');
                            $this->content_db->set_model($modelid);
                        } else {
                            if ($where) {
                                $where .= ' and status=99';
                            } else {
                                $where = 'status=99';
                            }
                        }
                        $datas = $this->content_db->select($where, '*', '', 'id DESC');
                    } else {
                        //读取专题搜索接口
                        $this->special_db = pc_base::load_model('special_content_model');
                        $datas = $this->special_db->select($where, '*', '', 'id DESC');
                    }
                    $datas && $data = array_merge($data,$datas);
                }

                $pages = $this->db->pages;
                $totalnums = $this->db->number;
            }
            $execute_time = execute_time();
            $pages = isset($pages) ? $pages : '';
            $totalnums = isset($totalnums) ? $totalnums : 0;
            $data = isset($data) ? $data : '';

            if (is_mobile($siteid) && $sitelist[$siteid]['mobileauto'] || defined('IS_MOBILE') && IS_MOBILE) {
                if (!file_exists(PC_PATH.'templates'.DIRECTORY_SEPARATOR.$default_style.DIRECTORY_SEPARATOR.'mobile_search'.DIRECTORY_SEPARATOR.'list.html')) {
                    include template('search','list',$default_style);
                } else {
                    if ($sitelist[$siteid]['mobile_domain']) {
                        //header('location:'.$sitelist[$siteid]['mobile_domain']);
                        //exit;
                    }
                    pc_base::load_app_func('global','mobile');
                    include template('mobile_search','list',$default_style);
                }
            }else{
                include template('search','list',$default_style);
            }
        } else {
            if (is_mobile($siteid) && $sitelist[$siteid]['mobileauto'] || defined('IS_MOBILE') && IS_MOBILE) {
                if (!file_exists(PC_PATH.'templates'.DIRECTORY_SEPARATOR.$default_style.DIRECTORY_SEPARATOR.'mobile_search'.DIRECTORY_SEPARATOR.'index.html')) {
                    include template('search','index',$default_style);
                } else {
                    if ($sitelist[$siteid]['mobile_domain']) {
                        //header('location:'.$sitelist[$siteid]['mobile_domain']);
                        //exit;
                    }
                    pc_base::load_app_func('global','mobile');
                    include template('mobile_search','index',$default_style);
                }
            }else{
                include template('search','index',$default_style);
            }
        }
    }

    public function public_get_suggest_keyword() {
        $url = $this->input->get('url').'&q='.$this->input->get('q');
        $trust_url = array('c8430fcf851e85818b546addf5bc4dd3');
        $urm_md5 = md5($url);
        if (!in_array($urm_md5, $trust_url)) exit;

        $res = @file_get_contents($url);
        if(CHARSET != 'gbk') {
            $res = iconv('gbk', CHARSET, $res);
        }
        echo $res;
    }

    /**
     * 提示搜索接口
     * TODO 暂时未启用，用的是google的接口
     */
    public function public_suggest_search() {
        //关键词转换为拼音
        pc_base::load_sys_func('iconv');
        $pinyin = gbk_to_pinyin($q);
        if(is_array($pinyin)) {
            $pinyin = implode('', $pinyin);
        }
        $this->keyword_db = pc_base::load_model('search_keyword_model');
        $suggest = $this->keyword_db->select("pinyin like '$pinyin%'", '*', 10, 'searchnums DESC');

        foreach($suggest as $v) {
            echo $v['keyword']."\n";
        }

    }
}
?>