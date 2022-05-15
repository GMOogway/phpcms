<?php

class foreground {
	public $db, $memberinfo;
	private $_member_modelinfo;
	
	public function __construct() {
		$this->input = pc_base::load_sys_class('input');
		$this->cache = pc_base::load_sys_class('cache');
		self::check_ip();
		$this->db = pc_base::load_model('member_model');
		$this->member_login_db = pc_base::load_model('member_login_model');
		self::login_before();
		//ajax验证信息不需要登录
		if(substr(ROUTE_A, 0, 7) != 'public_') {
			self::check_member();
		}
	}
	
	/**
	 * 判断用户是否已经登录
	 */
	final public function check_member() {
		$cms_auth = param::get_cookie('auth');
		if(ROUTE_M =='member' && ROUTE_C =='index' && in_array(ROUTE_A, array('login', 'alogin', 'register', 'mini', 'send_newmail'))) {
			if ($cms_auth && ROUTE_A != 'mini' && ROUTE_A != 'alogin') {
				showmessage(L('login_success', '', 'member'), APP_PATH.'index.php?m=member&c=index');
			} else {
				return true;
			}
		} else {
			//判断是否存在auth cookie
			if ($cms_auth) {
				$auth_key = get_auth_key('login');
				$login_attr = param::get_cookie('_login_attr');
				list($userid, $password) = explode("\t", sys_auth($cms_auth, 'DECODE', $auth_key));
				$userid = intval($userid);
				//验证用户，获取用户信息
				$this->memberinfo = $this->db->get_one(array('userid'=>$userid));
				if($this->memberinfo['islock']) exit('<h1>Bad Request!</h1>');
				//获取用户模型信息
				$this->db->set_model($this->memberinfo['modelid']);

				$this->_member_modelinfo = $this->db->get_one(array('userid'=>$userid));
				$this->_member_modelinfo = $this->_member_modelinfo ? $this->_member_modelinfo : array();
				$this->db->set_model();
				if(is_array($this->memberinfo)) {
					$this->memberinfo = array_merge($this->memberinfo, $this->_member_modelinfo);
				}
				
				if($this->memberinfo && $this->memberinfo['password'] === $password) {
					
					if ($login_attr!=md5(SYS_KEY.$this->memberinfo['password'].(isset($this->memberinfo['login_attr']) ? $this->memberinfo['login_attr'] : ''))) {
						$config = getcache('common', 'commons');
						if (isset($config['login_use']) && dr_in_array('member', $config['login_use'])) {
							$this->cache->del_auth_data('member_option_'.$userid, 1);
						}
						param::set_cookie('auth', '');
						param::set_cookie('_userid', '');
						param::set_cookie('_login_attr', '');
						param::set_cookie('_username', '');
						param::set_cookie('_groupid', '');
						redirect(APP_PATH.'index.php?m=member&c=index&a=login');
					}
					
					if (!defined('SITEID')) {
					   define('SITEID', $this->memberinfo['siteid']);
					}
					
					if($this->memberinfo['groupid'] == 1) {
						param::set_cookie('auth', '');
						param::set_cookie('_userid', '');
						param::set_cookie('_login_attr', '');
						param::set_cookie('_username', '');
						param::set_cookie('_groupid', '');
						showmessage(L('userid_banned_by_administrator', '', 'member'), APP_PATH.'index.php?m=member&c=index&a=login');
					} elseif($this->memberinfo['groupid'] == 7) {
						param::set_cookie('auth', '');
						param::set_cookie('_userid', '');
						param::set_cookie('_login_attr', '');
						param::set_cookie('_groupid', '');
						
						//设置当前登录待验证账号COOKIE，为重发邮件所用
						param::set_cookie('_regusername', $this->memberinfo['username']);
						param::set_cookie('_reguserid', $this->memberinfo['userid']);
						
						param::set_cookie('email', $this->memberinfo['email']);
						showmessage(L('need_emial_authentication', '', 'member'), APP_PATH.'index.php?m=member&c=index&a=register&t=2');
					}
				} else {
					param::set_cookie('auth', '');
					param::set_cookie('_userid', '');
					param::set_cookie('_login_attr', '');
					param::set_cookie('_username', '');
					param::set_cookie('_groupid', '');
					redirect(APP_PATH.'index.php?m=member&c=index&a=login');
				}
				unset($userid, $password, $cms_auth, $auth_key);
			} else {
				$forward= $this->input->get('forward') ?  urlencode($this->input->get('forward')) : urlencode(dr_now_url());
				showmessage(L('please_login', '', 'member'), APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
			}
		}
	}
	/**
	 * 
	 * IP禁止判断 ...
	 */
	private function check_ip(){
		$this->ipbanned = pc_base::load_model('ipbanned_model');
		$this->ipbanned->check_ip();
 	}

	/**
	 * 获取登录信息
	 */
	final public function member_get_log($uid) {
		if ($uid) {
			$row = $this->member_login_db->get_one(array('uid'=>$uid));
			if (!$row) {
				$row = array(
					'uid' => $uid,
					'is_login' => 0,
					'is_repwd' => 0,
					'updatetime' => 0,
				);
				$id = $this->member_login_db->insert($row, true);
				$row['id'] = $id;
			}
			$loguid = $row;
		}
		return $loguid;
	}

	/**
 	 * 登录之前更新ip
 	 */
	final public function member_login_before($username) {
		if (!$username) {
			return;
		}
		$config = getcache('common','commons');
		$user = $this->db->get_one(array('username'=>$username));
		if (!$user) {
			return;
		}
		if ($config) {
			$log = self::member_get_log($user['userid']);
			if (isset($config['login_use']) && dr_in_array('member', $config['login_use'])) {
				$attr = '';
				if ((isset($config['login_city']) && $config['login_city'])) {
					$attr.= $this->input->ip_address();
				}
				if ((isset($config['login_llq']) && $config['login_llq'])) {
					$attr.= $this->input->get_user_agent();
				}
				if ($attr) {
					$this->db->update(array('login_attr'=>md5($attr)), array('userid'=>$log['uid']));
				}
			}
		}
	}
	
	/**
 	 * 登录验证
 	 */
	private function login_before() {
		$config = getcache('common','commons');
		if ($config) {
			if (isset($config['safe_use']) && dr_in_array('member', $config['safe_use'])) {
				// 长时间未登录的用户就锁定起来
				if (isset($config['safe_wdl']) && $config['safe_wdl']) {
					$time = $config['safe_wdl'] * 3600 * 24;
					$where = 'logintime < '.(SYS_TIME - $time);
					$log_lock = $this->member_login_db->select($where);
					if ($log_lock) {
						foreach ($log_lock as $t) {
							$this->db->update(array('islock'=>1), array('userid'=>$t['uid']));
						}
					}
				}
			}
		}
		$cms_auth = param::get_cookie('auth');
		if ($cms_auth) {
			list($userid) = explode("\t", sys_auth($cms_auth, 'DECODE', get_auth_key('login')));
			$userid = intval($userid);
			if ($config && $userid) {
				$log = self::member_get_log($userid);
				if (isset($config['pwd_use']) && dr_in_array('member', $config['pwd_use'])) {
					// 首次登录是否强制修改密码
					if (!$log['is_login'] && isset($config['pwd_is_login_edit']) && $config['pwd_is_login_edit']) {
						// 该改密码了
						if (ROUTE_M =='member' && ROUTE_C == 'index' && in_array(ROUTE_A, array('account_manage_password','public_checkemail_ajax','logout'))) {
							return true; // 本身控制器不判断
						}
						showmessage(L('首次登录需要强制修改密码'), '?m=member&c=index&a=account_manage_password&t=1');
					}
					// 判断定期修改密码
					if (isset($config['pwd_is_edit']) && $config['pwd_is_edit']
						&& isset($config['pwd_day_edit']) && $config['pwd_day_edit']) {
						if ($log['updatetime']) {
							// 存在修改过密码才判断
							$time = $config['pwd_day_edit'] * 3600 * 24;
							if (SYS_TIME - $log['updatetime'] > $time) {
								// 该改密码了
								if (ROUTE_M =='member' && ROUTE_C == 'index' && in_array(ROUTE_A, array('account_manage_password','public_checkemail_ajax','logout'))) {
									return true; // 本身控制器不判断
								}
								showmessage(L('您需要定期修改密码'), '?m=member&c=index&a=account_manage_password&t=1');
							}
						}
					}
				}
				if (isset($config['login_use']) && dr_in_array('member', $config['login_use'])) {
					// 操作标记
					if (ROUTE_M =='member' && ROUTE_C == 'index' && in_array(ROUTE_A, array('login'))) {
						return; // 本身控制器不判断
					}
					if (isset($config['login_is_option']) && $config['login_is_option'] && $config['login_exit_time']) {
						$time = (int)$this->cache->get_auth_data('member_option_'.$userid, 1);
						$ctime = SYS_TIME - $time;
						if ($time && SYS_TIME - $time > $config['login_exit_time'] * 60) {
							// 长时间不动作退出
							$this->db->update(array('login_attr'=>rand(0, 99999)), array('userid'=>$log['uid']));
							$this->cache->del_auth_data('member_option_'.$userid, 1);
							param::set_cookie('auth', '');
							param::set_cookie('_userid', '');
							param::set_cookie('_login_attr', '');
							param::set_cookie('_username', '');
							param::set_cookie('_groupid', '');
							showmessage(L('长时间（'.ceil($ctime/60).'分钟）未操作，当前账号自动退出'),'?m=member&c=index&a=login');
						}
						$this->cache->set_auth_data('member_option_'.$userid, SYS_TIME, 1);
					}
				}
			}
			unset($userid, $cms_auth);
		}
	}
}