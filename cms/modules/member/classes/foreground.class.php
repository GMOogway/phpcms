<?php

class foreground {
	public $db, $memberinfo;
	private $_member_modelinfo;
	
	public function __construct() {
		$this->input = pc_base::load_sys_class('input');
		self::check_ip();
		$this->db = pc_base::load_model('member_model');
		//ajax验证信息不需要登录
		if(substr(ROUTE_A, 0, 7) != 'public_') {
			self::check_member();
		}
		self::login_before();
	}
	
	/**
	 * 判断用户是否已经登陆
	 */
	final public function check_member() {
		$cms_auth = param::get_cookie('auth');
		if(ROUTE_M =='member' && ROUTE_C =='index' && in_array(ROUTE_A, array('login', 'alogin', 'register', 'mini', 'send_newmail'))) {
			if ($cms_auth && ROUTE_A != 'mini' && ROUTE_A != 'alogin') {
				showmessage(L('login_success', '', 'member'), 'index.php?m=member&c=index');
			} else {
				return true;
			}
		} else {
			//判断是否存在auth cookie
			if ($cms_auth) {
				$auth_key = $auth_key = get_auth_key('login');
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
					
					if (!defined('SITEID')) {
					   define('SITEID', $this->memberinfo['siteid']);
					}
					
					if($this->memberinfo['groupid'] == 1) {
						param::set_cookie('auth', '');
						param::set_cookie('_userid', '');
						param::set_cookie('_username', '');
						param::set_cookie('_groupid', '');
						showmessage(L('userid_banned_by_administrator', '', 'member'), 'index.php?m=member&c=index&a=login');
					} elseif($this->memberinfo['groupid'] == 7) {
						param::set_cookie('auth', '');
						param::set_cookie('_userid', '');
						param::set_cookie('_groupid', '');
						
						//设置当前登录待验证账号COOKIE，为重发邮件所用
						param::set_cookie('_regusername', $this->memberinfo['username']);
						param::set_cookie('_reguserid', $this->memberinfo['userid']);
						
						param::set_cookie('email', $this->memberinfo['email']);
						showmessage(L('need_emial_authentication', '', 'member'), 'index.php?m=member&c=index&a=register&t=2');
					}
				} else {
					param::set_cookie('auth', '');
					param::set_cookie('_userid', '');
					param::set_cookie('_username', '');
					param::set_cookie('_groupid', '');
				}
				unset($userid, $password, $cms_auth, $auth_key);
			} else {
				$forward= $this->input->get('forward') ?  urlencode($this->input->get('forward')) : urlencode(get_url());
				showmessage(L('please_login', '', 'member'), 'index.php?m=member&c=index&a=login&forward='.$forward);
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
 	 * 登录验证
 	 */
	private function login_before() {
		$member_login_db = pc_base::load_model('member_login_model');
		$table = $member_login_db->db_tablepre.'member_login';
		if (!$member_login_db->table_exists('member_login')) {
			$member_login_db->query(format_create_sql('CREATE TABLE `'.$table.'` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`uid` mediumint(8) unsigned DEFAULT NULL COMMENT \'会员uid\',
			`is_login` int(10) unsigned DEFAULT NULL COMMENT \'是否首次登录\',
			`is_repwd` int(10) unsigned DEFAULT NULL COMMENT \'是否重置密码\',
			`updatetime` int(10) unsigned NOT NULL COMMENT \'修改密码时间\',
			`logintime` int(10) unsigned NOT NULL COMMENT \'最近登录时间\',
			PRIMARY KEY (`id`),
			KEY `uid` (`uid`),
			KEY `logintime` (`logintime`),
			KEY `updatetime` (`updatetime`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT=\'账号记录\''));
		}
		$cache = pc_base::load_sys_class('cache');
		$userid = $this->memberinfo['userid'];
		$config = getcache('common','commons');
		if ($config) {
			// 长时间未登录的用户就锁定起来
			if (isset($config['safe_wdl']) && $config['safe_wdl']) {
				$time = $config['safe_wdl'] * 3600 * 24;
				$where = 'logintime < '.(SYS_TIME - $time);
				$log_lock = $member_login_db->select($where);
				if ($log_lock) {
					foreach ($log_lock as $t) {
						$this->db->update(array('islock'=>1), array('userid'=>$t['uid']));
					}
				}
			}
		}
		if ($config && $userid) {
			$log = $member_login_db->get_one(array('uid'=>$userid));
			if (!$log) {
				$log = array(
					'uid' => $userid,
					'is_login' => 0,
					'is_repwd' => 0,
					'updatetime' => 0,
					'logintime' => SYS_TIME,
				);
				$member_login_db->insert($log);
			}
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
	}
}