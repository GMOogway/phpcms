<?php
defined('IN_CMS') or exit('No permission resources.');
class database {
	private $db;
	function __construct() {
		$this->input = pc_base::load_sys_class('input');
		pc_base::load_sys_class('db_factory');
		$this->database = pc_base::load_config('database');
		$this->db = db_factory::get_instance($database)->get_database('default');
		$session_storage = 'session_'.pc_base::load_config('system','session_storage');
		pc_base::load_sys_class($session_storage);
		$this->userid = $_SESSION['userid'];
	}

	public function import() {
		$action = $this->input->post('action');
		$file = $this->input->post('file');
		$backupDir = CACHE_PATH.'bakup/default/';
		if(ADMIN_FOUNDERS && !dr_in_array($this->userid, ADMIN_FOUNDERS)) {
			dr_json(0, L('only_fonder_operation'));
		}
		if (!preg_match("/^backup\-((?!\").)*\.zip$/i", $file)) {
			dr_json(0, L('参数不正确'));
		}
		$file = $backupDir.$file;
		if (!class_exists('ZipArchive')) {
			dr_json(0, L('服务器缺少php-zip组件，无法进行还原操作'));
		}
		try {
			$dir = $backupDir.'database/';
			if (!is_dir($dir)) {
				create_folder($dir, 0755);
			}
			$zip = new \ZipArchive;
			if ($zip->open($file) !== true) {
				dr_json(0, L('无法打开备份文件'));
			}
			if (!$zip->extractTo($dir)) {
				$zip->close();
				dr_json(0, L('无法解压备份文件'));
			}
			$zip->close();
			$filename = basename($file);
			$sqlFile = $dir . str_replace('.zip', '.sql', $filename);
			if (!is_file($sqlFile)) {
				dr_json(0, L('未找到SQL文件'));
			}
			dr_json(1, 'ok', array('url' => WEB_PATH.'index.php?m=content&c=database&a=import_index&file='.$file));
		} catch (Exception $e) {
			dr_json(0, L($e->getMessage()));
		} catch (PDOException $e) {
			dr_json(0, L($e->getMessage()));
		}
	}

	/**
	 * 还原
	 */
	public function import_index() {
		$file = $this->input->get('file');
		$todo_url = WEB_PATH.'index.php?m=content&c=database&a=todo_import&file='.$file;
		include admin_template('database_import_bfb', 'admin');
	}

	/**
	 * 还原
	 */
	public function todo_import() {
		$backupDir = CACHE_PATH.'bakup/default/';

		$file = $this->input->get('file');
		$page = max(1, intval($this->input->get('page')));
		if (!$file) {
			dr_json(0, '数据缓存不存在');
		}

		$filedir = $backupDir.'database/';
		$file = $backupDir.$file;
		$filename = basename($file);
		$sqlFile = $filedir . str_replace('.zip', '.sql', $filename);
		if (!is_file($sqlFile)) {
			dr_json(0, L('未找到SQL文件'));
		}

		// 导入数据结构
		if ($page) {
			$sql = file_get_contents($sqlFile);
			$sql = str_replace('phpcms_', 'cms_', $sql);
			if($this->database['tablepre'] != "cms_") $sql = str_replace("`cms_", '`'.$this->database['tablepre'], $sql);
			$rows = $this->query_rows($sql, 10);
			$key = $page - 1;
			if (isset($rows[$key]) && $rows[$key]) {
				// 安装本次结构
				foreach($rows[$key] as $query){
					if (!$query) {
						continue;
					}
					$ret = '';
					$queries = explode('SQL_CMS_EOL', trim($query));
					foreach($queries as $query) {
						$ret.= $query[0] == '#' || $query[0].$query[1] == '--' ? '' : $query;
					}
					if (!$ret) {
						continue;
					}
					$this->db->query($ret);
				}
				dr_json(1, '<p class="'.$class.'"><label class="rleft">正在执行：'.str_cut($ret, 70).'</label><label class="rright">完成</label></p>', ['page' => $page + 1]);
			} else {
				dr_dir_delete($filedir, true);
				dr_json(1, '<p class="'.$class.'"><label class="rleft">'.L('还原成功！').'</label>', ['page' => 0]);
			}
		}
	}

	// 数据分组
	private function query_rows($sql, $num = 0) {

		if (!$sql) {
			return '';
		}

		$rt = array();
		$sql = format_create_sql($sql);
		$sql_data = explode(';SQL_CMS_EOL', trim(str_replace(array(PHP_EOL, chr(13), chr(10)), 'SQL_CMS_EOL', $sql)));

		foreach($sql_data as $query){
			if (!$query) {
				continue;
			}
			$ret = '';
			$queries = explode('SQL_CMS_EOL', trim($query));
			foreach($queries as $query) {
				$ret.= $query[0] == '#' || $query[0].$query[1] == '--' ? '' : $query;
			}
			if (!$ret) {
				continue;
			}
			$rt[] = $ret;
		}
		
		return $num ? array_chunk($rt, $num) : $rt;
	}
}
?>