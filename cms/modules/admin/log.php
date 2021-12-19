<?php
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class log extends admin {
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('log_model');
		pc_base::load_sys_class('form');
		$admin_username = param::get_cookie('admin_username');//管理员COOKIE
		$userid = $_SESSION['userid'];//登陆USERID　
	}
	
	function init () {
		if ($this->input->get('search')){
			extract($this->input->get('search'),EXTR_SKIP);
		}
		if($username){
			$where[] = "username='$username'";
		}
		if ($module){
			$where[] = "module='$module'";
		}
		if($start_time) {
			$start = $start_time;
			$end = $end_time;
			$where[] = "`time` >= '".$start." 00:00:00' AND `time` <= '".$end." 23:59:59'";
		}
 
		$page = $this->input->get('page') && intval($this->input->get('page')) ? intval($this->input->get('page')) : 1; 
		$infos = $this->db->listinfo(($where ? implode(' AND ', $where) : ''),'logid DESC',$page, SYS_ADMIN_PAGESIZE); 
 		$pages = $this->db->pages;
 		//模块数组
		$module_arr = array();
		$modules = getcache('modules','commons');
		$default = $module ? $module : L('open_module');
 		foreach($modules as $module=>$m) $module_arr[$m['module']] = $m['module'];
 		include $this->admin_tpl('log_list');
	}
		
	/**
	 * 操作日志删除 包含批量删除 单个删除
	 */
	function delete() {
		$week = intval($this->input->get('week'));
		if($week){
			$where = '';
			$start = SYS_TIME - $week*7*24*3600;
			$d = date("Y-m-d",$start); 
 			//$end = strtotime($end_time);
			//$where .= "AND `message_time` >= '$start' AND `message_time` <= '$end' ";
			$where .= "`time` <= '$d'";
			$this->db->delete($where);
			dr_admin_msg(1,L('operation_success'),'?m=admin&c=log');
		} else {
			return false;
		}
	}
	
}
?>