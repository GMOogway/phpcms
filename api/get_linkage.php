<?php
/**
 * 获取关键字接口
 */
defined('IN_CMS') or exit('No permission resources.');

$pid = (int)$input->get('parent_id');
$code = dr_safe_replace($input->get('code'));
$linkage = dr_linkage_list($code, $pid);

$json = array();
$html = '';
foreach ($linkage as $v) {
	if ($v['pid'] == $pid) {
		$json[] = array(
			'region_id' => $v['ii'],
			'region_name' => $v['name']
		);
	}
}

echo json_encode(array(
	'data' => $json,
	'html' => $html,
), JSON_UNESCAPED_UNICODE);exit;
?>