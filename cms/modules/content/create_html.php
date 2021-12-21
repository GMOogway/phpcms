<?php
defined('IN_CMS') or exit('No permission resources.');

pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);

class create_html extends admin {
	private $db;
	public $siteid,$categorys;
	public function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('content_model');
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		// 不是超级管理员
		/*if ($_SESSION['roleid']!=1) {
			dr_admin_msg(0,L('需要超级管理员账号操作'));
		}*/
	}
	
	public function update_urls() {
		$page = max(0, intval($this->input->get('page')));
		$show_header = $show_dialog  = '';
		$admin_username = param::get_cookie('admin_username');
		$this->model_db = pc_base::load_model('sitemodel_model');
		$module = $this->model_db->get_one(array('siteid'=>$this->siteid,'type'=>0,'disabled'=>0),'modelid','modelid');
		$modelid = $this->input->get('modelid') ? intval($this->input->get('modelid')) : $module['modelid'];
		
		$tables = array();
		$this->db->set_model(intval($modelid));
		$table_list = $this->db->query('show table status');
		foreach ($table_list as $t) {
			//if (strpos($t['Name'], $this->db->table_name) === 0) {
				$tables[$t['Name']] = $t;
			//}
		}
		include $this->admin_tpl('update_urls');
	}

	private function urls($id, $catid= 0, $inputtime = 0, $prefix = ''){
		$this->url = pc_base::load_app_class('url');
		$urls = $this->url->show($id, 0, $catid, $inputtime, $prefix,'','edit');
		//更新到数据库
		$url = $urls[0];
		$this->db->update(array('url'=>$url),array('id'=>$id));
		//echo $id; echo "|";
		return $urls;
	}
	/**
	* 生成内容页
	*/
	public function show() {
		// 生成权限文件
		if (!dr_html_auth(1)) {
			dr_admin_msg(0, L('/cache/html/ 无法写入文件'));
		}
		if($this->input->get('dosubmit')) {
			$modelid = intval($this->input->get('modelid'));
			$catids = $this->input->get('catids');
			$pagesize = intval($this->input->get('pagesize'));
			$fromdate = $this->input->get('fromdate');
			$todate = $this->input->get('todate');
			$fromid = intval($this->input->get('fromid'));
			$toid = intval($this->input->get('toid'));
			if ($catids && is_array($catids)) {
				$catids = implode(',', $catids);
			}
			$this->model_db = pc_base::load_model('sitemodel_model');
			$model = $this->model_db->get_one(array('siteid'=>$this->siteid,'modelid'=>$modelid));
			$modulename = $model['name'];
			$count_url = '?m=content&c=create_html&a=public_show_count&pagesize='.$pagesize.'&modelid='.$modelid.'&catids='.$catids.'&fromdate='.$fromdate.'&todate='.$todate.'&fromid='.$fromid.'&toid='.$toid;
			$todo_url = '?m=content&c=create_html&a=public_show_add&pagesize='.$pagesize.'&modelid='.$modelid.'&catids='.$catids.'&fromdate='.$fromdate.'&todate='.$todate.'&fromid='.$fromid.'&toid='.$toid;
			include $this->admin_tpl('show_html');
		} else {
			$show_header = $show_dialog  = '';
			$admin_username = param::get_cookie('admin_username');
			$this->model_db = pc_base::load_model('sitemodel_model');
			$module = $this->model_db->get_one(array('siteid'=>$this->siteid,'type'=>0,'disabled'=>0),'modelid','modelid');
			$modelid = $this->input->get('modelid') ? intval($this->input->get('modelid')) : $module['modelid'];
			
			$tree = pc_base::load_sys_class('tree');
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$categorys = array();
			if(!empty($this->categorys)) {
				foreach($this->categorys as $catid=>$r) {
					$setting = string2array($r['setting']);
					if ($setting['disabled']) continue;
					if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
					if($modelid && $modelid != $r['modelid']) continue;
					$categorys[$catid] = $r;
				}
			}
			$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";

			$tree->init($categorys);
			$string = $tree->get_tree(0, $str);
			include $this->admin_tpl('create_html_show');
		}

	}
	// 断点内容
	public function public_show_point() {
		$cache_class = pc_base::load_sys_class('cache');
		$modelid = intval($this->input->get('modelid'));
		$catids = $this->input->get('catids');
		$pagesize = intval($this->input->get('pagesize'));
		$fromdate = intval($this->input->get('fromdate'));
		$todate = $this->input->get('todate');
		$fromid = $this->input->get('fromid');
		$toid = intval($this->input->get('toid'));
		if ($catids && is_array($catids)) {
			$catids = implode(',', $catids);
		}
		$name = 'show-'.$modelid.'-html-file';
		$page = $cache_class->get_auth_data($name.'-error'); // 设置断点
		if (!$page) {
			dr_json(0, L('没有找到上次中断生成的记录'));
		}

		$this->model_db = pc_base::load_model('sitemodel_model');
		$model = $this->model_db->get_one(array('siteid'=>$this->siteid,'modelid'=>$modelid));
		$modulename = $model['name'];
		$count_url = '?m=content&c=create_html&a=public_show_point_count&pagesize='.$pagesize.'&modelid='.$modelid.'&catids='.$catids.'&fromdate='.$fromdate.'&todate='.$todate.'&fromid='.$fromid.'&toid='.$toid;
		$todo_url = '?m=content&c=create_html&a=public_show_add&pagesize='.$pagesize.'&modelid='.$modelid.'&catids='.$catids.'&fromdate='.$fromdate.'&todate='.$todate.'&fromid='.$fromid.'&toid='.$toid;
		include $this->admin_tpl('show_html');
	}
	// 断点内容的数量统计
	public function public_show_point_count() {
		$cache_class = pc_base::load_sys_class('cache');
		$modelid = intval($this->input->get('modelid'));
		$name = 'show-'.$modelid.'-html-file';
		$page = $cache_class->get_auth_data($name.'-error'); // 设置断点
		if (!$page) {
			dr_json(0, L('没有找到上次中断生成的记录'));
		} elseif (!$cache_class->get_auth_data($name)) {
			dr_json(0, L('生成记录已过期，请重新开始生成'));
		} elseif (!$cache_class->get_auth_data($name.'-'.$page)) {
			dr_json(0, L('生成记录已过期，请重新开始生成'));
		}

		dr_json(1, 'ok');
	}
	// 内容数量统计
	public function public_show_count() {
		$html = pc_base::load_sys_class('html');
		$html->get_show_data($this->input->get('modelid'), array(
			'catids' => $this->input->get('catids'),
			'todate' => $this->input->get('todate'),
			'fromdate' => $this->input->get('fromdate'),
			'toid' => $this->input->get('toid'),
			'fromid' => $this->input->get('fromid'),
			'pagesize' => $this->input->get('pagesize'),
			'siteid' => $this->siteid
		));
	}
	/**
	* 生成栏目页
	*/
	public function category() {
		// 生成权限文件
		if (!dr_html_auth(1)) {
			dr_admin_msg(0, L('/cache/html/ 无法写入文件'));
		}
		if($this->input->get('dosubmit')) {
			$catids = $this->input->get('catids');
			if ($catids && is_array($catids)) {
				$catids = implode(',', $catids);
			}
			$maxsize = $this->input->get('maxsize');
			$modulename = '栏目';
			$count_url = '?m=content&c=create_html&a=public_category_count&maxsize='.$maxsize.'&catids='.$catids;
			$todo_url = '?m=content&c=create_html&a=public_category_add&maxsize='.$maxsize.'&catids='.$catids;
			include $this->admin_tpl('show_html');
		} else {
			$show_header = $show_dialog  = '';
			$admin_username = param::get_cookie('admin_username');
			$modelid = $this->input->get('modelid') ? intval($this->input->get('modelid')) : 0;
			
			$tree = pc_base::load_sys_class('tree');
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$categorys = array();
			if(!empty($this->categorys)) {
				foreach($this->categorys as $catid=>$r) {
					$setting = string2array($r['setting']);
					if ($setting['disabled']) continue;
					if($this->siteid != $r['siteid'] || ($r['type']==2 && $r['child']==0)) continue;
					if($modelid && $modelid != $r['modelid']) continue;
					$categorys[$catid] = $r;
				}
			}
			$str  = "<option value='\$catid'>\$spacer \$catname</option>";

			$tree->init($categorys);
			$string = $tree->get_tree(0, $str);
			include $this->admin_tpl('create_html_category');
		}

	}
	// 断点生成栏目
	public function public_category_point() {
		$cache_class = pc_base::load_sys_class('cache');
		$name = 'category-html-file';
		$page = $cache_class->get_auth_data($name.'-error'); // 设置断点
		if (!$page) {
			dr_json(0, L('没有找到上次中断生成的记录'));
		}

		$catids = $this->input->get('catids');
		if ($catids && is_array($catids)) {
			$catids = implode(',', $catids);
		}

		$modulename = '栏目';
		$count_url = '?m=content&c=create_html&a=public_category_point_count&maxsize='.$maxsize.'&catids='.$catids;
		$todo_url = '?m=content&c=create_html&a=public_category_add&maxsize='.$maxsize.'&catids='.$catids;
		include $this->admin_tpl('show_html');
	}
	// 断点栏目的数量统计
	public function public_category_point_count() {
		$cache_class = pc_base::load_sys_class('cache');
		$name = 'category-html-file';
		$page = $cache_class->get_auth_data($name.'-error'); // 设置断点
		if (!$page) {
			dr_json(0, L('没有找到上次中断生成的记录'));
		} elseif (!$cache_class->get_auth_data($name)) {
			dr_json(0, L('生成记录已过期，请重新开始生成'));
		} elseif (!$cache_class->get_auth_data($name.'-'.$page)) {
			dr_json(0, L('生成记录已过期，请重新开始生成'));
		}
		dr_json(1, 'ok');
	}
	// 获取生成的栏目
	private function _category_data($catids, $cats) {

		if (!$catids) {
			return $cats;
		}

		$rt = array();
		$arr = explode(',', $catids);
		foreach ($arr as $id) {
			if ($id && $cats[$id]) {
				$rt[$id] = $cats[$id];
			}
		}

		return $rt;
	}
	// 栏目的数量统计
	public function public_category_count() {
		$catids = $this->input->get('catids');
		$maxsize = (int)$this->input->get('maxsize');

		$cat = getcache('category_content_'.$this->siteid,'commons');
		$html = pc_base::load_sys_class('html');
		$html->get_category_data($this->_category_data($catids, $cat), $maxsize);
	}
	//生成首页
	public function public_index() {
		$this->site_db = pc_base::load_model('site_model');
		$data = $this->site_db->get_one(array('siteid'=>$this->siteid));
		$ishtml = $data['ishtml'];
		$mobilehtml = $data['mobilehtml'];
		include $this->admin_tpl('create_html_index');
	}
	//生成首页
	public function public_index_ajax() {
		$this->html = pc_base::load_app_class('html');
		$this->db = pc_base::load_model('site_model');
		$data = $this->db->get_one(array('siteid'=>$this->siteid));
		if($data['ishtml']==1) {
			$html = $this->html->index();
			dr_json(1, $html);
		} else {
			dr_json(0, L('index_create_close'));
		}
	}
	/**
	* 批量生成内容页
	*/
	public function batch_show() {
		if($this->input->post('dosubmit')) {
			$catid = intval($this->input->get('catid'));
			if(!$catid) dr_json(0, L('missing_part_parameters'));
			$modelid = $this->categorys[$catid]['modelid'];
			$setting = string2array($this->categorys[$catid]['setting']);
			$content_ishtml = $setting['content_ishtml'];
			if(!$content_ishtml) dr_json(0, L('它是动态模式'));
			if($content_ishtml) {
				$ids = $this->input->get_post_ids();
				if(empty($ids)) dr_json(0, L('you_do_not_check'));
				$count = 0;
				foreach($ids as $id) {
					$insert['catid']=$catid;
					$insert['id']=$id;
					$count ++;
					$cache_data[] = $insert;
				}
				$cache = array();
				if ($count > 100) {
					$pagesize = ceil($count/100);
					for ($i = 1; $i <= 100; $i ++) {
						$cache[$i] = array_slice($cache_data, ($i - 1) * $pagesize, $pagesize);
					}
				} else {
					for ($i = 1; $i <= $count; $i ++) {
						$cache[$i] = array_slice($cache_data, ($i - 1), 1);
					}
				}
				setcache('update_html_show-'.$this->siteid.'-'.$_SESSION['userid'], $cache,'content');
				dr_json(1, 'ok', array('url' => '?m=content&c=create_html&a=public_batch_show_add&menuid='.$this->input->get('menuid').'&pc_hash='.$this->input->get('pc_hash')));
			}
		}
	}
	/**
	* 批量生成内容页
	*/
	public function public_batch_show_add() {
		$show_header = $show_dialog = $show_pc_hash = '';
		$todo_url = '?m=content&c=create_html&a=public_batch_show&menuid='.$this->input->get('menuid').'&pc_hash='.$this->input->get('pc_hash');
		include $this->admin_tpl('show_url');
	}
	/**
	* 批量生成内容页
	*/
	public function public_batch_show() {
		$this->html = pc_base::load_app_class('html');
		$this->url = pc_base::load_app_class('url');
		$page = max(1, intval($this->input->get('page')));
		$update_html_show = getcache('update_html_show-'.$this->siteid.'-'.$_SESSION['userid'], 'content');
		if (!$update_html_show) {
			dr_json(0, '临时缓存数据不存在');
		}

		$cache_data = $update_html_show[$page];
		if ($cache_data) {
			$html = '';
			foreach ($cache_data as $insert) {
				$ok = '完成';
				$class = '';
				$modelid = $this->categorys[$insert['catid']]['modelid'];
				$setting = string2array($this->categorys[$insert['catid']]['setting']);
				$content_ishtml = $setting['content_ishtml'];
				$this->db->set_model($modelid);
				$rs = $this->db->get_one(array('id'=>$insert['id']));
				if($content_ishtml) {
					if($rs['islink']) {
						$class = 'p_error';
						$ok = '<a class="error" href="'.$rs['url'].'" target="_blank">转向链接</a>';
					} else {
						//写入文件
						$this->db->table_name = $this->db->table_name.'_data';
						$r2 = $this->db->get_one(array('id'=>$rs['id']));
						if($r2) $rs = array_merge($rs,$r2);
						//判断是否为升级或转换过来的数据
						if(!$rs['upgrade']) {
							$urls = $this->url->show($rs['id'], '', $rs['catid'], $rs['inputtime']);
						} else {
							$urls[1] = $rs['url'];
						}
						$this->html->show($urls[1],$rs,0,'edit',$rs['upgrade']);
						$class = 'ok';
						$ok = '<a class="ok" href="'.$rs['url'].'" target="_blank">生成成功</a>';
					}
				} else {
					$class = 'p_error';
					$ok = '<a class="error" href="'.$rs['url'].'" target="_blank">它是动态模式</a>';
				}
				$html.= '<p class="'.$class.'"><label class="rleft">(#'.$rs['id'].')'.$rs['title'].'</label><label class="rright">'.$ok.'</label></p>';
			}
			dr_json($page + 1, $html);
		}
		// 完成
		delcache('update_html_show-'.$this->siteid.'-'.$_SESSION['userid'], 'content');
		dr_json(100, '');
	}
	/**
	* 批量批量更新URL
	*/
	public function public_show_url() {
		$modelid = intval($this->input->get('modelid'));
		$page = (int)$this->input->get('page');
		$psize = 100; // 每页处理的数量
		$total = (int)$this->input->get('total');
		$this->db->set_model($modelid);
		if (!$page) {
			// 计算数量
			$total = $this->db->count(array('status' => 99));
			if (!$total) {
				html_msg(0, L('无可用内容更新'));
			}

			$url = '?m=content&c=create_html&a=public_show_url&modelid='.$modelid;
			html_msg(1, L('正在执行中...'), $url.'&total='.$total.'&page='.($page+1));
		}
		$tpage = ceil($total / $psize); // 总页数
		// 更新完成
		if ($page > $tpage) {
			html_msg(1, L('更新完成'));
		}
		$data = $this->db->listinfo(array('status' => 99), 'id DESC', $page, $psize);
		foreach ($data as $t) {
			if(!$t['islink'] || !$t['upgrade']) {
				$urls = $this->urls($t['id'], $t['catid'], $t['inputtime'], $t['prefix']);
			}
		}
		html_msg(1, L('正在执行中'.$tpage.'/'.$page.'...'), '?m=content&c=create_html&a=public_show_url&modelid='.$modelid.'&total='.$total.'&page='.($page+1));
	}
	/**
	* 批量生成栏目页
	*/
	public function public_category_add() {
		// 判断权限
		if (!dr_html_auth()) {
			dr_json(0, '权限验证超时，请重新执行生成');
		}
		$cache_class = pc_base::load_sys_class('cache');
		$this->html = pc_base::load_app_class('html');
		$page = max(1, intval($this->input->get('pp')));
		$name = 'category-html-file-'.$page;
		$name2 = 'category-html-file';
		$pcount = $cache_class->get_auth_data($name2, $this->siteid);
		if (!$pcount) {
			dr_json(0, '临时缓存数据不存在：'.$name2);
		} elseif ($page > $pcount) {
			// 完成
			//$cache_class->del_auth_data($name, $this->siteid);
			$cache_class->del_auth_data($name2, $this->siteid);
			dr_json(-1, '');
		}

		$cache = $cache_class->get_auth_data($name, $this->siteid);
		if (!$cache) {
			dr_json(0, '临时缓存数据不存在：'.$name);
		}

		if ($cache) {
			$html = '';
			foreach ($cache as $t) {
				$ok = '完成';
				$class = '';
				if (!$t['ishtml']) {
					$class = 'p_error';
					$ok = '<a class="error" href="'.$t['url'].'" target="_blank">它是动态模式</a>';
				} else {
					if (strpos($t['url'], 'index.php?')!==false) {
						$class = 'p_error';
						$ok = '<a class="error" href="'.$t['url'].'" target="_blank">地址【'.$t['url'].'】是动态，请更新内容URL地址为静态模式</a>';
					} else {
						$this->html->category($t['catid'],$t['page']);
						$cache_class->set_auth_data($name2.'-error', $page); // 设置断点
						$class = 'ok';
						$ok = '<a class="ok" href="'.$t['url'].'" target="_blank">生成成功</a>';
					}
				}
				$html.= '<p class="todo_p '.$class.'"><label class="rleft">(#'.$t['catid'].')'.$t['catname'].'</label><label class="rright">'.$ok.'</label></p>';
			}
			// 完成
			dr_json($page + 1, $html, array('pcount' => $pcount + 1));
		}
	}
	/**
	* 批量生成内容页
	*/
	public function public_show_add() {
		// 判断权限
		if (!dr_html_auth()) {
			dr_json(0, '权限验证超时，请重新执行生成');
		}
		$cache_class = pc_base::load_sys_class('cache');
		$this->html = pc_base::load_app_class('html');
		$this->url = pc_base::load_app_class('url');
		$modelid = intval($this->input->get('modelid'));
		$page = max(1, intval($this->input->get('pp')));
		$name = 'show-'.$modelid.'-html-file-data';
		$name2 = 'show-'.$modelid.'-html-file';
		$pcount = $cache_class->get_auth_data($name2, $this->siteid);
		if (!$pcount) {
			dr_json(0, '临时数据不存在：'.$name2);
		} elseif ($page > $pcount) {
			// 完成
			$cache_class->del_auth_data($name, $this->siteid);
			$cache_class->del_auth_data($name2, $this->siteid);
			dr_json(-1, '');
		}

		$cache = $cache_class->get_auth_data($name, $this->siteid);
		if (!$cache) {
			dr_json(0, '临时数据不存在：'.$name);
		} elseif (!$cache['sql']) {
			dr_json(0, '临时数据SQL未生成成功：'.$name);
		}
		
		if ($cache) {
			$sql = $cache['sql']. ' order by id asc limit '.($cache['pagesize'] * ($page - 1)).','.$cache['pagesize'];
			$this->db->query($sql);
			$data = $this->db->fetch_array();
			if (!$data) {
				// 完成
				$cache_class->del_auth_data($name, $this->siteid);
				$cache_class->del_auth_data($name2, $this->siteid);
				dr_json(-1, '');
			}
			$html = '';
			foreach ($data as $t) {
				$ok = '完成';
				$class = '';
				//设置模型数据表名
				$this->db->set_model(intval($this->categorys[$t['catid']]['modelid']));
				$setting = string2array($this->categorys[$t['catid']]['setting']);
				$content_ishtml = $setting['content_ishtml'];
				if($content_ishtml) {
					$r = $this->db->get_one(array('id'=>$t['id']));
					if($t['islink']) {
						$class = 'p_error';
						$ok = '<a class="error" href="'.$t['url'].'" target="_blank">转向链接</a>';
					} else {
						//写入文件
						$this->db->table_name = $this->db->table_name.'_data';
						$r2 = $this->db->get_one(array('id'=>$t['id']));
						if($r2) $r = array_merge($r, $r2);
						//判断是否为升级或转换过来的数据
						if($r['upgrade']) {
							$urls[1] = $t['url'];
						} else {
							$urls = $this->url->show($t['id'], '', $t['catid'], $t['inputtime']);
						}
						if (strpos($t['url'], 'index.php?')!==false) {
							$class = 'p_error';
							$ok = '<a class="error" href="'.$t['url'].'" target="_blank">地址【'.$t['url'].'】是动态，请更新内容URL地址为静态模式</a>';
						} else {
							$this->html->show($urls[1],$r,0,'edit',$t['upgrade']);
							$cache_class->set_auth_data($name2.'-error', $page); // 设置断点
							$class = 'ok';
							$ok = '<a class="ok" href="'.$t['url'].'" target="_blank">生成成功</a>';
						}
					}
				} else {
					$class = 'p_error';
					$ok = '<a class="error" href="'.$t['url'].'" target="_blank">它是动态模式</a>';
				}
				$html.= '<p class="todo_p '.$class.'"><label class="rleft">(#'.$t['id'].')'.$t['title'].'</label><label class="rright">'.$ok.'</label></p>';
			}
			// 完成
			dr_json($page + 1, $html, array('pcount' => $pcount + 1));
		}
	}
	
	// 统一设置URL规则
	public function public_batch_category() {
		$show_header = $show_dialog  = '';
		if(IS_AJAX_POST) {
			$setting = $this->input->post('setting');
			$this->category_db = pc_base::load_model('category_model');
			$row = $this->category_db->select(array('siteid'=>$this->siteid));
			foreach($row as $r) {
				$r['setting'] = dr_string2array($r['setting']);
				$r['setting']['ishtml'] = $setting['ishtml'];
				$r['setting']['content_ishtml'] = $setting['content_ishtml'];
				if($r['type']!=2) {
					if($setting['ishtml']) {
						$r['setting']['category_ruleid'] = $this->input->post('category_html_ruleid');
					} else {
						$r['setting']['category_ruleid'] = $this->input->post('category_php_ruleid');
					}
				}
				if($setting['content_ishtml']) {
					$r['setting']['show_ruleid'] = $this->input->post('show_html_ruleid');
				} else {
					$r['setting']['show_ruleid'] = $this->input->post('show_php_ruleid');
				}
				$this->category_db->update(array('setting'=>dr_array2string($r['setting'])), array('catid'=>$r['catid']));
			}
			dr_json(1, L('操作成功，请更新内容URL生效'), array('url' => '?m=content&c=create_html&a=public_batch_category&pc_hash='.dr_get_csrf_token()));
		} else {
			$tree = pc_base::load_sys_class('tree');
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$categorys = array();
			if(!empty($this->categorys)) {
				foreach($this->categorys as $catid=>$r) {
					$setting = string2array($r['setting']);
					if($this->siteid != $r['siteid'] || $r['type']==2) continue;
					$r['name'] = str_cut($r['catname'], 30);
					$ishtml = intval($setting['ishtml']);
					$r['is_page_html'] = '<a href="javascript:;" onclick="dr_cat_ajax_open_close(this, \'?m=content&c=create_html&a=public_html_edit&share=1&catid='.$r['catid'].'&pc_hash=\'+pc_hash, 0);" class="badge badge-'.(!$ishtml ? 'no' : 'yes').'"><i class="fa fa-'.(!$ishtml ? 'times' : 'check').'"></i></a>';
					if ($r['type']==0) {
						$content_ishtml = intval($setting['content_ishtml']);
						$r['is_show_html'] = '<a href="javascript:;" onclick="dr_cat_ajax_open_close(this, \'?m=content&c=create_html&a=public_html_edit&share=0&catid='.$r['catid'].'&pc_hash=\'+pc_hash, 0);" class="badge badge-'.(!$content_ishtml ? 'no' : 'yes').'"><i class="fa fa-'.(!$content_ishtml ? 'times' : 'check').'"></i></a>';
					} else {
						$r['is_show_html'] = '';
					}
					$r['category'] = form::urlrule('content','category',$ishtml,$setting['category_ruleid'],'class="form-control" onchange="dr_save_urlrule(1, \''.$r['catid'].'\', this.value)"');
					if ($r['type']==0) {
						$r['show'] = form::urlrule('content','show',$content_ishtml,$setting['show_ruleid'],'class="form-control" onchange="dr_save_urlrule(0, \''.$r['catid'].'\', this.value)"');
					} else {
						$r['show'] = '';
					}
					$categorys[$catid] = $r;
				}
			}
			$str = "<tr>";
			$str.= "<td style='text-align:center'>\$catid</td>";
			$str.= "<td>\$spacer \$name</td>";
			$str.= "<td style='text-align:center'>\$is_page_html</td>";
			$str.= "<td style='text-align:center'>\$is_show_html</td>";
			$str.= "<td>\$category</td>";
			$str.= "<td>\$show</td>";
			$str.= "</tr>";
			$tree->init($categorys);
			$string = $tree->get_tree(0, $str);
			include $this->admin_tpl('module_category_html');
		}
	}
	// 按栏目设置URL规则
	public function public_html_index() {
		$show_header = $show_dialog  = '';
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $catid=>$r) {
				$setting = string2array($r['setting']);
				if($this->siteid != $r['siteid'] || $r['type']==2) continue;
				$r['name'] = str_cut($r['catname'], 30);
				$ishtml = intval($setting['ishtml']);
				$r['is_page_html'] = '<a href="javascript:;" onclick="dr_cat_ajax_open_close(this, \'?m=content&c=create_html&a=public_html_edit&share=1&catid='.$r['catid'].'&pc_hash=\'+pc_hash, 0);" class="badge badge-'.(!$ishtml ? 'no' : 'yes').'"><i class="fa fa-'.(!$ishtml ? 'times' : 'check').'"></i></a>';
				if ($r['type']==0) {
					$content_ishtml = intval($setting['content_ishtml']);
					$r['is_show_html'] = '<a href="javascript:;" onclick="dr_cat_ajax_open_close(this, \'?m=content&c=create_html&a=public_html_edit&share=0&catid='.$r['catid'].'&pc_hash=\'+pc_hash, 0);" class="badge badge-'.(!$content_ishtml ? 'no' : 'yes').'"><i class="fa fa-'.(!$content_ishtml ? 'times' : 'check').'"></i></a>';
				} else {
					$r['is_show_html'] = '';
				}
				$r['category'] = form::urlrule('content','category',$ishtml,$setting['category_ruleid'],'class="form-control" onchange="dr_save_urlrule(1, \''.$r['catid'].'\', this.value)"');
				if ($r['type']==0) {
					$r['show'] = form::urlrule('content','show',$content_ishtml,$setting['show_ruleid'],'class="form-control" onchange="dr_save_urlrule(0, \''.$r['catid'].'\', this.value)"');
				} else {
					$r['show'] = '';
				}
				$categorys[$catid] = $r;
			}
		}
		$str = "<tr>";
		$str.= "<td style='text-align:center'>\$catid</td>";
		$str.= "<td>\$spacer \$name</td>";
		$str.= "<td style='text-align:center'>\$is_page_html</td>";
		$str.= "<td style='text-align:center'>\$is_show_html</td>";
		$str.= "<td>\$category</td>";
		$str.= "<td>\$show</td>";
		$str.= "</tr>";
		$tree->init($categorys);
		$string = $tree->get_tree(0, $str);
		include $this->admin_tpl('module_content_html');
	}
	public function public_html_edit() {
		$show_header = $show_dialog  = '';
		$share = intval($this->input->get('share'));
		$catid = intval($this->input->get('catid'));
		$this->category_db = pc_base::load_model('category_model');
		$this->urlrule_db = pc_base::load_model('urlrule_model');
		$row = $this->category_db->get_one(array('catid'=>$catid));
		if (!$row) {
			dr_json(0, L('栏目数据不存在'));
		}
		$row['setting'] = dr_string2array($row['setting']);
		if ($share) {
			$html = (int)$row['setting']['ishtml'];
			$v = $html ? 0 : 1;
			$row['setting']['ishtml'] = $v;
			$categoryrules = $this->urlrule_db->select(array('module'=>'content','file'=>'category','ishtml'=>$v));
			if (!$categoryurlruleid) {$onecategoryrules = reset($categoryrules);$categoryurlruleid = $onecategoryrules['urlruleid'];}
			$data['setting']['category_ruleid'] = $categoryurlruleid;
		} else {
			$html = (int)$row['setting']['content_ishtml'];
			$v = $html ? 0 : 1;
			$row['setting']['content_ishtml'] = $v;
			$showrules = $this->urlrule_db->select(array('module'=>'content','file'=>'show','ishtml'=>$v));
			if (!$showurlruleid) {$oneshowrules = reset($showrules);$showurlruleid = $oneshowrules['urlruleid'];}
			$data['setting']['show_ruleid'] = $showurlruleid;
		}
		$this->category_db->update(array('setting' => dr_array2string($row['setting'])),array('catid'=>$catid));
		$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
		$this->cache_api->cache('category');
		dr_json(1, L($v ? '静态模式' : '动态模式'), array('value' => $v, 'share' => 1));
	}
	public function public_index_edit() {
		$show_header = $show_dialog  = '';
		$share = intval($this->input->get('share'));
		$this->site_db = pc_base::load_model('site_model');
		$row = $this->site_db->get_one(array('siteid'=>$this->siteid));
		if (!$row) {
			dr_json(0, L('站点数据不存在'));
		}
		if ($share) {
			$html = (int)$row['ishtml'];
			$v = $html ? 0 : 1;
			$row['ishtml'] = $v;
			$this->site_db->update(array('ishtml' => $row['ishtml']),array('siteid'=>$this->siteid));
		} else {
			$html = (int)$row['mobilehtml'];
			$v = $html ? 0 : 1;
			$row['mobilehtml'] = $v;
			$this->site_db->update(array('mobilehtml' => $row['mobilehtml']),array('siteid'=>$this->siteid));
		}
		$this->cache_site = pc_base::load_app_class('sites', 'admin');
		$this->cache_site->set_cache();
		dr_json(1, L($v ? '静态模式' : '动态模式'), array('value' => $v, 'share' => 1));
	}
	public function public_rule_edit() {
		$show_header = $show_dialog  = '';
		$share = intval($this->input->get('share'));
		$catid = intval($this->input->get('catid'));
		$value = $this->input->get('value');
		$this->category_db = pc_base::load_model('category_model');
		$data = $this->category_db->get_one(array('catid'=>$catid));
		if (!$data) {
			dr_json(0, L('栏目#'.$id.'不存在'));
		}
		$data['setting'] = dr_string2array($data['setting']);
		if ($share) {
			$data['setting']['category_ruleid'] = $value;
		} else {
			$data['setting']['show_ruleid'] = $value;
		}
		$this->category_db->update(array('setting' => dr_array2string($data['setting'])),array('catid'=>$catid));
		$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
		$this->cache_api->cache('category');
		dr_json(1, L('操作成功，更新缓存生效'));
	}
	public function public_sync_index() {
		$this->category_db = pc_base::load_model('category_model');
		$this->urlrule_db = pc_base::load_model('urlrule_model');
		$url = '?m=content&c=create_html&a=public_sync_index';
		$page = intval($this->input->get('page'));
		$categoryrules = $this->urlrule_db->select(array('module'=>'content','file'=>'category','ishtml'=>1));
		$showrules = $this->urlrule_db->select(array('module'=>'content','file'=>'show','ishtml'=>1));
		if (!$categoryurlruleid) {$onecategoryrules = reset($categoryrules);$categoryurlruleid = $onecategoryrules['urlruleid'];}
		if (!$showurlruleid) {$oneshowrules = reset($showrules);$showurlruleid = $oneshowrules['urlruleid'];}
		if (!$page) {
			// 计算数量
			$total = $this->category_db->count();
			if (!$total) {
				html_msg(0, L('无可用栏目更新'));
			}
			html_msg(1, L('正在执行中...'), $url.'&total='.$total.'&page=1');
		}

		$psize = 100; // 每页处理的数量
		$total = (int)$this->input->get('total');
		$tpage = ceil($total / $psize); // 总页数
		// 更新完成
		if ($page > $tpage) {
			$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
			$this->cache_api->cache('category');
			html_msg(1, L('更新完成'));
		}

		$category = $this->category_db->listinfo('', 'catid DESC', $page, $psize);
		if ($category) {
			foreach ($category as $data) {
				$data['setting'] = dr_string2array($data['setting']);
				$data['setting']['ishtml'] = 1;
				$data['setting']['content_ishtml'] = 1;
				$data['setting']['category_ruleid'] = $categoryurlruleid;
				$data['setting']['show_ruleid'] = $showurlruleid;
				$this->category_db->update(array('setting' => dr_array2string($data['setting'])),array('catid'=>$data['catid']));
			}
		}

		html_msg(1, L('正在执行中【'.$tpage.'/'.$page.'】...'), $url.'&total='.$total.'&page='.($page+1));
	}
	public function public_sync2_index() {
		$this->category_db = pc_base::load_model('category_model');
		$this->urlrule_db = pc_base::load_model('urlrule_model');
		$url = '?m=content&c=create_html&a=public_sync2_index';
		$page = intval($this->input->get('page'));
		$categoryrules = $this->urlrule_db->select(array('module'=>'content','file'=>'category','ishtml'=>0));
		$showrules = $this->urlrule_db->select(array('module'=>'content','file'=>'show','ishtml'=>0));
		if (!$categoryurlruleid) {$onecategoryrules = reset($categoryrules);$categoryurlruleid = $onecategoryrules['urlruleid'];}
		if (!$showurlruleid) {$oneshowrules = reset($showrules);$showurlruleid = $oneshowrules['urlruleid'];}
		if (!$page) {
			// 计算数量
			$total = $this->category_db->count();
			if (!$total) {
				html_msg(0, L('无可用栏目更新'));
			}
			html_msg(1, L('正在执行中...'), $url.'&total='.$total.'&page=1');
		}

		$psize = 100; // 每页处理的数量
		$total = (int)$this->input->get('total');
		$tpage = ceil($total / $psize); // 总页数
		// 更新完成
		if ($page > $tpage) {
			$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
			$this->cache_api->cache('category');
			html_msg(1, L('更新完成'));
		}

		$category = $this->category_db->listinfo('', 'catid DESC', $page, $psize);
		if ($category) {
			foreach ($category as $data) {
				$data['setting'] = dr_string2array($data['setting']);
				$data['setting']['ishtml'] = 0;
				$data['setting']['content_ishtml'] = 0;
				$data['setting']['category_ruleid'] = $categoryurlruleid;
				$data['setting']['show_ruleid'] = $showurlruleid;
				$this->category_db->update(array('setting' => dr_array2string($data['setting'])),array('catid'=>$data['catid']));
			}
		}

		html_msg(1, L('正在执行中【'.$tpage.'/'.$page.'】...'), $url.'&total='.$total.'&page='.($page+1));
	}
	// 提取tag
	public function public_tag_index() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $catid=>$r) {
				$setting = string2array($r['setting']);
				if ($setting['disabled']) continue;
				if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
				if($modelid && $modelid != $r['modelid']) continue;
				$categorys[$catid] = $r;
			}
		}
		$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";
		$tree->init($categorys);
		$string = $tree->get_tree(0, $str);
		$todo_url = '?m=content&c=create_html&a=public_tag_edit&modelid='.$modelid;
		include $this->admin_tpl('module_content_tag');
	}
	// 提取tag
	public function public_tag_edit() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$page = (int)$this->input->get('page');
		$psize = 10; // 每页处理的数量
		$total = (int)$this->input->get('total');
		$this->db->set_model($modelid);

		$where = 'status = 99';
		$catid = $this->input->get('catid');

		$url = '?m=content&c=create_html&a=public_tag_edit&modelid='.$modelid;

		// 获取生成栏目
		if ($catid) {
			$cat = array();
			foreach ($catid as $i) {
				if ($i) {
					$cat[] = intval($i);
					if ($this->categorys[$i]['child']) {
						$cat = dr_array2array($cat, explode(',', $this->categorys[$i]['arrchildid']));
					}
					$url.= '&catid[]='.intval($i);
				}
			}
			$cat && $where.= ' AND catid IN ('.implode(',', $cat).')';
		}

		$keyword = $this->input->get('keyword');
		$keyword && $where.= ' AND keywords=""';
		$url.= '&keyword='.$keyword;

		if (!$page) {
			// 计算数量
			$total = $this->db->count($where);
			if (!$total) {
				html_msg(0, L('无可用内容更新'));
			}

			html_msg(1, L('正在执行中...'), $url.'&total='.$total.'&page='.($page+1), L('在使用网络分词接口时可能会很慢'));
		}

		$tpage = ceil($total / $psize); // 总页数

		// 更新完成
		if ($page > $tpage) {
			html_msg(1, L('更新完成'));
		}

		$data = $this->db->listinfo($where, 'id DESC', $page, $psize);
		foreach ($data as $t) {
			$tag = dr_get_keywords($t['title'].' '.$t['description']);
			if ($tag) {
				$this->db->update(array('keywords' => $tag), array('id' => $t['id']));
			}
		}

		html_msg(1, L('正在执行中【'.$tpage.'/'.$page.'】...'), $url.'&total='.$total.'&page='.($page+1), L('在使用网络分词接口时可能会很慢'));
	}
	// 提取缩略图
	public function public_thumb_index() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $catid=>$r) {
				$setting = string2array($r['setting']);
				if ($setting['disabled']) continue;
				if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
				if($modelid && $modelid != $r['modelid']) continue;
				$categorys[$catid] = $r;
			}
		}
		$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";
		$tree->init($categorys);
		$string = $tree->get_tree(0, $str);
		$todo_url = '?m=content&c=create_html&a=public_thumb_edit&modelid='.$modelid;
		include $this->admin_tpl('module_content_thumb');
	}
	// 提取缩略图
	public function public_thumb_edit() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$page = (int)$this->input->get('page');
		$psize = 100; // 每页处理的数量
		$total = (int)$this->input->get('total');
		$this->db->set_model($modelid);

		$where = 'status = 99';
		$catid = $this->input->get('catid');

		$url = '?m=content&c=create_html&a=public_thumb_edit&modelid='.$modelid;

		// 获取生成栏目
		if ($catid) {
			$cat = array();
			foreach ($catid as $i) {
				if ($i) {
					$cat[] = intval($i);
					if ($this->categorys[$i]['child']) {
						$cat = dr_array2array($cat, explode(',', $this->categorys[$i]['arrchildid']));
					}
					$url.= '&catid[]='.intval($i);
				}
			}
			$cat && $where.= ' AND catid IN ('.implode(',', $cat).')';
		}

		$thumb = $this->input->get('thumb');
		$thumb && $where.= ' AND thumb=""';
		$url.= '&thumb='.$thumb;

		if (!$page) {
			// 计算数量
			$total = $this->db->count($where);
			if (!$total) {
				html_msg(0, L('无可用内容更新'));
			}

			html_msg(1, L('正在执行中...'), $url.'&total='.$total.'&page='.($page+1));
		}

		$tpage = ceil($total / $psize); // 总页数

		// 更新完成
		if ($page > $tpage) {
			html_msg(1, L('更新完成'));
		}

		$data = $this->db->listinfo($where, 'id DESC', $page, $psize);
		foreach ($data as $row) {
			$content = get_content($modelid, $row['id']);
			$this->db->set_model($modelid);
			if ($row && $content && preg_match("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|png))\\2/i", code2html($content), $m)) {
				$this->db->update(array('thumb' => str_replace(array('"', '\''), '', $m[3])), array('id' => $row['id']));
			}
		}

		html_msg(1, L('正在执行中【'.$tpage.'/'.$page.'】...'), $url.'&total='.$total.'&page='.($page+1));
	}
	// 提取描述信息
	public function public_desc_index() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $catid=>$r) {
				$setting = string2array($r['setting']);
				if ($setting['disabled']) continue;
				if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
				if($modelid && $modelid != $r['modelid']) continue;
				$categorys[$catid] = $r;
			}
		}
		$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";
		$tree->init($categorys);
		$string = $tree->get_tree(0, $str);
		$todo_url = '?m=content&c=create_html&a=public_desc_edit&modelid='.$modelid;
		include $this->admin_tpl('module_content_desc');
	}
	// 提取描述信息
	public function public_desc_edit() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$page = (int)$this->input->get('page');
		$psize = 100; // 每页处理的数量
		$total = (int)$this->input->get('total');
		$this->db->set_model($modelid);

		$where = 'status = 99';
		$catid = $this->input->get('catid');

		$url = '?m=content&c=create_html&a=public_desc_edit&modelid='.$modelid;

		// 获取生成栏目
		if ($catid) {
			$cat = array();
			foreach ($catid as $i) {
				if ($i) {
					$cat[] = intval($i);
					if ($this->categorys[$i]['child']) {
						$cat = dr_array2array($cat, explode(',', $this->categorys[$i]['arrchildid']));
					}
					$url.= '&catid[]='.intval($i);
				}
			}
			$cat && $where.= ' AND catid IN ('.implode(',', $cat).')';
		}

		$nums = max(1, $this->input->get('nums'));
		$keyword = $this->input->get('keyword');
		$keyword && $where.= ' AND description=""';
		$url.= '&nums='.$nums;
		$url.= '&keyword='.$keyword;

		if (!$page) {
			// 计算数量
			$total = $this->db->count($where);
			if (!$total) {
				html_msg(0, L('无可用内容更新'));
			}

			html_msg(1, L('正在执行中...'), $url.'&total='.$total.'&page='.($page+1));
		}

		$tpage = ceil($total / $psize); // 总页数

		// 更新完成
		if ($page > $tpage) {
			html_msg(1, L('更新完成'));
		}

		$data = $this->db->listinfo($where, 'id DESC', $page, $psize);
		foreach ($data as $row) {
			$content = get_content($modelid, $row['id']);
			$this->db->set_model($modelid);
			if ($row && $content && dr_get_description(code2html($content), $nums)) {
				$this->db->update(array('description' => dr_get_description(code2html($content), $nums)), array('id' => $row['id']));
			} elseif ($row['title']) {
				$this->db->update(array('description' => dr_get_description(code2html($row['title']), $nums)), array('id' => $row['id']));
			}
		}

		html_msg(1, L('正在执行中【'.$tpage.'/'.$page.'】...'), $url.'&total='.$total.'&page='.($page+1));
	}
	// 提取变更栏目
	public function public_cat_index() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $catid=>$r) {
				$setting = string2array($r['setting']);
				if ($setting['disabled']) continue;
				if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
				if($modelid && $modelid != $r['modelid']) continue;
				$categorys[$catid] = $r;
			}
		}
		$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";
		$tree->init($categorys);
		$string = $tree->get_tree(0, $str);
		$categorys_post = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $catid=>$r) {
				$setting = string2array($r['setting']);
				if ($setting['disabled']) continue;
				if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
				if($modelid && $modelid != $r['modelid']) continue;
				$r['disabled'] = $r['child'] ? 'disabled' : '';
				$categorys_post[$catid] = $r;
			}
		}
		$str_post  = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";
		$tree->init($categorys_post);
		$select_post = $tree->get_tree(0, $str_post);
		$todo_url = '?m=content&c=create_html&a=public_cat_edit&modelid='.$modelid;
		include $this->admin_tpl('module_content_cat');
	}
	// 提取变更栏目
	public function public_cat_edit() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$page = (int)$this->input->get('page');
		$psize = 100; // 每页处理的数量
		$total = (int)$this->input->get('total');
		$this->db->set_model($modelid);

		$toid = (int)$this->input->get('toid');
		if (!$toid) {
			html_msg(0, L('目标栏目必须选择'));
		}

		$url = '?m=content&c=create_html&a=public_cat_edit&modelid='.$modelid;
		$url.= '&toid='.$toid;
		$where = '';

		// 获取生成栏目
		$catid = $this->input->get('catid');
		if ($catid) {
			$cat = array();
			foreach ($catid as $i) {
				if ($i) {
					$cat[] = intval($i);
					if ($this->categorys[$i]['child']) {
						$cat = dr_array2array($cat, explode(',', $this->categorys[$i]['arrchildid']));
					}
					$url.= '&catid[]='.intval($i);
				}
			}
			$cat && $where.= ' catid IN ('.implode(',', $cat).')';
		}
		if (!$page) {
			// 计算数量
			$total = $this->db->count($where);
			if (!$total) {
				html_msg(0, L('无可用内容更新'));
			}

			html_msg(1, L('正在执行中...'), $url.'&total='.$total.'&page='.($page+1));
		}

		$tpage = ceil($total / $psize); // 总页数

		// 更新完成
		if ($page > $tpage) {
			html_msg(1, L('更新完成'));
		}

		$data = $this->db->listinfo($where, 'id DESC', 1, $psize);
		foreach ($data as $row) {
			if ($row) {
				$this->db->update(array('catid' => $toid), array('id' => $row['id']));
			}
		}

		html_msg(1, L('正在执行中【'.$tpage.'/'.$page.'】...'), $url.'&total='.$total.'&page='.($page+1));
	}
	// 批量删除
	public function public_del_index() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $catid=>$r) {
				$setting = string2array($r['setting']);
				if ($setting['disabled']) continue;
				if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
				if($modelid && $modelid != $r['modelid']) continue;
				$categorys[$catid] = $r;
			}
		}
		$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";
		$tree->init($categorys);
		$string = $tree->get_tree(0, $str);
		$todo_url = '?m=content&c=create_html&a=public_del_edit&modelid='.$modelid;
		include $this->admin_tpl('module_content_del');
	}
	// 批量删除
	public function public_del_edit() {
		$show_header = $show_dialog  = '';
		$modelid = intval($this->input->get('modelid'));
		$page = (int)$this->input->get('page');
		$psize = 100; // 每页处理的数量
		$total = (int)$this->input->get('total');
		$this->db->set_model($modelid);
		$this->hits_db = pc_base::load_model('hits_model');
		$this->queue = pc_base::load_model('queue_model');
		$html_root = SYS_HTML_ROOT;
		//附件初始化
		$attachment = pc_base::load_model('attachment_model');
		$this->content_check_db = pc_base::load_model('content_check_model');
		$this->position_data_db = pc_base::load_model('position_data_model');
		$this->search_db = pc_base::load_model('search_model');
		$this->comment = pc_base::load_app_class('comment', 'comment');
		$search_model = getcache('search_model_'.$this->siteid,'search');
		$typeid = $search_model[$modelid]['typeid'];
		$this->url = pc_base::load_app_class('url', 'content');
		$sitelist = getcache('sitelist','commons');

		$where = array();
		$catid = $this->input->get('catid');

		$url = '?m=content&c=create_html&a=public_del_edit&modelid='.$modelid;

		// 获取生成栏目
		if ($catid) {
			$cat = array();
			foreach ($catid as $i) {
				if ($i) {
					$cat[] = intval($i);
					if ($this->categorys[$i]['child']) {
						$cat = dr_array2array($cat, explode(',', $this->categorys[$i]['arrchildid']));
					}
					$url.= '&catid[]='.intval($i);
				}
			}
			$cat && $where[] = ' catid IN ('.implode(',', $cat).')';
		}

		$author = $this->input->get('author');
		if (is_numeric($author)) {
			$author = (int)$author;
			$author_db = pc_base::load_model('admin_model');
			$author_data = $author_db->get_one(array('userid'=>$author));
			$author = $author_data['username'];
		}
		if ($author) {
			$where[] = 'username="'.dr_safe_replace($author).'"';
			$url.= '&author='.$author;
		}

		$id1 = (int)$this->input->get('id1');
		$id2 = (int)$this->input->get('id2');
		if ($id1 || $id2) {
			if (!$id2) {
				$where[] = 'id>'.$id1;
			} else {
				$where[] = '`id` BETWEEN '.$id1.' AND '.$id2;
			}
			$url.= '&id1='.$id1.'&id2='.$id2;
		}

		if (!$where) {
			html_msg(0, L('没有设置条件'));
		}

		$where = implode(' AND ', $where);

		if (!$page) {
			// 计算数量
			$total = $this->db->count($where);
			if (!$total) {
				html_msg(0, L('无可用内容更新'));
			}

			html_msg(1, L('正在删除中...'), $url.'&total='.$total.'&page='.($page+1));
		}

		$tpage = ceil($total / $psize); // 总页数

		// 更新完成
		if ($page > $tpage) {
			html_msg(1, L('删除完成'));
		}

		$data = $this->db->listinfo($where, 'id DESC', 1, $psize);
		foreach ($data as $row) {
			if ($row) {
				$sethtml = $this->categorys[$row['catid']]['sethtml'];
				if($sethtml) $html_root = '';
				$setting = string2array($this->categorys[$row['catid']]['setting']);
				if($setting['content_ishtml'] && !$row['islink']) {
					$urls = $this->url->show($row['id'], 0, $row['catid'], $row['inputtime']);
					$fileurl = $urls[1];
					if($this->siteid != 1) {
						$fileurl = $html_root.'/'.$sitelist[$this->siteid]['dirname'].$fileurl;
					}
					$mobilefileurl = SYS_MOBILE_ROOT.$fileurl;
					//删除静态文件，排除htm/html/shtml外的文件
					$lasttext = strrchr($fileurl,'.');
					$len = -strlen($lasttext);
					$path = substr($fileurl,0,$len);
					$path = ltrim($path,'/');
					$filelist = glob(CMS_PATH.$path.'{_,-,.}*',GLOB_BRACE);
					$mobilelasttext = strrchr($mobilefileurl,'.');
					$mobilelen = -strlen($mobilelasttext);
					$mobilepath = substr($mobilefileurl,0,$mobilelen);
					$mobilepath = ltrim($mobilepath,'/');
					$mobilefilelist = glob(CMS_PATH.$mobilepath.'{_,-,.}*',GLOB_BRACE);
					foreach ($filelist as $delfile) {
						$lasttext = strrchr($delfile,'.');
						if(!in_array($lasttext, array('.htm','.html','.shtml'))) continue;
						@unlink($delfile);
						//删除发布点队列数据
						$delfile = str_replace(CMS_PATH, '/', $delfile);
						$this->queue->add_queue('del',$delfile,$this->siteid);
					}
					if($sitelist[$this->siteid]['mobilehtml']==1) {
						foreach ($mobilefilelist as $mobiledelfile) {
							$mobilelasttext = strrchr($mobiledelfile,'.');
							if(!in_array($mobilelasttext, array('.htm','.html','.shtml'))) continue;
							@unlink($mobiledelfile);
						}
					}
				} else {
					$fileurl = 0;
				}
				//删除内容
				$this->db->delete_content($row['id'],$fileurl,$row['catid']);
				//删除统计表数据
				$this->hits_db->delete(array('hitsid'=>'c-'.$modelid.'-'.$row['id']));
				//删除附件
				$attachment->api_delete('c-'.$row['catid'].'-'.$row['id']);
				//删除审核表数据
				$this->content_check_db->delete(array('checkid'=>'c-'.$row['id'].'-'.$modelid));
				//删除推荐位数据
				$this->position_data_db->delete(array('id'=>$row['id'],'catid'=>$row['catid'],'module'=>'content'));
				//删除全站搜索中数据
				$this->search_db->delete_search($typeid,$row['id']);
				//删除关键词和关键词数量重新统计
				$keyword_db = pc_base::load_model('keyword_model');
				$keyword_data_db = pc_base::load_model('keyword_data_model');
				$keyword_arr = $keyword_data_db->select(array('siteid'=>$this->siteid,'contentid'=>$row['id'].'-'.$modelid));
				if($keyword_arr){
					foreach ($keyword_arr as $val){
						$keyword_db->update(array('videonum'=>'-=1'),array('id'=>$val['tagid']));
					}
					$keyword_data_db->delete(array('siteid'=>$this->siteid,'contentid'=>$row['id'].'-'.$modelid));
					$keyword_db->delete(array('videonum'=>'0'));
				}
				
				//删除相关的评论,删除前应该判断是否还存在此模块
				if(module_exists('comment')){
					$commentid = id_encode('content_'.$row['catid'], $row['id'], $this->siteid);
					$this->comment->del($commentid, $this->siteid, $row['id'], $row['catid']);
				}
			}
		}
		//更新栏目统计
		$this->db->cache_items();

		html_msg(1, L('正在删除中【'.$tpage.'/'.$page.'】...'), $url.'&total='.$total.'&page='.($page+1));
	}
	// 获取可用字段
	private function _get_field($bm) {

		$fields = $this->db->query('SHOW FULL COLUMNS FROM `'.$bm.'`');
		if (!$fields) {
			dr_json(0, L('表['.$bm.']没有可用字段'));
		}

		$rt = array();
		foreach ($fields as $t) {
			$rt[] = $t['Field'];
		}

		return $rt;
	}
	// 内容维护替换
	public function public_replace_index() {
		$bm = $this->input->post('bm');
		if (!$bm) {
			dr_json(0, L('表名不能为空'));
		}
		$tables = array();
		$tables[$bm] = $this->_get_field($bm);

		$t1 = $this->input->post('t1');
		$t2 = $this->input->post('t2');
		$fd = dr_safe_replace($this->input->post('fd'));

		if (!$fd) {
			dr_json(0, L('待替换字段必须填写'));
		} elseif (!$t1) {
			dr_json(0, L('被替换内容必须填写'));
		} elseif (!$tables) {
			dr_json(0, L('表名称必须填写'));
		} elseif ($fd == 'id') {
			dr_json(0, L('ID主键不支持替换'));
		}

		$count = 0;
		$replace = '`'.$fd.'`=REPLACE(`'.$fd.'`, \''.addslashes($t1).'\', \''.addslashes($t2).'\')';

		foreach ($tables as $table => $fields) {
			if (!dr_in_array($fd, $fields)) {
				dr_json(0, L('表['.$table.']字段['.$fd.']不存在'));
			}
			$this->db->query('UPDATE `'.$table.'` SET '.$replace);
			$count = $this->db->affected_rows();
		}

		if ($count < 0) {
			dr_json(0, L('执行错误'));
		}

		dr_json(1, L('本次替换'.$count.'条数据'));
	}
	// 内容批量修改
	public function public_all_edit() {
		$bm = $this->input->post('bm');
		if (!$bm) {
			dr_json(0, L('表名不能为空'));
		}
		$tables = array();
		$tables[$bm] = $this->_get_field($bm);

		$t1 = $this->input->post('t1');
		$t2 = $this->input->post('t2');
		$ms = (int)$this->input->post('ms');
		$fd = dr_safe_replace($this->input->post('fd'));

		if (!$fd) {
			dr_json(0, L('待修改字段必须填写'));
		} elseif (!$tables) {
			dr_json(0, L('表名称必须填写'));
		} elseif ($fd == 'id') {
			dr_json(0, L('ID主键不支持替换'));
		}

		$count = 0;

		$where = '';
		if ($t1) {
			// 防范sql注入后期需要加强
			foreach (array('outfile', 'dumpfile', '.php', 'union', ';') as $kw) {
				if (strpos(strtolower($t1), $kw) !== false) {
					dr_json(0, L('存在非法SQL关键词：'.$kw));
				}
			}
			$where = ' WHERE '.addslashes($t1);
		}

		if ($ms == 1) {
			// 之前
			$replace = '`'.$fd.'`=CONCAT(\''.addslashes($t2).'\', `'.$fd.'`)';
		} elseif ($ms == 2) {
			// 之后
			$replace = '`'.$fd.'`=CONCAT(`'.$fd.'`, \''.addslashes($t2).'\')';
		} else {
			// 替换
			$replace = '`'.$fd.'`=\''.addslashes($t2).'\'';
		}


		foreach ($tables as $table => $fields) {

			if (!dr_in_array($fd, $fields)) {
				dr_json(0, L('表['.$table.']字段['.$fd.']不存在'));
			}

			$this->db->query('UPDATE `'.$table.'` SET '.$replace . $where);
			$count = $this->db->affected_rows();
		}

		if ($count < 0) {
			dr_json(0, L('执行错误'));
		}

		dr_json(1, L('本次替换'.$count.'条数据'));
	}
	// 全库
	public function public_dball_edit() {
		$cache_class = pc_base::load_sys_class('cache');
		$page = (int)$this->input->get('page');
		$tpage = (int)$this->input->get('tpage');
		$prefix = $this->db->db_tablepre;
		$name = 'dball_edit';

		$url = '?m=content&c=create_html&a=public_dball_edit';

		if (!$page) {
			// 计算数量
			$t1 = $this->input->get('t1');
			$t2 = $this->input->get('t2');
			if (!$t1) {
				dr_json(0, L('替换内容不能为空'));
			}
			$data = [];
			$module = getcache('model', 'commons');
			if ($module) {
				foreach ($module as $m) {
					if($m['siteid']!=$this->siteid) continue;
					$mod = getcache('model_field_'.$m['modelid'], 'model');
					if ($mod) {
						$table = $prefix.$m['tablename'];
						foreach ($mod as $t) {
							if ($t['issystem']) {
								$this->_is_rp_field($t, $table) && $data[] = [ $table, $t['field'] ];
							} else {
								$this->_is_rp_field($t, $table.'_data') && $data[] = [ $table.'_data', $t['field'] ];
							}
						}
					}
				}
			}
			$mod = getcache('model_field_0', 'model');
			if ($mod) {
				$table = $prefix.'site';
				foreach ($mod as $t) {
					if ($t['issystem']) {
						$this->_is_rp_field($t, $table) && $data[] = [ $table, $t['fieldname'] ];
					}
				}
			}
			$mod = getcache('model_field_-1', 'model');
			if ($mod) {
				$table = $prefix.'category';
				foreach ($mod as $t) {
					if ($t['issystem']) {
						$this->_is_rp_field($t, $table) && $data[] = [ $table, $t['fieldname'] ];
					}
				}
			}
			$mod = getcache('model_field_-2', 'model');
			if ($mod) {
				$table = $prefix.'page';
				foreach ($mod as $t) {
					if ($t['issystem']) {
						$this->_is_rp_field($t, $table) && $data[] = [ $table, $t['fieldname'] ];
					}
				}
			}

			$cache = array_chunk($data, 30);
			foreach ($cache as $i => $t) {
				$cache_class->set_auth_data($name.'-'.($i+1), $t);
			}

			$cache_class->set_auth_data($name, [$t1, $t2]);

			html_msg(1, L('正在执行中...'), $url.'&cache='.$name.'&page=1&tpage='.dr_count($cache));
		}

		$value = $cache_class->get_auth_data($name);
		$replace = $cache_class->get_auth_data($name.'-'.$page);
		if (!$value) {
			html_msg(0, L('临时数据读取失败'));
		} elseif (!isset($replace[$page+1])) {
			html_msg(0, L('替换完成'));
		}

		// 更新完成
		if ($page > $tpage) {
			html_msg(1, L('替换完成'));
		}

		foreach ($replace as $t) {
			$sql = 'update `'.$t[0].'` set `'.$t[1].'`=REPLACE(`'.$t[1].'`, \''.addslashes($value[0]).'\', \''.addslashes($value[1]).'\')';
			$this->db->query($sql);
		}

		html_msg(1, L('正在执行中【%s】...', "$tpage/$page"), $url.'&tpage='.$tpage.'&page='.($page+1));
	}
	// 检测字段是否存在
	private function _is_rp_field($f, $table) {
		$this->db->table_name = $table;
		if (in_array($f['formtype'], array(
			'image',
			'images',
			'file',
			'downfile',
			'downfiles',
			'editor'
			))) {
			if ($this->db->field_exists($f['field'])) {
				return 1;
			}
		}

		return 0;
	}
	// 联动加载字段
	public function public_field_index() {
		$table = dr_safe_replace($this->input->get('table'));
		$table = str_replace($this->db->db_tablepre, '', $table);
		if (!$table) {
			dr_json(0, L('表参数不能为空'));
		} elseif (!$this->db->table_exists($table)) {
			dr_json(0, L('表['.$table.']不存在'));
		}

		$fields = $this->db->query('SHOW FULL COLUMNS FROM `'.$this->db->db_tablepre.$table.'`');
		if (!$fields) {
			dr_json(0, L('表['.$table.']没有可用字段'));
		}

		$msg = '<select name="fd" class="form-control">';
		foreach ($fields as $t) {
			if ($t['Field'] != 'id') {
				$msg.= '<option value="'.$t['Field'].'">'.$t['Field'].($t['Comment'] ? '（'.$t['Comment'].'）' : '').'</option>';
			}
		}
		$msg.= '</select>';

		dr_json(1, $msg);
	}
}
?>