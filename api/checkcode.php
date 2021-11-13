<?php
defined('IN_CMS') or exit('No permission resources.'); 

$session_storage = 'session_'.pc_base::load_config('system','session_storage');
pc_base::load_sys_class($session_storage);
$cache = pc_base::load_sys_class('cache');
$checkcode = pc_base::load_sys_class('checkcode');
if($input->get('width') && intval($input->get('width'))) $checkcode->width = intval($input->get('width'));
if($input->get('height') && intval($input->get('height'))) $checkcode->height = intval($input->get('height'));
if($input->get('code_len') && intval($input->get('code_len'))) $checkcode->code_len = intval($input->get('code_len'));
if($input->get('font_size') && intval($input->get('font_size'))) $checkcode->font_size = intval($input->get('font_size'));
if ($input->get('font_color') && trim(urldecode($input->get('font_color'))) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($input->get('font_color'))))) $checkcode->font_color = trim(urldecode($input->get('font_color')));
if ($input->get('background') && trim(urldecode($input->get('background'))) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($input->get('background'))))) $checkcode->background = trim(urldecode($input->get('background')));
if($checkcode->width > 500 || $checkcode->width < 10) $checkcode->width = 100;
if($checkcode->height > 300 || $checkcode->height < 10) $checkcode->height = 35;
if($checkcode->code_len > 8 || $checkcode->code_len < 2) $checkcode->code_len = 4;
if($checkcode->font_size > 50 || $checkcode->font_size < 14) $checkcode->font_size = 20;
$checkcode->show_code();
$_SESSION['code'] = $checkcode->get_code();
$cache->set_file('code', $_SESSION['code']);