<?php
class content_input {
	var $modelid;
	var $fields;
	var $data;

	function __construct($modelid) {
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('sitemodel_field_model');
		$this->db_pre = $this->db->db_tablepre;
		$this->modelid = $modelid;
		$this->fields = getcache('model_field_'.$modelid,'model');
		//初始化附件类
		pc_base::load_sys_class('download','',0);
		$this->siteid = param::get_cookie('siteid');
		$this->download = new download('content','0',$this->siteid);
		$this->site_config = getcache('sitelist','commons');
		$this->site_config = $this->site_config[$this->siteid];
	}

	function get($data,$isimport = 0) {
		$this->data = $data = trim_script($data);
		$info = array();
		foreach($data as $field=>$value) {
			if(!isset($this->fields[$field]) && !check_in($field,'paytype,paginationtype,maxcharperpage,id')) continue;
			if(defined('IN_ADMIN')) {
				if(check_in($_SESSION['roleid'], $this->fields[$field]['unsetroleids'])) continue;
			} else {
				$_groupid = param::get_cookie('_groupid');
				if(check_in($_groupid, $this->fields[$field]['unsetgroupids'])) continue;
			}
			$name = $this->fields[$field]['name'];
			$minlength = $this->fields[$field]['minlength'];
			$maxlength = $this->fields[$field]['maxlength'];
			$pattern = $this->fields[$field]['pattern'];
			$errortips = $this->fields[$field]['errortips'];
			if(empty($errortips)) $errortips = $name.' '.L('not_meet_the_conditions');
			$length = empty($value) ? 0 : (is_string($value) ? mb_strlen($value) : count($value));

			if($minlength && $length < $minlength) {
				if($isimport) {
					return false;
				} else {
					if (IS_ADMIN) {
						dr_admin_msg(0, $name.' '.L('not_less_than').' '.$minlength.L('characters'), array('field' => $field));
					} else {
						dr_msg(0, $name.' '.L('not_less_than').' '.$minlength.L('characters'), array('field' => $field));
					}
				}
			}
			if($maxlength && $length > $maxlength) {
				if($isimport) {
					$value = str_cut($value,$maxlength,'');
				} else {
					if (IS_ADMIN) {
						dr_admin_msg(0, $name.' '.L('not_more_than').' '.$maxlength.L('characters'), array('field' => $field));
					} else {
						dr_msg(0, $name.' '.L('not_more_than').' '.$maxlength.L('characters'), array('field' => $field));
					}
				}
			} elseif($maxlength) {
				$value = str_cut($value,$maxlength,'');
			}
			if($pattern && $length && !preg_match($pattern, $value) && !$isimport) {
				if (IS_ADMIN) {
					dr_admin_msg(0, $errortips, array('field' => $field));
				} else {
					dr_msg(0, $errortips, array('field' => $field));
				}
			}
			$MODEL = getcache('model', 'commons');
			$this->db->table_name = $this->fields[$field]['issystem'] ? $this->db_pre.$MODEL[$this->modelid]['tablename'] : $this->db_pre.$MODEL[$this->modelid]['tablename'].'_data';
			if($this->fields[$field]['isunique'] && $this->db->get_one(array($field=>$value),$field) && ROUTE_A != 'edit') {
				if (IS_ADMIN) {
					dr_admin_msg(0, $name.L('the_value_must_not_repeat'), array('field' => $field));
				} else {
					dr_msg(0, $name.L('the_value_must_not_repeat'), array('field' => $field));
				}
			}
			$func = $this->fields[$field]['formtype'];
			if(method_exists($this, $func)) $value = $this->$func($field, $value);
			if($this->fields[$field]['issystem']) {
				$info['system'][$field] = $value;
			} else {
				$info['model'][$field] = $value;
			}
			//颜色选择为隐藏域 在这里进行取值
			$info['system']['style'] = $this->input->post('style_color') && preg_match('/^#([0-9a-z]+)/i', $this->input->post('style_color')) ? $this->input->post('style_color') : '';
			if($this->input->post('style_font_weight')=='bold') $info['system']['style'] = $info['system']['style'].';'.clearhtml($this->input->post('style_font_weight'));
		}
		return $info;
	}
}?>