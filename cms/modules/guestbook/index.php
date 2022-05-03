<?php
defined('IN_CMS') or exit('No permission resources.');
if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists'));
class index {
	function __construct() {
		pc_base::load_app_func('global');
		$this->input = pc_base::load_sys_class('input');
		$siteid = $this->input->get('siteid') ? intval($this->input->get('siteid')) : get_siteid();
  		define("SITEID",$siteid);
	}
	
	public function init() {
		$siteid = SITEID; 
 		$setting = getcache('guestbook', 'commons');
		$SEO = seo(SITEID, '', L('guestbook'), '', '');
		include template('guestbook', 'index');
	}
	
	 /**
	 *	留言板列表页
	 */
	public function list_type() {
		$siteid = SITEID;
  		$type_id = trim(urldecode($this->input->get('type_id')));
		$type_id = intval($type_id);
  		if($type_id==""){
 			$type_id ='0';
 		}
   		$setting = getcache('guestbook', 'commons');
		$SEO = seo(SITEID, '', L('guestbook'), '', '');
  		include template('guestbook', 'list_type');
	} 
 	
	 /**
	 *	留言板留言 
	 */
	public function register() { 
 		$siteid = SITEID;
		$setting = getcache('guestbook', 'commons');
		$setting = $setting[$siteid];
		if(!$setting['is_post']){
			showmessage(L('suspend_application'), HTTP_REFERER);
		}
 		if($this->input->post('dosubmit')){
 			if(!$this->input->post('name')){
 				showmessage(L('usename_noempty'),"?m=guestbook&c=index&a=register&siteid=$siteid");
 			}
 			if(!$this->input->post('lxqq')){
 				showmessage(L('email_not_empty'),"?m=guestbook&c=index&a=register&siteid=$siteid");
 			}
 			if(!$this->input->post('email')){
 				showmessage(L('email_not_empty'),"?m=guestbook&c=index&a=register&siteid=$siteid");
 			}
			if(!$this->input->post('shouji')){
 				showmessage(L('shouji_not_empty'),"?m=guestbook&c=index&a=register&siteid=$siteid");
 			}
 			$guestbook_db = pc_base::load_model('guestbook_model');
 			 
			 /*添加用户数据*/
 			$sql = array('siteid'=>$siteid,'typeid'=>$this->input->post('typeid'),'name'=>$this->input->post('name'),'sex'=>$this->input->post('sex'),'lxqq'=>$this->input->post('lxqq'),'email'=>$this->input->post('email'),'shouji'=>$this->input->post('shouji'),'introduce'=>$this->input->post('introduce'),'addtime'=>SYS_TIME);
 			 
 			$dataid = $guestbook_db->insert($sql, true);
			if ($dataid) {
				if ($setting['sendmail'] && $setting['mails']) {
					$email = pc_base::load_sys_class('email');
					$mails = explode(',', $setting['mails']);
					if (is_array($mails)) {
						foreach ($mails as $m) {
							$email->set();
							$mailmessage = $setting['mailmessage'];
							$mailmessage = str_replace('$', '', $mailmessage);
							if (preg_match_all("/\{(.+)\}/U", $mailmessage, $value)) {
								foreach ($value[1] as $t) {
									$mailmessage = str_replace($t, $this->input->post($t), $mailmessage);
								}
							}
							$mailmessage = str_replace(array('{', '}'), '', $mailmessage);
							$email->send($m, L('tips'), $mailmessage);
						}
					}
				}
				if ($setting['sendsms'] && $setting['mobiles'] && module_exists('sms')) {
					pc_base::load_app_class('smsapi', 'sms', 0);
					$mobiles = explode(',', $setting['mobiles']);
					if (is_array($mobiles)) {
						foreach ($mobiles as $m) {
							$smsmessage = $setting['smsmessage'];
							$smsmessage = str_replace('$', '', $smsmessage);
							if (preg_match_all("/\{(.+)\}/U", $smsmessage, $value)) {
								foreach ($value[1] as $t) {
									$smsmessage = str_replace($t, $this->input->post($t), $smsmessage);
								}
							}
							$smsmessage = str_replace(array('{', '}'), '', $smsmessage);
							$smsapi = new smsapi();
							$rt = $smsapi->send_sms($m, $smsmessage);
						}
					}
				}
			}
 			showmessage(L('add_success').($setting['sendsms'] && $setting['mobiles'] && module_exists('sms') ? $rt['msg'] : ''), "?m=guestbook&c=index&siteid=$siteid");
 		}else {
 			$this->type = pc_base::load_model('type_model');
 			$types = $this->type->get_types($siteid);//获取站点下所有留言板分类
 			pc_base::load_sys_class('form', '', 0);
 			$SEO = seo(SITEID, '', L('application_guestbook'), '', '');
   			include template('guestbook', 'register');
 		}
	} 
	
}
?>