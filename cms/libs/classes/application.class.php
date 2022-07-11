<?php
/**
 *  application.class.php CMS应用程序创建类
 *
 * @copyright			(C) 2005-2010
 * @lastmodify			2010-6-7
 */
class application {
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		pc_base::load_sys_class('debug', '', 0);
		register_shutdown_function(array('debug','fatalerror'));
		set_error_handler(array('debug','error_handler'));
		set_exception_handler(array('debug', 'exception'));
		$param = pc_base::load_sys_class('param');
		define('ROUTE_M', $param->route_m());
		define('ROUTE_C', $param->route_c());
		define('ROUTE_A', $param->route_a());
		$this->init();
	}
	
	/**
	 * 调用件事
	 */
	private function init() {
		//判断环境
		if (version_compare(PHP_VERSION, MAX_PHP_VERSION) >= 0) {
			exit("<font color=red>PHP版本过高，请在".MAX_PHP_VERSION."以下的环境使用，当前".PHP_VERSION."，高版本需要等待官方对CMS版本的更新升级！~</font>");
		} elseif (version_compare(PHP_VERSION, MIN_PHP_VERSION) < 0) {
			exit("<font color=red>PHP版本必须在".MIN_PHP_VERSION."及以上，当前".PHP_VERSION."</font>");
		}
		$controller = $this->load_controller();
		if (method_exists($controller, ROUTE_A)) {
			if (preg_match('/^[_]/i', ROUTE_A)) {
				exit('You are visiting the action is to protect the private action');
			} else {
				call_user_func(array($controller, ROUTE_A));
				if (!in_array(ROUTE_M, array('admin')) || !in_array(ROUTE_C, array('index')) && !in_array(ROUTE_A, array('public_main'))) {
					if (IS_ADMIN && CI_DEBUG && !IS_AJAX) {
						debug::message();
					}
				}
				if (!IS_ADMIN && IS_DEV && !IS_AJAX) {
					debug::message();
				}
			}
		} else {
			exit('Action does not exist.');
		}
	}
	
	/**
	 * 加载控制器
	 * @param string $filename
	 * @param string $m
	 * @return obj
	 */
	private function load_controller($filename = '', $m = '') {
		if (empty($filename)) $filename = ROUTE_C;
		if (empty($m)) $m = ROUTE_M;
		$filepath = PC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.$filename.'.php';
		if (file_exists($filepath)) {
			$classname = $filename;
			include $filepath;
			if ($mypath = pc_base::my_path($filepath)) {
				$classname = 'MY_'.$filename;
				include $mypath;
			}
			if(class_exists($classname)){
				return new $classname;
			}else{
				exit('Controller does not exist.');
 			}
		} else {
			exit('Controller does not exist.');
		}
	}
}