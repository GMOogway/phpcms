<?php
/**
 * 列表格式化函数库
 */

class function_list {

    protected $uid_data = array();
    protected $cid_data = array();

    // 用于列表显示栏目
    public function catid($catid, $param = array(), $data = array()) {

        $url = IS_ADMIN ? '' : dr_cat_value($catid, 'url').'" target="_blank';
        $value = dr_cat_value($catid, 'catname');

        return '<a href="'.$url.'">'.str_cut($value, 10).'</a>';
    }

    // 用于列表显示标题
    public function title($value, $param = array(), $data = array()) {

        $value = htmlspecialchars(clearhtml($value));
        $title = ($data['thumb'] ? '<i class="fa fa-photo"></i> ' : '').dr_keyword_highlight(str_cut($value, 30), $param['keyword']);
        !$title && $title = '...';

        return isset($data['url']) && $data['url'] ? ('<a href="'.$data['url'].'" target="_blank" class="tooltips" data-container="body" data-placement="top" data-original-title="'.$value.'" title="'.$value.'">'.$title.'</a>') : $title;
    }

    // 用于列表显示内容
    public function content($value, $param = array(), $data = array()) {

        $value = htmlspecialchars(clearhtml($value));
        $title = dr_keyword_highlight(str_cut($value, 30), $param['keyword']);
        !$title && $title = '...';

        return isset($data['url']) && $data['url'] ? '<a href="'.$data['url'].'" target="_blank" class="tooltips" data-container="body" data-placement="top" data-original-title="'.$value.'" title="'.$value.'">'.$title.'</a>' : $title;
    }

    // 用于列表显示联动菜单值
    public function linkage_address($value, $param = array(), $data = array()) {
        if (!$value) {
            return '';
        }
        return get_linkage($value, 1);
    }

    // 用于列表显示时间日期格式
    public function datetime($value, $param = array(), $data = array()) {
        return dr_date($value, null, 'red');
    }

    // 用于列表显示日期格式
    public function date($value, $param = array(), $data = array()) {
        return dr_date($value, 'Y-m-d', 'red');
    }

    // 用于列表显示作者
    public function author($value, $param = array(), $data = array()) {
        if (!$value) {
            return L('游客');
        }
        return $value ? str_cut($value, 10) : L('游客');
    }

    // 用于列表显示作者
    public function userid($userid, $param = array(), $data = array()) {
        // 查询username
        if (strlen($userid) > 12) {
            return L('游客');
        }
        $this->admin_db = pc_base::load_model('admin_model');
        $this->member_db = pc_base::load_model('member_model');
        $userinfo = $this->admin_db->get_one(array('userid'=>$userid));
        $username = $userinfo['realname'] ? $userinfo['realname'] : $userinfo['username'];
        if (!$userinfo) {
            $userinfo = $this->member_db->get_one(array('userid'=>$userid));
            $username = $userinfo['nickname'] ? $userinfo['nickname'] : $userinfo['username'];
        }
        $this->uid_data[$userid] = isset($this->uid_data[$userid]) && $this->uid_data[$userid] ? $this->uid_data[$userid] : $username;
        return $this->uid_data[$userid] ? str_cut($this->uid_data[$userid], 10) : L('游客');
    }

    // 用于列表显示ip地址
    public function ip($value, $param = array(), $data = array()) {
        $ip_area = pc_base::load_sys_class('ip_area');
        if ($value) {
            list($value) = explode('-', $value);
            return '<a href="https://www.baidu.com/s?wd='.$value.'&action=cms" target="_blank">'.str_cut($ip_area->address($value), 20).'</a>';
        }
        return L('无');
    }

    // url链接输出
    public function url($value, $param = array(), $data = array()) {
        return '<a href="'.$value.'" target="_blank">'.$value.'</a>';
    }

    // 用于列表显示图片专用
    public function image($value, $param = array(), $data = array()) {

        if ($value) {
            $file = get_attachment($value);
            if ($file) {
                $value = $file['url'];
            }
            $url = 'javascript:dr_preview_image(\''.$value.'\');';
            return '<a class="thumbnail" style="display: inherit;" href="'.$url.'"><img style="width:30px" src="'.thumb($value, 100, 100).'"></a>';
        }

        return L('无');
    }

    // 用于列表显示多文件
    public function files($value, $param = array(), $data = array()) {

        if ($value) {
            $rt = array();
            $arr = dr_get_files($value);
            foreach ($arr as $t) {
                $file = get_attachment($t['fileurl']);
                if ($file) {
                    $value = $file['url'];
                } else {
                    $value = $t;
                }
                $ext = trim(strtolower(strrchr($value, '.')), '.');
                if (dr_is_image($ext)) {
                    $url = 'javascript:dr_preview_image(\''.$value.'\');';
                    $rt[] = '<a href="'.$url.'"><img src="'.IMG_PATH.'ext/jpg.png'.'"></a>';
                } elseif (is_file(CMS_PATH.'statics/images/ext/'.$ext.'.png')) {
                    $file = IMG_PATH.'ext/'.$ext.'.png';
                    $url = 'javascript:dr_preview_url(\''.dr_file($value).'\');';
                    $rt[] = '<a href="'.$url.'"><img src="'.$file.'"></a>';
                } elseif (strpos($value, 'http://') === 0) {
                    $file = IMG_PATH.'ext/url.png';
                    $url = 'javascript:dr_preview_url(\''.$value.'\');';
                    $rt[] = '<a href="'.$url.'"><img src="'.$file.'"></a>';
                } else {
                    $rt[] = $value;
                }
            }
            return implode('', $rt);
        }

        return L('无');
    }

    // 用于列表显示单文件
    public function file($value, $param = array(), $data = array()) {
        if ($value) {
            $file = get_attachment($value);
            if ($file) {
                $value = $file['url'];
            }
            $ext = trim(strtolower(strrchr($value, '.')), '.');
            if (dr_is_image($ext)) {
                $url = 'javascript:dr_preview_image(\''.$value.'\');';
                return '<a href="'.$url.'"><img src="'.IMG_PATH.'ext/jpg.png'.'"></a>';
            } elseif (is_file(CMS_PATH.'statics/images/ext/'.$ext.'.png')) {
                $file = IMG_PATH.'assets/images/ext/'.$ext.'.png';
                $url = 'javascript:dr_preview_url(\''.dr_file($value).'\');';
                return '<a href="'.$url.'"><img src="'.$file.'"></a>';
            } elseif (strpos($value, 'http://') === 0) {
                $file = IMG_PATH.'assets/images/ext/url.png';
                $url = 'javascript:dr_preview_url(\''.$value.'\');';
                return '<a href="'.$url.'"><img src="'.$file.'"></a>';
            } else {
                return $value;
            }
        }
        return L('无');
    }

    // 用于列表显示用户组
    public function group($value, $param = array(), $data = array()) {

        $user = dr_member_info($value);
        if ($user && $user['groupid']) {
            $rt =getcache('grouplist', 'member');
            return $rt[$user['groupid']]['name'] ? $rt[$user['groupid']]['name'] : L('无');
        }

        return L('无');
    }

    // 用于列表显示价格
    public function price($value, $param = array(), $data = array()) {
        return '<span style="color:#ef4c2f">￥'.number_format($value, 2).'</span>';
    }

    // 用于列表显示价格
    public function money($value, $param = array(), $data = array(), $field = array()) {
        return '<span style="color:#ef4c2f">'.number_format($value, 2).'</span>';
    }

    // 用于列表显示积分
    public function score($value, $param = array(), $data = array(), $field = array()) {
        return '<span style="color:#2f5fef">'.intval($value).'</span>';
    }

    // 单选字段name
    public function radio_name($value, $param = array(), $data = array(), $field = array()) {

        if ($field) {
            $options = dr_format_option_array($field['setting']['option']['options']);
            if ($options && isset($options[$value])) {
                return $options[$value];
            }
        }

        return $value;
    }

    // 下拉字段name值
    public function select_name($value, $param = array(), $data = array(), $field = array()) {

        if ($field) {
            $options = dr_format_option_array($field['setting']['option']['options']);
            if ($options && isset($options[$value])) {
                return $options[$value];
            }
        }

        return $value;
    }

    // checkbox字段name值
    public function checkbox_name($value, $param = array(), $data = array(), $field = array()) {

        $arr = dr_string2array($value);
        if ($field && is_array($arr)) {
            $options = dr_format_option_array($field['setting']['option']['options']);
            if ($options) {
                $rt = array();
                foreach ($options as $i => $v) {
                    if (dr_in_array($i, $arr)) {
                        $rt[] = $v;
                    }
                }
                return implode('、', $rt);
            }
        }

        return $value;
    }

    // 实时存储文本值
    public function save_text_value($value, $param = array(), $data = array(), $field = array()) {

        $m = defined('ROUTE_M') && ROUTE_M ? ROUTE_M : '';
        $c = defined('ROUTE_C') && ROUTE_C ? ROUTE_C : '';
        $url = '?m='.$m.'&c='.$c.'&a=listorder&catid='.$data['catid'].'&id='.$data['id'].'&after='; //after是回调函数
        $html = '<input type="text" class="form-control" placeholder="" value="'.htmlspecialchars($value).'" onblur="dr_ajax_save(this.value, \''.$url.'\', \''.$field['field'].'\')">';

        return $html;
    }
}