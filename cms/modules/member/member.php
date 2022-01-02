<?php
/**
 * 管理员后台会员操作类
 */

defined('IN_CMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_func('util', 'content');

class member extends admin {
	
	private $db, $verify_db;
	
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->cache = pc_base::load_sys_class('cache');
		$this->db = pc_base::load_model('member_model');
		$this->member_login_db = pc_base::load_model('member_login_model');
		$this->module_db = pc_base::load_model('module_model');
		$this->member = $this->cache->get('member');
		$this->member_cache = $this->member['member'];
		$this->field = $this->member_cache['field'];
		$this->list_field = $this->member_cache['setting']['list_field'];
	}

	/**
	 * defalut
	 */
	function init() {
		$show_header = $show_scroll = true;
		pc_base::load_sys_class('form', '', 0);
		$this->verify_db = pc_base::load_model('member_verify_model');
		
		//搜索框
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$groupid = isset($_GET['groupid']) ? $_GET['groupid'] : '';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
		$grouplist = getcache('grouplist');
		foreach($grouplist as $k=>$v) {
			$grouplist[$k] = $v['name'];
		}

		$memberinfo['totalnum'] = $this->db->count();
		$memberinfo['vipnum'] = $this->db->count(array('vip'=>1));
		$memberinfo['verifynum'] = $this->verify_db->count(array('status'=>0));

		$todaytime = strtotime(date('Y-m-d', SYS_TIME));
		$memberinfo['today_member'] = $this->db->count("`regdate` > '$todaytime'");
		
		include $this->admin_tpl('member_init');
	}
	
	/**
	 * 会员列表
	 */
	function manage() {

		//搜索框
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$groupid = isset($_GET['groupid']) ? $_GET['groupid'] : '';
		$modelid = isset($_GET['modelid']) ? $_GET['modelid'] : '';
		
		//站点信息
		$sitelistarr = getcache('sitelist', 'commons');
		$siteid = isset($_GET['siteid']) ? $_GET['siteid'] : '';
		
		foreach ($sitelistarr as $k=>$v) {
			$sitelist[$k] = $v['name'];
		}
		
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		$amount_from = isset($_GET['amount_from']) ? $_GET['amount_from'] : '';
		$amount_to = isset($_GET['amount_to']) ? $_GET['amount_to'] : '';
		$point_from = isset($_GET['point_from']) ? $_GET['point_from'] : '';
		$point_to = isset($_GET['point_to']) ? $_GET['point_to'] : '';
				
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
		$grouplist = getcache('grouplist');
		foreach($grouplist as $k=>$v) {
			$grouplist[$k] = $v['name'];
		}
		//会员所属模型		
		$modellistarr = getcache('member_model', 'commons');
		foreach ($modellistarr as $k=>$v) {
			$modellist[$k] = $v['name'];
		}

		if (isset($_GET['dosubmit'])) {
			
			//默认选取一个月内的用户，防止用户量过大给数据造成灾难
			$where_start_time = strtotime($start_time) ? strtotime($start_time) : 0;
			$where_end_time = strtotime($end_time) + 86400;
			//开始时间大于结束时间，置换变量
			if($where_start_time > $where_end_time) {
				$tmp = $where_start_time;
				$where_start_time = $where_end_time;
				$where_end_time = $tmp;
				$tmptime = $start_time;
				
				$start_time = $end_time;
				$end_time = $tmptime;
				unset($tmp, $tmptime);
			}
			
			//如果是超级管理员角色，显示所有用户，否则显示当前站点用户
			if(cleck_admin($_SESSION['roleid'])) {
				if(!empty($siteid)) {
					if ($siteid && is_array($siteid)) {
						$sidin = [];
						foreach ($siteid as $tid) {
							$tid = intval($tid);
							if ($tid) {
								$sidin[] = $tid;
							}
						}
						if ($sidin) {
							$where[] = "`siteid` in (".implode(',', $sidin).")";
						}
					}
				}
			} else {
				$siteid = get_siteid();
				$where[] = "`siteid` = '$siteid'";
			}
			
			if ($status && is_array($status)) {
				$sin = [];
				foreach ($status as $sid) {
					$sid = intval($sid);
					$sin[] = $sid;
				}
				if ($sin) {
					$where[] = "`islock` in (".implode(',', $sin).")";
				}
			}
			
			if ($groupid && is_array($groupid)) {
				$in = [];
				foreach ($groupid as $gid) {
					$gid = intval($gid);
					if ($gid) {
						$in[] = $gid;
					}
				}
				if ($in) {
					$where[] = "`groupid` in (".implode(',', $in).")";
				}
			}
			
			if ($modelid && is_array($modelid)) {
				$min = [];
				foreach ($modelid as $mid) {
					$mid = intval($mid);
					if ($mid) {
						$min[] = $mid;
					}
				}
				if ($min) {
					$where[] = "`modelid` in (".implode(',', $min).")";
				}
			}
			$start_time && $end_time && $where[] = "`regdate` BETWEEN '$where_start_time' AND '$where_end_time'";

			//资金范围
			if($amount_from) {
				if($amount_to) {
					if($amount_from > $amount_to) {
						$tmp = $amount_from;
						$amount_from = $amount_to;
						$amount_to = $tmp;
						unset($tmp);
					}
					$where[] = "`amount` BETWEEN '$amount_from' AND '$amount_to'";
				} else {
					$where[] = "`amount` > '$amount_from'";
				}
			}
			//点数范围
			if($point_from) {
				if($point_to) {
					if($point_from > $point_to) {
						$tmp = $amount_from;
						$point_from = $point_to;
						$point_to = $tmp;
						unset($tmp);
					}
					$where[] = "`point` BETWEEN '$point_from' AND '$point_to'";
				} else {
					$where[] = "`point` > '$point_from'";
				}
			}
		
			if($keyword) {
				if ($type == '1') {
					$where[] = "`username` LIKE '%$keyword%'";
				} elseif($type == '2') {
					$where[] = "`userid` = '$keyword'";
				} elseif($type == '3') {
					$where[] = "`email` LIKE '%$keyword%'";
				} elseif($type == '4') {
					$where[] = "`regip` = '$keyword'";
				} elseif($type == '5') {
					$where[] = "`nickname` LIKE '%$keyword%'";
				} else {
					$where[] = "`username` LIKE '%$keyword%'";
				}
			}
		}

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$memberlist = $this->db->listinfo(($where ? implode(' AND ', $where) : ''), $this->input->get('order') ? $this->input->get('order') : 'userid DESC', $page, SYS_ADMIN_PAGESIZE);
		//查询会员头像
		foreach($memberlist as $k=>$v) {
			$memberlist[$k]['avatar'] = get_memberavatar($v['userid']);
		}
		$pages = $this->db->pages;
		$list_field = $this->list_field;
		$big_menu = array('javascript:artdialog(\'add\',\'?m=member&c=member&a=add\',\''.L('member_add').'\',700,500);void(0);', L('member_add'));
		include $this->admin_tpl('member_list');
	}

    // 修改账号
    public function username_edit() {
        $show_header = '';

        $userid = intval($this->input->get('userid'));
        $member = $this->db->get_one(array('userid'=>$userid));
        if (!$member) {
            dr_json(0, L('该用户不存在'));
        }

        if (IS_POST) {
            $name = trim(dr_safe_filename($this->input->post('name')));
            if (!$name) {
                dr_json(0, L('新账号不能为空'), array('field' => 'name'));
            } elseif ($member['username'] == $name) {
                dr_json(0, L('新账号不能和原始账号相同'), array('field' => 'name'));
            } elseif ($this->db->count(array('username'=>$name))) {
                dr_json(0, L('新账号'.$name.'已经注册'), array('field' => 'name'));
            }
			$rt = $this->check_username($name);
			if (!$rt['code']) {
				dr_json(0, $rt['msg'], array('field' => 'name'));
			}

            $this->db->update(array('username'=>$name), array('userid'=>$userid));

            dr_json(1, L('操作成功'));
        }

        include $this->admin_tpl('member_edit_username');exit;
    }
		
	/**
	 * add member
	 */
	function add() {
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			$info = array();
			if(!$this->_checkname($_POST['info']['username'])){
				dr_admin_msg(0,L('member_exist'));
			}
			$info['username'] = $this->input->post('info')['username'];
			if(!$this->_checkpasswd($_POST['info']['password'])){
				dr_admin_msg(0,L('password_format_incorrect'));
			}
			$info['regip'] = ip_info();
			$info['overduedate'] = strtotime($_POST['info']['overduedate']);

			$_POST['info']['encrypt'] = create_randomstr(10);
			$info['password'] = password($_POST['info']['password'], $_POST['info']['encrypt']);
			$info['encrypt'] = $this->input->post('info')['encrypt'];
			$info['nickname'] = $this->input->post('info')['nickname'];
			$info['email'] = $this->input->post('info')['email'];
			$info['mobile'] = $this->input->post('info')['mobile'];
			$info['groupid'] = $this->input->post('info')['groupid'];
			$info['point'] = $this->input->post('info')['point'];
			$info['modelid'] = $this->input->post('info')['modelid'];
			$info['vip'] = $this->input->post('info')['vip'];
			$info['regdate'] = $this->input->post('info')['lastdate'] = SYS_TIME;
			
			$this->db->insert($info);
			if($this->db->insert_id()){
				dr_admin_msg(1,L('operation_success'),'?m=member&c=member&a=add', '', 'add');
			}
		} else {
			$show_header = $show_scroll = true;
			$siteid = get_siteid();
			//会员组缓存
			$group_cache = getcache('grouplist', 'member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			//会员模型缓存
			$member_model_cache = getcache('member_model', 'commons');
			foreach($member_model_cache as $_key=>$_value) {
				if($siteid == $_value['siteid']) {
					$modellist[$_key] = $_value['name'];
				}
			}
			
			include $this->admin_tpl('member_add');
		}
		
	}
	
	/**
	 * edit member
	 */
	function edit() {
		if(isset($_POST['dosubmit'])) {
			$memberinfo = $info = array();
			$basicinfo['userid'] = $this->input->post('info')['userid'];
			$basicinfo['username'] = $this->input->post('info')['username'];
			$basicinfo['nickname'] = $this->input->post('info')['nickname'];
			$basicinfo['email'] = $this->input->post('info')['email'];
			$basicinfo['point'] = $this->input->post('info')['point'];
			$basicinfo['password'] = $this->input->post('info')['password'];
			$basicinfo['groupid'] = $this->input->post('info')['groupid'];
			$basicinfo['modelid'] = $this->input->post('info')['modelid'];
			$basicinfo['vip'] = $this->input->post('info')['vip'];
			$basicinfo['mobile'] = $this->input->post('info')['mobile'];
			$basicinfo['overduedate'] = strtotime($_POST['info']['overduedate']);

			//会员基本信息
			$info = $this->_checkuserinfo($basicinfo, 1);

			//会员模型信息
			$modelinfo = array_diff_key($_POST['info'], $info);
			//过滤vip过期时间
			unset($modelinfo['overduedate']);
			unset($modelinfo['pwdconfirm']);

			$userid = $info['userid'];
			
			//如果是超级管理员角色，显示所有用户，否则显示当前站点用户
			if(cleck_admin($_SESSION['roleid'])) {
				$where = array('userid'=>$userid);
			} else {
				$siteid = get_siteid();
				$where = array('userid'=>$userid, 'siteid'=>$siteid);
			}
			
		
			$userinfo = $this->db->get_one($where);
			if(empty($userinfo)) {
				dr_admin_msg(0,L('user_not_exist').L('or').L('no_permission'), HTTP_REFERER);
			}
			
			//删除用户头像
			if(!empty($_POST['delavatar'])) {
				$this->deleteavatar($userinfo['userid']);
			}

			unset($info['userid']);
			unset($info['username']);
			
			//如果密码不为空，修改用户密码。
			if(isset($info['password']) && !empty($info['password'])) {
				$info['password'] = password($info['password'], $userinfo['encrypt']);
			} else {
				unset($info['password']);
			}

			$this->db->update($info, array('userid'=>$userid));
			
			require_once CACHE_MODEL_PATH.'member_input.class.php';
			require_once CACHE_MODEL_PATH.'member_update.class.php';
			$member_input = new member_input($basicinfo['modelid']);
			$modelinfo = $member_input->get($modelinfo);

			//更新模型表，方法更新了$this->table
			$this->db->set_model($info['modelid']);
			$userinfo = $this->db->get_one(array('userid'=>$userid));
			if($userinfo) {
				$this->db->update($modelinfo, array('userid'=>$userid));
			} else {
				$modelinfo['userid'] = $userid;
				$this->db->insert($modelinfo);
			}
			
			dr_admin_msg(1,L('operation_success'), '?m=member&c=member&a=manage', '', 'edit');
		} else {
			$show_header = $show_scroll = true;
			$siteid = get_siteid();
			$userid = isset($_GET['userid']) ? $_GET['userid'] : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
			
			//会员组缓存
			$group_cache = getcache('grouplist', 'member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}

			//会员模型缓存
			$member_model_cache = getcache('member_model', 'commons');
			foreach($member_model_cache as $_key=>$_value) {
				if($siteid == $_value['siteid']) {
					$modellist[$_key] = $_value['name'];
				}
			}
			
			//如果是超级管理员角色，显示所有用户，否则显示当前站点用户
			if(cleck_admin($_SESSION['roleid'])) {
				$where = array('userid'=>$userid);
			} else {
				$where = array('userid'=>$userid, 'siteid'=>$siteid);
			}

			$memberinfo = $this->db->get_one($where);
			
			if(empty($memberinfo)) {
				dr_admin_msg(0,L('user_not_exist').L('or').L('no_permission'), HTTP_REFERER);
			}
			
			$memberinfo['avatar'] = get_memberavatar($memberinfo['userid']);
			
			$modelid = isset($_GET['modelid']) ? $_GET['modelid'] : $memberinfo['modelid'];
			
			//获取会员模型表单
			require CACHE_MODEL_PATH.'member_form.class.php';
			$member_form = new member_form($modelid);
			
			$form_overdudate = form::date('info[overduedate]', $memberinfo['overduedate'] ? date('Y-m-d H:i:s',$memberinfo['overduedate']) : '', 1);
			$this->db->set_model($modelid);
			$membermodelinfo = $this->db->get_one(array('userid'=>$userid));
			$forminfos = $forminfos_arr = $member_form->get($membermodelinfo);
			
			//万能字段过滤
			foreach($forminfos as $field=>$info) {
				if($info['isomnipotent']) {
					unset($forminfos[$field]);
				} else {
					if($info['formtype']=='omnipotent') {
						foreach($forminfos_arr as $_fm=>$_fm_value) {
							if($_fm_value['isomnipotent']) {
								$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
							}
						}
						$forminfos[$field]['form'] = $info['form'];
					}
				}
			}
			$show_dialog = 1;
			include $this->admin_tpl('member_edit');		
		}
	}

	/**
	 * 后台授权登录
	 */
	public function alogin_index() {
		$cache_class = pc_base::load_sys_class('cache');
		$uid = intval($this->input->get('id'));
		if (!$this->cleck_edit_member($uid)) {
			dr_admin_msg(0,L('无权限操作其他管理员账号'));
		}
		// 当不具备用户操作权限时，只能授权登录当前账号
		/*if (!$this->is_admin_auth() && $uid != $this->uid) {
			dr_admin_msg(0,L('无权限操作其他账号'));
		}*/
		$admin = $this->db->get_one(array('userid'=>$uid));
		$cache_class->set_auth_data('admin_login_member', $admin, 1);

		dr_admin_msg(1,L('正在授权登录此用户...'), WEB_PATH.'index.php?m=member&c=index&a=alogin');exit;
	}
	
	/**
	 *  删除用户头像
	 *  @return {0:失败;1:成功}
	 */
	public function deleteavatar($uid) {
		//根据用户id创建文件夹
		if(isset($uid)) {
			$this->uid = $uid;
		} else {
			exit('0');
		}
		$upload = pc_base::load_sys_class('upload');
		$memberinfo = $this->db->get_one(array('userid'=>$uid));
		if ($memberinfo && $memberinfo['avatar']) {
			$attachment_db = pc_base::load_model('attachment_model');
			$data = $attachment_db->get_one(array('aid'=>$memberinfo['avatar']));
			if ($data) {
				$rt = $upload->_delete_file($data);
				$this->db->update(array('avatar'=>''), array('userid'=>$uid));
			}
		}
	}
	
	/**
	 * delete member
	 */
	function delete() {
		$uidarr = isset($_POST['userid']) ? $_POST['userid'] : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		$uidarr = array_map('intval',$uidarr);
		$where = to_sqls($uidarr, '', 'userid');
		//查询用户信息
		$userinfo_arr = $this->db->select($where, "userid, modelid");
		$userinfo = array();
		if(is_array($userinfo_arr)) {
			foreach($userinfo_arr as $v) {
				$userinfo[$v['userid']] = $v['modelid'];
			}
		}
		if ($this->db->delete($where)) {
			//删除用户模型用户资料
			foreach($uidarr as $v) {
				if(!empty($userinfo[$v])) {
					$this->db->set_model($userinfo[$v]);
					$this->db->delete(array('userid'=>$v));
					$this->member_login_db->delete(array('uid'=>$v));
				}
			}
			dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
		} else {
			dr_admin_msg(0,L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * lock member
	 */
	function lock() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('islock'=>1), $where);
			dr_admin_msg(1,L('member_lock').L('operation_success'), HTTP_REFERER);
		} else {
			dr_admin_msg(0,L('operation_failure'), HTTP_REFERER);
		}
	}
	
	/**
	 * unlock member
	 */
	function unlock() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			if($this->db->update(array('islock'=>0), $where)) {
				$config = getcache('common','commons');
				if ($config) {
					if (isset($config['safe_wdl']) && $config['safe_wdl']) {
						$time = $config['safe_wdl'] * 3600 * 24;
						$login_where[] = 'logintime < '.(SYS_TIME - $time);
						$login_where[] = to_sqls($uidarr, '', 'uid');
						$this->member_login_db->update(array('logintime'=>SYS_TIME), implode(' AND ', $login_where));
					}
				}
			}
			dr_admin_msg(1,L('member_unlock').L('operation_success'), HTTP_REFERER);
		} else {
			dr_admin_msg(0,L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * move member
	 */
	function move() {
		if(isset($_POST['dosubmit'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
			$groupid = isset($_POST['groupid']) && !empty($_POST['groupid']) ? $_POST['groupid'] : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
			
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('groupid'=>$groupid), $where);
			dr_admin_msg(1,L('member_move').L('operation_success'), HTTP_REFERER, '', 'move');
		} else {
			$show_header = $show_scroll = true;
			$grouplist = getcache('grouplist');
			foreach($grouplist as $k=>$v) {
				$grouplist[$k] = $v['name'];
			}
			
			$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']): dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
			array_pop($ids);
			if(!empty($ids)) {
				$where = to_sqls($ids, '', 'userid');
				$userarr = $this->db->listinfo($where);
			} else {
				dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER, '', 'move');
			}
			
			include $this->admin_tpl('member_move');
		}
	}

	function memberinfo() {
		$show_header = false;
		
		$userid = !empty($_GET['userid']) ? intval($_GET['userid']) : '';
		$username = !empty($_GET['username']) ? trim($_GET['username']) : '';
		if(!empty($userid)) {
			$memberinfo = $this->db->get_one(array('userid'=>$userid));
		} elseif(!empty($username)) {
			$memberinfo = $this->db->get_one(array('username'=>$username));
		} else {
			dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		}
		
		if(empty($memberinfo)) {
			dr_admin_msg(0,L('user').L('not_exists'), HTTP_REFERER);
		}
		
		$memberinfo['avatar'] = get_memberavatar($memberinfo['userid']);

		$grouplist = getcache('grouplist');
		//会员模型缓存
		$modellist = getcache('member_model', 'commons');

		$modelid = !empty($_GET['modelid']) ? intval($_GET['modelid']) : $memberinfo['modelid'];
		//站群缓存
		$sitelist =getcache('sitelist', 'commons');

		$this->db->set_model($modelid);
		$member_modelinfo_arr = $this->db->get_one(array('userid'=>$userid));
		//模型字段名称
		$model_fieldinfo = getcache('model_field_'.$modelid, 'model');
	
		//图片字段显示图片
		foreach($model_fieldinfo as $k=>$v) {
			if($v['formtype'] == 'omnipotent') continue;
			if($v['formtype'] == 'image') {
				$member_modelinfo[$v['name']] = "<a href='".$member_modelinfo_arr[$k]."' target='_blank'><img src='".$member_modelinfo_arr[$k]."' height='40' widht='40' onerror=\"this.src='".IMG_PATH."member/nophoto.gif'\"></a>";
			} elseif($v['formtype'] == 'datetime' && $v['fieldtype'] == 'int') {	//如果为日期字段
				$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k] ? format::date($member_modelinfo_arr[$k], $v['format']) : '';
			} elseif($v['formtype'] == 'images') {
				$tmp = string2array($member_modelinfo_arr[$k]);
				$member_modelinfo[$v['name']] = '';
				if(is_array($tmp)) {
					foreach ($tmp as $tv) {
						$member_modelinfo[$v['name']] .= " <a href='".$tv['url']."' target='_blank'><img src='".$tv['url']."' height='40' widht='40' onerror=\"this.src='".IMG_PATH."member/nophoto.gif'\"></a>";
					}
					unset($tmp);
				}
			} elseif($v['formtype'] == 'box') {	//box字段，获取字段名称和值的数组
				$tmp = explode("\n",$v['options']);
				if(is_array($tmp)) {
					foreach($tmp as $boxv) {
						$box_tmp_arr = explode('|', trim($boxv));
						if(is_array($box_tmp_arr) && isset($box_tmp_arr[1]) && isset($box_tmp_arr[0])) {
							$box_tmp[$box_tmp_arr[1]] = $box_tmp_arr[0];
							$tmp_key = intval($member_modelinfo_arr[$k]);
						}
					}
				}
				if(isset($box_tmp[$tmp_key])) {
					$member_modelinfo[$v['name']] = $box_tmp[$tmp_key];
				} else {
					$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k];
				}
				unset($tmp, $tmp_key, $box_tmp, $box_tmp_arr);
			} elseif($v['formtype'] == 'linkage') {	//如果为联动菜单
				$tmp = string2array($v['setting']);
				$fullname = dr_linkagepos($tmp['linkage'], $member_modelinfo_arr[$k], $tmp['space']);

				$member_modelinfo[$v['name']] = substr($fullname, 0, -1);
				unset($tmp, $fullname);
			} else {
				$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k];
			}
		}

		include $this->admin_tpl('member_moreinfo');
	}
	
	private function _checkuserinfo($data, $is_edit=0) {
		if(!is_array($data)){
			dr_admin_msg(0,L('need_more_param'));return false;
		} elseif (!is_username($data['username']) && !$is_edit){
			dr_admin_msg(0,L('username_format_incorrect'));return false;
		} elseif (!isset($data['userid']) && $is_edit) {
			dr_admin_msg(0,L('username_format_incorrect'));return false;
		}  elseif (empty($data['email']) || !is_email($data['email'])){
			dr_admin_msg(0,L('email_format_incorrect'));return false;
		}
		return $data;
	}
		
	private function _checkpasswd($password){
		if (!is_password($password)){
			return false;
		}
		return true;
	}
	
	private function _checkname($username) {
		$username =  trim($username);
		if ($this->db->get_one(array('username'=>$username))){
			return false;
		}
		return true;
	}
	
	/**
	 * 检查用户名
	 * @param string $username	用户名
	 * @return $status {-4：用户名禁止注册;-1:用户名已经存在 ;1:成功}
	 */
	public function public_checkname_ajax() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if(CHARSET != 'utf-8') {
			$username = iconv('utf-8', CHARSET, $username);
			$username = addslashes($username);
		}
			
		if(isset($_GET['userid'])) {
			$userid = intval($_GET['userid']);
			//如果是会员修改，而且NICKNAME和原来优质一致返回1，否则返回0
			$info = get_memberinfo($userid);
			if($info['username'] == $username){//未改变
				exit('1');
			}else{//已改变，判断是否已有此名
				$where = array('username'=>$username);
				$res = $this->db->get_one($where);
				if($res) {
					exit('0');
				} else {
					exit('1');
				}
			}
 		} else {
			$where = array('username'=>$username);
			$res = $this->db->get_one($where);
			if($res) {
				exit('0');
			} else {
				exit('1');
			}
		}
		
	}
	
	/**
	 * 检查邮箱
	 * @param string $email
	 * @return $status {-1:email已经存在 ;-5:邮箱禁止注册;1:成功}
	 */
	public function public_checkemail_ajax() {
		$email = isset($_GET['email']) && trim($_GET['email']) ? trim($_GET['email']) : exit(0);
		
		if(isset($_GET['userid'])) {
			$userid = intval($_GET['userid']);
			//如果是会员修改，而且NICKNAME和原来优质一致返回1，否则返回0
			$info = get_memberinfo($userid);
			if($info['email'] == $email){//未改变
				exit('1');
			}else{//已改变，判断是否已有此名
				$where = array('email'=>$email);
				$res = $this->db->get_one($where);
				if($res) {
					exit('0');
				} else {
					exit('1');
				}
			}
 		} else {
			$where = array('email'=>$email);
			$res = $this->db->get_one($where);
			if($res) {
				exit('0');
			} else {
				exit('1');
			}
		}
	}

	// 验证邮件地址
	public function check_email($value) {

		if (!$value) {
			return false;
		} elseif (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $value)) {
			return false;
		} elseif (strpos($value, '"') !== false || strpos($value, '\'') !== false) {
			return false;
		}

		return true;
	}

	// 验证账号
	public function check_username($value) {
		$member_setting = getcache('member_setting', 'member');

		if (!$value) {
			return dr_return_data(0, L('账号不能为空'), array('field' => 'username'));
		} elseif ($member_setting['config']['preg']
			&& !preg_match($member_setting['config']['preg'], $value)) {
			// 验证账号的组成格式
			return dr_return_data(0, L('账号格式不正确'), array('field' => 'username'));
		} elseif (strpos($value, '"') !== false || strpos($value, '\'') !== false) {
			// 引号判断
			return dr_return_data(0, L('账号名存在非法字符'), array('field' => 'username'));
		} elseif ($member_setting['config']['userlen']
			&& mb_strlen($value) < $member_setting['config']['userlen']) {
			// 验证账号长度
			return dr_return_data(0, L('账号长度不能小于'.$member_setting['config']['userlen'].'位，当前'.mb_strlen($value).'位'), array('field' => 'username'));
		} elseif ($member_setting['config']['userlenmax']
			&& mb_strlen($value) > $member_setting['config']['userlenmax']) {
			// 验证账号长度
			return dr_return_data(0, L('账号长度不能大于'.$member_setting['config']['userlenmax'].'位，当前'.mb_strlen($value).'位'), array('field' => 'username'));
		}
		$notallow = [$member_setting['notallow']];
		$notallow[] = L('游客');
		// 后台不允许注册的词语，放在最后一次比较
		foreach ($notallow as $a) {
			if (dr_strlen($a) && strpos($value, $a) !== false) {
				return dr_return_data(0, L('账号名不允许注册'), array('field' => 'username'));
			}
		}

		return dr_return_data(1, 'ok');
	}

	// 验证账号的密码
	public function check_password($value, $username) {
		$member_setting = getcache('member_setting', 'member');

		if (!$value) {
			return dr_return_data(0, L('密码不能为空'), array('field' => 'password'));
		} elseif (!$member_setting['config']['user2pwd'] && $value == $username) {
			return dr_return_data(0, L('密码不能与账号相同'), array('field' => 'password'));
		} elseif ($member_setting['config']['pwdpreg']
			&& !preg_match(trim($member_setting['config']['pwdpreg']), $value)) {
			return dr_return_data(0, L('密码格式不正确'), array('field' => 'password'));
		} elseif ($member_setting['config']['pwdlen']
			&& mb_strlen($value) < $member_setting['config']['pwdlen']) {
			return dr_return_data(0, L('密码长度不能小于'.$member_setting['config']['pwdlen'].'位，当前'.mb_strlen($value).'位'), array('field' => 'password'));
		} elseif ($member_setting['config']['pwdmax']
			&& mb_strlen($value) > $member_setting['config']['pwdmax']) {
			return dr_return_data(0, L('密码长度不能大于'.$member_setting['config']['pwdmax'].'位，当前'.mb_strlen($value).'位'), array('field' => 'password'));
		}

		return dr_return_data(1, 'ok');
	}
	
}
?>