<?php
/**
 * 获取语音验证码接口
 */
defined('IN_CMS') or exit('No permission resources.');

//生成语音验证码
echo dr_get_merge(param::get_cookie('code'));
?>