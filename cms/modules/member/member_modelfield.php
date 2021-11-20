<?php
/**
 * 管理员后台会员模型字段操作类
 */

defined('IN_CMS') or exit('No permission resources.');
//模型原型存储路径
define('MODEL_PATH',PC_PATH.'modules'.DIRECTORY_SEPARATOR.'member'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR);
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_func('util');

class member_modelfield extends admin {
	
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('sitemodel_field_model');
		$this->model_db = pc_base::load_model('sitemodel_model');
		$this->siteid = $this->get_siteid();
	}
	
	public function manage() {
		$modelid = $this->input->get('modelid');
		$datas = $this->cache_field($modelid);
		$modelinfo = $this->model_db->get_one(array('modelid'=>$modelid));
		$big_menu = array('javascript:artdialog(\'add\',\'?m=member&c=member_modelfield&a=add&modelid='.$modelinfo['modelid'].'\',\''.L('member_modelfield_add').' '.L('model_name').'：'.$modelinfo['name'].'\',\'80%\',\'80%\');void(0);', L('member_modelfield_add'));
		include $this->admin_tpl('member_modelfield_list');
	}
	
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$model_cache = getcache('member_model', 'commons');
			
			$modelid = $this->input->post('info')['modelid'] = intval($_POST['info']['modelid']);
			$model_table = $model_cache[$modelid]['tablename'];
			$tablename = $this->db->db_tablepre.$model_table;

			$field = $this->input->post('info')['field'];
			$minlength = $this->input->post('info')['minlength'] ? $_POST['info']['minlength'] : 0;
			$maxlength = $this->input->post('info')['maxlength'] ? $_POST['info']['maxlength'] : 0;
			$field_type = $this->input->post('info')['formtype'];
			$where = 'modelid='.$modelid.' AND field=\''.$field.'\' AND siteid='.$this->siteid.'';
			$model_field = $this->db->get_one($where);
			if ($model_field) dr_admin_msg(0,L('fieldname').'（'.$field.'）'.L('already_exist'), HTTP_REFERER);
			
			require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';
			
			if(isset($_POST['setting']['fieldtype'])) {
				$field_type = $this->input->post('setting')['fieldtype'];
			}
			
			require MODEL_PATH.'add.sql.php';
			//附加属性值
			$_POST['info']['setting'] = array2string($_POST['setting']);
			$_POST['info']['unsetgroupids'] = isset($_POST['unsetgroupids']) ? implode(',',$_POST['unsetgroupids']) : '';
			$_POST['info']['unsetroleids'] = isset($_POST['unsetroleids']) ? implode(',',$_POST['unsetroleids']) : '';

			$this->db->insert($_POST['info']);
			$this->cache_field($modelid);
			dr_admin_msg(1,L('operation_success'), '?m=member&c=member_model&a=manage', '', 'add');
		} else {
			$show_header = $show_validator= $show_dialog ='';
			pc_base::load_sys_class('form', '', 0);
			require MODEL_PATH.'fields.inc.php'; 
			$modelid = $this->input->get('modelid');
			
			//角色缓存
			$roles = getcache('role','commons');
			//会员组缓存
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			
			header("Cache-control: private");
			include $this->admin_tpl('member_modelfield_add');
		}
	}
	
	/**
	 * 修改
	 */
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$model_cache = getcache('member_model','commons');
			$fieldid = intval($_POST['fieldid']);
			$modelid = $this->input->post('info')['modelid'] = intval($_POST['info']['modelid']);
			$model_table = $model_cache[$modelid]['tablename'];

			$tablename = $this->db->db_tablepre.$model_table;

			$field = $this->input->post('info')['field'];
			$minlength = $this->input->post('info')['minlength'] ? $_POST['info']['minlength'] : 0;
			$maxlength = $this->input->post('info')['maxlength'] ? $_POST['info']['maxlength'] : 0;
			$field_type = $this->input->post('info')['formtype'];
			$where = 'modelid='.$modelid.' AND field=\''.$field.'\' AND siteid='.$this->siteid.'';
			if ($fieldid) {
				$where .= ' AND fieldid<>'.$fieldid;
			}
			$model_field = $this->db->get_one($where);
			if ($model_field) dr_admin_msg(0,L('fieldname').'（'.$field.'）'.L('already_exist'), HTTP_REFERER);
			
			require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';
			
			if(isset($_POST['setting']['fieldtype'])) {
				$field_type = $this->input->post('setting')['fieldtype'];
			}
			$oldfield = $this->input->post('oldfield');
			require MODEL_PATH.'edit.sql.php';
			//附加属性值
			$_POST['info']['setting'] = array2string($_POST['setting']);
			$_POST['info']['unsetgroupids'] = isset($_POST['unsetgroupids']) ? implode(',',$_POST['unsetgroupids']) : '';
			$_POST['info']['unsetroleids'] = isset($_POST['unsetroleids']) ? implode(',',$_POST['unsetroleids']) : '';
			$this->db->update($_POST['info'],array('fieldid'=>$fieldid));
			$this->cache_field($modelid);
			
			//更新模型缓存
			pc_base::load_app_class('member_cache','','');
			member_cache::update_cache_model();
			
			dr_admin_msg(1,L('operation_success'), HTTP_REFERER, '', 'edit');
		} else {
			$show_header = $show_validator= $show_dialog ='';
			pc_base::load_sys_class('form','',0);
			require MODEL_PATH.'fields.inc.php'; 
			$modelid = intval($_GET['modelid']);
			$fieldid = intval($_GET['fieldid']);
			$r = $this->db->get_one(array('fieldid'=>$fieldid));
			extract($r);
			$setting = string2array($setting);
			ob_start();
			include MODEL_PATH.$formtype.DIRECTORY_SEPARATOR.'field_edit_form.inc.php';
			$form_data = ob_get_contents();
			ob_end_clean();
			//角色缓存
			$roles = getcache('role','commons');
			$grouplist = array();
			//会员组缓存
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			header("Cache-control: private");
			include $this->admin_tpl('member_modelfield_edit');
		}
	}
	
	public function delete() {
		$fieldid = intval($_GET['fieldid']);
		$r = $this->db->get_one(array('fieldid'=>$fieldid));
		
		//删除模型字段
		$this->db->delete(array('fieldid'=>$fieldid));
		
		//删除表字段
		$model_cache = getcache('member_model', 'commons');
		
		$model_table = $model_cache[$r['modelid']]['tablename'];

		$this->db->drop_field($model_table, $r['field']);
		
		dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
	}
	
	/**
	 *  禁用字段
	 */
	public function disable() {
		$fieldid = intval($_GET['fieldid']);
		$disabled = intval($_GET['disabled']);
		$this->db->update(array('disabled'=>$disabled), array('fieldid'=>$fieldid));
		dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
	}
	
	/**
	 * 排序
	 */
	public function sort() {
		if (isset($_POST['listorders']) && is_array($_POST['listorders'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('fieldid'=>$id));
			}
			dr_admin_msg(1,L('operation_success'));
		} else {
			dr_admin_msg(0,L('operation_failure'));
		}
	}
	
	/**
	 * 检查字段是否存在
	 */
	public function public_checkfield() {
		$field = strtolower($this->input->get('field'));
		$fieldid = intval($this->input->get('fieldid'));
		//$oldfield = strtolower($_GET['oldfield']);
		//if($field==$oldfield) exit('1');
		$modelid = intval($this->input->get('modelid'));
		/*$model_cache = getcache('member_model','commons');
		$tablename = $model_cache[$modelid]['tablename'];
		$this->db->table_name = $this->db->db_tablepre.$tablename;

		$fields = $this->db->get_fields();*/
		$where = 'modelid='.$modelid.' AND field=\''.$field.'\' AND siteid='.$this->siteid.'';
		if ($fieldid) {
			$where .= ' AND fieldid<>'.$fieldid;
		}
		$fields = $this->db->get_one($where);
		
		if($fields) {
		//if(array_key_exists($field, $fields)) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/**
	 * 字段属性设置
	 */
	public function public_field_setting() {
		$fieldtype = $this->input->get('fieldtype');
		require MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'config.inc.php';
		ob_start();
		include MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'field_add_form.inc.php';
		$data_setting = ob_get_contents();
		ob_end_clean();
		$settings = array('field_basic_table'=>$field_basic_table,'field_minlength'=>$field_minlength,'field_maxlength'=>$field_maxlength,'field_allow_search'=>$field_allow_search,'field_allow_fulltext'=>$field_allow_fulltext,'field_allow_isunique'=>$field_allow_isunique,'setting'=>$data_setting);
		echo json_encode($settings);
		return true;
	}
	
	/**
	 * 更新指定模型字段缓存
	 * 
	 * @param $modelid 模型id
	 */
	public function cache_field($modelid = 0) {
		$field_array = array();
		$fields = $this->db->select(array('modelid'=>$modelid),'*',100,'listorder ASC');
		foreach($fields as $_value) {
			$setting = string2array($_value['setting']);
			$_value = array_merge($_value,$setting);
			$field_array[$_value['field']] = $_value;
		}
		setcache('model_field_'.$modelid,$field_array,'model');
		return $field_array;
	}
	
	/**
	 * 预览模型
	 */
	public function public_priview() {
		pc_base::load_sys_class('form','',0);
		$show_header = '';
		$modelid = intval($_GET['modelid']);

		require CACHE_MODEL_PATH.'content_form.class.php';
		$content_form = new content_form($modelid);
		$forminfos = $content_form->get();
		include $this->admin_tpl('sitemodel_priview');
	}
	/**
	 * 汉字转换拼音
	 */
	public function public_ajax_pinyin() {
		$pinyin = pc_base::load_sys_class('pinyin');
		$name = dr_safe_replace($this->input->get('name'));
		if (!$name) {
			exit('');
		}
		$py = $pinyin->result($name);
		if (strlen($py) > 12) {
			$sx = $pinyin->result($name, 0);
			if ($sx) {
				exit($sx);
			}
		}
		exit($py);
	}
}
?>