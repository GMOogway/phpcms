<?php
/**
 * 获取语音验证码接口
 */
defined('IN_CMS') or exit('No permission resources.');

//生成语音验证码
$cache = pc_base::load_sys_class('cache');
echo dr_get_merge($cache->get_auth_data('code', 1));
$cache->del_auth_data('code', 1)
?>