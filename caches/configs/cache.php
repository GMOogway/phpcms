<?php
if (!defined('IN_CMS')) exit('No direct script access allowed');

return array (
	'file1' => array (
		'type' => 'file',
		'debug' => true,
		'pconnect' => 0,
		'autoconnect' => 0
		),
	'template' => array (
		'hostname' => '210.78.140.2',
		'port' => 11211,
		'timeout' => 0,
		'type' => 'memcache',
		'debug' => true,
		'pconnect' => 0,
		'autoconnect' => 0
	)
);

?>