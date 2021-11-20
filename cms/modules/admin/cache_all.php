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
			array('name' => L('module'), 'function' => 'module'),
			array('name' => L('sites'), 'mod' => 'admin', 'file' => 'sites', 'function' => 'set_cache'),
			array('name' => L('category'), 'function' => 'category'),
			array('name' => L('downservers'), 'function' => 'downservers'),
			array('name' => L('badword_name'), 'function' => 'badword'),
			array('name' => L('ipbanned'), 'function' => 'ipbanned'),
			array('name' => L('keylink'), 'function' => 'keylink'),
			array('name' => L('linkage'), 'function' => 'linkage'),
			array('name' => L('position'), 'function' => 'position'),
			array('name' => L('admin_role'), 'function' => 'admin_role'),
			array('name' => L('urlrule'), 'function' => 'urlrule'),
			array('name' => L('sitemodel'), 'function' => 'sitemodel'),
			array('name' => L('type'), 'function' => 'type', 'param' => 'content'),
			array('name' => L('workflow'), 'function' => 'workflow'),
			array('name' => L('dbsource'), 'function' => 'dbsource'),
			array('name' => L('member_setting'), 'function' => 'member_setting'),
			array('name' => L('member_group'), 'function' => 'member_group'),
			array('name' => L('membermodel'), 'function' => 'membermodel'),
			array('name' => L('member_model_field'), 'function' => 'member_model_field'),
			array('name' => L('search_type'), 'function' => 'type', 'param' => 'search'),
			array('name' => L('search_setting'), 'function' => 'search_setting'),
			array('name' => L('update_vote_setting'), 'function' => 'vote_setting'),
			array('name' => L('update_link_setting'), 'function' => 'link_setting'),
			array('name' => L('special'), 'function' => 'special'),
			array('name' => L('setting'), 'function' => 'setting'),
			array('name' => L('database'), 'function' => 'database'),
			array('name' => L('update_formguide_model'), 'mod' => 'formguide', 'file' => 'formguide', 'function' => 'public_cache'),
			array('name' => L('cache_copyfrom'), 'function' => 'copyfrom'),
			array('name' => L('clear_files'), 'function' => 'del_file'),
			array('name' => L('远程附件'), 'function' => 'attachment_remote'),
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