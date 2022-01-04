<?php 
defined('IN_CMS') or exit('No permission resources.');
$session_storage = 'session_'.pc_base::load_config('system','session_storage');
pc_base::load_sys_class($session_storage);
if(param::get_cookie('sys_lang')) {
	define('SYS_STYLE',param::get_cookie('sys_lang'));
} else {
	define('SYS_STYLE','zh-cn');
}
class attachments {
	private $att_db;
	function __construct() {
		$this->input = pc_base::load_sys_class('input');
		$this->cache = pc_base::load_sys_class('cache');
		pc_base::load_app_func('global');
		$this->upload = pc_base::load_sys_class('upload');
		$this->imgext = array('jpg','gif','png','bmp','jpeg','webp');
		$this->userid = $_SESSION['userid'] ? $_SESSION['userid'] : (param::get_cookie('_userid') ? param::get_cookie('_userid') : param::get_cookie('userid'));
		$this->isadmin = $this->admin_username = $_SESSION['roleid'] ? 1 : 0;
		$this->groupid = param::get_cookie('_groupid') ? param::get_cookie('_groupid') : 8;
		//判断是否登录
		if(empty($this->userid)){
			showmessage(L('please_login','','member'));
		}
	}
	
	/**
	 * 常规上传
	 */
	public function upload() {
		$grouplist = getcache('grouplist','member');
		if($this->isadmin==0 && !$grouplist[$this->groupid]['allowattachment']) return false;
		$args = $this->input->get('args');
		$p = dr_string2array(dr_authcode($args, 'DECODE'));
		if (!$p) {
			showmessage(L('attachment_parameter_error'));
		}
		$file_size_limit = intval($p['size']) ? floatval(intval($p['size'])) : $file_size_limit;
		$authkey = $this->input->get('authkey');
		foreach($p as $k=>$v) {
			$arraykey[$k] = $v;
		}
		$argskey = str_replace('"', '', dr_array2string(implode(',', $arraykey)));
		if(upload_key($argskey) != $authkey) showmessage(L('attachment_parameter_error'));
		extract(geth5init($args));
		pc_base::load_sys_class('upload','',0);
		$module = trim($this->input->get('module'));
		$catid = intval($this->input->get('catid'));
		$watermark = $site_setting['ueditor'] ? 1 : intval($watermark_enable);
		$upload = new upload($module,$catid,$siteid);
		$upload->set_userid($this->userid);
		$rt = $upload->upload_file(array(
			'path' => '',
			'form_name' => 'upload',
			'file_exts' => explode('|', strtolower($file_types_post)),
			'file_size' => $file_size_limit * 1024 * 1024,
			'watermark' => $watermark,
			'attachment' => $upload->get_attach_info(intval($attachment), intval($image_reduce)),
		));
		if (!$rt['code']) {
			$result = array("uploaded"=>false,"error"=>array("message"=>$rt['msg']));
			exit(dr_array2string($result));
			//exit(dr_array2string($rt));
		}
		$data = array();
		if (defined('SYS_ATTACHMENT_CF') && SYS_ATTACHMENT_CF && $rt['data']['md5']) {
			$att_db = pc_base::load_model('attachment_model');
			$att = $att_db->get_one(array('userid'=>intval($this->userid),'filemd5'=>$rt['data']['md5'],'fileext'=>$rt['data']['ext'],'filesize'=>$rt['data']['size']));
			if ($att) {
				$data = dr_return_data($att['aid'], 'ok');
				// 删除现有附件
				// 开始删除文件
				$storage = new storage($module,$catid,$siteid);
				$storage->delete($upload->get_attach_info((int)$p['attachment']), $rt['data']['file']);
				$rt['data'] = get_attachment($att['aid']);
			}
		}
		
		// 附件归档
		if (!$data) {
			$data = $upload->save_data($rt['data']);
			if (!$data['code']) {
				$result = array("uploaded"=>false,"error"=>array("message"=>$data['msg']));
				exit(dr_array2string($result));
			}
		}
		
		if($rt && $data){
			$fn = intval($this->input->get('CKEditorFuncNum'));
			$rt['data']['filename'] && $rt['data']['name'] = $rt['data']['filename'];
			$rt['data']['size'] = $rt['data']['size'] ? format_file_size($rt['data']['size']) : format_file_size($rt['data']['filesize']);
			$this->upload_json($data['code'],$rt['data']['url'],$rt['data']['name'],$rt['data']['size']);
			$result = array("uploaded"=>true,
				"fileName"=>$rt['data']['name'],
				"url"=>$rt['data']['url'],
				"error"=>array(
					"message"=>""
				)
			);
		}else{
			$result = array('uploaded'=>false,'error'=>array('message'=>L('上传错误')));
		}
		exit(dr_array2string($result));
	}
	/**
	 * h5upload上传附件
	 */
	public function h5upload(){
		$grouplist = getcache('grouplist','member');
		if($this->input->post('dosubmit')){
			if($this->input->post('h5_auth_key') != md5(SYS_KEY.$this->input->post('H5UPLOADSESSID')) || ($this->input->post('isadmin')==0 && !$grouplist[$this->input->post('groupid')]['allowattachment'])) exit();
			pc_base::load_sys_class('upload','',0);
			$args = $this->input->post('args');
			$p = dr_string2array(dr_authcode($args, 'DECODE'));
			if (!$p) {
				dr_json(0, L('attachment_parameter_error'));
			}
			define('SITEID', $this->input->post('siteid'));
			$upload = new upload($this->input->post('module'),$this->input->post('catid'),$this->input->post('siteid'));
			$upload->set_userid($this->input->post('userid'));
			$site_setting = get_site_setting($this->input->post('siteid'));
			$site_allowext = $site_setting['upload_allowext'];
			$upload_maxsize = intval($p['size']) ? floatval(intval($p['size'])) : $site_setting['upload_maxsize'];
			if ($this->input->post('filetype_post')) {
				$filetype_post = $this->input->post('filetype_post');
			} else {
				$filetype_post = $site_allowext;
			}
			$rt = $upload->upload_file(array(
				'path' => '',
				'form_name' => 'file_upload',
				'file_exts' => explode('|', strtolower($filetype_post)),
				'file_size' => $upload_maxsize * 1024 * 1024,
				'watermark' => intval($this->input->post('watermark_enable')),
				'attachment' => $upload->get_attach_info(intval($this->input->post('attachment')), (int)$this->input->post('image_reduce')),
			));
			if (!$rt['code']) {
				exit(dr_array2string($rt));
			}
			$data = array();
			if (defined('SYS_ATTACHMENT_CF') && SYS_ATTACHMENT_CF && $rt['data']['md5']) {
				$att_db = pc_base::load_model('attachment_model');
				$att = $att_db->get_one(array('userid'=>intval($this->input->post('userid')),'filemd5'=>$rt['data']['md5'],'fileext'=>$rt['data']['ext'],'filesize'=>$rt['data']['size']));
				if ($att) {
					$data = dr_return_data($att['aid'], 'ok');
					// 删除现有附件
					// 开始删除文件
					$storage = new storage($this->input->post('module'),$this->input->post('catid'),$this->input->post('siteid'));
					$storage->delete($upload->get_attach_info((int)$p['attachment']), $rt['data']['file']);
					$rt['data'] = get_attachment($att['aid']);
				}
			}

			// 附件归档
			if (!$data) {
				$data = $upload->save_data($rt['data']);
				if (!$data['code']) {
					exit(dr_array2string($data));
				}
			}
			
			// 缩略图
			if (dr_is_image($rt['data']['url']) && ($this->input->post('thumb_width') > 0 || $this->input->post('thumb_height') > 0)) {
				thumb($rt['data']['url'], $this->input->post('thumb_width'), $this->input->post('thumb_height') ,$this->input->post('watermark_enable'));
			}
			
			if($rt && $data) {
				if($upload->uploadedfiles[0]['isimage'] || $rt['data']['isimage']) {
					$rt['data']['ext'] = 1;
				}
				$rt['data']['id'] = $data['code'];
				$rt['data']['filename'] && $rt['data']['name'] = $rt['data']['filename'];
				$rt['data']['size'] = $rt['data']['size'] ? format_file_size($rt['data']['size']) : format_file_size($rt['data']['filesize']);
				dr_json(1, L('att_upload_succ'), $rt['data']);
			} else {
				dr_json(0, $rt['msg']);
			}
		} else {
			if($this->isadmin==0 && !$grouplist[$this->groupid]['allowattachment']) showmessage(L('att_no_permission'));
			$args = $this->input->get('args');
			$p = dr_string2array(dr_authcode($args, 'DECODE'));
			if (!$p) {
				showmessage(L('attachment_parameter_error'));
			}
			$authkey = $this->input->get('authkey');
			foreach($p as $k=>$v) {
				$arraykey[$k] = $v;
			}
			$argskey = str_replace('"', '', dr_array2string(implode(',', $arraykey)));
			if(upload_key($argskey) != $authkey) showmessage(L('attachment_parameter_error'));
			extract(geth5init($args));
			$att_not_used = $this->cache->get_data('att_json');
			if(empty($att_not_used) || !isset($att_not_used)) $tab_status = ' class="on"';
			if(!empty($att_not_used)) $div_status = ' hidden';
			include $this->admin_tpl('h5upload');
		}
	}
	/**
	 * 下载附件
	 */
	public function download(){
		$grouplist = getcache('grouplist','member');
		if($this->isadmin==0 && !$grouplist[$this->groupid]['allowattachment']) dr_json(0, L('att_no_permission'));
		if(empty($this->input->post('filename'))) dr_json(0, L('文件地址不能为空'));
		if (strpos($this->input->post('filename'), 'http') !== 0 ) {
			dr_json(0, L('下载文件地址必须是https或者http开头'));
		} elseif (strpos($this->input->post('filename'), '?') !== false) {
			dr_json(0, L('下载文件地址中不能包含？号'));
		} elseif (strpos($this->input->post('filename'), '#') !== false) {
			dr_json(0, L('下载文件地址中不能包含#号'));
		}
		pc_base::load_sys_class('upload','',0);
		$args = $this->input->post('args');
		$p = dr_string2array(dr_authcode($args, 'DECODE'));
		if (!$p) {
			dr_json(0, L('参数传递错误'));
		}
		$authkey = $this->input->post('authkey');
		foreach($p as $k=>$v) {
			$arraykey[$k] = $v;
		}
		$argskey = str_replace('"', '', dr_array2string(implode(',', $arraykey)));
		if(upload_key($argskey) != $authkey) dr_json(0, L('参数传递错误'));
		extract(geth5init($args));
		$upload = new upload($this->input->post('module'),$this->input->post('catid'),$siteid);
		$upload->set_userid($this->userid);
		// 下载远程文件
		$rt = $upload->down_file(array(
			'url' => $this->input->post('filename'),
			'attachment' => $upload->get_attach_info(intval($attachment), intval($image_reduce)),
		));
		if (!$rt['code']) {
			exit(dr_array2string($rt));
		}
		$data = array();
		if (defined('SYS_ATTACHMENT_CF') && SYS_ATTACHMENT_CF && $rt['data']['md5']) {
			$att_db = pc_base::load_model('attachment_model');
			$att = $att_db->get_one(array('userid'=>intval($this->userid),'filemd5'=>$rt['data']['md5'],'fileext'=>$rt['data']['ext'],'filesize'=>$rt['data']['size']));
			if ($att) {
				$data = dr_return_data($att['aid'], 'ok');
				// 删除现有附件
				// 开始删除文件
				$storage = new storage($this->input->post('module'),$this->input->post('catid'),$siteid);
				$storage->delete($upload->get_attach_info((int)$p['attachment']), $rt['data']['file']);
				$rt['data'] = get_attachment($att['aid']);
			}
		}
		
		// 附件归档
		if (!$data) {
			$data = $upload->save_data($rt['data']);
			if (!$data['code']) {
				exit(dr_array2string($data));
			}
		}
		
		$rt['data']['filename'] && $rt['data']['name'] = $rt['data']['filename'];
		$rt['data']['size'] = $rt['data']['size'] ? format_file_size($rt['data']['size']) : format_file_size($rt['data']['filesize']);
		$this->upload_json($data['code'],$rt['data']['url'],$rt['data']['name'],$rt['data']['size']);
		exit(dr_array2string(array('code' => 1, 'msg' => L('上传成功'), 'id' => $data['code'], 'info' => $rt['data'])));
	}
	/**
	 * 获取临时未处理文件列表
	 */
	public function att_not(){
		$args = $this->input->get('args');
		$p = dr_string2array(dr_authcode($args, 'DECODE'));
		if (!$p) {
			showmessage(L('attachment_parameter_error'));
		}
		$authkey = $this->input->get('authkey');
		foreach($p as $k=>$v) {
			$arraykey[$k] = $v;
		}
		$argskey = str_replace('"', '', dr_array2string(implode(',', $arraykey)));
		if(upload_key($argskey) != $authkey) showmessage(L('attachment_parameter_error'));
		extract(geth5init($args));
		//获取临时未处理文件列表
		$att = $this->att_not_used();
		include $this->admin_tpl('att_not');
	}
	
	/**
	 * 加载图片库
	 */
	public function album_load() {
		if(!$this->admin_username) return false;
		$uploadtime= '';
		$this->att_db= pc_base::load_model('attachment_model');
		$args = $this->input->get('args');
		$p = dr_string2array(dr_authcode($args, 'DECODE'));
		if (!$p) {
			showmessage(L('attachment_parameter_error'));
		}
		$authkey = $this->input->get('authkey');
		foreach($p as $k=>$v) {
			$arraykey[$k] = $v;
		}
		$argskey = str_replace('"', '', dr_array2string(implode(',', $arraykey)));
		if(upload_key($argskey) != $authkey) showmessage(L('attachment_parameter_error'));
		extract(geth5init($args));
		$site_setting = get_site_setting($siteid);
		$upload_allowext = $site_setting['upload_allowext'];
		$site_allowext = ($file_types_post!='') ? $file_types_post : ($this->input->get('site_allowext') ? $this->input->get('site_allowext') : $upload_allowext);
		$array_test = explode('|',$site_allowext);
		$length = sizeof($array_test);
		$s_str = '';
		for($i=0;$i<$length;$i++){
			$s_str .= "'".$array_test[$i]."',";
		}
		$s_str = substr($s_str, 0, strlen($s_str) - 1);
		$where = "fileext in (".$s_str.") AND module<>'member' AND siteid=".$siteid." AND userid=".(int)$this->userid;
		if($this->input->get('dosubmit')){
			extract($this->input->get('info'));
			$filename = safe_replace($filename);
			if($filename) $where .= " AND `filename` LIKE '%$filename%' ";
			if($uploadtime) {
				$start_uploadtime = strtotime($uploadtime.' 00:00:00');
				$stop_uploadtime = strtotime($uploadtime.' 23:59:59');
				$where .= " AND `uploadtime` >= '$start_uploadtime' AND  `uploadtime` <= '$stop_uploadtime'";				
			}
		}
		pc_base::load_sys_class('form');
		$page = $this->input->get('page') ? $this->input->get('page') : '1';
		$infos = $this->att_db->listinfo($where, 'aid DESC', $page, 16);
		foreach($infos as $n=>$v){
			$ext = fileext($v['filepath']);
			if(in_array($ext,$this->imgext)) {
				$infos[$n]['src']=dr_get_file_url($v);
				$infos[$n]['width']='80';
			} else {
				$infos[$n]['src']=file_icon($v['filepath']);
				$infos[$n]['width']='64';
			}
		}
		$pages = $this->att_db->pages;
		include $this->admin_tpl('album_list');
	}
	
	/**
	 * 目录浏览模式添加图片
	 */
	public function album_dir() {
		if(!$this->admin_username) return false;
		$args = $this->input->get('args');
		$p = dr_string2array(dr_authcode($args, 'DECODE'));
		if (!$p) {
			showmessage(L('attachment_parameter_error'));
		}
		$authkey = $this->input->get('authkey');
		foreach($p as $k=>$v) {
			$arraykey[$k] = $v;
		}
		$argskey = str_replace('"', '', dr_array2string(implode(',', $arraykey)));
		if(upload_key($argskey) != $authkey) showmessage(L('attachment_parameter_error'));
		extract(geth5init($args));
		$dir = $this->input->get('dir') && trim($this->input->get('dir')) ? str_replace(array('..\\', '../', './', '.\\','..','.*'), '', trim($this->input->get('dir'))) : '';
		$filepath = SYS_UPLOAD_PATH.$dir;
		$list = glob($filepath.'/'.'*');
		if(!empty($list)) rsort($list);
		$local = str_replace(array(PC_PATH, CMS_PATH ,DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('','',DIRECTORY_SEPARATOR), $filepath);
		$url = ($dir == '.' || $dir=='') ? SYS_UPLOAD_URL : SYS_UPLOAD_URL.str_replace('.', '', $dir).'/';
		$show_header = true;
		include $this->admin_tpl('album_dir');
	}
	
	/**
	 * 设置upload上传的json格式cookie
	 */
	private function upload_json($aid,$src,$filename,$size) {
		if(!SYS_ATTACHMENT_STAT) return false;
		$arr['aid'] = intval($aid);
		$arr['src'] = trim($src);
		$arr['filename'] = urlencode($filename);
		$arr['size'] = $size;
		$json_str = json_encode($arr);
		$att_arr_exist = $this->cache->get_data('att_json');
		$att_arr_exist_tmp = explode('||', $att_arr_exist);
		if(is_array($att_arr_exist_tmp) && in_array($json_str, $att_arr_exist_tmp)) {
			return true;
		} else {
			$json_str = $att_arr_exist ? $att_arr_exist.'||'.$json_str : $json_str;
			$this->cache->set_data('att_json', $json_str, 3600);
			return true;			
		}
	}
	
	/**
	 * 设置h5upload上传的json格式cookie
	 */
	public function h5upload_json() {
		if(!SYS_ATTACHMENT_STAT) return false;
		$arr['aid'] = intval($this->input->get('aid'));
		$arr['src'] = safe_replace(trim($this->input->get('src')));
		$arr['filename'] = urlencode(safe_replace($this->input->get('filename')));
		$arr['size'] = $this->input->get('size');
		$json_str = json_encode($arr);
		$att_arr_exist = $this->cache->get_data('att_json');
		$att_arr_exist_tmp = explode('||', $att_arr_exist);
		if(is_array($att_arr_exist_tmp) && in_array($json_str, $att_arr_exist_tmp)) {
			return true;
		} else {
			$json_str = $att_arr_exist ? $att_arr_exist.'||'.$json_str : $json_str;
			$this->cache->set_data('att_json', $json_str, 3600);
			return true;			
		}
	}
	
	/**
	 * 删除h5upload上传的json格式cookie
	 */	
	public function h5upload_json_del() {
		$arr['aid'] = intval($this->input->get('aid'));
		$arr['src'] = trim($this->input->get('src'));
		$arr['filename'] = urlencode($this->input->get('filename'));
		$arr['size'] = $this->input->get('size');
		$json_str = json_encode($arr);
		$att_arr_exist = $this->cache->get_data('att_json');
		$att_arr_exist = str_replace(array($json_str,'||||'), array('','||'), $att_arr_exist);
		$att_arr_exist = preg_replace('/^\|\|||\|\|$/i', '', $att_arr_exist);
		$this->cache->set_data('att_json', $att_arr_exist, 3600);
	}	

	private function att_not_used() {
		$this->att_db= pc_base::load_model('attachment_model');
		//获取临时未处理文件列表
		if($att_json = $this->cache->get_data('att_json')) {
			if($att_json) $att_cookie_arr = explode('||', $att_json);	
			foreach ($att_cookie_arr as $_att_c) $att[] = json_decode($_att_c,true);
			if(is_array($att) && !empty($att)) {
				foreach ($att as $n=>$v) {
					$ext = fileext($v['src']);
					if(in_array($ext,$this->imgext)) {
						$att[$n]['fileimg']=$v['src'];
						$att[$n]['width']='80';
						$att[$n]['filename']=urldecode($v['filename']);
					} else {
						$att[$n]['fileimg']=file_icon($v['src']);
						$att[$n]['width']='64';
						$att[$n]['filename']=urldecode($v['filename']);
					}
					$this->cookie_att .= '|'.$v['src'];
				}
			}			
		}
		return $att;
	}
	
	/**
	 * 获取站点配置信息
	 * @param  $siteid 站点id
	 */
	private function _get_site_setting($siteid) {
		$siteinfo = getcache('sitelist', 'commons');
		return string2array($siteinfo[$siteid]['setting']);
	}
	
	final public static function admin_tpl($file, $m = '') {
		return admin_template($file, $m);
	}
	final public static function get_siteid() {
		return get_siteid();
	}	
}
?>