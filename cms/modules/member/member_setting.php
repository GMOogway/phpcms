<?php
/**
 * 管理员后台会员模块设置
 */

defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);

class member_setting extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('module_model');	
	}

	/**
	 * member list
	 */
	function manage() {
		$show_header = '';
		$show_validator = true;
		if(IS_AJAX_POST) {
			$member_setting = $this->input->post('info');
			$member_setting['allowregister'] = intval($member_setting['allowregister']);
			$member_setting['choosemodel'] = intval($member_setting['choosemodel']);
			$member_setting['enablemailcheck'] = intval($member_setting['enablemailcheck']);
			$member_setting['enablcodecheck'] = intval($member_setting['enablcodecheck']);
			$member_setting['registerverify'] = intval($member_setting['registerverify']);
			$member_setting['showapppoint'] = intval($member_setting['showapppoint']);
			$member_setting['showregprotocol'] = intval($member_setting['showregprotocol']);
			if (!preg_match('/^\\d{1,8}$/i', $member_setting['rmb_point_rate'])) {
				dr_json(0, L('rmb_point_rate').L('between_1_to_8_num'), array('field' => 'rmb_point_rate'));
			}
			if (!preg_match('/^\\d{1,8}$/i', $member_setting['defualtpoint'])) {
				dr_json(0, L('defualtpoint').L('between_1_to_8_num'), array('field' => 'defualtpoint'));
			}
			if (!preg_match('/^\\d{1,8}$/i', $member_setting['defualtamount'])) {
				dr_json(0, L('defualtamount').L('between_1_to_8_num'), array('field' => 'defualtamount'));
			}
			$this->db->update(array('module'=>'member', 'setting'=>array2string($member_setting)), array('module'=>'member'));
			setcache('member_setting', $member_setting);
			dr_json(1, L('operation_success'), array('url' => '?m=member&c=member_setting&a=manage&page='.(int)($this->input->post('page')).'&pc_hash='.dr_get_csrf_token()));
		} else {
			$show_scroll = true;
			$member_setting = $this->db->get_one(array('module'=>'member'), 'setting');
			$member_setting = string2array($member_setting['setting']);
			
			$email_config = getcache('common', 'commons');
			$this->sms_setting_arr = getcache('sms','sms');
			$siteid = get_siteid();
			
			if(empty($email_config['mail_user']) || empty($email_config['mail_password'])) {
				$mail_disabled = 1;
			}
			
			if(!empty($this->sms_setting_arr[$siteid])) {
 				$this->sms_setting = $this->sms_setting_arr[$siteid];
				if($this->sms_setting['sms_enable']=='0'){
					$sms_disabled = 1;
				}else{
					if(empty($this->sms_setting['userid']) || empty($this->sms_setting['productid']) || empty($this->sms_setting['sms_key'])){
					$sms_disabled = 1;
					}
				}
 			} else {
				$sms_disabled = 1;
			}
 			
			include $this->admin_tpl('member_setting');
		}

	}

}
?>