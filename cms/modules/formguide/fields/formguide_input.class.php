<?php
class formguide_input {
	var $formid;
	var $fields;
	var $data;

	function __construct($formid) {
		$this->input = pc_base::load_sys_class('input');
		$this->formid = $formid;
		$this->fields = getcache('model_field_'.$formid, 'model');
		$this->siteid = get_siteid();
		//初始化附件类
		pc_base::load_sys_class('download','',0);
		$this->siteid = param::get_cookie('siteid');
		$this->download = new download('formguide','0',$this->siteid);
		$this->site_config = getcache('sitelist','commons');
		$this->site_config = $this->site_config[$this->siteid];
	}

	function get($data,$isimport = 0) {
		$this->data = $data = trim_script($data);
		$info = array();
		if (is_array($this->fields)) {
			foreach($this->fields as $field) {
				//if(!isset($this->fields[$field]) || check_in($_roleid, $this->fields[$field]['unsetroleids']) || check_in($_groupid, $this->fields[$field]['unsetgroupids'])) continue;
				$name = $field['name'];
				$minlength = $field['minlength'];
				$maxlength = $field['maxlength'];
				$pattern = $field['pattern'];
				$errortips = $field['errortips'];
				$value = $data[$field['field']];
				if(empty($errortips)) $errortips = $name.' '.L('not_meet_the_conditions');
				$length = is_array($value) ? (empty($value) ? 0 : 1) : mb_strlen($value);

				if($minlength && $length < $minlength) {
					if($isimport) {
						return false;
					} else {
						if (IS_ADMIN) {
							dr_admin_msg(0, $name.' '.L('not_less_than').' '.$minlength.L('characters'), array('field' => $field['field']));
						} else {
							dr_msg(0, $name.' '.L('not_less_than').' '.$minlength.L('characters'), array('field' => $field['field']));
						}
					}
				}
				if($maxlength && $length > $maxlength) {
					if($isimport) {
						$value = str_cut($value,$maxlength,'');
					} else {
						if (IS_ADMIN) {
							dr_admin_msg(0, $name.' '.L('not_more_than').' '.$maxlength.L('characters'), array('field' => $field['field']));
						} else {
							dr_msg(0, $name.' '.L('not_more_than').' '.$maxlength.L('characters'), array('field' => $field['field']));
						}
					}
				} elseif($maxlength) {
					$value = str_cut($value,$maxlength,'');
				}
				if($pattern && $length && !preg_match($pattern, $value) && !$isimport) {
					if (IS_ADMIN) {
						dr_admin_msg(0, $errortips, array('field' => $field['field']));
					} else {
						dr_msg(0, $errortips, array('field' => $field['field']));
					}
				}
				$func = $field['formtype'];
				if(method_exists($this, $func)) $value = $this->$func($field['field'], $value);
				$info[$field['field']] = $value;
				//颜色选择为隐藏域 在这里进行取值
				if ($this->input->post('style_color')) $info['style'] = $this->input->post('style_color');
				if($this->input->post('style_font_weight')) $info['style'] = $info['style'].';'.clearhtml($this->input->post('style_font_weight'));
			}
		}
		return $info;
	}
}?>