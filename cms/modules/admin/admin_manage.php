<?php
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('admin');
class admin_manage extends admin {
	private $db,$role_db;
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('admin_model');
		$this->admin_login_db = pc_base::load_model('admin_login_model');
		$this->role_db = pc_base::load_model('admin_role_model');
		$this->op = pc_base::load_app_class('admin_op');
	}
	
	/**
	 * 管理员管理列表
	 */
	public function init() {
		$userid = $_SESSION['userid'];
		$admin_username = param::get_cookie('admin_username');
		$page = $this->input->get('page') ? intval($this->input->get('page')) : '1';
		$infos = $this->db->listinfo('', '', $page, 20);
		$pages = $this->db->pages;
		$roles = getcache('role','commons');
		include $this->admin_tpl('admin_list');
	}

    // 修改账号
    public function username_edit() {
        $show_header = '';

        $userid = intval($this->input->get('userid'));
        $info = $this->db->get_one(array('userid'=>$userid));
        extract($info);	
        if (!$info) {
            dr_json(0, L('该用户不存在'));
        }

        if (IS_POST) {
            $name = trim(dr_safe_filename($this->input->post('name')));
            if (!$name) {
                dr_json(0, L('新账号不能为空'));
            } elseif ($info['username'] == $name) {
                dr_json(0, L('新账号不能和原始账号相同'));
            } elseif ($this->db->count(array('username'=>$name))) {
                dr_json(0, L('新账号'.$name.'已经注册'));
            }

            $this->db->update(array('username'=>$name), array('userid'=>$userid));

            dr_json(1, L('操作成功'));
        }

        include $this->admin_tpl('admin_edit_username');exit;
    }
	
	/**
	 * 添加管理员
	 */
	public function add() {
		if($this->input->post('dosubmit')) {
			if($this->check_admin_manage_code()==false){
				dr_admin_msg(0,"error auth code");
			}
			$info = array();
			if(!$this->op->checkname($this->input->post('info')['username'])){
				dr_admin_msg(0,L('admin_already_exists'));
			}
			$info = checkuserinfo($this->input->post('info'));		
			if(!checkpasswd($info['password'])){
				dr_admin_msg(0,L('pwd_incorrect'));
			}
			$passwordinfo = password($info['password']);
			$info['password'] = $passwordinfo['password'];
			$info['encrypt'] = $passwordinfo['encrypt'];
			
			$admin_fields = array('username', 'email', 'password', 'encrypt','roleid','realname');
			foreach ($info as $k=>$value) {
				if (!in_array($k, $admin_fields)){
					unset($info[$k]);
				}
			}
			$this->db->insert($info);
			if($this->db->insert_id()){
				dr_admin_msg(1,L('operation_success'),'?m=admin&c=admin_manage');
			}
		} else {
			$roles = $this->role_db->select(array('disabled'=>'0'));
			$admin_manage_code = $this->get_admin_manage_code();
			include $this->admin_tpl('admin_add');
		}
		
	}
	
	/**
	 * 修改管理员
	 */
	public function edit() {
		if($this->input->post('dosubmit')) {
			if($this->check_admin_manage_code()==false){
				dr_admin_msg(0,"error auth code");
			}
			$memberinfo = $info = array();			
			$info = checkuserinfo($this->input->post('info'));
			if(isset($info['password']) && !empty($info['password']))
			{
				$this->op->edit_password($info['userid'], $info['password']);
			}
			$userid = $info['userid'];
			$admin_fields = array('username', 'email', 'roleid','realname');
			foreach ($info as $k=>$value) {
				if (!in_array($k, $admin_fields)){
					unset($info[$k]);
				}
			}
			$this->db->update($info,array('userid'=>$userid));
			dr_admin_msg(1,L('operation_success'),'','','edit');
		} else {
			$info = $this->db->get_one(array('userid'=>$this->input->get('userid')));
			extract($info);	
			$roles = $this->role_db->select(array('disabled'=>'0'));	
			$show_header = true;
			$admin_manage_code = $this->get_admin_manage_code();
			include $this->admin_tpl('admin_edit');		
		}
	}
	
	/**
	 * 删除管理员
	 */
	public function delete() {
		$userid = intval($this->input->get('userid'));
		if($userid == '1') dr_admin_msg(0,L('this_object_not_del'), HTTP_REFERER);
		$this->db->delete(array('userid'=>$userid));
		dr_admin_msg(1,L('admin_cancel_succ'));
	}

	/**
	 * 锁定管理员
	 */
	function lock() {
		$userid = intval($this->input->get('userid'));
		if(!$userid) {
			dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(ADMIN_FOUNDERS && !dr_in_array($userid, ADMIN_FOUNDERS)) {
				$this->db->update(array('islock'=>1), array('userid'=>$userid));
				dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
			} else {
				dr_admin_msg(0,L('founder_cannot_locked'), HTTP_REFERER);
			}
		}
	}
	
	/**
	 * 解锁管理员
	 */
	function unlock() {
		$userid = intval($this->input->get('userid'));
		if(!$userid) {
			dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		} else {
			if($this->db->update(array('islock'=>0), array('userid'=>$userid))) {
				$config = getcache('common','commons');
				if ($config) {
					if (isset($config['safe_wdl']) && $config['safe_wdl']) {
						$time = $config['safe_wdl'] * 3600 * 24;
						$login_where[] = 'logintime < '.(SYS_TIME - $time);
						$login_where[] = 'uid = '.$userid;
						$this->admin_login_db->update(array('logintime'=>SYS_TIME), implode(' AND ', $login_where));
					}
				}
			}
			dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
		}
	}
	
	/**
	 * 管理员自助修改密码
	 */
	public function public_edit_pwd() {
		$userid = $_SESSION['userid'];
		if($this->input->post('dosubmit')) {
			$r = $this->db->get_one(array('userid'=>$userid),'password,encrypt');
			if (password($this->input->post('old_password'),$r['encrypt']) !== $r['password']) dr_admin_msg(0,L('old_password_wrong'),HTTP_REFERER);
			if($this->input->post('new_password') && !empty($this->input->post('new_password'))) {
				if($this->op->edit_password($userid, $this->input->post('new_password'))) {
					$this->admin_login_db->update(array('is_login' => SYS_TIME, 'is_repwd' => SYS_TIME, 'updatetime' => SYS_TIME), array('uid'=>$userid));
				}
			}
			dr_admin_msg(1,L('password_edit_succ_logout'),'?m=admin&c=index&a=public_logout');
		} else {
			$info = $this->db->get_one(array('userid'=>$userid));
			extract($info);
			include $this->admin_tpl('admin_edit_pwd');			
		}

	}
	/*
	 * 编辑用户信息
	 */
	public function public_edit_info() {
		$userid = $_SESSION['userid'];
		if($this->input->post('dosubmit')) {
			$admin_fields = array('email','realname','lang');
			$info = array();
			$info = $this->input->post('info');
			if(trim($info['lang'])=='') $info['lang'] = 'zh-cn';
			foreach ($info as $k=>$value) {
				if (!in_array($k, $admin_fields)){
					unset($info[$k]);
				}
			}
			$this->db->update($info,array('userid'=>$userid));
			param::set_cookie('sys_lang', $info['lang'],SYS_TIME+86400*30);
			dr_admin_msg(1,L('operation_success'),HTTP_REFERER);			
		} else {
			$info = $this->db->get_one(array('userid'=>$userid));
			extract($info);
			
			$lang_dirs = glob(PC_PATH.'languages/*');
			$dir_array = array();
			foreach($lang_dirs as $dirs) {
				$dir_array[] = str_replace(PC_PATH.'languages/','',$dirs);
			}
			include $this->admin_tpl('admin_edit_info');			
		}	
	
	}
	/**
	 * 异步检测用户名
	 */
	function public_checkname_ajx() {
		$username = $this->input->get('username') && trim($this->input->get('username')) ? trim($this->input->get('username')) : exit(0);
		if ($this->db->get_one(array('username'=>$username),'userid')){
			exit('0');
		}
		exit('1');
	}
	/**
	 * 异步检测密码
	 */
	function public_password_ajx() {
		$userid = $_SESSION['userid'];
		$r = array();
		$r = $this->db->get_one(array('userid'=>$userid),'password,encrypt');
		if ( password($this->input->get('old_password'),$r['encrypt']) == $r['password'] ) {
			exit('1');
		}
		exit('0');
	}
	/**
	 * 异步检测emial合法性
	 */
	function public_email_ajx() {
		$email = $this->input->get('email');
		$userid = $_SESSION['userid'];
		$check = $this->db->get_one(array('email'=>$email),'userid');
		if ($check && $check['userid']!=$userid){
			exit('0');
		}else{
			exit('1');
		}
 	}

	//添加修改用户 验证串验证
	private function check_admin_manage_code(){
		$admin_manage_code = $this->input->post('info')['admin_manage_code'];
		$pc_auth_key = md5(SYS_KEY.'adminuser');
		$admin_manage_code = sys_auth($admin_manage_code, 'DECODE', $pc_auth_key);	
		if($admin_manage_code==""){
			return false;
		}
		$admin_manage_code = explode("_", $admin_manage_code);
		if($admin_manage_code[0]!="adminuser" || $admin_manage_code[1]!=$this->input->post('pc_hash')){
			return false;
		}
		return true;
	}
	//添加修改用户 生成验证串
	private function get_admin_manage_code(){
		$pc_auth_key = md5(SYS_KEY.'adminuser');
		$code = sys_auth("adminuser_".$this->input->get('pc_hash')."_".time(), 'ENCODE', $pc_auth_key);
		return $code;
	}	
}
?>