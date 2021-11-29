<?php
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class cache_all extends admin {
	private $cache_api;
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
	}

	public function init() {
		$modules = array(
			array('function' => 'module'),
			array('mod' => 'admin', 'file' => 'sites', 'function' => 'set_cache'),
			array('function' => 'category'),
			array('function' => 'downservers'),
			array('function' => 'badword'),
			array('function' => 'ipbanned'),
			array('function' => 'keylink'),
			array('function' => 'linkage'),
			array('function' => 'position'),
			array('function' => 'admin_role'),
			array('function' => 'urlrule'),
			array('function' => 'sitemodel'),
			array('function' => 'type', 'param' => 'content'),
			array('function' => 'workflow'),
			array('function' => 'dbsource'),
			array('function' => 'member_setting'),
			array('function' => 'member_group'),
			array('function' => 'membermodel'),
			array('function' => 'member_model_field'),
			array('function' => 'type', 'param' => 'search'),
			array('function' => 'search_setting'),
			array('function' => 'vote_setting'),
			array('function' => 'link_setting'),
			array('function' => 'special'),
			array('function' => 'setting'),
			array('function' => 'database'),
			array('mod' => 'formguide', 'file' => 'formguide', 'function' => 'public_cache'),
			array('function' => 'copyfrom'),
			array('function' => 'del_file'),
			array('function' => 'attachment_remote'),
		);
		foreach ($modules as $m) {
			if ($m['mod'] && $m['function']) {
				if ($m['file'] == '') $m['file'] = $m['function'];
				$M = getcache('modules', 'commons');
				if (in_array($m['mod'], array_keys($M))) {
					$cache = pc_base::load_app_class($m['file'], $m['mod']);
					$cache->{$m['function']}();
				}
			} else {
				$this->cache_api->cache($m['function'], $m['param']);
			}
		}
		$this->cache2database();
		if ($this->input->get('is_ajax') || IS_AJAX) {
			dr_json(1, L('全站缓存更新完成'));
		} else {
			showmessage(L('全站缓存更新完成'), 'close');
		}
	}
	
	/**
	 * 根据数据库记录更新缓存
	 */
	public function cache2database() {
		$cache = pc_base::load_model('cache_model');
		$result = $cache->select();
		if (is_array($result) && !empty($result)) {
			foreach ($result as $re) {
				if (!file_exists(CACHE_PATH.$re['path'].$re['filename'])) {
					$filesize = pc_base::load_config('system','lock_ex') ? file_put_contents(CACHE_PATH.$re['path'].$re['filename'], $re['data'], LOCK_EX) : file_put_contents(CACHE_PATH.$re['path'].$re['filename'], $re['data']);
				} else {
					continue;
				}
			}
		}
	}
}
?>