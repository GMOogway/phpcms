<?php
defined('IN_CMS') or exit('No permission resources.');
//模型原型存储路径
define('MODEL_PATH',PC_PATH.'modules'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR);
pc_base::load_app_class('admin','admin',0);
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
class sitemodel_field extends admin {
	private $input,$db,$model_db,$content_db,$cache_api;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('sitemodel_field_model');
		$this->model_db = pc_base::load_model('sitemodel_model');
		$this->content_db = pc_base::load_model('content_model');
		$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
		$this->siteid = $this->get_siteid();
	}
	
	public function init() {
		$show_header = true;
		$modelid = $this->input->get('modelid');
		$this->cache_field($modelid);
		$datas = $this->db->select(array('modelid'=>$modelid),'*',100,$this->input->get('order') ? $this->input->get('order') : 'listorder ASC,fieldid ASC');
		$r = $this->model_db->get_one(array('modelid'=>$modelid));
		require MODEL_PATH.'fields.inc.php';
		if($modelid==-2) {
			$forbid_delete = array('title','keywords','updatetime','content','template');
		}
		include $this->admin_tpl('sitemodel_field_manage');
	}
	public function add() {
		if(IS_AJAX_POST) {
			$model_cache = getcache('model','commons');
			$info = $this->input->post('info', false);
			$setting = $this->input->post('setting', false);
			if (!$info['formtype']) dr_json(0, L('select_fieldtype'), array('field' => 'formtype'));
			if (!$info['name']) dr_json(0, L('field_nickname').L('empty'), array('field' => 'name'));
			if (!$info['field']) dr_json(0, L('fieldname').L('empty'), array('field' => 'field'));
			$modelid = $info['modelid'];
			if($modelid==-1) {
				$this->siteid = 1;
				$info['issystem'] = 1;
				$tablename = $this->db->db_tablepre.'category';
			} else if($modelid==-2) {
				$this->siteid = 1;
				$info['issystem'] = 1;
				$tablename = $this->db->db_tablepre.'page';
			} else if($modelid) {
				$model_table = $model_cache[$modelid]['tablename'];
				$tablename = $this->input->post('issystem') ? $this->db->db_tablepre.$model_table : $this->db->db_tablepre.$model_table.'_data_0';
			} else {
				$this->siteid = 1;
				$info['issystem'] = 1;
				$tablename = $this->db->db_tablepre.'site';
			}
			$issystem = $info['issystem'];

			$field = $info['field'];
			$cname = $info['name'];
			$model_field = $this->db->get_one(array('modelid'=>$modelid, 'field'=>$field, 'siteid'=>$this->siteid));
			if (!$model_field) {
				$field_rs = $this->db->query('SHOW FULL COLUMNS FROM `'.$tablename.'`');
				foreach ($field_rs as $rs) {
					if ($rs['Field']==$field) {
						$model_field = 1;
					}
				}
			}
			if ($model_field) dr_json(0, L('fieldname').'（'.$field.'）'.L('already_exist'), array('field' => 'field'));
			$minlength = $info['minlength'] ? $info['minlength'] : 0;
			$maxlength = $info['maxlength'] ? $info['maxlength'] : 0;
			$field_type = $info['formtype'];
			
			require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';
			
			if(isset($setting['fieldtype'])) {
				$field_type = $setting['fieldtype'];
			}
			require MODEL_PATH.'add.sql.php';
			//附加属性值
			$info['setting'] = array2string($setting);
			$info['siteid'] = $this->siteid;
			$info['unsetgroupids'] = $this->input->post('unsetgroupids') ? implode(',',$this->input->post('unsetgroupids')) : '';
			$info['unsetroleids'] = $this->input->post('unsetroleids') ? implode(',',$this->input->post('unsetroleids')) : '';
			!$issystem && $info['issearch'] = 0;
			$this->db->insert($info);
			$this->cache_field($modelid);
			dr_json(1, L('add_success'), array('url' => '?m=content&c=sitemodel_field&a=init&modelid='.$modelid.'&menuid='.$this->input->post('menuid').'&pc_hash='.dr_get_csrf_token()));
		} else {
			$show_header = $show_validator = $show_dialog = true;
			pc_base::load_sys_class('form','',0);
			require MODEL_PATH.'fields.inc.php';
			$modelid = $this->input->get('modelid');
			if (!$modelid) {
				$not_allow_fields = array('catid','typeid','title','keyword','posid','islink','template','username','groupid','author','readpoint','downfile','copyfrom','pages','redirect','wxurl','word');
			} elseif ($modelid==-1) {
				$not_allow_fields = array('catid','typeid','title','keyword','posid','islink','template','username','pages','redirect','wxurl','word');
			} elseif ($modelid==-2) {
				$not_allow_fields = array('catid','typeid','title','keyword','posid','islink','template','username','pages','redirect');
			}
			$f_datas = $this->db->select(array('modelid'=>$modelid),'field,name',100,'listorder ASC');
			$m_r = $this->model_db->get_one(array('modelid'=>$modelid));
			$exists_field = array();
			foreach($f_datas as $_k=>$_v) {
				$exists_field[] = $_v['field'];
			}

			$all_field = array();
			foreach($fields as $_k=>$_v) {
				if(in_array($_k,$not_allow_fields) || in_array($_k,$exists_field) && in_array($_k,$unique_fields)) continue;
				$all_field[$_k] = $_v;
			}

			$modelid = $this->input->get('modelid');
			//角色缓存
			$roles = getcache('role','commons');
			$grouplist = array();
			//会员组缓存
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			header("Cache-control: private");
			include $this->admin_tpl('sitemodel_field_add');
		}
	}
	public function edit() {
		if(IS_AJAX_POST) {
			$model_cache = getcache('model','commons');
			$fieldid = intval($this->input->post('fieldid'));
			$info = $this->input->post('info', false);
			$setting = $this->input->post('setting', false);
			if (!$info['formtype']) dr_json(0, L('select_fieldtype'), array('field' => 'formtype'));
			if (!$info['name']) dr_json(0, L('field_nickname').L('empty'), array('field' => 'name'));
			if (!$info['field']) dr_json(0, L('fieldname').L('empty'), array('field' => 'field'));
			$modelid = $info['modelid'];
			if($modelid==-1) {
				$this->siteid = 1;
				$tablename = $this->db->db_tablepre.'category';
			} else if($modelid==-2) {
				$this->siteid = 1;
				$tablename = $this->db->db_tablepre.'page';
			} else if($modelid) {
				$model_table = $model_cache[$modelid]['tablename'];
				$tablename = $this->input->post('issystem') ? $this->db->db_tablepre.$model_table : $this->db->db_tablepre.$model_table.'_data_0';
			} else {
				$this->siteid = 1;
				$tablename = $this->db->db_tablepre.'site';
			}

			$field = $info['field'];
			$cname = $info['name'];
			$minlength = $info['minlength'] ? $info['minlength'] : 0;
			$maxlength = $info['maxlength'] ? $info['maxlength'] : 0;
			$field_type = $info['formtype'];
			
			require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';
			
			if(isset($setting['fieldtype'])) {
				$field_type = $setting['fieldtype'];
			}
			$oldfield = $this->input->post('oldfield');
			$model_field = $this->db->get_one(array('modelid'=>$modelid, 'field'=>$field, 'fieldid<>'=>$fieldid, 'siteid'=>$this->siteid));
			if (!$model_field && $field!=$oldfield) {
				$field_rs = $this->db->query('SHOW FULL COLUMNS FROM `'.$tablename.'`');
				foreach ($field_rs as $rs) {
					if ($rs['Field']==$field) {
						$model_field = 1;
					}
				}
			}
			if ($model_field) dr_json(0, L('fieldname').'（'.$field.'）'.L('already_exist'), array('field' => 'field'));
			require MODEL_PATH.'edit.sql.php';
			//附加属性值
			$info['setting'] = array2string($setting);
			
			$info['unsetgroupids'] = $this->input->post('unsetgroupids') ? implode(',',$this->input->post('unsetgroupids')) : '';
			$info['unsetroleids'] = $this->input->post('unsetroleids') ? implode(',',$this->input->post('unsetroleids')) : '';
			!$this->input->post('issystem') && $info['issearch'] = 0;
			$this->db->update($info,array('fieldid'=>$fieldid,'siteid'=>$this->siteid));
			$this->cache_field($modelid);
			dr_json(1, L('update_success'), array('url' => '?m=content&c=sitemodel_field&a=init&modelid='.$modelid.'&menuid='.$this->input->post('menuid').'&pc_hash='.dr_get_csrf_token()));
		} else {
			$show_header = $show_validator = $show_dialog = true;
			pc_base::load_sys_class('form','',0);
			require MODEL_PATH.'fields.inc.php';
			$modelid = intval($this->input->get('modelid'));
			$fieldid = intval($this->input->get('fieldid'));

			
			$m_r = $this->model_db->get_one(array('modelid'=>$modelid));
			$r = $this->db->get_one(array('fieldid'=>$fieldid));
			extract($r);
			if($unsetgroupids != '') $unsetgroupids = strpos($unsetgroupids, ',') ? explode(',', $unsetgroupids) : array($unsetgroupids);
			if($unsetroleids != '') $unsetroleids = strpos($unsetroleids, ',') ? explode(',', $unsetroleids) : array($unsetroleids);
			require MODEL_PATH.$formtype.DIRECTORY_SEPARATOR.'config.inc.php';
			
			$setting = string2array($setting);
			ob_start();
			include MODEL_PATH.$formtype.DIRECTORY_SEPARATOR.'field_edit_form.inc.php';
			$form_data = ob_get_contents();
			ob_end_clean();
			!$issystem && $field_allow_search = 0;
			//角色缓存
			$roles = getcache('role','commons');
			$grouplist = array();
			//会员组缓存
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			header("Cache-control: private");
			include $this->admin_tpl('sitemodel_field_edit');
		}
	}
	public function disabled() {
		$modelid = intval($this->input->get('modelid'));
		$fieldid = intval($this->input->get('fieldid'));
		if($modelid==-1) {
			$this->siteid = 1;
		} else if($modelid==-2) {
			$this->siteid = 1;
		} else if(!$modelid) {
			$this->siteid = 1;
		}
		$disabled = $this->input->get('disabled') ? 0 : 1;
		$this->db->update(array('disabled'=>$disabled),array('fieldid'=>$fieldid,'siteid'=>$this->siteid));
		$this->cache_field($modelid);
		dr_admin_msg(1,L('operation_success'),HTTP_REFERER);
	}
	public function delete() {
		$modelid = intval($this->input->get('modelid'));
		$fieldid = intval($this->input->get('fieldid'));
		if($modelid==-1) {
			$this->siteid = 1;
		} else if($modelid==-2) {
			$this->siteid = 1;
		} else if(!$modelid) {
			$this->siteid = 1;
		}
		$r = $this->db->get_one(array('fieldid'=>$this->input->get('fieldid'),'siteid'=>$this->siteid));
		//必须放在删除字段前、在删除字段部分，重置了 tablename
		$this->db->delete(array('fieldid'=>$this->input->get('fieldid'),'siteid'=>$this->siteid));

		$model_cache = getcache('model','commons');
		if($modelid==-1) {
			$tablename = 'category';
		} else if($modelid==-2) {
			$tablename = 'page';
		} else if($modelid) {
			$model_table = $model_cache[$modelid]['tablename'];
			$tablename = $r['issystem'] ? $model_table : $model_table.'_data_0';
		} else {
			$tablename = 'site';
		}
		$this->db->drop_field($tablename,$r['field'],$r['issystem']);
		dr_admin_msg(1,L('operation_success'),HTTP_REFERER);
	}
	/**
	 * 排序
	 */
	public function listorder() {
		if($this->input->post('dosubmit')) {
			if ($this->input->post('listorders') && is_array($this->input->post('listorders'))) {
				foreach($this->input->post('listorders') as $id => $listorder) {
					$this->db->update(array('listorder'=>$listorder),array('fieldid'=>$id));
				}
			}
			dr_admin_msg(1,L('operation_success'),HTTP_REFERER);
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
		//$oldfield = strtolower($this->input->get('oldfield'));
		//if($field==$oldfield) exit('1');
		$modelid = intval($this->input->get('modelid'));
		/*if($modelid==-1) {
			$tablename = 'category';
		} else if($modelid==-2) {
			$tablename = 'page';
		} else if($modelid) {
			$model_cache = getcache('model','commons');
			$tablename = $model_cache[$modelid]['tablename'];
			$issystem = intval($this->input->get('issystem'));
		} else {
			$tablename = 'site';
		}
		if($modelid==-1) {
			$this->db->table_name = $this->db->db_tablepre.$tablename;
		} else if($modelid==-2) {
			$this->db->table_name = $this->db->db_tablepre.$tablename;
		} else if($modelid) {
			if($issystem) {
				$this->db->table_name = $this->db->db_tablepre.$tablename;
			} else {
				$this->db->table_name = $this->db->db_tablepre.$tablename.'_data_0';
			}
		} else {
			$this->db->table_name = $this->db->db_tablepre.$tablename;
		}
		$fields = $this->db->get_fields();*/
		$where = 'modelid='.$modelid.' AND field=\''.$field.'\' AND siteid='.$this->siteid.'';
		if ($fieldid) {
			$where .= ' AND fieldid<>'.$fieldid;
		}
		$fields = $this->db->get_one($where);
		
		if($fields) {
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
		if (!is_file(MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'config.inc.php')) {
			exit();
		}
		require MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'config.inc.php';
		ob_start();
		include MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'field_add_form.inc.php';
		$data_setting = ob_get_contents();
		//$data_setting = iconv('gbk','utf-8',$data_setting);
		ob_end_clean();
		$settings = array('field_basic_table'=>$field_basic_table,'field_minlength'=>$field_minlength,'field_maxlength'=>$field_maxlength,'field_allow_search'=>$field_allow_search,'field_allow_fulltext'=>$field_allow_fulltext,'field_allow_isunique'=>$field_allow_isunique,'setting'=>$data_setting);
		exit(dr_array2string($settings));
	}
	/**
	 * 更新指定模型字段缓存
	 * 
	 * @param $modelid 模型id
	 */
	public function cache_field($modelid = 0) {
		$this->cache_api->sitemodel_field($modelid);
	}
	/**
	 * 预览模型
	 */
	public function public_priview() {
		pc_base::load_sys_class('form','',0);
		$show_header = $show_validator = $show_dialog = true;
		$modelid = intval($this->input->get('modelid'));
		require CACHE_MODEL_PATH.'content_form.class.php';
		$content_form = new content_form($modelid);
		$r = $this->model_db->get_one(array('modelid'=>$modelid));
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