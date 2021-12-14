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
		$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
	}

	/**
	 * member list
	 */
	function manage() {
		$show_header = '';
		$show_validator = true;
		if(IS_AJAX_POST) {
			$member_setting = $this->input->post('info');
			$setting = $this->input->post('setting');
			$member_setting['allowregister'] = intval($member_setting['allowregister']);
			$member_setting['choosemodel'] = intval($member_setting['choosemodel']);
			$member_setting['enablemailcheck'] = intval($member_setting['enablemailcheck']);
			$member_setting['enablcodecheck'] = intval($member_setting['enablcodecheck']);
			$member_setting['registerverify'] = intval($member_setting['registerverify']);
			$member_setting['showapppoint'] = intval($member_setting['showapppoint']);
			$member_setting['showregprotocol'] = intval($member_setting['showregprotocol']);
			$member_setting['list_field'] = dr_list_field_order($setting['list_field']);
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
			$this->cache_api->cache('member_setting');
			dr_json(1, L('operation_success'), array('url' => '?m=member&c=member_setting&a=manage&page='.(int)($this->input->post('page')).'&pc_hash='.dr_get_csrf_token()));
		} else {
			$show_scroll = true;
			$member_setting = $this->db->get_one(array('module'=>'member'), 'setting');
			$member_setting = string2array($member_setting['setting']);
			$data['setting'] = $member_setting;
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
 			
			if (!isset($data['setting']['list_field']) || !$data['setting']['list_field']) {
				$data['setting']['list_field'] = array (
					'username' =>
						array (
							'use' => '1',
							'name' => '账号',
							'width' => '110',
							'func' => 'author',
						),
					'groupid' =>
						array (
							'func' => 'group',
							'center' => '1',
						),
					'nickname' =>
						array (
							'use' => '1',
							'name' => '昵称',
							'width' => '120',
							'func' => '',
						),
					'amount' =>
						array (
							'use' => '1',
							'name' => '余额',
							'width' => '120',
							'func' => 'money',
						),
					'point' =>
						array (
							'use' => '1',
							'name' => '积分',
							'width' => '120',
							'func' => 'score',
						),
					'regip' =>
						array (
							'use' => '1',
							'name' => '注册IP',
							'width' => '140',
							'func' => 'ip',
						),
					'regdate' =>
						array (
							'use' => '1',
							'name' => '注册时间',
							'width' => '160',
							'func' => 'datetime',
						),
				);
			}
			$page = intval($this->input->get('page'));
			$field = dr_list_field_value($data['setting']['list_field'], $this->member_list_field(), '');
			include $this->admin_tpl('member_setting');
		}

	}

	/**
	 * 会员内置字段
	 */
	public function member_list_field() {
		return array(
			'userid' => array(
				'name' => L('用户ID'),
				'formtype' => 'text',
				'field' => 'userid',
				'setting' => array()
			),
			'groupid' => array(
				'name' => L('用户组'),
				'formtype' => 'text',
				'field' => 'groupid',
				'setting' => array()
			),
			'username' => array(
				'name' => L('账号'),
				'formtype' => 'text',
				'field' => 'username',
				'setting' => array()
			),
			'nickname' => array(
				'name' => L('昵称'),
				'formtype' => 'text',
				'field' => 'nickname',
				'setting' => array()
			),
			'email' => array(
				'name' => L('邮箱'),
				'formtype' => 'text',
				'field' => 'email',
				'setting' => array()
			),
			'mobile' => array(
				'name' => L('手机'),
				'formtype' => 'text',
				'field' => 'mobile',
				'setting' => array()
			),
			'amount' => array(
				'name' => L('余额'),
				'formtype' => 'text',
				'field' => 'amount',
				'setting' => array()
			),
			'point' => array(
				'name' => L('积分'),
				'formtype' => 'text',
				'field' => 'point',
				'setting' => array()
			),
			'regip' => array(
				'name' => L('注册IP'),
				'formtype' => 'text',
				'field' => 'regip',
				'setting' => array()
			),
			'regdate' => array(
				'name' => L('注册时间'),
				'formtype' => 'text',
				'field' => 'regdate',
				'setting' => array()
			),
		);
	}
}
?>