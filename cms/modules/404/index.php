<?php
defined('IN_CMS') or exit('No permission resources.');
class index {
	private $db;
	function __construct() {
		$this->input = pc_base::load_sys_class('input');
		$this->_userid = param::get_cookie('_userid');
		$this->_username = param::get_cookie('_username');
		$this->_groupid = param::get_cookie('_groupid');
	}
	//404
	public function init() {
		if($this->input->get('siteid')) {
			$siteid = intval($this->input->get('siteid'));
		} else {
			$siteid = 1;
		}
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//SEO
		$SEO = seo($siteid, 0, L('你访问的页面不存在'));
		$sitelist  = getcache('sitelist','commons');
		$default_style = $sitelist[$siteid]['default_style'];
		if (IS_DEV) {
			$uri = $this->input->get('uri', true);
			$msg = '没有找到这个页面: '.$uri;
		} else {
			$msg = L('没有找到这个页面');
		}
		include template('404','index',$default_style);
	}
}
?>