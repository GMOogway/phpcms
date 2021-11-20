<?php
defined('IN_CMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'bdts_config', 'parentid'=>42, 'm'=>'bdts', 'c'=>'bdts', 'a'=>'config', 'data'=>'', 'icon'=>'fa fa-internet-explorer', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'url_add', 'parentid'=>$parentid, 'm'=>'bdts', 'c'=>'bdts', 'a'=>'url_add', 'data'=>'', 'icon'=>'fa fa-plus', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'log_index', 'parentid'=>$parentid, 'm'=>'bdts', 'c'=>'bdts', 'a'=>'log_index', 'data'=>'', 'icon'=>'fa fa-calendar', 'listorder'=>0, 'display'=>'1'));
$language = array('bdts_config'=>'百度主动推送','url_add'=>'手动推送','log_index'=>'推送日志');
?>