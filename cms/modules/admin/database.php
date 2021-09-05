<?php
@set_time_limit(0);
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class database extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->userid = $_SESSION['userid'];
		pc_base::load_sys_class('db_factory');
		pc_base::load_sys_class('form');
		pc_base::load_sys_func('dir');	
	}
	/**
	 * 数据字典
	 */
	public function export() {
		$database = pc_base::load_config('database');
		$r = array();
		$db = db_factory::get_instance($database)->get_database('default');
		$tbl_show = $db->query("SHOW TABLE STATUS FROM `".$database['default']['database']."`");
		while(($rs = $db->fetch_next()) != false) {
			$r[] = $rs;
		}
		$infos = $this->status($r,$database['default']['tablepre']);
		$db->free_result($tbl_show);
		include $this->admin_tpl('database_export');
	}
	
	/**
	 * 备份与还原
	 */
	public function import() {
		$database = pc_base::load_config('database');
		$backupDir = CACHE_PATH.'bakup/default/';
		if(IS_POST) {
			$action = $this->input->post('action');
			$file = $this->input->post('file');
			if ($action == 'backup') {
				pc_base::load_sys_class('backup','',0);
				$admin_founders = explode(',',pc_base::load_config('system','admin_founders'));
				if(!in_array($this->userid,$admin_founders)) {
					dr_json(0, L('only_fonder_operation'));
				}
				if (!class_exists('ZipArchive')) {
					dr_json(0, L('服务器缺少php-zip组件，无法进行备份操作'));
				}
				$database = $database['default'];
				try {
					$backup = new backup($database['hostname'], $database['username'], $database['database'], $database['password'], $database['port']);
					$backup->setIgnoreTable('')->backup($backupDir);
				} catch (Exception $e) {
					dr_json(0, L($e->getMessage()));
				}
				dr_json(1, L('bakup_succ'));
			} elseif ($action == 'restore') {
				if (!preg_match("/^backup\-([a-z0-9\-]+)\.zip$/i", $file)) {
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
					$sql = file_get_contents($sqlFile);
					$this->db = db_factory::get_instance($database)->get_database('default');
					$database = $database['default'];
					$this->db_charset = $database['charset'];
					$this->db_tablepre = $database['tablepre'];
					$this->sql_execute($sql);
					dr_dir_delete($dir, true);
				} catch (Exception $e) {
					dr_json(0, L($e->getMessage()));
				} catch (PDOException $e) {
					dr_json(0, L($e->getMessage()));
				}
				dr_json(1, L('还原成功'));
			} elseif ($action == 'delete') {
				if (!preg_match("/^backup\-([a-z0-9\-]+)\.zip$/i", $file)) {
					dr_json(0, L('参数不正确'));
				}
				$file = $backupDir.$file;
				unlink($file);
				dr_json(1, L('删除成功'));
			}
		} else {
			$infos = array();
			foreach (glob($backupDir . "*.zip") as $filename) {
				$time = filemtime($filename);
				$infos[] =
					[
						'file' => str_replace($backupDir, '', $filename),
						'date' => dr_date($time, "Y-m-d H:i:s", 'red'),
						'size' => format_file_size(filesize($filename))
					];
			}
			$show_validator = true;
			include $this->admin_tpl('database_import');
		}
	}
	
	/**
	 * 备份文件下载
	 */
	public function public_down() {
		$admin_founders = explode(',',pc_base::load_config('system','admin_founders'));
		if(!in_array($this->userid,$admin_founders)) {
			showmessage(L('only_fonder_operation'));
		}	
		$datadir = $this->input->get('pdoname');
		$filename = $this->input->get('filename');
		$fileext = fileext($filename);
		if($fileext != 'sql') {
			showmessage(L('only_sql_down'));
		}
		file_down(CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$datadir.DIRECTORY_SEPARATOR.$filename);
	}
	
	/**
	 * 数据库修复、优化
	 */
	public function public_repair() {
		$database = pc_base::load_config('database');
		$tables = $this->input->post('tables') ? $this->input->post('tables') : trim($this->input->get('tables'));
		$operation = trim($this->input->get('operation'));
		$this->db = db_factory::get_instance($database)->get_database('default');
		$tables = is_array($tables) ? implode(',',$tables) : $tables;
		if($tables && in_array($operation,array('repair','optimize','flush'))) {
			$this->db->query("$operation TABLE $tables");
			showmessage(L('operation_success'),'?m=admin&c=database&a=export&menuid='.$this->input->get('menuid'));
		} elseif ($tables && $operation == 'showcreat') {
			$this->db->query("SHOW CREATE TABLE $tables");
			$structure = $this->db->fetch_next();
			$structure = $structure['Create Table'];
			$show_header = true;
			include $this->admin_tpl('database_structure');
		} elseif ($tables && $operation == 'show') {
			$structure = $this->db->query("SHOW FULL COLUMNS FROM $tables");
			$show_header = true;
			include $this->admin_tpl('database_show');
		} elseif ($tables && $operation == 'ut') {
			foreach ($this->input->post('tables') as $table) {
				$this->db->query('ALTER TABLE `'.$table.'` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;');
			}
			showmessage(L('operation_success'),'?m=admin&c=database&a=export&menuid='.$this->input->get('menuid'));
		} elseif ($tables && $operation == 'jc') {
			$data = $this->db->query("CHECK TABLE $tables");
			if (!$data) {
				showmessage(L('database_table'),'?m=admin&c=database&a=export&menuid='.$this->input->get('menuid'));
			} else {
				showmessage(L('operation_success'),'?m=admin&c=database&a=export&menuid='.$this->input->get('menuid'));
			}
		} else {
			showmessage(L('select_tbl'),'?m=admin&c=database&a=export&menuid='.$this->input->get('menuid'));
		}
	}
	/**
	 * 获取数据表
	 * @param unknown_type 数据表数组
	 * @param unknown_type 表前缀
	 */
	private function status($tables,$tablepre) {
		$cms = array();
		$other = array();
		foreach($tables as $table) {
			$name = $table['Name'];
			$row = array('name'=>$name,'comment'=>$table['Comment'],'rows'=>$table['Rows'],'size'=>$table['Data_length']+$table['Index_length'],'engine'=>$table['Engine'],'data_free'=>$table['Data_free'],'collation'=>$table['Collation'],'updatetime'=>strtotime($table['Update_time']));
			if(strpos($name, $tablepre) === 0) {
				$cms[] = $row;
			} else {
				$other[] = $row;
			}				
		}
		return array('cmstables'=>$cms, 'othertables'=>$other);
	}
	// 批量操作
	public function public_add() {
		$show_header = '';
		$operation = $this->input->get('operation');
		$ids = $this->input->post('tables');
		if (!$ids) {
			dr_json(0, L('database_no_table'));
		}
		$cache = array();
		$count = count($ids);
		if ($count > 100) {
			$pagesize = ceil($count/100);
			for ($i = 1; $i <= 100; $i ++) {
				$cache[$i] = array_slice($ids, ($i - 1) * $pagesize, $pagesize);
			}
		} else {
			for ($i = 1; $i <= $count; $i ++) {
				$cache[$i] = array_slice($ids, ($i - 1), 1);
			}
		}
		// 存储文件
		setcache('db-todo-'.$operation, $cache, 'commons');
		dr_json(1, 'ok', array('url' => '?m=admin&c=database&a=public_count_index&operation='.$operation));
    }
	
	public function public_count_index() {
		$show_header = '';
		$operation = $this->input->get('operation');
		$todo_url = '?m=admin&c=database&a=public_todo_index&operation='.$operation;
		include $this->admin_tpl('database_bfb');
    }
	
	public function public_todo_index() {
		$show_header = '';
		$database = pc_base::load_config('database');
		$operation = $this->input->get('operation');
		$this->db = db_factory::get_instance($database)->get_database('default');
		$page = max(1, intval($this->input->get('page')));
		$cache = getcache('db-todo-'.$operation, 'commons');
		if (!$cache) {
			dr_json(0, L('database_cache'));
		}
		$data = $cache[$page];
		if ($data) {
			$html = '';
			foreach ($data as $table) {
				$ok = L('database_success');
				$class = '';
				switch ($operation) {
					case 'x':
						$this->db->query('REPAIR TABLE `'.$table.'`');
						break;
					case 'y':
						$this->db->query('OPTIMIZE TABLE `'.$table.'`');
						break;
					case 's':
						$this->db->query('FLUSH TABLE `'.$table.'`');
						break;
					case 'ut':
						$this->db->query('ALTER TABLE `'.$table.'` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;');
						break;
					case 'jc':
						$data = $this->db->query('CHECK TABLE `'.$table.'`');
						if (!$data) {
							$class = 'p_error';
							$ok = "<span class='error'>".L('database_table')."</span>";
						} else {
							$ok = L('database_success');
						}
				}
				$html.= '<p class="'.$class.'"><label class="rleft">'.$table.'</label><label class="rright">'.$ok.'</label></p>';
			}
			dr_json($page + 1, $html);
		}
		// 完成
		delcache('db-todo-'.$operation, 'commons');
		dr_json(100, '');
    }
	
	/**
	 * 执行SQL
	 * @param unknown_type $sql
	 */
 	private function sql_execute($sql) {
	    $sqls = $this->sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					$this->db->query($sql);
				}
			}
		} else {
			$this->db->query($sqls);
		}
		return true;
	}
	

 	private function sql_split($sql) {
		$sql = str_replace('phpcms_', 'cms_', $sql);
		if($this->db_tablepre != "cms_") $sql = str_replace("`cms_", '`'.$this->db_tablepre, $sql);
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach($queriesarray as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			$queries = array_filter($queries);
			foreach($queries as $query) {
				$str1 = substr($query, 0, 1);
				if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
			}
			$num++;
		}
		return($ret);
	}
}
?>