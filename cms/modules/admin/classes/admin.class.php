<?php
defined('IN_CMS') or exit('No permission resources.');
$session_storage = 'session_'.pc_base::load_config('system','session_storage');
pc_base::load_sys_class($session_storage);
if(param::get_cookie('sys_lang')) {
	define('SYS_STYLE',param::get_cookie('sys_lang'));
} else {
	define('SYS_STYLE','zh-cn');
}
//定义在后台
!defined('IN_ADMIN') && define('IN_ADMIN', TRUE);
class admin {
	public $userid;
	public $username;
	
	public function __construct() {
		if (NeedCheckComeUrl) self::check_url();
		self::login_before();
		self::check_admin();
		self::check_priv();
		pc_base::load_app_func('global','admin');
		if (!module_exists(ROUTE_M)) dr_admin_msg(0,L('module_not_exists'));
		self::manage_log();
		self::check_ip();
		self::lock_screen();
		self::check_hash();
	}
	
	/**
	 * 判断用户是否已经登陆
	 */
	final public function check_admin() {
		if(ROUTE_M =='admin' && ROUTE_C =='index' && in_array(ROUTE_A, array(SYS_ADMIN_PATH, 'fclient'))) {
			return true;
		} else {
			$cache = pc_base::load_sys_class('cache');
			$config = getcache('common','commons');
			$admin_db = pc_base::load_model('admin_model');
			$userid = param::get_cookie('userid');
			$login_attr = param::get_cookie('login_attr');
			$user = $admin_db->get_one(array('userid'=>$userid));
			if ($user && $login_attr!=md5(SYS_KEY.$user['password'].(isset($user['login_attr']) ? $user['login_attr'] : ''))) {
				if (isset($config['login_use']) && dr_in_array('admin', $config['login_use'])) {
					$cache->del_auth_data('admin_option_'.$_SESSION['userid']);
				}
				$_SESSION['userid'] = 0;
				$_SESSION['login_attr'] = '';
				$_SESSION['roleid'] = 0;
				param::set_cookie('admin_username','');
				param::set_cookie('userid',0);
				param::set_cookie('login_attr', '');
				$cache->clear(COOKIE_PRE.ip().'pc_hash');
				redirect('?m=admin&c=index&a='.SYS_ADMIN_PATH);
			}
			if(!isset($_SESSION['userid']) || !isset($_SESSION['roleid']) || !$_SESSION['userid'] || !$_SESSION['roleid'] || $userid != $_SESSION['userid']) dr_admin_msg(0,L('admin_login'),'?m=admin&c=index&a='.SYS_ADMIN_PATH);
		}
	}

	/**
	 * 加载后台模板
	 * @param string $file 文件名
	 * @param string $m 模型名
	 */
	final public static function admin_tpl($file, $m = '') {
		return admin_template($file, $m);
	}
	
	/**
	 * 按父ID查找菜单子项
	 * @param integer $parentid   父菜单ID  
	 * @param integer $with_self  是否包括他自己
	 */
	final public static function admin_menu($parentid, $with_self = 0) {
		$parentid = intval($parentid);
		$menudb = pc_base::load_model('menu_model');
		$site_model = param::get_cookie('site_model');
		$where = array('parentid'=>$parentid,'display'=>1);
		if ($site_model && $parentid) {
			$where[$site_model] = 1;
 		}
		$result =$menudb->select($where,'*',1000,'listorder ASC,id ASC');
		if($with_self) {
			$result2[] = $menudb->get_one(array('id'=>$parentid));
			$result = array_merge($result2,$result);
		}
		//权限检查
		if($_SESSION['roleid'] == 1) return $result;
		$array = array();
		$privdb = pc_base::load_model('admin_role_priv_model');
		$siteid = param::get_cookie('siteid');
		foreach($result as $v) {
			$action = $v['a'];
			if(preg_match('/^public_/',$action)) {
				$array[] = $v;
			} else {
				if(preg_match('/^ajax_([a-z]+)_/',$action,$_match)) $action = $_match[1];
				$r = $privdb->get_one(array('m'=>$v['m'],'c'=>$v['c'],'a'=>$action,'roleid'=>$_SESSION['roleid'],'siteid'=>$siteid));
				if($r) $array[] = $v;
			}
		}
		return $array;
	}
	/**
	 * 获取菜单 头部菜单导航
	 * 
	 * @param $parentid 菜单id
	 */
	final public static function submenu($parentid = '', $big_menu = false) {
		$input = pc_base::load_sys_class('input');
		if(empty($parentid)) {
			$menudb = pc_base::load_model('menu_model');
			$r = $menudb->get_one(array('m'=>ROUTE_M,'c'=>ROUTE_C,'a'=>ROUTE_A));
			$parentid = isset($r['id']) ? $r['id'] : $input->get('menuid');
		}
		$array = self::admin_menu($parentid,1);
		
		$numbers = count($array);
		if($numbers==1 && !$big_menu) return '';
		$string = '';
		$pc_hash = dr_get_csrf_token();
		foreach($array as $_value) {
			if (!$input->get('s')) {
				$classname = ROUTE_M == $_value['m'] && ROUTE_C == $_value['c'] && ROUTE_A == $_value['a'] ? 'class="on"' : '';
			} else {
				$_s = !empty($_value['data']) ? str_replace('=', '', strstr($_value['data'], '=')) : '';
				$classname = ROUTE_M == $_value['m'] && ROUTE_C == $_value['c'] && ROUTE_A == $_value['a'] && $input->get('s') == $_s ? 'class="on"' : '';
			}
			if($_value['parentid'] == 0 || $_value['m']=='') continue;
			if($classname) {
				$string .= "<a href='javascript:;' $classname><em>".L($_value['name'])."</em></a><span>|</span>";
			} else {
				$string .= "<a href='?m=".$_value['m']."&c=".$_value['c']."&a=".$_value['a']."&menuid=$parentid&pc_hash=$pc_hash".'&'.$_value['data']."' $classname><em>".L($_value['name'])."</em></a><span>|</span>";
			}
		}
		$string = substr($string,0,-14);
		return $string;
	}
	final public static function child_menu($parentid, $self = 0) {
		$datas = self::admin_menu($parentid);
		$valuedata = '';
		if($datas) {
			$i = 0;
			$child = ',"child": [';
			foreach($datas as $value) {
				if ($value['data']) {
					if (strstr($value['data'], '&') && substr($value['data'], 0, 1)=='&') {
						$valuedata = $value['data'];
					} else {
						$valuedata = '&'.$value['data'];
					}
				}
				if ($self==1) {
					if ($i==0) {
						$child .= '{"id": "'.$value['id'].'","title": "'.L($value['name']).'","href": "","icon": "'.$value['icon'].'","target": "_self"'.self::child_menu($value['id']).'}';
					} else {
						$child .= ',{"id": "'.$value['id'].'","title": "'.L($value['name']).'","href": "","icon": "'.$value['icon'].'","target": "_self"'.self::child_menu($value['id']).'}';
					}
				} else {
					if ($i==0) {
						$child .= '{"id": "'.$value['id'].'","title": "'.L($value['name']).'","href": "?m='.$value['m'].'&c='.$value['c'].'&a='.$value['a'].$valuedata.'&menuid='.$value['id'].'&pc_hash='.dr_get_csrf_token().'","icon": "'.$value['icon'].'","target": "_self"}';
					} else {
						$child .= ',{"id": "'.$value['id'].'","title": "'.L($value['name']).'","href": "?m='.$value['m'].'&c='.$value['c'].'&a='.$value['a'].$valuedata.'&menuid='.$value['id'].'&pc_hash='.dr_get_csrf_token().'","icon": "'.$value['icon'].'","target": "_self"}';
					}
				}
				$i ++;
	        }
			$child .= ']';
		}
		return $child;
	}
	/**
	 * 当前位置
	 * 
	 * @param $id 菜单id
	 */
	final public static function current_pos($id) {
		$menudb = pc_base::load_model('menu_model');
		$r =$menudb->get_one(array('id'=>$id),'id,name,parentid');
		$str = '';
		if($r['parentid']) {
			$str = self::current_pos($r['parentid']);
		}
		return $str.L($r['name']).' > ';
	}
	
	/**
	 * 获取当前的站点ID
	 */
	final public static function get_siteid() {
		return get_siteid();
	}
	
	/**
	 * 获取当前站点信息
	 * @param integer $siteid 站点ID号，为空时取当前站点的信息
	 * @return array
	 */
	final public static function get_siteinfo($siteid = '') {
		if ($siteid == '') $siteid = self::get_siteid();
		if (empty($siteid)) return false;
		$sites = pc_base::load_app_class('sites', 'admin');
		return $sites->get_by_id($siteid);
	}
	
	final public static function return_siteid() {
		$sites = pc_base::load_app_class('sites', 'admin');
		$siteid = explode(',',$sites->get_role_siteid($_SESSION['roleid']));
		return current($siteid);
	}
	/**
	 * 权限判断
	 */
	final public function check_priv() {
		if(ROUTE_M =='admin' && ROUTE_C =='index' && in_array(ROUTE_A, array(SYS_ADMIN_PATH, 'init', 'fclient'))) return true;
		if($_SESSION['roleid'] == 1) return true;
		$siteid = param::get_cookie('siteid');
		$action = ROUTE_A;
		$privdb = pc_base::load_model('admin_role_priv_model');
		if(preg_match('/^public_/',ROUTE_A)) return true;
		if(preg_match('/^ajax_([a-z]+)_/',ROUTE_A,$_match)) {
			$action = $_match[1];
		}
		$r =$privdb->get_one(array('m'=>ROUTE_M,'c'=>ROUTE_C,'a'=>$action,'roleid'=>$_SESSION['roleid'],'siteid'=>$siteid));
		if(!$r) dr_admin_msg(0,'您没有权限操作该项');
	}

	/**
	 * 获取登陆信息
	 */
	final public static function admin_get_log($uid) {
		$admin_login_db = pc_base::load_model('admin_login_model');
		if ($uid) {
			$row = $admin_login_db->get_one(array('uid'=>$uid));
			if (!$row) {
				$row = array(
					'uid' => $uid,
					'is_login' => 0,
					'is_repwd' => 0,
					'updatetime' => 0,
				);
				$id = $admin_login_db->insert($row, true);
				$row['id'] = $id;
			}
			$loguid = $row;
		}
		return $loguid;
	}

	/**
 	 * 登录之前更新ip
 	 */
	final public static function admin_login_before($username) {
		if (!$username) {
			return;
		}
		$cache = pc_base::load_sys_class('cache');
		$input = pc_base::load_sys_class('input');
		$admin_db = pc_base::load_model('admin_model');
		$config = getcache('common','commons');
		$user = $admin_db->get_one(array('username'=>$username));
		if (!$user) {
			return;
		}
		if ($config) {
			$log = self::admin_get_log($user['userid']);
			if (isset($config['login_use']) && dr_in_array('admin', $config['login_use'])) {
				$attr = '';
				if ((isset($config['login_city']) && $config['login_city'])) {
					$attr.= $input->ip_address();
				}
				if ((isset($config['login_llq']) && $config['login_llq'])) {
					$attr.= $input->get_user_agent();
				}
				if ($attr) {
					$admin_db->update(array('login_attr'=>md5($attr)), array('userid'=>$log['uid']));
				}
			}
		}
	}

	/**
	 * 
	 * 记录日志 
	 */
	private function manage_log() {
		//判断是否记录
 		if(SYS_ADMIN_LOG){
 			$action = ROUTE_A;
 			if($action == '' || strchr($action,'public') || $action == 'init' || $action=='public_current_pos') {
				return false;
			}else {
				$ip = ip();
				$log = pc_base::load_model('log_model');
				$username = param::get_cookie('admin_username');
				$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
				$time = date('Y-m-d H-i-s',SYS_TIME);
				$url = '?m='.ROUTE_M.'&c='.ROUTE_C.'&a='.ROUTE_A;
				$log->insert(array('module'=>ROUTE_M,'username'=>$username,'userid'=>$userid,'action'=>ROUTE_C, 'querystring'=>$url,'time'=>$time,'ip'=>$ip));
			}
	  	}
	}
	
	/**
	 * 
	 * 后台IP禁止判断 ...
	 */
	private function check_ip(){
		$this->ipbanned = pc_base::load_model('ipbanned_model');
		$this->ipbanned->check_ip();
 	}
 	/**
 	 * 检查锁屏状态
 	 */
	private function lock_screen() {
		if(isset($_SESSION['lock_screen']) && $_SESSION['lock_screen']==1) {
			if(preg_match('/^public_/', ROUTE_A) || (ROUTE_M == 'content' && ROUTE_C == 'create_html') || (ROUTE_M == 'release') || (ROUTE_A == SYS_ADMIN_PATH) || (ROUTE_M == 'search' && ROUTE_C == 'search_admin' && ROUTE_A=='createindex')) return true;
			dr_admin_msg(0,L('admin_login'),'?m=admin&c=index&a='.SYS_ADMIN_PATH);
		}
	}

	/**
 	 * 检查hash值，验证用户数据安全性
 	 */
	private function check_hash() {
		$input = pc_base::load_sys_class('input');
		if(preg_match('/^public_/', ROUTE_A) || ROUTE_M =='admin' && ROUTE_C =='index' || in_array(ROUTE_A, array(SYS_ADMIN_PATH))) {
			return true;
		}
		if($input->get('pc_hash') && dr_get_csrf_token() != '' && (dr_get_csrf_token() == $input->get('pc_hash'))) {
			return true;
		} elseif($input->post('pc_hash') && dr_get_csrf_token() != '' && (dr_get_csrf_token() == $input->post('pc_hash'))) {
			return true;
		} else {
			dr_admin_msg(0,L('hash_check_false'),HTTP_REFERER);
		}
	}

	/**
 	 * 登录验证
 	 */
	private function login_before() {
		$cache = pc_base::load_sys_class('cache');
		$admin_db = pc_base::load_model('admin_model');
		$admin_login_db = pc_base::load_model('admin_login_model');
		$member_db = pc_base::load_model('member_lock_model');
		$member_login_db = pc_base::load_model('member_login_model');
		$userid = $_SESSION['userid'];
		$config = getcache('common','commons');
		if ($config) {
			if (isset($config['safe_use']) && dr_in_array('admin', $config['safe_use'])) {
				// 长时间未登录的用户就锁定起来
				if (isset($config['safe_wdl']) && $config['safe_wdl']) {
					$time = $config['safe_wdl'] * 3600 * 24;
					$where = 'logintime < '.(SYS_TIME - $time);
					$log_lock = $admin_login_db->select($where);
					if ($log_lock) {
						foreach ($log_lock as $t) {
							if (ADMIN_FOUNDERS && !dr_in_array($t['uid'], ADMIN_FOUNDERS)) {
								$admin_db->update(array('islock'=>1), array('userid'=>$t['uid']));
							}
						}
					}
				}
			}
			if (isset($config['safe_use']) && dr_in_array('member', $config['safe_use'])) {
				// 长时间未登录的用户就锁定起来
				if (isset($config['safe_wdl']) && $config['safe_wdl']) {
					$time = $config['safe_wdl'] * 3600 * 24;
					$where = 'logintime < '.(SYS_TIME - $time);
					$log_lock = $member_login_db->select($where);
					if ($log_lock) {
						foreach ($log_lock as $t) {
							$member_db->update(array('islock'=>1), array('userid'=>$t['uid']));
						}
					}
				}
			}
		}
		if ($config && $userid) {
			$log = self::admin_get_log($userid);
			if (isset($config['pwd_use']) && dr_in_array('admin', $config['pwd_use'])) {
				// 首次登录是否强制修改密码
				if (!$log['is_login'] && isset($config['pwd_is_login_edit']) && $config['pwd_is_login_edit']) {
					// 该改密码了
					if (ROUTE_M =='admin' && in_array(ROUTE_C, array('index','admin_manage')) && in_array(ROUTE_A, array(SYS_ADMIN_PATH,'public_edit_pwd','public_password_ajx'))) {
						return true; // 本身控制器不判断
					}
					dr_admin_msg(0,L('首次登录需要强制修改密码'), '?m=admin&c=admin_manage&a=public_edit_pwd');
				}
				// 判断定期修改密码
				if (isset($config['pwd_is_edit']) && $config['pwd_is_edit']
					&& isset($config['pwd_day_edit']) && $config['pwd_day_edit']) {
					if ($log['updatetime']) {
						// 存在修改过密码才判断
						$time = $config['pwd_day_edit'] * 3600 * 24;
						if (SYS_TIME - $log['updatetime'] > $time) {
							// 该改密码了
							if (ROUTE_M =='admin' && in_array(ROUTE_C, array('index','admin_manage')) && in_array(ROUTE_A, array(SYS_ADMIN_PATH,'public_edit_pwd','public_password_ajx'))) {
								return true; // 本身控制器不判断
							}
							dr_admin_msg(0,L('您需要定期修改密码'), '?m=admin&c=admin_manage&a=public_edit_pwd');
						}
					}
				}
			}
			if (isset($config['login_use']) && dr_in_array('admin', $config['login_use'])) {
				// 操作标记
				if (ROUTE_M =='admin' && ROUTE_C == 'index' && in_array(ROUTE_A, array(SYS_ADMIN_PATH))) {
					return; // 本身控制器不判断
				}
				if (isset($config['login_is_option']) && $config['login_is_option'] && $config['login_exit_time']) {
					$time = (int)$cache->get_auth_data('admin_option_'.$userid);
					$ctime = SYS_TIME - $time;
					if ($time && SYS_TIME - $time > $config['login_exit_time'] * 60) {
						// 长时间不动作退出
						$admin_db->update(array('login_attr'=>rand(0, 99999)), array('userid'=>$log['uid']));
						$cache->del_auth_data('admin_option_'.$userid);
						dr_admin_msg(0,L('长时间（'.ceil($ctime/60).'分钟）未操作，当前账号自动退出'),'?m=admin&c=index&a='.SYS_ADMIN_PATH);
					}
					$cache->set_auth_data('admin_option_'.$userid, SYS_TIME);
				}
			}
		}
	}

	/**
	 * 后台信息列表模板
	 * @param string $id 被选中的模板名称
	 * @param string $str form表单中的属性名
	 */
	final public function admin_list_template($id = '', $str = '') {
		$templatedir = PC_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR;
		$pre = 'content_list';
		$templates = glob($templatedir.$pre.'*.tpl.php');
		if(empty($templates)) return false;
		$files = @array_map('basename', $templates);
		$templates = array();
		if(is_array($files)) {
			foreach($files as $file) {
				$key = substr($file, 0, -8);
				$templates[$key] = $file;
			}
		}
		ksort($templates);
		return form::select($templates, $id, $str,L('please_select'));
	}
	
	// 验证操作其他用户身份权限
	public function cleck_edit_member($uid) {

		// 超管不验证
		//if (in_array(1, $_SESSION['roleid'])) {
			//return true;
		//} elseif (param::get_cookie('userid') == $uid) {
			// 自己不验证
			//return true;
		//} elseif ($this->db->get_one(array('userid'=>$uid),'userid')) {
			// 此账号属于管理账号，禁止操作
			//return false;
		//}

		return true;
	}
	
	/**
	 * 是否需要检查外部访问
	 */
	final public function check_url() {
		if(ROUTE_M =='admin' && ROUTE_C =='index' && in_array(ROUTE_A, array(SYS_ADMIN_PATH, 'public_main', 'fclient', 'init'))) {
			return true;
		} else {
			if (!HTTP_REFERER) {
				CI_DEBUG && log_message('error', '直接地址输入访问后台');
				echo '<!DOCTYPE html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提示信息</title><meta name="author" content="zhaoxunzhiyin" /><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"></head><body><div style="margin-top:30px;text-align:center"><font color="red">对不起，为了系统安全，不允许直接输入地址访问本系统的后台管理页面。</font></div></body></html>';
				exit();
			} else {
				$curl = trim(SITE_PROTOCOL.SITE_HURL);
				if (strtolower(substr(HTTP_REFERER, 0, strlen($curl))) != strtolower($curl)) {
					CI_DEBUG && log_message('error', '外部链接访问后台');
					echo '<!DOCTYPE html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提示信息</title><meta name="author" content="zhaoxunzhiyin" /><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"></head><body><div style="margin-top:30px;text-align:center"><font color="red">对不起，为了系统安全，不允许从外部链接地址访问本系统的后台管理页面。</font></div></body></html>';
					exit();
				}
			}
		}
	}
}