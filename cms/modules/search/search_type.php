<?php
defined('IN_CMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
class search_type extends admin {
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('type_model');
		$this->siteid = $this->get_siteid();
		$this->model = getcache('model','commons');
		$this->yp_model = getcache('yp_model','model');
		$this->module_db = pc_base::load_model('module_model');
		$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
	}
	
	public function init () {
		$datas = array();
		$page = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
		$result_datas = $this->db->listinfo(array('siteid'=>$this->siteid,'module'=>'search'),'listorder ASC', $page, SYS_ADMIN_PAGESIZE);
		$pages = $this->db->pages;
		foreach($result_datas as $r) {
			$r['modelname'] = $this->model[$r['modelid']]['name'];
			$datas[] = $r;
		}
		$big_menu = array('javascript:artdialog(\'add\',\'?m=search&c=search_type&a=add\',\''.L('add_search_type').'\',580,240);void(0);', L('add_search_type'));
		$this->cache();
		include $this->admin_tpl('type_list');
	}
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['siteid'] = $this->siteid;
			$_POST['info']['module'] = 'search';
			if($_POST['module']=='content') {
				$_POST['info']['modelid'] = intval($_POST['info']['modelid']);
				$_POST['info']['typedir'] = $this->input->post('module');
			} elseif($_POST['module']=='yp') {
				$_POST['info']['modelid'] = intval($_POST['info']['yp_modelid']);
				$_POST['info']['typedir'] = $this->input->post('module');				
			} else {
				$_POST['info']['typedir'] = $this->input->post('module');
				$_POST['info']['modelid'] = 0;
			}
			
			//删除黄页模型变量无该字段
			unset($_POST['info']['yp_modelid']);

			$this->db->insert($_POST['info']);
			dr_admin_msg(1,L('add_success'), '', '', 'add');
		} else {
			$show_header = $show_validator = true;
			
			foreach($this->model as $_key=>$_value) {
				if($_value['siteid']!=$this->siteid) continue;
				$model_data[$_key] = $_value['name'];
			}
			if(is_array($this->yp_model)){
				foreach($this->yp_model as $_key=>$_value) {
					if($_value['siteid']!=$this->siteid) continue;
					$yp_model_data[$_key] = $_value['name'];
				}	
			}
					

			$module_data = array('special' => L('special'),'content' => L('content').L('module'),'yp'=>L('yp'));

			include $this->admin_tpl('type_add');
		}
	}
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$typeid = intval($_POST['typeid']);
			
			if($_POST['module']=='content') {
				$_POST['info']['modelid'] = intval($_POST['info']['modelid']);
			} elseif($_POST['module']=='yp') {
				$_POST['info']['modelid'] = intval($_POST['info']['yp_modelid']);
				$_POST['info']['typedir'] = $this->input->post('module');				
			} else {
				$_POST['info']['typedir'] = $this->input->post('typedir');
				$_POST['info']['modelid'] = 0;
			}
				
			//删除黄页模型变量无该字段
			unset($_POST['info']['yp_modelid']);
	
			$this->db->update($_POST['info'],array('typeid'=>$typeid));
			dr_admin_msg(1,L('update_success'), '', '', 'edit');
		} else {
			$show_header = $show_validator = true;
			$typeid = intval($_GET['typeid']);
			foreach($this->model as $_key=>$_value) {
				if($_value['siteid']!=$this->siteid) continue;
				$model_data[$_key] = $_value['name'];
			}
			foreach($this->yp_model as $_key=>$_value) {
				if($_value['siteid']!=$this->siteid) continue;
				$yp_model_data[$_key] = $_value['name'];
			}
						
			$module_data = array('special' => L('special'),'content' => L('content').L('module'),'yp'=>L('yp'));
			$r = $this->db->get_one(array('typeid'=>$typeid));

			extract($r);
			include $this->admin_tpl('type_edit');
		}
	}
	public function delete() {
		$_GET['typeid'] = intval($_GET['typeid']);
		$this->db->delete(array('typeid'=>$_GET['typeid']));
		dr_admin_msg(1,L('operation_success'), HTTP_REFERER);
	}
	
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			if (isset($_POST['listorders']) && is_array($_POST['listorders'])) {
				foreach($_POST['listorders'] as $id => $listorder) {
					$this->db->update(array('listorder'=>$listorder),array('typeid'=>intval($id)));
				}
			}
			dr_admin_msg(1,L('operation_success'));
		} else {
			dr_admin_msg(0,L('operation_failure'));
		}
	}
	
	public function cache() {
		$this->cache_api->cache('type', 'search');
		return true;
	}
}
?>