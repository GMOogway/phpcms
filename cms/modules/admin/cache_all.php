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
        $show_header = true;
		if ($this->input->get('is_ajax') || IS_AJAX) {
			$modules = array(
				array('function' => 'module'),
				array('mod' => 'admin', 'file' => 'sites', 'function' => 'set_cache'),
				array('function' => 'category'),
				array('function' => 'downservers'),
				array('function' => 'badword'),
				array('function' => 'ipbanned'),
				array('function' => 'keylink'),
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
				array('function' => 'cache2database'),
			);
			foreach ($modules as $m) {
				if (isset($m['mod']) && $m['mod'] && $m['function']) {
					if ($m['file'] == '') $m['file'] = $m['function'];
					$M = getcache('modules', 'commons');
					if (in_array($m['mod'], array_keys($M))) {
						$cache = pc_base::load_app_class($m['file'], $m['mod']);
						$cache->{$m['function']}();
					}
				} else {
					$this->cache_api->cache($m['function'], isset($m['param']) ? $m['param'] : '');
				}
			}
			dr_json(1, L('site_cache_completed'));
		} else {
			$list = array(
				array('name' => L('module'), 'function' => 'module'),
				array('name' => L('sites'), 'mod' => 'admin', 'file' => 'sites', 'function' => 'set_cache'),
				array('name' => L('category'), 'function' => 'category'),
				array('name' => L('downservers'), 'function' => 'downservers'),
				array('name' => L('badword_name'), 'function' => 'badword'),
				array('name' => L('ipbanned'), 'function' => 'ipbanned'),
				array('name' => L('keylink'), 'function' => 'keylink'),
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
				array('name' => L('remote_attachment'), 'function' => 'attachment_remote'),
				array('name' => L('update_attachment'), 'function' => 'attachment'),
				array('name' => L('update_thumb'), 'function' => 'update_thumb'),
				array('name' => L('cache_file'), 'function' => 'cache2database'),
			);
			include $this->admin_tpl('cache_all');
		}
	}

	// 执行更新缓存
	public function public_cache() {

        $function = dr_safe_replace($this->input->get('id'));
        $param = $this->input->get('param');
        $file = $this->input->get('file');
        $mod = $this->input->get('mod');
		if ($mod && $function) {
			if ($file == '') $file = $function;
			$M = getcache('modules', 'commons');
			if (in_array($mod, array_keys($M))) {
				$cache = pc_base::load_app_class($file, $mod);
				$cache->{$function}();
			}
		} else {
			$this->cache_api->cache($function, $param ? $param : '');
		}

        dr_json(1, L('update').L('database_success'), 0);
    }
}
?>