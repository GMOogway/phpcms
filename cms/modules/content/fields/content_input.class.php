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
			// 下载远程图片
			if (isset($_POST['is_auto_down_img_'.$field]) && $_POST['is_auto_down_img_'.$field]) {
				$setting = string2array($this->fields[$field]['setting']);
				$watermark = $setting['watermark'];
				$attachment = $setting['attachment'];
				$image_reduce = $setting['image_reduce'];
				$value = $this->download->download($_POST['info'][$field], $watermark, $attachment, $image_reduce, $this->input->post('info')['catid']);
				// 去除站外链接
				if (isset($_POST['is_remove_a_'.$field]) && $_POST['is_remove_a_'.$field]) {
					if (preg_match_all("/<a(.*)href=(.+)>(.*)<\/a>/Ui", $value, $arrs)) {
						//$sites = require CACHE_PATH.'caches_commons/caches_data/domain_site.cache.php';
						$this->sitedb = pc_base::load_model('site_model');
						$sitedb_data = $this->sitedb->select();
						$sites = array();
						foreach ($sitedb_data as $t) {
							$domain = parse_url($t['domain']);
							if ($domain['port']) {
								$sites[$domain['host'].':'.$domain['port']] = $t['siteid'];
							} else {
								$sites[$domain['host']] = $t['siteid'];
							}
						}
						foreach ($arrs[2] as $i => $a) {
							if (strpos($a, ' ') !== false) {
								list($a) = explode(' ', $a);
							}
							$a = trim($a, '"');
							$a = trim($a, '\'');
							$arr = parse_url($a);
							if ($arr && $arr['host'] && !isset($sites[$arr['host']])) {
								// 去除a标签
								$value = str_replace($arrs[0][$i], $arrs[3][$i], $value);
							}
						}
					}
				}
				$info['model']['content'] = html2code($value);
			}
			// 提取缩略图
			if(isset($_POST['info']['thumb']) && isset($_POST['is_auto_thumb_'.$field]) && !$_POST['info']['thumb']) {
				$content = $this->input->post('info')[$field];
				$auto_thumb_length = intval($_POST['auto_thumb_'.$field])-1;
				if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", code2html($content), $matches)) {
					$info['system']['thumb'] = $matches[3][$auto_thumb_length];
				}
			}
			// 去除站外链接
			if (isset($_POST['is_remove_a_'.$field]) && $_POST['is_remove_a_'.$field]) {
				$value = $_POST['info'][$field];
				if (preg_match_all("/<a(.*)href=(.+)>(.*)<\/a>/Ui", $value, $arrs)) {
					//$sites = require CACHE_PATH.'caches_commons/caches_data/domain_site.cache.php';
					$this->sitedb = pc_base::load_model('site_model');
					$sitedb_data = $this->sitedb->select();
					$sites = array();
					foreach ($sitedb_data as $t) {
						$domain = parse_url($t['domain']);
						if ($domain['port']) {
							$sites[$domain['host'].':'.$domain['port']] = $t['siteid'];
						} else {
							$sites[$domain['host']] = $t['siteid'];
						}
					}
					foreach ($arrs[2] as $i => $a) {
						if (strpos($a, ' ') !== false) {
							list($a) = explode(' ', $a);
						}
						$a = trim($a, '"');
						$a = trim($a, '\'');
						$arr = parse_url($a);
						if ($arr && $arr['host'] && !isset($sites[$arr['host']])) {
							// 去除a标签
							$value = str_replace($arrs[0][$i], $arrs[3][$i], $value);
						}
					}
				}
			}
			// 提取描述信息
			if(isset($_POST['info']['description']) && isset($_POST['is_auto_description_'.$field]) && !$_POST['info']['description']) {
				$content = code2html($_POST['info'][$field]);
				$auto_description_length = intval($_POST['auto_description_'.$field]);
				$info['system']['description'] = dr_get_description(str_replace(array("'","\r\n","\t",'[page]','[/page]','&ldquo;','&rdquo;','&nbsp;',' ','　','	'), '', $content), $auto_description_length);
			}
			if($this->fields[$field]['issystem']) {
				if (!$info['system']['thumb'] || !$info['system']['description']) {
					$info['system'][$field] = $value;
				}
			} else {
				if (!$info['model']['content']) {
					$info['model'][$field] = $value;
				}
			}
			//颜色选择为隐藏域 在这里进行取值
			$info['system']['style'] = $this->input->post('style_color') && preg_match('/^#([0-9a-z]+)/i', $this->input->post('style_color')) ? $this->input->post('style_color') : '';
			if($this->input->post('style_font_weight')=='bold') $info['system']['style'] = $info['system']['style'].';'.clearhtml($this->input->post('style_font_weight'));
		}
		return $info;
	}
}?>