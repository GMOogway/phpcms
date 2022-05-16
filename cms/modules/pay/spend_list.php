<?php
defined('IN_CMS') or exit('No permission resources.'); 
pc_base::load_app_class('foreground','member');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class spend_list extends foreground {
	private $spend_db;
	
	function __construct() {
		$this->input = pc_base::load_sys_class('input');
		$this->spend_db = pc_base::load_model('pay_spend_model');
		parent::__construct();
	}
	
	public function init() {
		$page = $this->input->get('page') && intval($this->input->get('page')) ? intval($this->input->get('page')) : 1;
		$userid  = param::get_cookie('_userid');
		$sql =  " `userid` = '$userid'";
		if ($this->input->get('dosubmit')) {
			$type = $this->input->get('type') && intval($this->input->get('type')) ? intval($this->input->get('type')) : '';
			$endtime = $this->input->get('endtime')  &&  trim($this->input->get('endtime')) ? strtotime(trim($this->input->get('endtime'))) : '';
			$starttime = $this->input->get('starttime') && trim($this->input->get('starttime')) ? strtotime(trim($this->input->get('starttime'))) : '';
			
			if (!empty($starttime) && empty($endtime)) {
				$endtime = SYS_TIME;
			}
			
			if (!empty($starttime) && !empty($endtime) && $endtime < $starttime) {
				showmessage(L('wrong_time_over_time_to_time_less_than'));
			}
						
			if (!empty($starttime)) {
				$sql .= $sql ? " AND `creat_at` BETWEEN '$starttime' AND '$endtime' " : " `creat_at` BETWEEN '$starttime' AND '$endtime' ";
			}
			
			if (!empty($type)) {
				$sql .= $sql ? " AND `type` = '$type' " : " `type` = '$type'";
			}
			
		}
		$list = $this->spend_db->listinfo($sql, '`id` desc', $page);
		$pages = $this->spend_db->pages;
		include template('pay', 'spend_list');
	}
}