<?php
defined('IN_CMS') or exit('No permission resources.');
//模型原型存储路径
define('MODEL_PATH',PC_PATH.'modules'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR);
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_class('admin','admin',0);
class sitemodel extends admin {
	private $db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->cache = pc_base::load_sys_class('cache');
		$this->db = pc_base::load_model('sitemodel_model');
		$this->content_db = pc_base::load_model('content_model');
		$this->cache_api = pc_base::load_app_class('cache_api', 'admin');
		$this->siteid = $this->get_siteid();
		if(!$this->siteid) $this->siteid = 1;
	}
	
	public function init() {
		$datas = $this->db->listinfo(array('siteid'=>$this->siteid,'type'=>0),$this->input->get('order'),$this->input->get('page'),SYS_ADMIN_PAGESIZE);
		$pages = $this->db->pages;
		$this->cache_api->cache('sitemodel');
		$big_menu = array('javascript:artdialog(\'add\',\'?m=content&c=sitemodel&a=add\',\''.L('add_model').'\',580,420);void(0);', L('add_model'));
		include $this->admin_tpl('sitemodel_manage');
	}
	
	public function add() {
		if($this->input->post('dosubmit')) {
			$info = $this->input->post('info');
			$setting = $this->input->post('setting');
			!$setting['list_field'] && $setting['list_field'] = array(
				'title' => array(
					'use' => 1,
					'name' => L('主题'),
					'width' => '',
					'func' => 'title',
				),
				'username' => array(
					'use' => 1,
					'name' => L('用户名'),
					'width' => '100',
					'func' => 'author',
				),
				'updatetime' => array(
					'use' => 1,
					'name' => L('更新时间'),
					'width' => '160',
					'func' => 'datetime',
				),
				'listorder' => array(
					'use' => 1,
					'name' => L('排序'),
					'width' => '100',
					'center' => 1,
					'func' => 'save_text_value',
				),
			);
			$info['setting'] = array2string($setting);
			$info['siteid'] = $this->siteid;
			$info['category_template'] = $setting['category_template'];
			$info['list_template'] = $setting['list_template'];
			$info['show_template'] = $setting['show_template'];
			if ($this->input->post('other')) {
				$info['admin_list_template'] = $setting['admin_list_template'];
				$info['member_add_template'] = $setting['member_add_template'];
				$info['member_list_template'] = $setting['member_list_template'];
			} else {
				unset($setting['admin_list_template'], $setting['member_add_template'], $setting['member_list_template']);
			}
			$modelid = $this->db->insert($info,1);
			$model_sql = file_get_contents(MODEL_PATH.'model.sql');
			$tablepre = $this->db->db_tablepre;
			$tablename = $info['tablename'];
			$model_sql = str_replace('$basic_table', $tablepre.$tablename, $model_sql);
			$model_sql = str_replace('$table_data',$tablepre.$tablename.'_data', $model_sql);
			$model_sql = str_replace('$table_model_field',$tablepre.'model_field', $model_sql);
			$model_sql = str_replace('$modelid',$modelid,$model_sql);
			$model_sql = str_replace('$siteid',$this->siteid,$model_sql);
			
			$this->db->sql_execute($model_sql);
			$this->cache_field($modelid);
			//调用全站搜索类别接口
			$this->type_db = pc_base::load_model('type_model');
			$this->type_db->insert(array('name'=>$info['name'],'module'=>'search','modelid'=>$modelid,'siteid'=>$this->siteid));
			$this->cache_api->cache('sitemodel');
			$this->cache_api->cache('type', 'search');
			dr_admin_msg(1,L('add_success'), '', '', 'add');
		} else {
			pc_base::load_sys_class('form','',0);
			$show_header = $show_validator = true;
			$style_list = template_list($this->siteid, 0);
			foreach ($style_list as $k=>$v) {
				$style_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($style_list[$k]);
			}
			$admin_list_template = $this->admin_list_template('content_list', 'name="setting[admin_list_template]"');
			include $this->admin_tpl('sitemodel_add');
		}
	}
	public function edit() {
		if(IS_AJAX_POST) {
			$modelid = intval($this->input->post('modelid'));
			$this->m_db = pc_base::load_model('sitemodel_field_model');
			$this->field = $this->m_db->select(array('siteid'=>$this->siteid, 'modelid'=>$modelid, 'issystem'=>1),'*','','listorder ASC,fieldid ASC');
			$sys_field = sys_field(array('id', 'title', 'username', 'updatetime', 'listorder'));
			$data = $this->db->get_one(array('modelid'=>$modelid));
			$data['setting'] = dr_string2array($data['setting']);
			$field = dr_list_field_value($data['setting']['list_field'], $sys_field, $this->field);
			$info = $this->input->post('info');
			$setting = $this->input->post('setting');
			if ($setting['list_field']) {
				foreach ($setting['list_field'] as $t) {
					if ($t['func']
						&& !method_exists(pc_base::load_sys_class('function_list'), $t['func']) && !function_exists($t['func'])) {
						dr_json(0, L('列表回调函数['.$t['func'].']未定义'));
					}
				}
			}
			$setting['list_field'] = dr_list_field_order($setting['list_field']);
			if ($setting['search_time'] && !isset($field[$setting['search_time']])) {
				dr_json(0, L('后台列表时间搜索字段'.$setting['search_time'].'不存在'));
			}
			if ($setting['order']) {
				$arr = explode(',', $setting['order']);
				foreach ($arr as $t) {
					list($a) = explode(' ', $t);
					if ($a && !isset($field[$a])) {
						dr_json(0, L('后台列表的默认排序字段'.$a.'不存在'));
					}
				}
			}
			$info['setting'] = array2string($setting);
			$info['category_template'] = $setting['category_template'];
			$info['list_template'] = $setting['list_template'];
			$info['show_template'] = $setting['show_template'];
			if ($this->input->post('other')) {
				$info['admin_list_template'] = $setting['admin_list_template'];
				$info['member_add_template'] = $setting['member_add_template'];
				$info['member_list_template'] = $setting['member_list_template'];
			} else {
				unset($setting['admin_list_template'], $setting['member_add_template'], $setting['member_list_template']);
			}
			
			$this->db->update($info,array('modelid'=>$modelid,'siteid'=>$this->siteid));
			dr_json(1, L('update_success'), array('url' => '?m=content&c=sitemodel&a=init&pc_hash='.dr_get_csrf_token()));
		} else {
			pc_base::load_sys_class('form','',0);
			$show_validator = true;
			$style_list = template_list($this->siteid, 0);
			foreach ($style_list as $k=>$v) {
				$style_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($style_list[$k]);
			}
			$modelid = intval($this->input->get('modelid'));
			$this->m_db = pc_base::load_model('sitemodel_field_model');
			$this->field = $this->m_db->select(array('siteid'=>$this->siteid, 'modelid'=>$modelid, 'issystem'=>1),'*','','listorder ASC,fieldid ASC');
			$sys_field = sys_field(array('id', 'title', 'username', 'updatetime', 'listorder'));
			$r = $this->db->get_one(array('modelid'=>$modelid));
			extract($r);
			if ($r['setting']) {
				extract(string2array($r['setting']));
			}
			!$list_field && $list_field = array(
				'title' => array(
					'use' => 1,
					'name' => L('主题'),
					'width' => '',
					'func' => 'title',
				),
				'username' => array(
					'use' => 1,
					'name' => L('用户名'),
					'width' => '100',
					'func' => 'author',
				),
				'updatetime' => array(
					'use' => 1,
					'name' => L('更新时间'),
					'width' => '160',
					'func' => 'datetime',
				),
				'listorder' => array(
					'use' => 1,
					'name' => L('排序'),
					'width' => '100',
					'center' => 1,
					'func' => 'save_text_value',
				),
			);
			$field = dr_list_field_value($list_field, $sys_field, $this->field);
			$page = intval($this->input->get('page'));
			$admin_list_template_f = $this->admin_list_template($admin_list_template, 'name="setting[admin_list_template]"');
			include $this->admin_tpl('sitemodel_edit');
		}
	}
	public function delete() {
		$this->sitemodel_field_db = pc_base::load_model('sitemodel_field_model');
		$modelid = intval($this->input->get('modelid'));
		$model_cache = getcache('model','commons');
		$model_table = $model_cache[$modelid]['tablename'];
		$this->sitemodel_field_db->delete(array('modelid'=>$modelid,'siteid'=>$this->siteid));
		$this->db->drop_table($model_table);
		$this->db->drop_table($model_table.'_data');
		
		$this->db->delete(array('modelid'=>$modelid,'siteid'=>$this->siteid));
		//删除全站搜索接口数据
		$this->type_db = pc_base::load_model('type_model');
		$this->type_db->delete(array('module'=>'search','modelid'=>$modelid,'siteid'=>$this->siteid));
		$this->cache_api->cache('sitemodel');
		$this->cache_api->cache('type', 'search');
		exit('1');
	}
	public function disabled() {
		$modelid = intval($this->input->get('modelid'));
		$r = $this->db->get_one(array('modelid'=>$modelid,'siteid'=>$this->siteid));
		
		$status = $r['disabled'] == '1' ? '0' : '1';
		$this->db->update(array('disabled'=>$status),array('modelid'=>$modelid,'siteid'=>$this->siteid));
		dr_admin_msg(1,L('update_success'), HTTP_REFERER);
	}
	/**
	 * 导出模型
	 */
	function export() {
		$modelid = $this->input->get('modelid') ? $this->input->get('modelid') : dr_admin_msg(0,L('illegal_parameters'), HTTP_REFERER);
		$modelarr = getcache('model', 'commons');
		//定义系统字段排除
		//$system_field = array('id','title','style','catid','url','listorder','status','userid','username','inputtime','updatetime','pages','readpoint','template','groupids_view','posids','content','keywords','description','thumb','typeid','relation','islink','allow_comment');
		$this->sitemodel_field_db = pc_base::load_model('sitemodel_field_model');
		$modelinfo = $this->sitemodel_field_db->select(array('modelid'=>$modelid));
		foreach($modelinfo as $k=>$v) {
			//if(in_array($v['field'],$system_field)) continue;
			$modelinfoarr[$k] = $v;
			$modelinfoarr[$k]['setting'] = string2array($v['setting']);
		}
		$res = var_export($modelinfoarr, TRUE);
		header('Content-Disposition: attachment; filename="'.$modelarr[$modelid]['tablename'].'.model"');
		echo $res;exit;
	}
	/**
	 * 导入模型
	 */
	function import(){
		if($this->input->post('dosubmit')) {
			$info = $this->input->post('info');
			$setting = $this->input->post('setting');
			!$setting['list_field'] && $setting['list_field'] = array(
				'title' => array(
					'use' => 1,
					'name' => L('主题'),
					'width' => '',
					'func' => 'title',
				),
				'username' => array(
					'use' => 1,
					'name' => L('用户名'),
					'width' => '100',
					'func' => 'author',
				),
				'updatetime' => array(
					'use' => 1,
					'name' => L('更新时间'),
					'width' => '160',
					'func' => 'datetime',
				),
				'listorder' => array(
					'use' => 1,
					'name' => L('排序'),
					'width' => '100',
					'center' => 1,
					'func' => 'save_text_value',
				),
			);
			$info['name'] = $info['modelname'];
			unset($info['modelname']);
			//主表表名
			$basic_table = $info['tablename'];
			//从表表名
			$table_data = $basic_table.'_data';
			$info['description'] = $info['description'];
			$info['setting'] = array2string($setting);
			$info['type'] = 0;
			$info['siteid'] = $this->siteid;
			
			$info['default_style'] = $this->input->post('default_style');
			$info['category_template'] = $setting['category_template'];
			$info['list_template'] = $setting['list_template'];
			$info['show_template'] = $setting['show_template'];
			
			if(!empty($_FILES['model_import']['tmp_name'])) {
				$model_import = @file_get_contents($_FILES['model_import']['tmp_name']);
				if(!empty($model_import)) {
					$model_import_data = string2array($model_import);				
				}
			}
			$is_exists = $this->db->table_exists($basic_table);
			if($is_exists) dr_admin_msg(0,L('operation_failure'),'?m=content&c=sitemodel&a=init');
			$modelid = $this->db->insert($info, 1);
			if($modelid){
				$tablepre = $this->db->db_tablepre;
				//建立数据表
				$model_sql = file_get_contents(MODEL_PATH.'model.sql');
				$model_sql = str_replace('$basic_table', $tablepre.$basic_table, $model_sql);
				$model_sql = str_replace('$table_data',$tablepre.$table_data, $model_sql);
				$model_sql = str_replace('$table_model_field',$tablepre.'model_field', $model_sql);
				$model_sql = str_replace('$modelid',$modelid,$model_sql);
				$model_sql = str_replace('$siteid',$this->siteid,$model_sql);
				$this->db->sql_execute($model_sql);
				
				if(!empty($model_import_data)) {
					$this->sitemodel_field_db = pc_base::load_model('sitemodel_field_model');
					$system_field = array('title','style','catid','url','listorder','status','userid','username','inputtime','updatetime','pages','readpoint','template','groupids_view','posids','content','keywords','description','thumb','typeid','relation','islink','allow_comment');
					foreach($model_import_data as $v) {
						$field = $v['field'];
						if(in_array($field,$system_field)) {
							$v['siteid'] = $this->siteid;
							unset($v['fieldid'],$v['modelid'],$v['field']);
							$v['setting'] = array2string($v['setting']);
							
							$this->sitemodel_field_db->update($v,array('modelid'=>$modelid,'field'=>$field));
						} else {
							$tablename = $v['issystem'] ? $tablepre.$basic_table : $tablepre.$table_data;
							//重组模型表字段属性
							
							$minlength = $v['minlength'] ? $v['minlength'] : 0;
							$maxlength = $v['maxlength'] ? $v['maxlength'] : 0;
							$field_type = $v['formtype'];
							require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';	
							if(isset($v['setting']['fieldtype'])) {
								$field_type = $v['setting']['fieldtype'];
							}
							require MODEL_PATH.'add.sql.php';
							$v['setting'] = array2string($v['setting']);
							$v['modelid'] = $modelid;
							$v['siteid'] = $this->siteid;
							unset($v['fieldid']);
							
							$this->sitemodel_field_db->insert($v);
						}
					}
				}
				$this->cache_api->cache('sitemodel');
				dr_admin_msg(1,L('operation_success'),'?m=content&c=sitemodel&a=init');
			}
		} else {
			pc_base::load_sys_class('form','',0);
			$show_validator = '';
			$style_list = template_list($this->siteid, 0);
			foreach ($style_list as $k=>$v) {
				$style_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($style_list[$k]);
			}
			$big_menu = array('javascript:artdialog(\'add\',\'?m=content&c=sitemodel&a=add\',\''.L('add_model').'\',580,400);void(0);', L('add_model'));
			include $this->admin_tpl('sitemodel_import');
		}
	}
	/**
	 * 在线帮助
	 */
	public function public_help() {
		$show_header = $show_validator = true;
		include $this->admin_tpl('sitemodel_help');
	}
	/**
	 * 检查表是否存在
	 */
	public function public_check_tablename() {
		$r = $this->db->table_exists(clearhtml($this->input->get('tablename')));
		if(!$r) echo '1';
	}
	/**
	 * 更新指定模型字段缓存
	 * 
	 * @param $modelid 模型id
	 */
	public function cache_field($modelid = 0) {
		$this->cache_api->sitemodel_field($modelid);
	}
	/**
	 * 汉字转换拼音
	 */
	public function public_ajax_pinyin() {
		$pinyin = pc_base::load_sys_class('pinyin');
		$name = dr_safe_replace($this->input->get('name'));
		if (!$name) {
			exit('');
		}
		$py = $pinyin->result($name);
		if (strlen($py) > 12) {
			$sx = $pinyin->result($name, 0);
			if ($sx) {
				exit($sx);
			}
		}
		exit($py);
	}
}
?>