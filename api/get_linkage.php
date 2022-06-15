<?php
/**
 * 获取联动菜单接口
 */
defined('IN_CMS') or exit('No permission resources.');

$code = dr_safe_replace($input->get('code'));
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
?>