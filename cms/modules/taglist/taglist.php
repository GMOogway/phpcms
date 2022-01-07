<?php
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class taglist extends admin {
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('keyword_model');
		$this->data_db = pc_base::load_model('keyword_data_model');
	}
	
	public function init() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$datas = $this->db->listinfo(array('siteid'=>$this->get_siteid()),'id DESC',$page,SYS_ADMIN_PAGESIZE);
		$pages = $this->db->pages;
		//var_dump($info);	
		$big_menu = array('javascript:artdialog(\'add\',\'?m=taglist&c=taglist&a=add\',\'添加内容\',450,280);void(0);', '添加内容');
		include $this->admin_tpl('taglist'); 

	}
	
	public function add() {
 		if(isset($_POST['dosubmit'])) {
			$tag = $this->input->post('tag');
			if(empty($tag['keyword'])) {
				dr_admin_msg(0,L('关键字不能为空'),HTTP_REFERER);
			} else {
				$tag['keyword'] = safe_replace($tag['keyword']);
			}
			if((!$tag['pinyin']) || empty($tag['pinyin'])) {
				$pinyin = pc_base::load_sys_class('pinyin');
				$py = $pinyin->result($tag['keyword']);
				if (strlen($py) > 12) {
					$py = $pinyin->result($tag['keyword'], 0);
				}
				$tag['pinyin'] = $py;
			}
			$tag['siteid'] = $this->get_siteid();
			if($this->db->insert($tag,true)){
				dr_admin_msg(1,L('operation_success'),HTTP_REFERER,'', 'add');
			}else{		
			 return FALSE; 
			}

		}
       include $this->admin_tpl('add');
	}
	
	public function edit() {
		if(isset($_POST['dosubmit'])){
 			$id = intval($_GET['id']);
			echo $id;
			if($id < 1) return false;
			$tag = $this->input->post('tag');
			if(!is_array($tag) || empty($tag)) dr_admin_msg(0,L('参数错误'),HTTP_REFERER);
			if((!$tag['keyword']) || empty($tag['keyword'])) dr_admin_msg(0,L('关键字不能为空'),HTTP_REFERER);
			if((!$tag['pinyin']) || empty($tag['pinyin'])) {
				$pinyin = pc_base::load_sys_class('pinyin');
				$py = $pinyin->result($tag['keyword']);
				if (strlen($py) > 12) {
					$py = $pinyin->result($tag['keyword'], 0);
				}
				$tag['pinyin'] = $py;
			}
			$this->db->update($tag,array('id'=>$id));
			dr_admin_msg(1,L('operation_success'),'?m=taglist&c=taglist&a=edit','', 'edit');
		}else{
			$info = $this->db->get_one(array('id'=>$_GET['id']));
			if(!$info) dr_admin_msg(0,L('修改失败'));
			extract($info); 
			include $this->admin_tpl('edit');
		}
	}
	
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $id_arr) {
 					//批量删除
					$this->db->delete(array('id'=>$id_arr, 'siteid'=>$this->get_siteid()));
					$this->data_db->delete(array('tagid'=>$id_arr, 'siteid'=>$this->get_siteid()));
				}
				dr_admin_msg(1,L('operation_success'),'?m=taglist&c=taglist');
			}else{
				$id = intval($_GET['id']);
				if($id < 1) return false;
				//删除
				$result = $this->db->delete(array('id'=>$id, 'siteid'=>$this->get_siteid()));
				$result = $this->data_db->delete(array('tagid'=>$id, 'siteid'=>$this->get_siteid()));
				if($result){
					dr_admin_msg(1,L('operation_success'),'?m=taglist&c=taglist');
				}else {
					dr_admin_msg(0,L("operation_failure"),'?m=taglist&c=taglist');
				}
			}
			dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
		}
	}
}
?>