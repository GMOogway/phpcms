<?php
/**
 * 获取联动菜单接口
 */
defined('IN_CMS') or exit('No permission resources.');

$linkage_db = pc_base::load_model('linkage_model');
$code = dr_safe_replace($input->get('code'));
$data = $linkage_db->get_one(array('code'=>$code));
if ($data['style']) {
	$pid = (int)$input->get('parent_id');
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
	exit(dr_array2string(array('data' => $json,'html' => $html)));
} else {
	$linkage = dr_linkage_json($code);
	if (!$linkage) {
		if (CI_DEBUG) {
			$linkage = array(
				array(
					'value' => 0,
					'label' => '请在联动菜单管理，找到【'.$code.'】，点击一键生成按钮',
					'children' => array(),
				)
			);
		} else {
			$linkage = array();
		}
	}
	exit('var linkage_'.$code.' ='.dr_array2string($linkage).';');
}
?>