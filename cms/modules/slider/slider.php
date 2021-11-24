<?php
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class slider extends admin {
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('slider_model');
		$this->db2 = pc_base::load_model('type_model');
	}

	public function init() {
		$typeid = $this->input->get('typeid');
		if($typeid){
			$where = array('typeid'=>intval($typeid),'siteid'=>$this->get_siteid());
		}else{
			$where = array('siteid'=>$this->get_siteid());
		}
 		$page = $this->input->get('page') && intval($this->input->get('page')) ? intval($this->input->get('page')) : 1;
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,id DESC',$page, '10');
		$pages = $this->db->pages;
		$types = $this->db2->get_types($this->get_siteid());
		$types = new_html_special_chars($types);
 		$type_arr = array ();
 		foreach($types as $typeid=>$type){
			$type_arr[$type['typeid']] = $type['name'];
		}
		$big_menu = array('javascript:artdialog(\'add\',\'?m=slider&c=slider&a=add&typeid='.$typeid.'\',\''.L('slider_add').'\',700,450);void(0);', L('add_slider'));
		include $this->admin_tpl('slider_list');
	}

	/*
	 *判断标题重复和验证 
	 */
	public function public_name() {
		$slider_title = $this->input->get('slider_name') && trim($this->input->get('slider_name')) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($this->input->get('slider_name'))) : trim($this->input->get('slider_name'))) : exit('0');
			
		$id = $this->input->get('id') && intval($this->input->get('id')) ? intval($this->input->get('id')) : '';
		$data = array();
		if ($id) {
			$data = $this->db->get_one(array('id'=>$id), 'name');
			if (!empty($data) && $data['name'] == $slider_title) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$slider_title), 'id')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	 
	//添加分类时，验证分类名是否已存在
	public function public_check_name() {
		$type_name = $this->input->get('type_name') && trim($this->input->get('type_name')) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($this->input->get('type_name'))) : trim($this->input->get('type_name'))) : exit('0');
		$type_name = safe_replace($type_name);
 		$typeid = $this->input->get('typeid') && intval($this->input->get('typeid')) ? intval($this->input->get('typeid')) : '';
 		$data = array();
		if ($typeid) {
 			$data = $this->db2->get_one(array('typeid'=>$typeid), 'name');
			if (!empty($data) && $data['name'] == $type_name) {
				exit('1');
			}
		}
		if ($this->db2->get_one(array('name'=>$type_name), 'typeid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	 
	//添加幻灯片
 	public function add() {
 		if($this->input->post('dosubmit')) {
			$slider = $this->input->post('slider');
			$slider['addtime'] = SYS_TIME;
			$slider['siteid'] = $this->get_siteid();
			
			if ($slider['image']) {
				$slider['image'] = safe_replace($slider['image']);
			}
			$data = new_addslashes($slider);
			$sliderid = $this->db->insert($data,true);
			if(!$sliderid) return FALSE; 
 			$siteid = $this->get_siteid();
	 		//更新附件状态
			if(SYS_ATTACHMENT_STAT & $slider['image']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($slider['image'],'slider-'.$id,1);
			}
			dr_admin_msg(1,L('operation_success'),HTTP_REFERER,'', 'edit');
		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
 			$siteid = $this->get_siteid();
			$types = $this->db2->get_types($siteid);
			
			//print_r($types);exit;
 			include $this->admin_tpl('slider_add');
		}

	}
	
	/**
	 * 说明:异步更新排序 
	 * @param  $optionid
	 */
	public function listorder_up() {
		$result = $this->db->update(array('listorder'=>'+=1'),array('id'=>$this->input->get('id')));
		if($result){
			echo 1;
		} else {
			echo 0;
		}
	}
	
	//更新排序
 	public function listorder() {
		if($this->input->post('dosubmit')) {
			if ($this->input->post('listorders') && is_array($this->input->post('listorders'))) {
				foreach($this->input->post('listorders') as $id => $listorder) {
					$id = intval($id);
					$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
				}
			}
			dr_admin_msg(1,L('operation_success'),HTTP_REFERER);
		} 
	}
	
	
	
	/**
	 * 删除分类
	 */
	public function delete_type() {
		if(!$this->input->get('typeid') || empty($this->input->get('typeid')) && !$this->input->post('typeid') || empty($this->input->post('typeid'))) {
			dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($this->input->post('typeid'))){
				foreach($this->input->post('typeid') as $typeid_arr) {
 					$this->db2->delete(array('typeid'=>$typeid_arr));
				}
				dr_admin_msg(1,L('operation_success'),HTTP_REFERER);
			}else{
				$typeid = intval($this->input->get('typeid'));
				if($typeid < 1) return false;
				$result = $this->db2->delete(array('typeid'=>$typeid));
				if($result){
					dr_admin_msg(1,L('operation_success'),HTTP_REFERER);
				}else {
					dr_admin_msg(0,L("operation_failure"),HTTP_REFERER);
				}
			}
		}
	}
	
	//:分类管理
 	public function list_type() {
		$this->db2 = pc_base::load_model('type_model');
		$page = $this->input->get('page') && intval($this->input->get('page')) ? intval($this->input->get('page')) : 1;
		$infos = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'listorder DESC',$page, $pages = '10');
		$big_menu = array('javascript:artdialog(\'add\',\'?m=slider&c=slider&a=add\',\''.L('slider_add').'\',700,450);void(0);', L('slider_add'));
		$pages = $this->db2->pages;
		include $this->admin_tpl('slider_list_type');
	}
 
	public function edit() {
		if($this->input->post('dosubmit')){
 			$id = intval($this->input->get('id'));
			if($id < 1) return false;
			$slider = $this->input->post('slider');
			if(!is_array($slider) || empty($slider)) return false;
			if((!$slider['name']) || empty($slider['name'])) return false;
			$this->db->update($slider,array('id'=>$id));
			//更新附件状态
			if(SYS_ATTACHMENT_STAT & $slider['image']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($slider['image'],'slider-'.$id,1);
			}
			dr_admin_msg(1,L('operation_success'),'?m=slider&c=slider&a=edit','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			$types = $this->db2->get_types($this->get_siteid());
 			$type_arr = array ();
			foreach($types as $typeid=>$type){
				$type_arr[$type['typeid']] = $type['name'];
			}
			//解出链接内容
			$info = $this->db->get_one(array('id'=>$this->input->get('id')));
			if(!$info) dr_admin_msg(0,L('slider_exit'));
			extract($info); 
 			include $this->admin_tpl('slider_edit');
		}

	}
	
	/**
	 * 修改幻灯片 分类
	 */
	public function edit_type() {
		if($this->input->post('dosubmit')){ 
			$typeid = intval($this->input->get('typeid')); 
			if($typeid < 1) return false;
			$type = $this->input->post('type');
			if(!is_array($type) || empty($type)) return false;
			if((!$type['name']) || empty($type['name'])) return false;
			$this->db2->update($type,array('typeid'=>$typeid));
			dr_admin_msg(1,L('operation_success'),'?m=slider&c=slider&a=list_type','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			//解出分类内容
			$info = $this->db2->get_one(array('typeid'=>$this->input->get('typeid')));
			if(!$info) dr_admin_msg(0,L('slider_exit'));
			extract($info);
			include $this->admin_tpl('slider_type_edit');
		}

	}

	/**
	 * 删除幻灯片  
	 * @param	intval	$sid	幻灯片ID，递归删除
	 */
	public function delete() {
  		if((!$this->input->get('id') || empty($this->input->get('id'))) && (!$this->input->post('id') || empty($this->input->post('id')))) {
			dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($this->input->post('id'))){
				foreach($this->input->post('id') as $id_arr) {
 					//批量删除幻灯片
					$this->db->delete(array('id'=>$id_arr));
					//更新附件状态
					if(SYS_ATTACHMENT_STAT && SYS_ATTACHMENT_DEL) {
						$this->attachment_db = pc_base::load_model('attachment_model');
						$this->attachment_db->api_delete('slider-'.$id_arr);
					}
				}
				dr_admin_msg(1,L('operation_success'),'?m=slider&c=slider');
			}else{
				$id = intval($this->input->get('id'));
				if($id < 1) return false;
				//删除幻灯片
				$result = $this->db->delete(array('id'=>$id));
				//更新附件状态
				if(SYS_ATTACHMENT_STAT && SYS_ATTACHMENT_DEL) {
					$this->attachment_db = pc_base::load_model('attachment_model');
					$this->attachment_db->api_delete('slider-'.$id);
				}
				if($result){
					dr_admin_msg(1,L('operation_success'),'?m=slider&c=slider');
				}else {
					dr_admin_msg(0,L("operation_failure"),'?m=slider&c=slider');
				}
			}
			dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
		}
	}
	 
	
    //添加幻灯片分类
 	public function add_type() {
		if($this->input->post('dosubmit')) {
			$type = $this->input->post('type');
			if(empty($type['name'])) {
				dr_admin_msg(0,L('slider_postion_noempty'),HTTP_REFERER);
			}
			$type['siteid'] = $this->get_siteid(); 
			$type['module'] = ROUTE_M;
 			$this->db2 = pc_base::load_model('type_model');
			$typeid = $this->db2->insert($type,true);
			if(!$typeid) return FALSE;
			dr_admin_msg(1,L('operation_success'),HTTP_REFERER);
		} else {
			$show_validator = $show_scroll = true;
			$big_menu = array('javascript:artdialog(\'add\',\'?m=slider&c=slider&a=add\',\''.L('slider_add').'\',700,450);void(0);', L('slider_add'));
 			include $this->admin_tpl('slider_type_add');
		}

	}


	public function view_lable(){
		$show_header = '';
		$typeid=intval($this->input->get('typeid'));
 		include $this->admin_tpl('slider_get_lable');
	}

	
	/**
	 * 说明:对字符串进行处理
	 * @param $string 待处理的字符串
	 * @param $isjs 是否生成JS代码
	 */
	function format_js($string, $isjs = 1){
		$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}
 
 
	
}
?>