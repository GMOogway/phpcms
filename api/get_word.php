<?php
/**
 * 获取Word接口
 */
defined('IN_CMS') or exit('No permission resources.');

$userid = $_SESSION['userid'] ? $_SESSION['userid'] : (param::get_cookie('_userid') ? param::get_cookie('_userid') : param::get_cookie('userid'));
$siteid = param::get_cookie('siteid');
$rid = md5(FC_NOW_URL.$input->get_user_agent().$input->ip_address().intval($userid));
if(!$siteid) $siteid = get_siteid() ? get_siteid() : 1 ;

pc_base::load_sys_class('upload','',0);
$module = trim($input->get('module'));
$catid = intval($input->get('catid'));
$upload = new upload($module,$catid,$siteid);
$upload->set_userid($userid);
$site_setting = get_site_setting($siteid);
$upload_maxsize = $site_setting['upload_maxsize'];
$rt = $upload->upload_file(array(
	'path' => '',
	'form_name' => 'file_upload',
	'file_exts' => explode('|', strtolower('docx')),
	'file_size' => $upload_maxsize * 1024 * 1024,
	'attachment' => $upload->get_attach_info(intval($input->get('attachment')), 0),
));
$data = array();
if (defined('SYS_ATTACHMENT_CF') && SYS_ATTACHMENT_CF && $rt['data']['md5']) {
	$att_db = pc_base::load_model('attachment_model');
	$att = $att_db->get_one(array('userid'=>intval($userid),'filemd5'=>$rt['data']['md5'],'fileext'=>$rt['data']['ext'],'filesize'=>$rt['data']['size']));
	if ($att) {
		$data = dr_return_data($att['aid'], 'ok');
		// 删除现有附件
		// 开始删除文件
		$storage = new storage($module,$catid,$siteid);
		$storage->delete($upload->get_attach_info((int)$input->get('attachment')), $rt['data']['file']);
		$rt['data'] = get_attachment($att['aid']);
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
	$title = $rt['data']['filename'] ? $rt['data']['filename'] : $rt['data']['name'];
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
$body = readWordToHtml($rt['data']['path'], $rid);
if (!$body) {
	dr_json(0, L('没有获取到Word内容'));
}

dr_json(1, L('导入成功'), array(
	'file' => $rt['data']['url'],
	'title' => $title,
	'keyword' => dr_get_keywords($title),
	'content' => $body,
));
/**
 * 获取站点配置信息
 * @param  $siteid 站点id
 */
function get_site_setting($siteid) {
	$siteinfo = getcache('sitelist', 'commons');
	return string2array($siteinfo[$siteid]['setting']);
}
/**
 * 设置upload上传的json格式cookie
 */
function upload_json($aid,$src,$filename,$size) {
	$arr['aid'] = intval($aid);
	$arr['src'] = trim($src);
	$arr['filename'] = urlencode($filename);
	$arr['size'] = $size;
	$json_str = json_encode($arr);
	$cache = pc_base::load_sys_class('cache');
	$att_arr_exist = $cache->get_data('att_json');
	$att_arr_exist_tmp = explode('||', $att_arr_exist);
	if(is_array($att_arr_exist_tmp) && in_array($json_str, $att_arr_exist_tmp)) {
		return true;
	} else {
		$json_str = $att_arr_exist ? $att_arr_exist.'||'.$json_str : $json_str;
		$cache->set_data('att_json', $json_str, 3600);
		return true;
	}
}
function readWordToHtml($source, $rid) {
	include_once PC_PATH."plugin/vendor/autoload.php";
	$input = pc_base::load_sys_class('input');
	$phpWord = \PhpOffice\PhpWord\IOFactory::load($source);
	$html = '';
	foreach ($phpWord->getSections() as $section) {
		foreach ($section->getElements() as $ele1) {
			$paragraphStyle = $ele1->getParagraphStyle();
			if ($paragraphStyle) {
				$html .= '<p style="text-align:'. $paragraphStyle->getAlignment() .';text-indent:20px;">';
			} else {
				$html .= '<p>';
			}
			if ($ele1 instanceof \PhpOffice\PhpWord\Element\TextRun) {
				foreach ($ele1->getElements() as $ele2) {
					if ($ele2 instanceof \PhpOffice\PhpWord\Element\Text) {
						$style = $ele2->getFontStyle();
						$fontFamily = mb_convert_encoding($style->getName(), 'GBK', 'UTF-8');
						$fontSize = $style->getSize();
						$isBold = $style->isBold();
						$styleString = '';
						$fontFamily && $styleString .= "font-family:{$fontFamily};";
						$fontSize && $styleString .= "font-size:{$fontSize}px;";
						$isBold && $styleString .= "font-weight:bold;";
						$html .= sprintf('<span style="%s">%s</span>',
							$styleString,
							mb_convert_encoding($ele2->getText(), 'GBK', 'UTF-8')
						);
					} elseif ($ele2 instanceof \PhpOffice\PhpWord\Element\Image) {
						$siteid = param::get_cookie('siteid');
						if(!$siteid) $siteid = get_siteid() ? get_siteid() : 1 ;
						$imageData = $ele2->getImageStringData(true);
						//$imageData = 'data:' . $ele2->getImageType() . ';base64,' . $imageData;
						$module = trim($input->get('module'));
						$upload = new upload(trim($input->get('module')),intval($input->get('catid')),$siteid);
						$upload->set_userid($userid);
						$rt = $upload->base64_image(array(
							'ext' => $ele2->getImageExtension(),
							'content' => base64_decode($imageData),
							'watermark' => intval($input->get('watermark')),
							'attachment' => $upload->get_attach_info(intval($input->get('attachment')), intval($input->get('image_reduce'))),
						));
						$data = array();
						if (defined('SYS_ATTACHMENT_CF') && SYS_ATTACHMENT_CF && $rt['data']['md5']) {
							$att_db = pc_base::load_model('attachment_model');
							$att = $att_db->get_one(array('userid'=>intval($userid),'filemd5'=>$rt['data']['md5'],'fileext'=>$rt['data']['ext'],'filesize'=>$rt['data']['size']));
							if ($att) {
								$data = dr_return_data($att['aid'], 'ok');
								// 删除现有附件
								// 开始删除文件
								$storage = new storage($module,$catid,$siteid);
								$storage->delete($upload->get_attach_info((int)$input->get('attachment')), $rt['data']['file']);
								$rt['data'] = get_attachment($att['aid']);
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
						$html .= '<img src="'.$rt['data']['url'].'" title="'.$rt['data']['name'].'" alt="'.$rt['data']['name'].'"/>';
					}
				}
			}
			$html .= '</p>';
		}
	}
	return mb_convert_encoding($html, 'UTF-8', 'GBK');
}
?>