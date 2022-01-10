<?php 
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class manage extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		pc_base::load_app_func('global');
		$this->input = pc_base::load_sys_class('input');
		$this->imgext = array('jpg','gif','png','bmp','jpeg');
		$this->db = pc_base::load_model('attachment_model');
		$this->remote_db = pc_base::load_model('attachment_remote_model');
		$this->upload = pc_base::load_sys_class('upload');
		$this->admin_username = param::get_cookie('admin_username');
		$this->siteid = $this->get_siteid();
	}	
	/**
	 * 附件列表
	 */
	public function init() {
		pc_base::load_sys_class('form');
		$modules = getcache('modules','commons');
		$category = getcache('category_content_'.$this->siteid,'commons');
		$remote = $this->remote_db->select();
		if (IS_POST) {
			$pagesize = $this->input->post('limit') ? $this->input->post('limit') : SYS_ADMIN_PAGESIZE;
			$page = $this->input->post('page') ? $this->input->post('page') : '1';
			$where = '';
			if($this->input->post('remote')) $where .= "AND `remote` = '".$this->input->post('remote')."' ";
			if($this->input->post('keyword')) $where .= "AND `filename` LIKE '%".$this->db->escape($this->input->post('keyword'))."%' ";
			if($this->input->post('start_uploadtime')) {
				$where .= 'AND uploadtime BETWEEN ' . max((int)strtotime(strpos($this->input->post('start_uploadtime'), ' ') ? $this->input->post('start_uploadtime') : $this->input->post('start_uploadtime').' 00:00:00'), 1) . ' AND ' . ($this->input->post('end_uploadtime') ? (int)strtotime(strpos($this->input->post('end_uploadtime'), ' ') ? $this->input->post('end_uploadtime') : $this->input->post('end_uploadtime').' 23:59:59') : SYS_TIME).' ';
			}
			if($this->input->post('fileext')) $where .= "AND `fileext`='".$this->db->escape($this->input->post('fileext'))."' ";
			$status =  trim($this->input->get('status'));
			if($status!='' && ($status==1 ||$status==0)) $where .= "AND `status`='$status' ";
			$module =  trim($this->input->get('module'));
			if(isset($module) && $module!='') $where .= "AND `module`='$module' ";		
			$where .="AND `siteid`='".$this->siteid."'";
			if($where) $where = substr($where, 3);
			$datas = $this->db->listinfo($where, 'uploadtime DESC', $page, $pagesize);
			$total = $this->db->count($where);
			$pages = $this->db->pages;
			if(!empty($datas)) {
				foreach($datas as $r) {
					$thumb = glob(dirname(SYS_UPLOAD_PATH.$r['filepath']).'/thumb_*'.basename($r['filepath']));
					$rs['aid'] = $r['aid'];
					$rs['type'] = '<label>'.(!$r['remote'] ? '<span class="label label-sm label-danger">'.L('默认').'</span>' : '<span class="label label-sm label-warning">'.L('自定义').'</span>').'</label>';
					$rs['module'] = $modules[$r['module']]['name'];
					if ($r['module']=='member' && $r['catid']==0) {
						$rs['catname'] = '头像';
						$rs['filepath'] = SYS_ATTACHMENT_SAVE_ID ? dr_get_file_url($r) : dr_file(SYS_AVATAR_URL.$r['filepath']);
					} else if ($r['module']=='cloud' && $r['catid']==0) {
						$rs['catname'] = '云服务';
						$rs['filepath'] = dr_get_file_url($r);
					} else {
						$rs['catname'] = $category[$r['catid']]['catname'];
						$rs['filepath'] = dr_get_file_url($r);
					}
					$rs['filename'] = $r['filename'];
					$rs['fileext'] = $r['fileext'].'<img src="'.file_icon('.'.$r['fileext'],'gif').'" />'.($thumb ? '<img title="'.L('att_thumb_manage').'" src="'.IMG_PATH.'admin_img/havthumb.png" onclick="showthumb('.$r['aid'].', \''.$r['filename'].'\')"/>':'').($r['status'] ? ' <img src="'.IMG_PATH.'admin_img/link.png"':'');
					$rs['related'] = $r['related'];
					$rs['status'] = $r['status'];
					$rs['filesize'] = format_file_size($r['filesize']);
					$rs['uploadtime'] = dr_date($r['uploadtime'],null,'red');
					$array[] = $rs;
				}
			}
			exit(json_encode(array('code'=>0,'msg'=>L('to_success'),'count'=>$total,'data'=>$array,'rel'=>1)));
		}
		include $this->admin_tpl('attachment_list');
	}
	
	/**
	 * 目录浏览模式添加图片
	 */
	public function dir() {
		if(!$this->admin_username) return false;
		$dir = $this->input->get('dir') && trim($this->input->get('dir')) ? str_replace(array('..\\', '../', './', '.\\'), '', trim($this->input->get('dir'))) : '';
		$filepath = SYS_UPLOAD_PATH.$dir;
		$list = glob($filepath.'/'.'*');
		if(!empty($list)) rsort($list);
		$local = str_replace(array(PC_PATH, CMS_PATH ,DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('','',DIRECTORY_SEPARATOR), $filepath);
		include $this->admin_tpl('attachment_dir');
	}
	
	/**
	 * 更新
	 */
	public function update() {
		if($this->input->post('dosubmit')) {
			$this->db->update(array($this->input->post('field')=>$this->input->post('value')),array('aid'=>$this->input->post('aid')));
			dr_json(1, L('operation_success'));
		} else {
			dr_json(0, L('operation_failure'));
		}
	}
	
	public function pulic_dirmode_del() {
		$filename = urldecode($this->input->get('filename'));
		$tmpdir = $dir = urldecode($this->input->get('dir'));
		$tmpdir = str_replace('\\','/',$tmpdir);
		$tmpdirs = explode('/',$tmpdir);
		$tmpdir = CMS_PATH.$tmpdirs[0].'/';
		if($tmpdir!=SYS_UPLOAD_PATH) {
			dr_admin_msg(0,L('illegal_operation'));
		}
		$file = CMS_PATH.$dir.DIRECTORY_SEPARATOR.$filename;
		$file = str_replace(array('/','\\'), DIRECTORY_SEPARATOR, $file);
		$file = str_replace('..', '', $file);
		if(@unlink($file)) {
			dr_json(1, L('operation_success'));
		} else {
			dr_json(0, L('operation_failure'));
		}
	}
	
	/**
	 * 删除附件
	 */
	public function delete() {
		$aid = $this->input->post('aid');
		$data = $this->db->get_one(array('aid'=>$aid));
		if (!$data) {
			dr_json(0, L('所选附件不存在'));
		}
		$rt = $this->upload->_delete_file($data);
		if (!$rt['code']) {
			return dr_return_data(0, $rt['msg']);
		}
		dr_json(1, L('delete').L('success'));
	}
	
	/**
	 * 批量删除附件
	 */
	public function public_delete_all() {
		$del_arr = $this->input->get_post_ids() ? $this->input->get_post_ids() : dr_json(0, L('illegal_parameters'));
		$data = $this->db->select('aid in ('.implode(',', $del_arr).')');
		if (!$data) {
			dr_json(0, L('所选附件不存在'));
		}
		foreach($data as $t){
			$rt = $this->upload->_delete_file($t);
			if (!$rt['code']) {
				return dr_return_data(0, $rt['msg']);
			}
		}
		dr_json(1, L('delete').L('success'));
	}
	
	public function pullic_showthumbs() {
		$aid = intval($this->input->get('aid'));
		$info = $this->db->get_one(array('aid'=>$aid));
		if($info) {
			$infos = glob(dirname(SYS_UPLOAD_PATH.$info['filepath']).'/thumb_*'.basename($info['filepath']));
			foreach ($infos as $n=>$thumb) {
				$thumbs[$n]['thumb_url'] = str_replace(SYS_UPLOAD_PATH, SYS_UPLOAD_URL, $thumb);
				$thumbinfo = explode('_', basename($thumb));
				$thumbs[$n]['thumb_filepath'] = $thumb;
				$thumbs[$n]['width'] = $thumbinfo[1];
				$thumbs[$n]['height'] = $thumbinfo[2];
			}
		}
		$show_header = true; 
		include $this->admin_tpl('attachment_thumb');
	}
	
	public function pullic_delthumbs() {
		$filepath = urldecode($this->input->get('filepath'));
		$ext = fileext($filepath);
		if(!in_array(strtoupper($ext),array('JPG','GIF','BMP','PNG','JPEG')))  exit('0');
		$reslut = @unlink($filepath);
		if($reslut) exit('1');
		 exit('0');
	}
}
?>