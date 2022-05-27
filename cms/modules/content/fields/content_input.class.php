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
		pc_base::load_sys_class('upload','',0);
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
			$MODEL = getcache('model', 'commons');
			if($this->fields[$field]['isunique']) {
				$this->db->table_name = $this->db_pre.$MODEL[$this->modelid]['tablename'];
				if (!$this->fields[$field]['issystem'] && $this->modelid && $this->modelid!=-1 && $this->modelid!=-2) {
					$content_data = $this->db->get_one('', '*', 'id desc');
					$tid = $content_data['id'] ? get_table_id($content_data['id']) + 1 : 200;
					for ($i = 0; $i < $tid; $i ++) {
						$this->db->table_name = $this->db_pre.$MODEL[$this->modelid]['tablename'].'_data_'.$i;
						$this->db->query("SHOW TABLES LIKE '".$this->db->table_name."'");
						$table_exists = $this->db->fetch_array();
						if (!$table_exists) {
							continue;
						}
						$isunique_value = $this->db->get_one(array($field=>$value),$field);
						$this->db->table_name = $this->db_pre.$MODEL[$this->modelid]['tablename'];
					}
				} else {
					$isunique_value = $this->db->get_one(array($field=>$value),$field);
				}
			}
			if($this->fields[$field]['isunique'] && !$value) {
				if (IS_ADMIN) {
					dr_admin_msg(0, $name.L('empty'), array('field' => $field));
				} else {
					dr_msg(0, $name.L('empty'), array('field' => $field));
				}
			}
			if($this->fields[$field]['isunique'] && $isunique_value) {
				if (IS_ADMIN) {
					dr_admin_msg(0, $name.L('the_value_must_not_repeat'), array('field' => $field));
				} else {
					dr_msg(0, $name.L('the_value_must_not_repeat'), array('field' => $field));
				}
			}
			$func = $this->fields[$field]['formtype'];
			if(method_exists($this, $func)) $value = $this->$func($field, $value);
			// 提取缩略图
			if(isset($_POST['info']['thumb']) && isset($_POST['is_auto_thumb_'.$field]) && !$_POST['info']['thumb']) {
				$setting = string2array($this->fields[$field]['setting']);
				$watermark = $setting['watermark'];
				$attachment = $setting['attachment'];
				$image_reduce = $setting['image_reduce'];
				$content = $this->input->post('info')[$field];
				$site_setting = string2array($this->site_config['setting']);
				$watermark = $site_setting['ueditor'] || $watermark ? 1 : 0;
				$auto_thumb_length = intval($_POST['auto_thumb_'.$field])-1;
				if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+)\\2/i", code2html($content), $matches)) {
					$this->upload = new upload('content',$this->input->post('info')['catid'],$this->siteid);
					foreach ($matches[3] as $img) {
						$ext = get_image_ext($img);
						if (!$ext) {
							continue;
						}
						// 下载缩略图
						// 判断域名白名单
						$arr = parse_url($img);
						$domain = $arr['host'];
						if ($domain) {
							$file = dr_catcher_data($img, 8);
							if (!$file) {
								CI_DEBUG && log_message('debug', '服务器无法下载图片：'.$img);
							} else {
								// 尝试找一找附件库
								$attachmentdb = pc_base::load_model('attachment_model');
								$att = $attachmentdb->get_one(array('related'=>'%ueditor%', 'filemd5'=>md5($file)));
								if ($att) {
									$images[] = dr_get_file($att['aid']);
								} else {
									// 下载归档
									$rt = $this->upload->down_file([
										'url' => $img,
										'timeout' => 5,
										'watermark' => $watermark,
										'attachment' => $this->upload->get_attach_info(intval($attachment), intval($image_reduce)),
										'file_ext' => $ext,
										'file_content' => $file,
									]);
									if ($rt['code']) {
										$att = $this->upload->save_data($rt['data'], 'ueditor:'.$this->rid);
										if ($att['code']) {
											// 归档成功
											$value = str_replace($img, $rt['data']['url'], $value);
											$images[] = dr_get_file($att['code']);
											// 标记附件
											$GLOBALS['downloadfiles'][] = $rt['data']['url'];
										}
									}
								}
							}
						}
					}
				}
			}
			if ($images) {
				$info['system']['thumb'] = $images[$auto_thumb_length];
			}
			// 提取描述信息
			if(isset($_POST['info']['description']) && isset($_POST['is_auto_description_'.$field]) && !$_POST['info']['description']) {
				$content = code2html($_POST['info'][$field]);
				$auto_description_length = intval($_POST['auto_description_'.$field]);
				$info['system']['description'] = dr_get_description(str_replace(array("'","\r\n","\t",'[page]','[/page]'), '', $content), $auto_description_length);
			}
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