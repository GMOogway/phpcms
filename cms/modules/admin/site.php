<?php
defined('IN_CMS') or exit('No permission resources.');
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form','',0);
pc_base::load_sys_func('dir');
class site extends admin {
	private $db;
	public function __construct() {
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('site_model');
		parent::__construct();
		$this->locate = array(
			'left-top' => L('site_att_watermark_pos_1'),
			'center-top' => L('site_att_watermark_pos_2'),
			'right-top' => L('site_att_watermark_pos_3'),

			'left-middle' => L('site_att_watermark_pos_4'),
			'center-middle' => L('site_att_watermark_pos_5'),
			'right-middle' => L('site_att_watermark_pos_6'),

			'left-bottom' => L('site_att_watermark_pos_7'),
			'center-bottom' => L('site_att_watermark_pos_8'),
			'right-bottom' => L('site_att_watermark_pos_9'),
		);
		$files = dr_file_map(CMS_PATH.'statics/images/water/font/', 1);
		foreach ($files as $t) {
			if (substr($t, -3) == 'ttf') {
				$this->waterfont[] = $t;
			}
		}
		$waterfiles = dr_file_map(CMS_PATH.'statics/images/water/', 1);
		foreach ($waterfiles as $t) {
			if (substr($t, -3) == 'png' || substr($t, -3) == 'gif' || substr($t, -3) == 'jpg' || substr($t, -3) == 'jpeg') {
				$this->waterfile[] = $t;
			}
		}
	}
	
	public function init() {
		$tablename = $this->db->db_tablepre.'site';
		if ($this->db->field_exists('uuid')) {
			$this->db->query('ALTER TABLE `'.$tablename.'` DROP `uuid`');
		}
		if (!$this->db->field_exists('ishtml')) {
			$this->db->query('ALTER TABLE `'.$tablename.'` ADD `ishtml` tinyint(1) unsigned NOT NULL DEFAULT \'1\' COMMENT \'首页静态\' AFTER `domain`');
		}
		if (!$this->db->field_exists('mobileauto')) {
			$this->db->query('ALTER TABLE `'.$tablename.'` ADD `mobileauto` tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'自动识别\' AFTER `ishtml`');
		}
		if (!$this->db->field_exists('mobilehtml')) {
			$this->db->query('ALTER TABLE `'.$tablename.'` ADD `mobilehtml` tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'生成静态\' AFTER `mobileauto`');
		}
		if (!$this->db->field_exists('not_pad')) {
			$this->db->query('ALTER TABLE `'.$tablename.'` ADD `not_pad` tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'将平板端排除\' AFTER `mobilehtml`');
		}
		if (!$this->db->field_exists('mobile_domain')) {
			$this->db->query('ALTER TABLE `'.$tablename.'` ADD `mobile_domain` char(255) DEFAULT \'\' COMMENT \'手机域名\' AFTER `not_pad`');
		}
		if (!$this->db->field_exists('style')) {
			$this->db->query('ALTER TABLE `'.$tablename.'` ADD `style` varchar(5) NOT NULL COMMENT \'\' AFTER `setting`');
		}
		$page = $this->input->get('page') && intval($this->input->get('page')) ? intval($this->input->get('page')) : 1;
		$pagesize = 20;
		$offset = ($page - 1) * $pagesize;
		$list = $this->db->select('', '*', $offset.','.$pagesize);
		$total = $this->db->count();
		$pages = pages($total, $page, $pagesize);
		$show_dialog = true;
		$big_menu = array('javascript:dr_iframe(\'add\',\'?m=admin&c=site&a=add\',\'60%\',\'60%\');void(0);', L('add_site'));
		include $this->admin_tpl('site_list');
	}
	
	public function add() {
		header("Cache-control: private");
		if ($this->input->post('dosubmit')) {
			$info = $this->input->post('info');
			$template = $this->input->post('template');
			$setting = $this->input->post('setting');
			$info['name'] = isset($info['name']) && trim($info['name']) ? trim($info['name']) : dr_json(0, L('site_name').L('empty'), array('field' => 'name'));
			$info['dirname'] = isset($info['dirname']) && trim($info['dirname']) ? trim($info['dirname']) : dr_json(0, L('site_dirname').L('empty'), array('field' => 'dirname'));
			$info['domain'] = isset($info['domain']) && trim($info['domain']) ? trim($info['domain']) : dr_json(0, L('site_domain').L('empty'), array('field' => 'domain'));
			$info['ishtml'] = isset($info['ishtml']) && trim($info['ishtml']) ? trim($info['ishtml']) : 0;
			$info['mobileauto'] = isset($info['mobileauto']) && trim($info['mobileauto']) ? trim($info['mobileauto']) : 0;
			$info['mobilehtml'] = isset($info['mobilehtml']) && trim($info['mobilehtml']) ? trim($info['mobilehtml']) : 0;
			$info['not_pad'] = isset($info['not_pad']) && trim($info['not_pad']) ? trim($info['not_pad']) : 0;
			$template = isset($template) && !empty($template) ? $template : dr_json(0, L('please_select_a_style'), array('field' => 'template'));
			$info['default_style'] = isset($info['default_style']) && !empty($info['default_style']) ? $info['default_style'] : dr_json(0, L('please_choose_the_default_style'), array('field' => 'default_style'));
			if ($this->db->get_one(array('name'=>$info['name']), 'siteid')) {
				dr_json(0, L('site_name').L('exists'), array('field' => 'name'));
			}
			if (is_dir(CMS_PATH.$info['dirname'])) {
				dr_json(0, L('目录['.$info['dirname'].']已经存在'), array('field' => 'dirname'));
			}
			if (!preg_match('/^\\w+$/i', $info['dirname'])) {
				dr_json(0, L('site_dirname').L('site_dirname_err_msg'), array('field' => 'dirname'));
			}
			if ($this->db->get_one(array('dirname'=>$info['dirname']), 'siteid')) {
				dr_json(0, L('site_dirname').L('exists'), array('field' => 'dirname'));
			}
			if (!empty($info['domain']) && !preg_match('/http(s?):\/\/(.+)\/$/i', $info['domain'])) {
				dr_json(0, L('site_domain').L('site_domain_ex2'), array('field' => 'domain'));
			}
			if (!empty($info['domain']) && $this->db->get_one(array('domain'=>$info['domain']), 'siteid')) {
				dr_json(0, L('site_domain').L('exists'), array('field' => 'domain'));
			}
			if (!$info['mobilemode']) {
				$info['mobile_domain'] = $info['domain'].'mobile/';
			} else {
				if (!empty($info['mobile_domain']) && !preg_match('/http(s?):\/\/(.+)\/$/i', $info['mobile_domain'])) {
					dr_json(0, L('site_domain').L('site_domain_ex2'), array('field' => 'mobile_domain'));
				}
				if (!empty($info['mobile_domain']) && $this->db->get_one(array('mobile_domain'=>$info['mobile_domain']), 'siteid')) {
					dr_json(0, L('site_domain').L('exists'), array('field' => 'mobile_domain'));
				}
				if ($info['mobile_domain']==$info['domain']) {
					dr_json(0, L('site_domain').L('exists'), array('field' => 'mobile_domain'));
				}
			}
			if (!empty($info['release_point']) && is_array($info['release_point'])) {
				if (dr_count($info['release_point']) > 4) {
					dr_json(0, L('release_point_configuration').L('most_choose_four'), array('field' => 'release_point'));
				}
				$s = '';
				foreach ($info['release_point'] as $key=>$val) {
					if($val) $s.= $s ? ",$val" : $val;
				}
				$info['release_point'] = $s;
				unset($s);
			} else {
				$info['release_point'] = '';
			}
			if (!empty($template) && is_array($template)) {
				$info['template'] = implode(',', $template);
			} else {
				$info['template'] = '';
			}
			$info['setting'] = array2string($setting);
			require_once CACHE_MODEL_PATH.'content_input.class.php';
			require_once CACHE_MODEL_PATH.'content_update.class.php';
			$content_input = new content_input(0);
			$inputinfo = $content_input->get($info);
			$systeminfo = $inputinfo['system'];
			$siteid = $this->db->insert($info, true);
			$class_site = pc_base::load_app_class('sites');
			$class_site->set_cache();
			$this->db->update($systeminfo,array('siteid'=>$siteid));
			//建立目录
			dir_create(CMS_PATH.$info['dirname']);
			//创建入口文件
			foreach (array(
						 //'admin.php',
						 'index.php',
						 'mobile/api.php',
						 'mobile/index.php',
					) as $file) {
				if (is_file(TEMPPATH.'web/'.$file)) {
					if ($file == 'admin.php') {
						$dst = CMS_PATH.$info['dirname'].'/'.(SELF == 'index.php' ? 'admin.php' : SELF);
					} else {
						$dst = CMS_PATH.$info['dirname'].'/'.$file;
					}
					$fix_web_dir = isset($info['dirname']) && $info['dirname'] ? $info['dirname'] : '';
                    if (strpos($file, 'mobile/') !== false) {
                        $fix_web_dir .= '/mobile';
                    }
					dir_create(dirname($dst));
					$size = file_put_contents($dst, str_replace(array(
						'{CMS_PATH}',
						'{SITE_ID}',
						'{FIX_WEB_DIR}'
					), array(
						CMS_PATH,
						$siteid,
						$fix_web_dir
					), file_get_contents(TEMPPATH.'web/'.$file)));
					if (!$size) {
						dr_json(0, L('文件['.$dst.']无法写入'));
					}
				}
			}
			dr_json(1, L('operation_success'));
		} else {
			$show_dialog = $show_validator = $show_scroll = $show_header = true;
			$locate = $this->locate;
			$waterfont = $this->waterfont;
			$waterfile = $this->waterfile;
			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form(0);
			$forminfos = $content_form->get();
 			$formValidator = $content_form->formValidator;
 			$checkall = $content_form->checkall;
			$release_point_db = pc_base::load_model('release_point_model');
			$release_point_list = $release_point_db->select('', 'id, name');
			$template_list = template_list();
			include $this->admin_tpl('site_add');
		}
	}
	
	public function del() {
		$siteid = $this->input->get('siteid') && intval($this->input->get('siteid')) ? intval($this->input->get('siteid')) : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		if($siteid==1) dr_admin_msg(0,L('operation_failure'), HTTP_REFERER);
		$sitelist = getcache('sitelist','commons');
		if ($sitelist[$siteid]['dirname']) {
			dir_delete(CMS_PATH.$sitelist[$siteid]['dirname']);
		}
		if ($this->db->get_one(array('siteid'=>$siteid))) {
			if ($this->db->delete(array('siteid'=>$siteid))) {
				$model_db = pc_base::load_model('sitemodel_model');
				$model_data = $model_db->select(array('siteid'=>$siteid));
				$category_db = pc_base::load_model('category_model');
				$category_db->delete(array('siteid'=>$siteid));
				$type_db = pc_base::load_model('type_model');
				$type_db->delete(array('siteid'=>$siteid));
				foreach ($model_data as $r) {
					$category_db->delete(array('siteid'=>$siteid,'modelid'=>$r['modelid']));
					$type_db->delete(array('siteid'=>$siteid,'modelid'=>$r['modelid']));
					if ($r['tablename']) {
						$tablename = $this->db->db_tablepre.$r['tablename'];
						$tablename_data = $this->db->db_tablepre.$r['tablename'].'_data';
						$this->db->query('DROP TABLE IF EXISTS `'.$tablename.'`;');
						$this->db->query('DROP TABLE IF EXISTS `'.$tablename_data.'`;');
					}
				}
				$model_db->delete(array('siteid'=>$siteid));
				$model_field_db = pc_base::load_model('sitemodel_field_model');
				$model_field_db->delete(array('siteid'=>$siteid));
				$keyword_db = pc_base::load_model('keyword_model');
				$keyword_data_db = pc_base::load_model('keyword_data_model');
				$keyword_db->delete(array('siteid'=>$siteid));
				$keyword_data_db->delete(array('siteid'=>$siteid));
				$class_site = pc_base::load_app_class('sites');
				$class_site->set_cache();
				$cache_api = pc_base::load_app_class('cache_api', 'admin');
				$cache_api->cache('category');
				dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
			} else {
				dr_admin_msg(0,L('operation_failure'), HTTP_REFERER);
			}
		} else {
			dr_admin_msg(0,L('notfound'), HTTP_REFERER);
		}
	}
	
	public function edit() {
		$siteid = $this->input->get('siteid') && intval($this->input->get('siteid')) ? intval($this->input->get('siteid')) : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		$sitelist = getcache('sitelist','commons');
		if ($data = $this->db->get_one(array('siteid'=>$siteid))) {
			if ($this->input->post('dosubmit')) {
				$info = $this->input->post('info');
				$template = $this->input->post('template');
				$setting = $this->input->post('setting');
				$info['name'] = isset($info['name']) && trim($info['name']) ? trim($info['name']) : dr_json(0, L('site_name').L('empty'), array('field' => 'name'));
				if ($siteid != 1) $info['dirname'] = isset($info['dirname']) && trim($info['dirname']) ? trim($info['dirname']) : dr_json(0, L('site_dirname').L('empty'), array('field' => 'dirname'));
				$info['domain'] = isset($info['domain']) && trim($info['domain']) ? trim($info['domain']) : dr_json(0, L('site_domain').L('empty'), array('field' => 'domain'));
				$info['ishtml'] = isset($info['ishtml']) && trim($info['ishtml']) ? trim($info['ishtml']) : 0;
				$info['mobileauto'] = isset($info['mobileauto']) && trim($info['mobileauto']) ? trim($info['mobileauto']) : 0;
				$info['mobilehtml'] = isset($info['mobilehtml']) && trim($info['mobilehtml']) ? trim($info['mobilehtml']) : 0;
				$info['not_pad'] = isset($info['not_pad']) && trim($info['not_pad']) ? trim($info['not_pad']) : 0;
				$template = isset($template) && !empty($template) ? $template : dr_json(0, L('please_select_a_style'), array('field' => 'template'));
				$info['default_style'] = isset($info['default_style']) && !empty($info['default_style']) ? $info['default_style'] : dr_json(0, L('please_choose_the_default_style'), array('field' => 'default_style'));
				if ($data['name'] != $info['name'] && $this->db->get_one(array('name'=>$info['name']), 'siteid')) {
					dr_json(0, L('site_name').L('exists'), array('field' => 'name'));
				}
				if ($siteid != 1) {
					if (!preg_match('/^\\w+$/i', $info['dirname'])) {
						dr_json(0, L('site_dirname').L('site_dirname_err_msg'), array('field' => 'dirname'));
					}
					if ($data['dirname'] != $info['dirname'] && $this->db->get_one(array('dirname'=>$info['dirname']), 'siteid')) {
						dr_json(0, L('site_dirname').L('exists'), array('field' => 'dirname'));
					}
				}
				if ($sitelist[$siteid]['dirname']!=$info['dirname']) {
					$state = rename(CMS_PATH.$sitelist[$siteid]['dirname'], CMS_PATH.$info['dirname']);
					if (!$state) {
						dr_json(0, L('重命名目录['.$sitelist[$siteid]['dirname'].']失败！'), array('field' => 'dirname'));
					}
				}
				
				if (!empty($info['domain']) && !preg_match('/http(s?):\/\/(.+)\/$/i', $info['domain'])) {
					dr_json(0, L('site_domain').L('site_domain_ex2'), array('field' => 'domain'));
				}
				if (!empty($info['domain']) && $data['domain'] != $info['domain'] && $this->db->get_one(array('domain'=>$info['domain']), 'siteid')) {
					dr_json(0, L('site_domain').L('exists'), array('field' => 'domain'));
				}
				if (!$info['mobilemode']) {
					$info['mobile_domain'] = $info['domain'].'mobile/';
				} else {
					if (!empty($info['mobile_domain']) && !preg_match('/http(s?):\/\/(.+)\/$/i', $info['mobile_domain'])) {
						dr_json(0, L('site_domain').L('site_domain_ex2'), array('field' => 'mobile_domain'));
					}
					if (!empty($info['mobile_domain']) && $data['mobile_domain'] != $info['mobile_domain'] && $this->db->get_one(array('mobile_domain'=>$info['mobile_domain']), 'siteid')) {
						dr_json(0, L('site_domain').L('exists'), array('field' => 'mobile_domain'));
					}
					if ($info['mobile_domain']==$info['domain']) {
						dr_json(0, L('site_domain').L('exists'), array('field' => 'mobile_domain'));
					}
				}
				if (!empty($info['release_point']) && is_array($info['release_point'])) {
					if (dr_count($info['release_point']) > 4) {
						dr_json(0, L('release_point_configuration').L('most_choose_four'), array('field' => 'release_point'));
					}
					$s = '';
					foreach ($info['release_point'] as $key=>$val) {
						if($val) $s.= $s ? ",$val" : $val;
					}
					$info['release_point'] = $s;
					unset($s);
				} else {
					$info['release_point'] = '';
				}
				if (!empty($template) && is_array($template)) {
					$info['template'] = implode(',', $template);
				} else {
					$info['template'] = '';
				}
				$info['setting'] = array2string($setting);
				require_once CACHE_MODEL_PATH.'content_input.class.php';
				require_once CACHE_MODEL_PATH.'content_update.class.php';
				$content_input = new content_input(0);
				$inputinfo = $content_input->get($info);
				$systeminfo = $inputinfo['system'];
				if ($siteid == 1) unset($info['dirname']);
				if ($this->db->update($info, array('siteid'=>$siteid))) {
					if($siteid==1) {
						if (!empty($info['mobile_domain'])) {
							$setconfig['mobile_js_path'] = $info['mobile_domain'].'statics/js/';
							$setconfig['mobile_css_path'] = $info['mobile_domain'].'statics/css/';
							$setconfig['mobile_img_path'] = $info['mobile_domain'].'statics/images/';
							$setconfig['mobile_path'] = $info['mobile_domain'];
							set_config($setconfig);
						}
					}
					$class_site = pc_base::load_app_class('sites');
					$class_site->set_cache();
					$this->db->update($systeminfo,array('siteid'=>$siteid));
					dr_json(1, L('operation_success'));
				} else {
					dr_json(0, L('operation_failure'));
				}
			} else {
				$show_dialog = $show_validator = $show_header = $show_scroll = true;
				$locate = $this->locate;
				$waterfont = $this->waterfont;
				$waterfile = $this->waterfile;
				$data = $this->db->get_one(array('siteid'=>$siteid));
				require CACHE_MODEL_PATH.'content_form.class.php';
				$content_form = new content_form(0);
				$forminfos = $content_form->get($data);
				$formValidator = $content_form->formValidator;
				$checkall = $content_form->checkall;
				$template_list = template_list();
				$setting = string2array($data['setting']);
				$release_point_db = pc_base::load_model('release_point_model');
				$release_point_list = $release_point_db->select('', 'id, name');
				include $this->admin_tpl('site_edit');
			}
		} else {
			dr_admin_msg(0,L('notfound'), HTTP_REFERER);
		}
	}
	
	/**
	 * 水印图片预览
	 */
	public function public_preview() {
		$data = $this->input->get('setting');
		$data['source_image'] = CACHE_PATH.'preview.png';
		$data['dynamic_output'] = true;
		
		pc_base::load_sys_class('image');
		$image = new image();
		$rt = $image->watermark($data, 1);
		if (!$rt) {
			echo $image->display_errors();
		}
		exit;
	}

	// 上传字体文件或图片
	public function public_upload_index() {
		pc_base::load_sys_class('upload','',0);
		$upload = new upload();
		$at = dr_safe_filename($this->input->get('at'));
		if ($at == 'font') {
			$rt = $upload->upload_file(array(
				'save_name' => 'null',
				'save_path' => CMS_PATH.'statics/images/water/font/',
				'form_name' => 'file_data',
				'file_exts' => array('ttf'),
				'file_size' => 20 * 1024 * 1024,
				'attachment' => array(
					'value' => array(
						'path' => 'null'
					)
				),
			));
		} else {
			$rt = $upload->upload_file(array(
				'save_name' => 'null',
				'save_path' => CMS_PATH.'statics/images/water/',
				'form_name' => 'file_data',
				'file_exts' => array('png'),
				'file_size' => 3 * 1024 * 1024,
				'attachment' => array(
					'value' => array(
						'path' => 'null'
					)
				),
			));
		}
        if (!$rt['code']) {
            exit(dr_array2string($rt));
        }
		dr_json(1, L('上传成功'));
	}

	/**
	 * 测试电脑新域名是否可用
	 */
	public function public_test_site_domain() {

		$v = $this->input->get('v');
		if (!$v) {
			dr_json(0, L('域名不能为空'));
		} elseif (!$this->public_check_domain($v)) {
			dr_json(0, L('域名（'.$v.'）格式不正确'));
		} elseif (!function_exists('stream_context_create')) {
			dr_json(0, '函数没有被启用：stream_context_create');
		}

		$url = $v . 'mobile/api.php';
		/*if (strpos($v, ':') !== false) {
			dr_json(0, '可以尝试手动访问：' . $url . '，如果提示cms ok就表示成功');
		}*/

		$code = dr_catcher_data($url, 5);
		if ($code != 'cms ok') {
			dr_json(0, '['.$v.']域名绑定异常，无法访问：' . $url . '，可以尝试手动访问此地址，如果提示cms ok就表示成功');
		}

		dr_json(1, L('绑定正常'));
	}

	/**
	 * 测试手机域名是否可用
	 */
	public function public_test_mobile_domain() {

		$v = $this->input->get('v');
		$siteid = $this->input->get('siteid');
		if (!$v) {
			dr_json(0, L('域名不能为空'));
		} elseif (!$this->public_check_domain($v)) {
			dr_json(0, L('域名（'.$v.'）格式不正确'));
		} elseif (!function_exists('stream_context_create')) {
			dr_json(0, '函数没有被启用：stream_context_create');
		} elseif (siteurl($siteid) == $v) {
			dr_json(0, L('手机域名不能与电脑相同'));
		}

		$url = $v . 'api.php';
		/*if (strpos($v, ':') !== false) {
			dr_json(0, '可以尝试手动访问：' . $url . '，如果提示cms ok就表示成功');
		}*/

		$code = dr_catcher_data($url, 5);
		if ($code != 'cms ok') {
			dr_json(0, '['.$v.']域名绑定异常，无法访问：' . $url . '，可以尝试手动访问此地址，如果提示cms ok就表示成功');
		}

		dr_json(1, L('绑定正常'));
	}

	// 验证域名
	public function public_check_domain($value) {
		if (!$value) {
			return false;
		}
		foreach (array('?', '&', '\\', '*', ' ', '..') as $p) {
			if (strpos($value, $p) !== false) {
				return false;
			}
		}
		return true;
	}

	public function public_name() {
		$name = $this->input->get('name') && trim($this->input->get('name')) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($this->input->get('name'))) : trim($this->input->get('name'))) : exit('0');
		$siteid = $this->input->get('siteid') && intval($this->input->get('siteid')) ? intval($this->input->get('siteid')) : '';
 		$data = array();
		if ($siteid) {
			
			$data = $this->db->get_one(array('siteid'=>$siteid), 'name');
			if (!empty($data) && $data['name'] == $name) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$name), 'siteid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	public function public_dirname() {
		$dirname = $this->input->get('dirname') && trim($this->input->get('dirname')) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($this->input->get('dirname'))) : trim($this->input->get('dirname'))) : exit('0');
		$siteid = $this->input->get('siteid') && intval($this->input->get('siteid')) ? intval($this->input->get('siteid')) : '';
		$data = array();
		if ($siteid) {
			$data = $this->db->get_one(array('siteid'=>$siteid), 'dirname');
			if (!empty($data) && $data['dirname'] == $dirname) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('dirname'=>$dirname), 'siteid')) {
			exit('0');
		} else {
			exit('1');
		}
	}

	private function check_gd() {
		if(!function_exists('imagepng') && !function_exists('imagejpeg') && !function_exists('imagegif')) {
			$gd = L('gd_unsupport');
		} else {
			$gd = L('gd_support');
		}
		return $gd;
	}
}