<?php
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_func('dir');

class menu extends admin {
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('menu_model');
		$this->module_db = pc_base::load_model('module_model');
	}
	
	function init() {
		$list = $this->db->select('','*','','listorder ASC,id ASC');
		$array = array();
		foreach($list as $r) {
			$rs['id'] = $r['id'];
			$rs['title'] = '<i class="'.$r['icon'].'"></i> '.L($r['name']);
			$rs['parentid'] = $r['parentid'];
			$rs['display'] = $r['display'];
			$rs['listorder'] = $r['listorder'];
			if ($r['parentid'] == 0) {
				$rs['type'] = '<span class="btn btn-xs yellow">'.L('目录').'</span>';
			} else {
				if ($r['display'] == 0) {
					$rs['type'] = '<span class="btn btn-xs btn-default">'.L('按钮').'</span>';
				} else {
					$rs['type'] = '<span class="btn btn-xs dark">'.L('菜单').'</span>';
				}
			}
			$array[] = $rs;
		}
		$tree = pc_base::load_sys_class('tree');
		$array = $tree->get($array);
		include $this->admin_tpl('menu');
	}
	function add() {
		if($this->input->post('dosubmit')) {
			$this->db->insert($this->input->post('info'));
			//开发过程中用于自动创建语言包
			$file = PC_PATH.'languages'.DIRECTORY_SEPARATOR.'zh-cn'.DIRECTORY_SEPARATOR.'system_menu.lang.php';
			if(file_exists($file)) {
				$content = file_get_contents($file);
				$content = substr($content,0,-2);
				$key = $this->input->post('info')['name'];
				$data = $content."\$LANG['$key'] = '$_POST[language]';\r\n?>";
				file_put_contents($file,$data);
			} else {
				
				$key = $this->input->post('info')['name'];
				$data = "<?php\r\n\$LANG['$key'] = '$_POST[language]';\r\n?>";
				file_put_contents($file,$data);
			}
			//结束
			dr_admin_msg(1,L('add_success'), '?m=admin&c=menu&a=init&menuid='.$this->input->post('menuid'));
		} else {
			$show_validator = '';
			$tree = pc_base::load_sys_class('tree');
			$result = $this->db->select();
			$array = array();
			foreach($result as $r) {
				$r['cname'] = L($r['name']);
				$r['selected'] = $r['id'] == $this->input->get('parentid') ? 'selected' : '';
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
			$models = pc_base::load_config('model_config');
			include $this->admin_tpl('menu');
		}
	}
	function delete() {
		if($this->input->get('id')) {
			$id = intval($this->input->get('id'));
			$this->delete_child($id);
			$this->db->delete(array('id'=>$id));
			dr_admin_msg(1, L('operation_success'), '?m=admin&c=menu&a=init&menuid='.$this->input->get('menuid'));
		} else {
			dr_admin_msg(0, L('operation_failure'), '?m=admin&c=menu&a=init&menuid='.$this->input->get('menuid'));
		}
	}
	/**
	 * 递归删除
	 * @param $id 要删除的id
	 */
	private function delete_child($id) {
		$id = intval($id);
		if (empty($id)) return false;
		$list = $this->db->select(array('parentid'=>$id));
		foreach($list as $r) {
			$this->delete_child($r['id']);
			$this->db->delete(array('id'=>$r['id']));
		}
		return true;
	}
	
	function edit() {
		if($this->input->post('dosubmit')) {
			$id = intval($this->input->post('id'));
			$r = $this->db->get_one(array('id'=>$id));
			$this->db->update($this->input->post('info'),array('id'=>$id));
			//修改语言文件
			$file = PC_PATH.'languages'.DIRECTORY_SEPARATOR.'zh-cn'.DIRECTORY_SEPARATOR.'system_menu.lang.php';
			require $file;
			$key = $this->input->post('info')['name'];
			if(!isset($LANG[$key])) {
				$content = file_get_contents($file);
				$content = substr($content,0,-2);
				$data = $content."\$LANG['$key'] = '$_POST[language]';\r\n?>";
				file_put_contents($file,$data);
			} elseif(isset($LANG[$key]) && $LANG[$key]!=$this->input->post('language')) {
				$content = file_get_contents($file);
				$content = str_replace($LANG[$key],$this->input->post('language'),$content);
				file_put_contents($file,$content);
			}
			$this->update_menu_models($id, $r, $this->input->post('info'));
			
			//结束语言文件修改
			dr_admin_msg(1,L('operation_success'), '?m=admin&c=menu&a=init&menuid='.$this->input->post('menuid'));
		} else {
			$show_validator = '';
			$tree = pc_base::load_sys_class('tree');
			$id = intval($this->input->get('id'));
			$r = $this->db->get_one(array('id'=>$id));
			if($r) extract($r);
			$result = $this->db->select();
			foreach($result as $r) {
				$r['cname'] = L($r['name']);
				$r['selected'] = $r['id'] == $parentid ? 'selected' : '';
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
			$models = pc_base::load_config('model_config');
			include $this->admin_tpl('menu');
		}
	}
	
	/**
	 * 选择图标
	 */
	public function public_icon() {
		$show_header = $show_pc_hash = true;
		include $this->admin_tpl('menu_icon');
	}
	
	/**
	 * 初始化菜单
	 */
	public function public_init() {
		define('INSTALL', true);
		if(file_exists(TEMPPATH.'menu/menu.sql')) {
			$sql = file_get_contents(TEMPPATH.'menu/menu.sql');
			$this->_sql_execute($sql);
		}
		$modules = $this->module_db->select('', '*', '', '', '', 'module');
		foreach ($modules as $t) {
			if ($t['module']!='admin' && $t['module']!='member' && $t['module']!='pay' && $t['module']!='digg' && $t['module']!='special' && $t['module']!='content' && $t['module']!='mobile' && $t['module']!='search' && $t['module']!='scan' && $t['module']!='attachment' && $t['module']!='block' && $t['module']!='collection' && $t['module']!='dbsource' && $t['module']!='template' && $t['module']!='release') {
				$this->installdir = PC_PATH.'modules'.DIRECTORY_SEPARATOR.$t['module'].DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR;
				if (file_exists($this->installdir.'extention.inc.php')) {
					$menu_db = pc_base::load_model('menu_model');
					@include ($this->installdir.'extention.inc.php');
					$file = PC_PATH.'languages'.DIRECTORY_SEPARATOR.SYS_LANGUAGE.DIRECTORY_SEPARATOR.'system_menu.lang.php';
					if(file_exists($file)) {
						$content = file_get_contents($file);
						$content = substr($content,0,-2);
						$data = '';
						foreach ($language as $key => $l) {
							if (L($key, '', 'system_menu')==$key) {
								$data .= "\$LANG['".$key."'] = '".$l."';\r\n";
							}
						}
						$data = $content.$data."?>";
						file_put_contents($file,$data);
					} else {
						foreach ($language as $key =>$l) {
							if (L($key, '', 'system_menu')==$key) {
								$data .= "\$LANG['".$key."'] = '".$l."';\r\n";
							}
						}
						$data = "<?"."php\r\n\$data?>";
						file_put_contents($file,$data);
					}
				}
				if (file_exists($this->installdir.'languages'.DIRECTORY_SEPARATOR)) {
					dir_copy($this->installdir.'languages'.DIRECTORY_SEPARATOR, PC_PATH.'languages'.DIRECTORY_SEPARATOR);
				}
				/*if(file_exists($this->installdir.'templates'.DIRECTORY_SEPARATOR)) {
					dir_copy($this->installdir.'templates'.DIRECTORY_SEPARATOR, PC_PATH.'templates'.DIRECTORY_SEPARATOR.SYS_TPL_NAME.DIRECTORY_SEPARATOR.$t['module'].DIRECTORY_SEPARATOR);
					if (file_exists($this->installdir.'templates'.DIRECTORY_SEPARATOR.'name.inc.php')) {
						$keyid = 'templates|'.SYS_TPL_NAME.'|'.$t['module'];
						$file_explan[$keyid] = include $this->installdir.'templates'.DIRECTORY_SEPARATOR.'name.inc.php';
						$templatepath = PC_PATH.'templates'.DIRECTORY_SEPARATOR.SYS_TPL_NAME.DIRECTORY_SEPARATOR;
						if (file_exists($templatepath.'config.php')) {
							$style_info = include $templatepath.'config.php';
							$style_info['file_explan'] = array_merge($style_info['file_explan'], $file_explan);
							@file_put_contents($templatepath.'config.php', '<?php return '.var_export($style_info, true).';?>');
						}
						unlink(PC_PATH.'templates'.DIRECTORY_SEPARATOR.SYS_TPL_NAME.DIRECTORY_SEPARATOR.$t['module'].DIRECTORY_SEPARATOR.'name.inc.php');
					}
				}*/
			}
		}
		dr_json(1, L('refresh_menu_ok'));
	}
	
	// 隐藏或者启用
	function display() {
		$i = intval($this->input->get('id'));
		$v = $this->db->get_one(array('id'=>$i));
		if (!$v) {
		    dr_json(0, L('数据#'.$i.'不存在'));
        }
		$v = (int)$v['display'] ? 0 : 1;
		$this->db->update(array('display'=>$v),array('id'=>$i));
		dr_json(1, L($v ? '此菜单已被启用' : '此菜单已被隐藏'), array('value' => $v));
	}
	
	// 保存数据
	public function listorder() {
		$i = intval($this->input->get('id'));
		$this->db->update(array(dr_safe_replace($this->input->get('name'))=>dr_safe_replace($this->input->get('value'))),array('id'=>$i));
		dr_json(1, L('operation_success'));
	}
	
	/**
	 * 更新菜单的所属模式
	 * @param $id INT 菜单的ID
	 * @param $old_data 该菜单的老数据
	 * @param $new_data 菜单的新数据
	 **/
	private function update_menu_models($id, $old_data, $new_data) {
		$models_config = pc_base::load_config('model_config');
		if (is_array($models_config)) {
			foreach ($models_config as $_k => $_m) { 
				if (!isset($new_data[$_k])) $new_data[$_k] = 0;
				if ($old_data[$_k]==$new_data[$_k]) continue; //数据没有变化时继续执行下一项
				$r = $this->db->get_one(array('id'=>$id), 'parentid');
				$this->db->update(array($_k=>$new_data[$_k]), array('id'=>$id));
				if ($new_data[$_k] && $r['parentid']) {
					$this->update_parent_menu_models($r['parentid'], $_k); //如果设置所属模式，更新父级菜单的所属模式
				}
			}
		}
		return true;
	}

	/**
	 * 更新父级菜单的所属模式
	 * @param $id int 菜单ID
	 * @param $field  修改字段名
	 */
	private function update_parent_menu_models($id, $field) {
		$id = intval($id);
		$r = $this->db->get_one(array('id'=>$id), 'parentid');
		$this->db->update(array($field=>1), array('id'=>$id)); //修改父级的所属模式，然后判断父级是否存在父级
		if ($r['parentid']) {
			$this->update_parent_menu_models($r['parentid'], $field);
		}
		return true;
	}
	
	/**
	 * 执行SQL
	 * @param string $sql 要执行的sql语句
	 */
 	private function _sql_execute($sql) {
	    $sqls = $this->_sql_split($sql);
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
	
	/**
	 * 分割SQL语句
	 * @param string $sql 要执行的sql语句
	 */	
 	private function _sql_split($sql) {
		$database = pc_base::load_config('database');
		$db_charset = $database['default']['charset'];
		if($this->db->version() > '4.1' && $db_charset) {
			$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$db_charset,$sql);
		}
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