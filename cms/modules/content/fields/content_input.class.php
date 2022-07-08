<?php
class content_input {
	var $modelid;
	var $fields;
	var $data;

	function __construct($modelid) {
		$this->input = pc_base::load_sys_class('input');
		$this->cache = pc_base::load_sys_class('cache');
		$this->db = pc_base::load_model('sitemodel_field_model');
		$this->db_pre = $this->db->db_tablepre;
		$this->modelid = $modelid;
		$this->fields = getcache('model_field_'.$modelid,'model');
		//初始化附件类
		pc_base::load_sys_class('download','',0);
		$this->siteid = param::get_cookie('siteid');
		$this->userid = $_SESSION['userid'] ? $_SESSION['userid'] : (param::get_cookie('_userid') ? param::get_cookie('_userid') : param::get_cookie('userid'));
		$this->download = new download('content','0',$this->siteid);
		$this->site_config = getcache('sitelist','commons');
		$this->site_config = $this->site_config[$this->siteid];
		$this->rid = md5(FC_NOW_URL.$this->input->get_user_agent().$this->input->ip_address().intval($this->userid));
	}

	function get($data,$isimport = 0) {
		$this->data = $data;
		$info = array();
		if (is_array($data)) {
			foreach($data as $field=>$value) {
				if(!isset($this->fields[$field]) && !check_in($field,'paytype,paginationtype,maxcharperpage,id')) continue;
				if(defined('IS_ADMIN') && IS_ADMIN) {
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
				$length = empty($value) ? 0 : (is_string($value) ? mb_strlen($value) : dr_strlen($value));

				if(isset($_POST['info']['islink']) && $_POST['info']['islink']==1 && !$_POST['linkurl']) {
					if($isimport) {
						return false;
					} else {
						if (IS_ADMIN) {
							dr_admin_msg(0, L('islink_url').L('empty'), array('field' => 'islink'));
						} else {
							dr_msg(0, L('islink_url').L('empty'), array('field' => 'islink'));
						}
					}
				}
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
				if ($this->modelid && $this->modelid!=-1 && $this->modelid!=-2) {
					if($this->fields[$field]['isunique']) {
						if (!$this->fields[$field]['issystem']) {
							$MODEL = getcache('model', 'commons');
							$this->db->table_name = $this->db_pre.$MODEL[$this->modelid]['tablename'];
							$content_data = $this->db->get_one('', '*', 'id desc');
							$tid = $content_data['id'] ? get_table_id($content_data['id']) + 1 : 200;
							for ($i = 0; $i < $tid; $i ++) {
								$this->db->table_name = $this->db_pre.$MODEL[$this->modelid]['tablename'].'_data_'.$i;
								$this->db->query("SHOW TABLES LIKE '".$this->db->table_name."'");
								$table_exists = $this->db->fetch_array();
								if (!$table_exists) {
									continue;
								}
								$isunique_value = $this->db->get_one(array($field=>$value,'id<>'=>(int)$data['id']),$field);
								$this->db->table_name = $this->db_pre.$MODEL[$this->modelid]['tablename'];
							}
						} else {
							$isunique_value = $this->db->get_one(array($field=>$value,'id<>'=>(int)$data['id']),$field);
						}
						if(!$value) {
							if (IS_ADMIN) {
								dr_admin_msg(0, $name.L('empty'), array('field' => $field));
							} else {
								dr_msg(0, $name.L('empty'), array('field' => $field));
							}
						}
						if($isunique_value) {
							if (IS_ADMIN) {
								dr_admin_msg(0, $name.L('the_value_must_not_repeat'), array('field' => $field));
							} else {
								dr_msg(0, $name.L('the_value_must_not_repeat'), array('field' => $field));
							}
						}
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
		}
		return $info;
	}
}?>