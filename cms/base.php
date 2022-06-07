<?php
/**
 *  base.php CMS框架入口文件
 *
 * @copyright			(C) 2005-2010
 * @lastmodify			2021-06-06
 */
define('IN_CMS', TRUE);
define('IN_PHPCMS', IN_CMS);

// 是否是开发者模式
!defined('IS_DEV') && define('IS_DEV', FALSE);

// 后台管理标识
!defined('IS_ADMIN') && define('IS_ADMIN', FALSE);

// 移动入口标识
!defined('IS_MOBILE') && define('IS_MOBILE', FALSE);

// 采集入口标识
!defined('IS_COLLAPI') && define('IS_COLLAPI', FALSE);

//CMS框架路径
!defined('PC_PATH') && define('PC_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

!defined('CMS_PATH') && define('CMS_PATH', PC_PATH.'..'.DIRECTORY_SEPARATOR);
!defined('PHPCMS_PATH') && define('PHPCMS_PATH', CMS_PATH);

//缓存文件夹地址
!defined('CACHE_PATH') && define('CACHE_PATH', CMS_PATH.'caches'.DIRECTORY_SEPARATOR);
//主配置目录
!defined('CONFIGPATH') && define('CONFIGPATH', CACHE_PATH.'configs'.DIRECTORY_SEPARATOR);
//来源
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

//系统开始时间
define('SYS_START_TIME', microtime(true));

//PHP最低版本
define('MIN_PHP_VERSION', '7.1.0');
//PHP最高版本
define('MAX_PHP_VERSION', '8.2.0');

//加载公用函数库
pc_base::load_sys_func('global');
pc_base::load_sys_func('extention');
pc_base::auto_load_func();

// 主站URL
define('ROOT_URL', siteurl(1).'/');

// 系统变量
/*$system = array(
	'WEB_PATH' => '',
	'SESSION_STORAGE' => 'mysqli',
	'SESSION_TTL' => 1800,
	'SESSION_SAVEPATH' => CACHE_PATH.'sessions/',
	'SESSION_N' => 0,
	'COOKIE_DOMAIN' => '',
	'COOKIE_PATH' => '',
	'COOKIE_PRE' => '',
	'COOKIE_TTL' => 0,
	'TPL_ROOT' => 'templates/',
	'TPL_NAME' => 'default',
	'TPL_CSS' => 'default',
	'TPL_REFERESH' => 1,
	'TPL_EDIT'=> 0,
	'ATTACHMENT_STAT' => '1',
	'ATTACHMENT_FILE' => '0',
	'ATTACHMENT_DEL' => '1',
	'SYS_ATTACHMENT_SAVE_ID' => 0,
	'SYS_ATTACHMENT_CF' => 0,
	'SYS_ATTACHMENT_SAFE' => 0,
	'SYS_ATTACHMENT_PATH' => '',
	'SYS_ATTACHMENT_SAVE_TYPE' => 0,
	'SYS_ATTACHMENT_SAVE_DIR' => '',
	'SYS_ATTACHMENT_URL' => '',
	'SYS_AVATAR_PATH' => '',
	'SYS_AVATAR_URL' => '',
	'SYS_THUMB_PATH' => '',
	'SYS_THUMB_URL' => '',
	'JS_PATH' => '',
	'CSS_PATH' => '',
	'IMG_PATH' => '',
	'MOBILE_JS_PATH' => '',
	'MOBILE_CSS_PATH' => '/',
	'MOBILE_IMG_PATH' => '',
	'APP_PATH' => '',
	'MOBILE_PATH' => '',
	'SYS_EDITOR' => '0',
	'SYS_MAX_CATEGORY' => 100,
	'SYS_ADMIN_PAGESIZE' => 10,
	'CHARSET' => 'utf-8',
	'TIMEZONE' => '8',
	'SYS_TIME_FORMAT' => '',
	'DEBUG' => 1,
	'SYS_CSRF' => 0,
	'NEEDCHECKCOMEURL' => 1,
	'ADMIN_LOG' => 1,
	'ERRORLOG' => 1,
	'GZIP' => 1,
	'AUTH_KEY' => '',
	'LANG' => 'zh-cn',
	'LOCK_EX' => '1',
	'ADMIN_FOUNDERS' => '1',
	'EXECUTION_SQL' => 0,
	'HTML_ROOT' => '/html',
	'MOBILE_ROOT' => '/mobile',
	'CONNECT_ENABLE' => 1,
	'SINA_AKEY' => '',
	'SINA_SKEY' => '',
	'QQ_APPKEY' => '',
	'QQ_APPID' => '',
	'QQ_CALLBACK' => '',
	'KEYWORDAPI' => '0',
	'BAIDU_AID' => '',
	'BAIDU_SKEY' => '',
	'BAIDU_ARCRETKEY' => '',
	'BAIDU_QCNUM' => '10',
	'XUNFEI_AID' => '',
	'XUNFEI_SKEY' => '',
	'ADMIN_LOGIN_PATH' => '',
);
if (is_file(CONFIGPATH.'system.php')) {
	$my = require CONFIGPATH.'system.php';
} else {
	$my = array();
}

foreach ($system as $var => $value) {
	if (!defined($var)) {
		define($var, isset($my[$var]) ? $my[$var] : $value);
	}
}
unset($my, $system);*/

// 设置时区
define('SYS_TIMEZONE', pc_base::load_config('system','timezone'));
if (is_numeric(SYS_TIMEZONE) && strlen(SYS_TIMEZONE) > 0) {
	function_exists('date_default_timezone_set') && date_default_timezone_set('Etc/GMT'.(SYS_TIMEZONE > 0 ? '-' : '+').abs(SYS_TIMEZONE)); // 设置时区
}

define('CHARSET', pc_base::load_config('system','charset'));
//输出页面字符集
header('Content-Type: text/html; charset='.CHARSET);

// 定义模板目录
define('SYS_TPL_ROOT', pc_base::load_config('system','tpl_root'));
!defined('TPLPATH') && define('TPLPATH', PC_PATH.SYS_TPL_ROOT);
//网站时间显示格式与date函数一致，默认Y-m-d H:i:s
define('SYS_TIME_FORMAT', pc_base::load_config('system','sys_time_format'));
// 最大栏目数量限制category
!defined('MAX_CATEGORY') && define('MAX_CATEGORY', intval(pc_base::load_config('system','sys_max_category')));
// 后台数据分页显示数量
define('SYS_ADMIN_PAGESIZE', intval(pc_base::load_config('system','sys_admin_pagesize')));
//temp目录
define('TEMPPATH', PC_PATH.'temp/');
//是否来自ajax提交
define('IS_AJAX', (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'));
//是否来自post提交
define('IS_POST', isset($_POST) && count($_POST) ? TRUE : FALSE);
define('IS_AJAX_POST', IS_POST);
//当前系统时间戳
define('SYS_TIME', $_SERVER['REQUEST_TIME'] ? $_SERVER['REQUEST_TIME'] : time());
//百度地图API
define('SYS_BDMAP_API', pc_base::load_config('system','bdmap_api'));
//定义网站根路径
define('WEB_PATH', pc_base::load_config('system','web_path'));
//js 路径
define('JS_PATH', pc_base::load_config('system','js_path'));
//css 路径
define('CSS_PATH', pc_base::load_config('system','css_path'));
//img 路径
define('IMG_PATH', pc_base::load_config('system','img_path'));
//手机js 路径
define('MOBILE_JS_PATH', pc_base::load_config('system','mobile_js_path'));
//手机css 路径
define('MOBILE_CSS_PATH', pc_base::load_config('system','mobile_css_path'));
//手机img 路径
define('MOBILE_IMG_PATH', pc_base::load_config('system','mobile_img_path'));
//动态程序路径
define('APP_PATH', pc_base::load_config('system','app_path'));
//动态程序手机路径
define('MOBILE_PATH', pc_base::load_config('system','mobile_path'));
// 调试器开关
define('SYS_DEBUG', pc_base::load_config('system','debug'));
//编辑器模式
define('SYS_EDITOR', pc_base::load_config('system','sys_editor') ? pc_base::load_config('system','sys_editor') : 0);
//Cookie前缀
define('COOKIE_PRE', pc_base::load_config('system','cookie_pre'));
//Cookie作用域
define('COOKIE_DOMAIN', pc_base::load_config('system','cookie_domain'));
//Cookie作用路径
define('COOKIE_PATH', pc_base::load_config('system','cookie_path'));
//自定义的后台登录地址
define('SYS_ADMIN_PATH', pc_base::load_config('system','admin_login_path') ? pc_base::load_config('system','admin_login_path') : 'login');
//是否需要检查外部访问
define('NeedCheckComeUrl', pc_base::load_config('system','needcheckcomeurl'));
//安全密匙
define('SYS_KEY', pc_base::load_config('system','auth_key'));
//网站语言包
define('SYS_LANGUAGE', pc_base::load_config('system','lang'));
//跨站验证
define('SYS_CSRF', pc_base::load_config('system','sys_csrf'));
//当前模板方案目录
define('SYS_TPL_NAME', pc_base::load_config('system','tpl_name'));
//是否允许在线编辑模板
define('IS_EDIT_TPL', pc_base::load_config('system','tpl_edit'));
//是否记录后台操作日志
define('SYS_ADMIN_LOG', pc_base::load_config('system','admin_log'));
//是否保存错误日志
define('SYS_ERRORLOG', pc_base::load_config('system','errorlog'));
//是否Gzip压缩后输出
define('SYS_GZIP', pc_base::load_config('system','gzip'));
//EXECUTION_SQL
define('SYS_EXECUTION_SQL', pc_base::load_config('system','execution_sql'));
//网站创始人ID
define('ADMIN_FOUNDERS', explode(',', pc_base::load_config('system','admin_founders')));
//生成静态文件路径
define('SYS_HTML_ROOT', pc_base::load_config('system','html_root'));
//生成手机静态文件路径
define('SYS_MOBILE_ROOT', pc_base::load_config('system','mobile_root'));
//站点id
!defined('SITE_ID') && define('SITE_ID', 1);
define('SITE_URL', siteurl(SITE_ID));
define('SITE_MURL', sitemobileurl(SITE_ID));
//是否记录附件使用状态
define('SYS_ATTACHMENT_STAT', pc_base::load_config('system','attachment_stat'));
//附件是否使用分站
define('SYS_ATTACHMENT_FILE', pc_base::load_config('system','attachment_file'));
//是否同步删除附件
define('SYS_ATTACHMENT_DEL', pc_base::load_config('system','attachment_del'));
// 本地附件上传目录和地址
define('SYS_ATTACHMENT_SAVE_ID', pc_base::load_config('system','sys_attachment_save_id'));
define('SYS_ATTACHMENT_CF', pc_base::load_config('system','sys_attachment_cf'));
define('SYS_ATTACHMENT_SAFE', pc_base::load_config('system','sys_attachment_safe'));
define('SYS_ATTACHMENT_PATH', pc_base::load_config('system','sys_attachment_path'));
define('SYS_ATTACHMENT_URL', pc_base::load_config('system','sys_attachment_url'));
define('SYS_ATTACHMENT_SAVE_TYPE', pc_base::load_config('system','sys_attachment_save_type'));
define('SYS_ATTACHMENT_SAVE_DIR', pc_base::load_config('system','sys_attachment_save_dir'));

define('CI_DEBUG', IS_DEV ? 1 : IS_ADMIN && SYS_DEBUG);

// 显示错误提示
IS_ADMIN || IS_DEV ? error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT ^ E_DEPRECATED) : error_reporting(0);

// 显示错误提示
if (CI_DEBUG) {
	ini_set('display_errors', 1);
	// 重置Zend OPcache
	function_exists('opcache_reset') && opcache_reset();
	define('ENVIRONMENT', 'development');
} else {
	ini_set('display_errors', 0);
}

// 缓存变量
$cache = [];
if (is_file(CACHE_PATH.'caches_sms/caches_data/cache.php')) {
	$cache = require CACHE_PATH.'caches_sms/caches_data/cache.php';
	IS_DEV && $cache['SYS_CACHE'] = 0; // 开发者模式下关闭缓存
}
foreach (array(
		'SYS_CACHE',
		'SYS_CACHE_TYPE',
		'SYS_CACHE_SHOW',
		'SYS_CACHE_PAGE',
		'SYS_CACHE_LIST',
		'SYS_CACHE_SEARCH',
		'SYS_CACHE_SMS',
	) as $name) {
	define($name, floatval($cache[$name]));
}
unset($cache);

// API接口项目标识
!defined('IS_API') && define('IS_API', FALSE);

if (SYS_ATTACHMENT_PATH
	&& (strpos(SYS_ATTACHMENT_PATH, '/') === 0 || strpos(SYS_ATTACHMENT_PATH, ':') !== false)
	&& is_dir(SYS_ATTACHMENT_PATH)) {
	// 相对于根目录
	// 附件上传目录
	define('SYS_UPLOAD_PATH', rtrim(SYS_ATTACHMENT_PATH, DIRECTORY_SEPARATOR).'/');
	// 附件访问URL
	define('SYS_UPLOAD_URL', trim(SYS_ATTACHMENT_URL, '/').'/');
} else {
	// 在当前网站目录
	$path = trim(SYS_ATTACHMENT_PATH ? SYS_ATTACHMENT_PATH : 'uploadfile', '/');
	// 附件上传目录
	define('SYS_UPLOAD_PATH', CMS_PATH.$path.'/');
	// 附件访问URL
	define('SYS_UPLOAD_URL', APP_PATH.$path.'/');
}
if (pc_base::load_config('system','sys_avatar_path')
	&& (strpos(pc_base::load_config('system','sys_avatar_path'), '/') === 0 || strpos(pc_base::load_config('system','sys_avatar_path'), ':') !== false)
	&& is_dir(pc_base::load_config('system','sys_avatar_path'))) {
	// 相对于根目录
	// 头像上传目录
	define('SYS_AVATAR_PATH', rtrim(pc_base::load_config('system','sys_avatar_path'), DIRECTORY_SEPARATOR).'/');
	// 头像访问URL
	define('SYS_AVATAR_URL', trim(pc_base::load_config('system','sys_avatar_url'), '/').'/');
} else {
	// 在当前网站目录
	$avatarpath = trim(pc_base::load_config('system','sys_avatar_path') ? pc_base::load_config('system','sys_avatar_path') : 'avatar', '/');
	// 头像上传目录
	define('SYS_AVATAR_PATH', SYS_UPLOAD_PATH.$avatarpath.'/');
	// 头像访问URL
	define('SYS_AVATAR_URL', SYS_UPLOAD_URL.$avatarpath.'/');
}
if (pc_base::load_config('system','sys_thumb_path')
	&& (strpos(pc_base::load_config('system','sys_thumb_path'), '/') === 0 || strpos(pc_base::load_config('system','sys_thumb_path'), ':') !== false)
	&& is_dir(pc_base::load_config('system','sys_thumb_path'))) {
	// 相对于根目录
	// 缩略图上传目录
	define('SYS_THUMB_PATH', rtrim(pc_base::load_config('system','sys_thumb_path'), DIRECTORY_SEPARATOR).'/');
	// 缩略图访问URL
	define('SYS_THUMB_URL', trim(pc_base::load_config('system','sys_thumb_url'), '/').'/');
} else {
	// 在当前网站目录
	$thumbpath = trim(pc_base::load_config('system','sys_thumb_path') ? pc_base::load_config('system','sys_thumb_path') : 'thumb', '/');
	// 缩略图上传目录
	define('SYS_THUMB_PATH', SYS_UPLOAD_PATH.$thumbpath.'/');
	// 缩略图访问URL
	define('SYS_THUMB_URL', SYS_UPLOAD_URL.$thumbpath.'/');
}
/*
 * 重写is_cli
 */
function is_cli(): bool {
	if (stripos(PHP_SAPI, 'cli') !== false || defined('STDIN')) {
		return true;
	}
	return false;
}
if (is_cli()) {
	// CLI命令行模式
	define('ADMIN_URL', 'http://localhost/');
	define('FC_NOW_URL', 'http://localhost/');
	define('FC_NOW_HOST', 'http://localhost/');
	define('DOMAIN_NAME', 'http://localhost/');
	define('WEB_DIR', '/');
	if ($_SERVER["argv"]) {
		foreach ($_SERVER["argv"] as $val) {
			if (strpos($val, '=') !== false) {
				list($name) = explode('=', $val);
				$_GET[$name] = substr($val, strlen($name)+1);
			}
		}
	}
	defined('ENVIRONMENT') && define('ENVIRONMENT', 'testing');
} else {
	// 正常访问模式
	// 当前URL
	$url = 'http';
	if ((defined('IS_HTTPS_FIX') && IS_HTTPS_FIX)
		|| (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
		|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
		|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
		|| (isset($_SERVER['HTTP_FROM_HTTPS']) && $_SERVER['HTTP_FROM_HTTPS'] == 'on')
		|| (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) != 'off')
	) {
		$url.= 's';
	}
	// 主机协议
	define('SITE_PROTOCOL', $url.'://');
	$host = strtolower($_SERVER['HTTP_HOST']);
	if (strpos($host, ':') !== false) {
		list($nhost, $port) = explode(':', $host);
		if ($port == 80) {
			$host = $nhost; // 排除80端口
		}
	}
	$url.= '://'.$host;
	IS_ADMIN && define('ADMIN_URL', $url.'/'); // 优先定义后台域名
	define('FC_NOW_URL', $url.($_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'] : $_SERVER['PHP_SELF'])));
	define('FC_NOW_HOST', $url.'/'); // 域名部分
	define('DOMAIN_NAME', $host); // 当前域名

	// 伪静态字符串
	$uu = isset($_SERVER['HTTP_X_REWRITE_URL']) || trim($_SERVER['REQUEST_URI'], '/') == SELF ? trim($_SERVER['HTTP_X_REWRITE_URL'], '/') : ($_SERVER['REQUEST_URI'] ? trim($_SERVER['REQUEST_URI'], '/') : NULL);
	if (defined('FIX_WEB_DIR') && FIX_WEB_DIR && strpos($uu, FIX_WEB_DIR) !== false &&  strpos($uu, FIX_WEB_DIR) === 0) {
		$uu = trim(substr($uu, strlen(FIX_WEB_DIR)), '/');
		define('WEB_DIR', WEB_PATH.trim(FIX_WEB_DIR, '/').'/');
	} else {
		define('WEB_DIR', WEB_PATH);
	}

	// 以index.php或者?开头的uri不做处理
	$uri = strpos($uu, SELF) === 0 || strpos($uu, '?') === 0 ? '' : $uu;

	// 当前URI
	define('CMSURI', $uri);

	// 根据自定义URL规则来识别路由
	if (!IS_ADMIN && CMSURI && !IS_API) {
		// 自定义URL解析规则
		$routes = [];
		$routes['index\.html(.*)'] = 'index.php?m=content&c=index';
		$routes['404\.html(.*)'] = 'index.php?m=404&uri='.CMSURI;
		$routes['rewrite-test.html(.*)'] = 'index.php?m=content&c=index&a=test';
		if (is_file(CONFIGPATH.'rewrite.php')) {
			$my = require CONFIGPATH.'rewrite.php';
			$my && $routes = array_merge($routes, $my);
		}
		// 正则匹配路由规则
		$is_404 = 1;
		foreach ($routes as $key => $val) {
			$rewrite = $match = []; //(defined('SYS_URL_PREG') && SYS_URL_PREG ? '' : '$')
			if ($key == CMSURI || preg_match('/^'.$key.'$/U', CMSURI, $match)) {
				unset($match[0]);
				// 开始匹配
				$is_404 = 0;
				// 开始解析路由 URL参数模式
				$_GET = [];
				$queryParts = explode('&', str_replace(['index.php?', '/index.php?'], '', $val));
				if ($queryParts) {
					foreach ($queryParts as $param) {
						$item = explode('=', $param);
						$_GET[$item[0]] = $item[1];
						if (strpos($item[1], '$') !== FALSE) {
							$id = (int)substr($item[1], 1);
							$_GET[$item[0]] = isset($match[$id]) ? $match[$id] : $item[1];
						}
					}
				}
				!$_GET['m'] && $_GET['m'] = 'content';
				!$_GET['c'] && $_GET['c'] = 'index';
				// 结束匹配
				break;
			}
		}
		// 自定义路由模式
		if (is_file(CONFIGPATH.'router.php')) {
			require CONFIGPATH.'router.php';
		}
		// 说明是404
		if ($is_404) {
			$_GET['m'] = '404';
			$_GET['uri'] = CMSURI;
		}
	}
}

pc_base::verify();

if(SYS_GZIP && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	ob_start();
}

class pc_base {
	
	/**
	 * 初始化应用程序
	 */
	public static function creat_app() {
		return self::load_sys_class('application');
	}
	/**
	 * 加载系统类方法
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	public static function load_sys_class($classname, $path = '', $initialize = 1) {
			return self::_load_class($classname, $path, $initialize);
	}
	
	/**
	 * 加载应用类方法
	 * @param string $classname 类名
	 * @param string $m 模块
	 * @param intger $initialize 是否初始化
	 */
	public static function load_app_class($classname, $m = '', $initialize = 1) {
		$m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
		if (empty($m)) return false;
		return self::_load_class($classname, 'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'classes', $initialize);
	}
	
	/**
	 * 加载数据模型
	 * @param string $classname 类名
	 */
	public static function load_model($classname) {
		return self::_load_class($classname,'model');
	}
		
	/**
	 * 加载类文件函数
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	private static function _load_class($classname, $path = '', $initialize = 1) {
		static $classes = array();
		if (empty($path)) $path = 'libs'.DIRECTORY_SEPARATOR.'classes';

		$key = md5($path.$classname);
		if (isset($classes[$key])) {
			if (!empty($classes[$key])) {
				return $classes[$key];
			} else {
				return true;
			}
		}
		if (file_exists(PC_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php')) {
			include PC_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php';
			$name = $classname;
			if ($my_path = self::my_path(PC_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php')) {
				include $my_path;
				$name = 'MY_'.$classname;
			}
			if ($initialize) {
				$classes[$key] = new $name;
			} else {
				$classes[$key] = true;
			}
			// 站群系统接入
			if (is_file(CMS_PATH.'api/fclient/sync.php')) {
				$sync = require CMS_PATH.'api/fclient/sync.php';
				if ($sync['status'] == 4) {
					if ($sync['close_url']) {
						redirect($sync['close_url']);
					} else {
						dr_msg(0, L('&#32593;&#31449;&#34987;&#20851;&#38381;'));
					}
				} elseif ($sync['status'] == 3 || ($sync['endtime'] && SYS_TIME > $sync['endtime'])) {
					if ($sync['pay_url']) {
						redirect($sync['pay_url']);
					} else {
						dr_msg(0, L('&#32593;&#31449;&#24050;&#36807;&#26399;'));
					}
				}
			}
			return $classes[$key];
		} else {
			return false;
		}
	}
	
	/**
	 * 加载系统的函数库
	 * @param string $func 函数库名
	 */
	public static function load_sys_func($func) {
		return self::_load_func($func);
	}
	
	/**
	 * 自动加载autoload目录下函数库
	 * @param string $func 函数库名
	 */
	public static function auto_load_func($path='') {
		return self::_auto_load_func($path);
	}
	
	/**
	 * 加载应用函数库
	 * @param string $func 函数库名
	 * @param string $m 模型名
	 */
	public static function load_app_func($func, $m = '') {
		$m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
		if (empty($m)) return false;
		return self::_load_func($func, 'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'functions');
	}
	
	/**
	 * 加载函数库
	 * @param string $func 函数库名
	 * @param string $path 地址
	 */
	private static function _load_func($func, $path = '') {
		static $funcs = array();
		if (empty($path)) $path = 'libs'.DIRECTORY_SEPARATOR.'functions';
		$path .= DIRECTORY_SEPARATOR.$func.'.func.php';
		$key = md5($path);
		if (isset($funcs[$key])) return true;
		if (file_exists(PC_PATH.$path)) {
			include PC_PATH.$path;
		} else {
			$funcs[$key] = false;
			return false;
		}
		$funcs[$key] = true;
		return true;
	}
	
	/**
	 * 加载函数库
	 * @param string $func 函数库名
	 * @param string $path 地址
	 */
	private static function _auto_load_func($path = '') {
		if (empty($path)) $path = 'libs'.DIRECTORY_SEPARATOR.'functions'.DIRECTORY_SEPARATOR.'autoload';
		$path .= DIRECTORY_SEPARATOR.'*.func.php';
		$auto_funcs = glob(PC_PATH.DIRECTORY_SEPARATOR.$path);
		if(!empty($auto_funcs) && is_array($auto_funcs)) {
			foreach($auto_funcs as $func_path) {
				include $func_path;
			}
		}
	}
	/**
	 * 是否有自己的扩展文件
	 * @param string $filepath 路径
	 */
	public static function my_path($filepath) {
		$path = pathinfo($filepath);
		if (file_exists($path['dirname'].DIRECTORY_SEPARATOR.'MY_'.$path['basename'])) {
			return $path['dirname'].DIRECTORY_SEPARATOR.'MY_'.$path['basename'];
		} else {
			return false;
		}
	}
	
	/**
	 * 加载配置文件
	 * @param string $file 配置文件
	 * @param string $key  要获取的配置荐
	 * @param string $default  默认配置。当获取配置项目失败时该值发生作用。
	 * @param boolean $reload 强制重新加载。
	 */
	public static function load_config($file, $key = '', $default = '', $reload = false) {
		static $configs = array();
		if (!$reload && isset($configs[$file])) {
			if (empty($key)) {
				return $configs[$file];
			} elseif (isset($configs[$file][$key])) {
				return $configs[$file][$key];
			} else {
				return $default;
			}
		}
		$path = CONFIGPATH.$file.'.php';
		if (file_exists($path)) {
			$configs[$file] = include $path;
		}
		if (empty($key)) {
			return $configs[$file];
		} elseif (isset($configs[$file][$key])) {
			return $configs[$file][$key];
		} else {
			return $default;
		}
	}

	/**
	 * CSRF Verify
	 */
	public static function verify() {
		if (defined('SYS_CSRF') && !SYS_CSRF) {
			return '';
		} elseif (defined('SYS_CSRF') && SYS_CSRF == 1 && IS_ADMIN) {
			return '';
		} elseif (defined('IS_API') && IS_API) {
			return '';
		} elseif (in_array($_GET['c'], array('attachments'))) {
			return '';
		} elseif (in_array($_GET['a'], array('public_upload_index', 'uploadavatar', 'public_ajax_add_panel', 'public_ajax_delete_panel'))) {
			return '';
		} elseif (defined('IS_INSTALL')) {
			return '';
		}
		if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
			$token =  $_POST['csrf_test_name'];
			$name = 'csrf_token';
			$code_file = CACHE_PATH.'caches_authcode/caches_data/'.md5('1'.$name);
			if (is_file($code_file)) {
				$ft = filemtime($code_file);
				if ($ft) {
					$st = SYS_TIME - $ft;
					if ($st > 1800) {
						unlink($code_file);
						log_message('debug', '缓存（'.$name.'）自动失效（'.FC_NOW_URL.'）超时: '.$st.'秒');
					} else {
						$hash = file_get_contents($code_file);
					}
				}
				unlink($code_file);
			}
			if (!isset($token, $hash) || !hash_equals($hash, $token)) {
				CI_DEBUG && log_message('debug', '跨站验证：'.FC_NOW_URL);
				dr_exit_msg(0, '跨站验证超时请重试', '', array('name' => $name, 'value' => $hash));
			}

			if (isset($token)) {
				unset($token);
			}
			unset($name);
			unset($code_file);
			unset($hash);
		}
	}
}