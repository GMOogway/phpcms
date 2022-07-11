<?php

/**
 * debug.class.php   debug类
 */

class debug {
	public static $info = array();
	public static $sqls = array();
	public static $files = array();
	public static $errors = array();
	public static $trace = array();
	public static $stoptime;
	public static $msg = array(
		E_WARNING => '错误警告',
		E_NOTICE => '错误提醒',
		E_STRICT => '编码标准化警告',
		E_USER_ERROR => '自定义错误',
		E_USER_WARNING => '自定义警告',
		E_USER_NOTICE => '自定义提醒',
		'Unkown ' => '未知错误' 
	);
	/**
	 *在脚本结束处调用获取脚本结束时间的微秒值
	 */
	public static function stop() {
		self::$stoptime = microtime(true);
	}
	/**
	 *返回同一脚本中两次获取时间的差值
	 */
	public static function spent() {
		return round((self::$stoptime - SYS_START_TIME) , 4);
		//计算后以4舍5入保留4位返回
	}
	/**
	 * 致命错误 fatalerror
	 */
	public static function fatalerror() {
		if ($e = error_get_last()) {
			switch($e['type']) {
				case E_ERROR:
				case E_PARSE:
				case E_CORE_ERROR:
				case E_COMPILE_ERROR:
				case E_USER_ERROR:  
				ob_end_clean();
				self::error($e['message'], $e['file'].' on line '.$e['line']);
				SYS_ERRORLOG && IS_DEV && error_log('<?php exit;?> FatalError : '.date('Y-m-d H:i:s',SYS_TIME).' message:'.$e['message'].', file:'.$e['file'].', line:'.$e['line']."\r\n", 3, CACHE_PATH.'error_log.php');
				self::addmsg('系统错误: '.$e['message'].'  位置: '.$e['file'].' 第 '.$e['line'].' 行 ', 2);
				break;
			}
		}
	}
	/**
	 * 错误 error_handler
	 */
	public static function error_handler($errno, $errstr, $errfile, $errline) {
		if($errno==8) return '';
		if(!isset(self::$msg[$errno]))
		$errno='Unkown';
		if($errno==E_NOTICE || $errno==E_USER_NOTICE)
		$color="#151515"; else
		$color="red";
		$mess = '<span style="color:'.$color.';">';
		$mess .= '<b>'.self::$msg[$errno].'</b> [文件 '.$errfile.' 中,第 '.$errline.' 行] ：';
		$mess .= $errstr;
		$mess .= '</span>';
		SYS_ERRORLOG && IS_DEV && error_log('<?php exit;?>'.date('Y-m-d H:i:s',SYS_TIME).' | '.$errno.' | '.str_pad($errstr,30).' | '.$errfile.' | '.$errline."\r\n", 3, CACHE_PATH.'error_log.php');
		self::addmsg($mess, 2);
	}
	/**
	 * 捕获异常
	 * @param	object	$exception
	 */
	public static function exception($exception) {
		if(defined('CI_DEBUG') && CI_DEBUG) {
			$mess = '<span style="color:red;">';
			$mess .= '<b>系统异常</b> [文件 '.$exception->getFile().' 中,第 '.$exception->getLine().' 行] ：';
			$mess .= $exception->getMessage();
			$mess .= '</span>';
			SYS_ERRORLOG && IS_DEV && error_log('<?php exit;?> ExceptionError : '.date('Y-m-d H:i:s',SYS_TIME).' | '.$exception->getMessage().' | '.$exception->getFile().' | '.$exception->getLine()."\r\n", 3, CACHE_PATH.'error_log.php');
			self::addmsg($mess, 2);
			self::error($exception->getMessage(), $exception->getFile().' on line '.$exception->getLine());
			self::message();
			exit;
		} else {
			self::error($exception->getMessage(), '');
		}
	}
	/**
	 * 添加调试消息
	 * @param	string	$msg	调试消息字符串
	 * @param	int		$type	消息的类型
	 */
	public static function addmsg($msg, $type=0) {
		switch($type) {
			case 0:
				self::$info[] = $msg;
			break;
			case 1:
				self::$sqls[] = htmlspecialchars($msg).';';
			break;
			case 2:
				self::$errors[] = $msg;
			break;
			case 3:
				self::$files[] = $msg;
			break;
			case 4:
				self::$trace[] = $msg;
			break;
		}
	}
	// 自定义调试的消息 使用方法 debug::trace('msg'); 
	public static function trace($msg) {
		self::addmsg($msg, 4);
	}
	/**
	 * 获取debug信息
	 */
	public static function get_debug() {
		return array(
			'base' => self::$info,
			'files' => self::$files,
			'errors' => self::$errors,
			'sqls' => self::$sqls,
			'trace' => self::$trace,
		);
	}
	/**
	 * 获取文件加载信息
	 */
	private static  function getRequrieFile() {
		// 系统默认显示信息
		$files  =  get_included_files();
		foreach ($files as $key=>$file) {
			self::addmsg($file.' ( '.number_format(filesize($file)/1024,2).' KB )', 3);
		}
	}
	/**
	 * 获取环境基本信息
	 */
	private static  function getBaseInfo() {
		// 系统默认显示信息
		$baseinfo_arr = array(
			1=> ' 服务器信息： '.$_SERVER['SERVER_SOFTWARE'],
			2=> ' 请求信息: '.date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']).' '.$_SERVER['SERVER_PROTOCOL'].' '.$_SERVER['REQUEST_METHOD'].' : '.$_SERVER["REQUEST_URI"],
			3=> ' 内存消耗：' . number_format((memory_get_usage() - SYS_START_MEM) / 1024, 2) . 'kb',  
			4=> ' 文件加载: '.count(self::$files).' , SQL: '.count(self::$sqls).' , '.' 错误: '.count(self::$errors).' , '.' 调试: '.count(self::$trace).' ', 
			5=> ' 运行时间: '.self::spent().'s [ 吞吐率：' . (self::spent() > 0 ? number_format(1 / self::spent(), 2) : '∞') . 'req/s ]',
		);
		foreach ($baseinfo_arr as $key=>$info) {
			self::addmsg($info, 0);
		}
	}
	/**
	 * 输出调试消息
	 */
	public static function message() { 
		self::stop();
		self::getRequrieFile();
		self::getBaseInfo();
		$page_trace = self::get_debug();
		if (IS_ADMIN) {
			include(admin_template('debug', 'admin'));
		} else {
			include(template('debug'));
		}
	}
	/**
	 *  输出错误信息
	 *
	 * @param		string  $msg	提示信息
	 * @param		string  $detailed	详细信息
	 * @return		void
	 */
	public static function error($msg, $detail = '') {
		if(ob_get_length() !== false) @ob_end_clean();
		show_error($msg.$detail);
	}
}