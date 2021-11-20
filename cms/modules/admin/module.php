<?php
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class module extends admin {
	private $db;
	
	public function __construct() {
		$this->input = pc_base::load_sys_class('input');
		$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
		$this->db = pc_base::load_model('module_model');
		parent::__construct();
	}
	
	public function init() {
		$show_header = '';
		$dirs = $module = $dirs_arr = $directory = array();
		$dirs = glob(PC_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'*');
		foreach ($dirs as $d) {
			if (is_dir($d)) {
				$d = basename($d);
				$dirs_arr[] = $d;
			}
		}
		define('INSTALL', true);
		$modules = $this->db->select('', '*', '', '', '', 'module');
		$total = count($dirs_arr);
		$dirs_arr = array_chunk($dirs_arr, 20, true);
		$page = max(intval($this->input->get('page')), 1);
		$pages = pages($total, $page, 20);
		$directory = $dirs_arr[intval($page-1)];
		include $this->admin_tpl('module_list');
	}
	
	/**
	 * 模块安装
	 */
	public function install() {
		$this->module = $this->input->post('module') ? $this->input->post('module') : dr_json(0, L('illegal_parameters'));
		$module_api = pc_base::load_app_class('module_api');
		if (!$module_api->check($this->module)) dr_json(0, $module_api->error_msg);
		if ($module_api->install()) {
			$this->cache();
			dr_json(1, L('success_module_install'), '');
		} else {
			dr_json(0, $module_api->error_msg);
		}
	}
	
	/**
	 * 模块卸载
	 */
	public function uninstall() {
		$this->module = $this->input->post('module') ? $this->input->post('module') : dr_json(0, L('illegal_parameters'));
		$module_api = pc_base::load_app_class('module_api');
		if(!$module_api->uninstall($this->module)) {
			dr_json(0, $module_api->error_msg);
		} else {
			$this->cache();
			dr_json(1, L('uninstall_success'), '');
		}
	}
	
	/**
	 * 更新模块缓存
	 */
	public function cache() {
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