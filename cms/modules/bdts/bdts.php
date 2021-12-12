<?php
defined('IN_CMS') or exit('No permission resources.');
if (!module_exists(ROUTE_M)) dr_admin_msg(0,L('module_not_exists'));
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('model', '', 0);

class bdts extends admin {
	function __construct() {
		parent::__construct();
		$this->input = pc_base::load_sys_class('input');
		$this->db = pc_base::load_model('content_model');
		$this->siteid = $this->get_siteid();
		$this->bdts = pc_base::load_app_class('admin_bdts');
	}
	
	//百度推送
	public function log_index() {
		$data = $list = array();
		$file = CACHE_PATH.'caches_bdts/bdts_log.php';
		if (is_file(CACHE_PATH.'caches_bdts/bdts_log.php')) {
			$data = explode(PHP_EOL, str_replace(array(chr(13), chr(10)), PHP_EOL, file_get_contents($file)));
			$data = $data ? array_reverse($data) : array();
			unset($data[0]);
			$getpage = max(intval($this->input->get('page')), 1);
			$page = max(1, (int)$getpage);
			$limit = ($page - 1) * SYS_ADMIN_PAGESIZE;
			$i = $j = 0;
			foreach ($data as $v) {
				if ($i >= $limit && $j < SYS_ADMIN_PAGESIZE) {
					$list[] = $v;
					$j ++;
				}
				$i ++;
			}
		}
		$total = $data ? max(0, count($data) - 1) : 0;
		$pages = pages($total, $getpage, SYS_ADMIN_PAGESIZE);
		include $this->admin_tpl('index');
	}
	
	//参数配置
	public function config() {
		if($this->input->post('dosubmit')) {
			$post = $this->input->post('data');
			if ($post['bdts']) {
				$bdts = [];
				foreach ($post['bdts'] as $i => $t) {
					if (isset($t['site'])) {
						if (!$t['site']) {
							dr_json(0, L('域名必须填写'));
						}
						$bdts[$i]['site'] = $t['site'];
					} else {
						if (!$t['token']) {
							dr_json(0, L('token必须填写'));
						}
						$bdts[$i-1]['token'] = $t['token'];
					}
				}
				$post['bdts'] = $bdts;
			}
			$this->bdts->setConfig($post);
			dr_json(1,L('操作成功'), array('url' => '?m=bdts&c=bdts&a=config&menuid='.$this->input->get('menuid').'&page='.(int)($this->input->post('page')).'&pc_hash='.dr_get_csrf_token()));
		}else{
			$this->siteid = $this->get_siteid();
			if(!$this->siteid) $this->siteid = 1;
			$page = max(intval($this->input->get('page')), 0);
			$this->sitemodel_db = pc_base::load_model('sitemodel_model');
			$sitemodel_data = $this->sitemodel_db->select(array('siteid'=>$this->siteid,'type'=>0));
			$data = $this->bdts->getConfig();
			$bdts = $data['bdts'];
			include $this->admin_tpl('config');
		}
	}
	
	public function del() {

		@unlink(CACHE_PATH.'caches_bdts/bdts_log.php');

		dr_admin_msg(1,L('操作成功'), '?m=bdts&c=bdts&a=log_index&menuid='.$this->input->get('menuid'));
	}
	
	//手动推送
	public function url_add() {

		if (IS_POST) {
			$url = $this->input->post('url');
			if (!$url) {
				dr_json(0, L('URL不能为空'));
			}

			$config = $this->bdts->getConfig();
			if (!$config) {
				dr_json(0, L('百度推送配置为空，不能推送'));
			}

			$uri = parse_url($url);
			$site = $uri['host'];
			if (!$site) {
				dr_json(0, L('百度推送没有获取到内容url（'.$url.'）的host值，不能推送'));
			}

			$token = '';
			foreach ($config['bdts'] as $t) {
				if ($t['site'] == $site && !$token) {
					$token = $t['token'];
				}
			}
			if (!$token) {
				dr_json(0, L('百度推送没有获取到内容url的Token，不能推送'));
			}

			$api = 'http://data.zz.baidu.com/urls?site='.$site.'&token='.$token;
			$urls = [$url];
			$ch = curl_init();
			$options =  array(
				CURLOPT_URL => $api,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => implode("\n", $urls),
				CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
			);
			curl_setopt_array($ch, $options);
			$rt = json_decode(curl_exec($ch), true);
			if ($rt['error']) {
				// 错误日志
				@file_put_contents(CACHE_PATH.'caches_bdts/bdts_log.php', date('Y-m-d H:i:s').' 手动['.$url.'] - 失败 - '.$rt['message'].PHP_EOL, FILE_APPEND);
			} else {
				// 推送成功
				@file_put_contents(CACHE_PATH.'caches_bdts/bdts_log.php', date('Y-m-d H:i:s').' 手动['.$url.'] - 成功'.PHP_EOL, FILE_APPEND);
			}

			dr_json(1,L('操作成功'), array('url' => '?m=bdts&c=bdts&a=url_add&menuid='.$this->input->get('menuid').'&page='.(int)($this->input->post('page')).'&pc_hash='.dr_get_csrf_token()));
		}

		$page = max(intval($this->input->get('page')), 0);
		include $this->admin_tpl('url_add');
		exit;
	}
	
	//批量百度主动推送
	public function add() {

		$mid = intval($this->input->get('modelid'));
		$ids = $this->input->post('ids');
		if (!$ids) {
			dr_json(0, L('所选数据不存在'));
		} elseif (!$mid) {
			dr_json(0, L('模块参数不存在'));
		}
		foreach ($ids as $id) {
			if ($field=='') {
				$field .= $id;
			}else{
				$field .= ','.$id;
			}
		}

		$this->db->set_model($mid);
		$sitemodel_model_db = pc_base::load_model('sitemodel_model');
		$sitemodel = $sitemodel_model_db->get_one(array('modelid'=>$mid));
		if($this->db->table_name==$this->db->db_tablepre) dr_json(0, L('模型被禁用或者是模型内容表不存在'));
		$status = 99;
		$where = 'id in ('.$field.')';
		$data = $this->db->select($where,'*',100);
		if (!$data) {
			dr_json(0, L('所选数据为空'));
		}

		$ct = 0;
		foreach ($data as $t) {
			$this->bdts->module_bdts($sitemodel['tablename'], $t['url'], 'add', 1);
			$ct++;
		}

		dr_json(1, L('共批量'.$ct.'个URL'));
	}
	
	//推送
	public function bdts() {
		$id = $this->input->get('id');
		$url = $this->apiurl();
		if (empty($url)) {
			dr_admin_msg(0,L('bdts_config_url'), '?m=bdts&c=bdts&a=config&menuid='.$this->input->get('menuid'));
		}
		$modelid = intval($this->input->get('modelid'));
		if(!$modelid) $modelid = 1;
		$this->db->set_model($modelid);
		if($this->db->table_name==$this->db->db_tablepre) dr_admin_msg(0,L('model_table_not_exists'));
		$rs = $this->db->get_one(array('id'=>$id));
		$bdts_r = $this->db->get_one(array('modelid'=>$modelid,'contentid'=>$rs['id']));
		if ($bdts_r) {
			dr_admin_msg(0,L('have_to_bdts'), HTTP_REFERER);
		}
		if ($rs) {
			$data = $rs['url'];
			$result = $this->post($url, $data);
			$arr = json_decode($result, true);
			if (isset($arr['success'])) {
				if ($arr['success'] != '0') {
					$this->db->insert(array('modelid'=>$modelid,'contentid'=>$id));
					dr_admin_msg(1,L('bdts_success'), HTTP_REFERER);
				} else {
					dr_admin_msg(0,L('bdts_error').$result, HTTP_REFERER);
				}
			} else {
				dr_admin_msg(0,L('bdts_error').$result['message'], HTTP_REFERER);
			}
		} else {
			dr_admin_msg(0,L('parameter_error'), HTTP_REFERER);
		}
		
	}
	
	public function apiurl() {
		if(!$this->siteid) $this->siteid = 1;
		$rs = $this->db_bdts_config->get_one(array('siteid'=>$this->siteid));
		if ($rs) {
			$url = $rs['url'];
			if ($rs['isauthor'] == 2) {
				$url = $url . '&type=original';
			}
			return $url;
		}
		return '';
	}
	
	public static function post($url,$data,$timeout=30,$head='') {
		$head=($head='')?FALSE:$head;
		$ch=curl_init();
		#设置超时
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		#Url
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		#设置header
		curl_setopt($ch,CURLOPT_HEADER,$head);
		#要求结果为字符串且输出到屏幕上
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		#post提交方式
		curl_setopt($ch,CURLOPT_POST,TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		$result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
?>