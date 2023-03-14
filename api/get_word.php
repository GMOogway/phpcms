<?php
/**
 * 获取Word接口
 */
defined('IN_CMS') or exit('No permission resources.');

$userid = intval($input->get('userid'));
$siteid = intval($input->get('siteid'));
$module = trim($input->get('module'));
$catid = intval($input->get('catid'));
$watermark = intval($input->get('watermark'));
$attachment = intval($input->get('attachment'));
$image_reduce = intval($input->get('image_reduce'));
$rid = md5(FC_NOW_URL.$input->get_user_agent().$input->ip_address().$userid);
if(!$siteid) $siteid = get_siteid() ? get_siteid() : 1 ;

pc_base::load_sys_class('upload','',0);
$upload = new upload($module,$catid,$siteid);
$upload->set_userid($userid);
$rt = $upload->upload_file(array(
	'path' => '',
	'form_name' => 'file_upload',
	'file_exts' => explode('|', strtolower('docx')),
	'file_size' => dr_site_value('upload_maxsize', $siteid) * 1024 * 1024,
	'attachment' => $upload->get_attach_info($attachment, 0),
));
$data = array();
if (defined('SYS_ATTACHMENT_CF') && SYS_ATTACHMENT_CF && $rt['data']['md5']) {
	$att_db = pc_base::load_model('attachment_model');
	$att = $att_db->get_one(array('userid'=>$userid,'filemd5'=>$rt['data']['md5'],'fileext'=>$rt['data']['ext'],'filesize'=>$rt['data']['size']));
	if ($att) {
		$data = dr_return_data($att['aid'], 'ok');
		// 删除现有附件
		// 开始删除文件
		$storage = new storage($module,$catid,$siteid);
		$storage->delete($upload->get_attach_info($attachment), $rt['data']['file']);
		$rt['data'] = get_attachment($att['aid']);
		if ($rt['data']) {
			$rt['data']['name'] = $rt['data']['filename'];
		}
	}
}

if (!$data) {
	$data = $upload->save_data($rt['data'], 'ueditor:'.$rid);
	if ($data['code']) {
		// 归档成功
		// 标记附件
		upload_json($data['code'],$rt['data']['url'],$rt['data']['name'],format_file_size($rt['data']['size']));
	}
}

if ($rt && $data) {
	$title = $rt['data']['name'];
} else {
	dr_json(0, L('文件上传失败'));
}
if (!$rt['data']['path'] && $rt['data']['file']) {
	$rt['data']['path'] = $rt['data']['file'];
}
if (!$rt['data']['path']) {
	dr_json(0, L('没有获取到文件内容'));
}
if (!$title) {
	dr_json(0, L('没有获取到文件标题'));
}
$body = readWordToHtml($rt['data']['path'], $module, $userid, $catid, $siteid, $watermark, $attachment, $image_reduce, $rid);
if (!$body) {
	dr_json(0, L('没有获取到Word内容'));
}

dr_json(1, L('导入成功'), array(
	'file' => $rt['data']['url'],
	'title' => $title,
	'keyword' => dr_get_keywords($title),
	'content' => $body,
));
?>