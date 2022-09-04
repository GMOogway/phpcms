<?php
defined('IN_CMS') or exit('No permission resources.');

/**
 * 上传附件和上传视频
 */
include "Uploader.class.php";

/* 上传配置 */
$base64 = "upload";
switch (html2code($input->get('action'))) {
    case 'uploadimage':
        $config = array(
            'siteid'=>$CONFIG['siteid'],
            'module'=>$CONFIG['module'],
            'catid'=>$CONFIG['catid'],
            'userid'=>$CONFIG['userid'],
            'isadmin'=>$CONFIG['isadmin'],
            'groupid'=>$CONFIG['groupid'],
            'is_wm'=>$CONFIG['is_wm'],
            'is_esi'=>$CONFIG['is_esi'],
            'attachment'=>intval($CONFIG['attachment']),
            'image_reduce'=>$CONFIG['image_reduce'],
            "pathFormat" => $CONFIG['imagePathFormat'],
            "maxSize" => $CONFIG['imageMaxSize'],
            "allowFiles" => $CONFIG['imageAllowFiles']
        );
        $fieldName = $CONFIG['imageFieldName'];
        break;
    case 'uploadscrawl':
        $config = array(
            'siteid'=>$CONFIG['siteid'],
            'module'=>$CONFIG['module'],
            'catid'=>$CONFIG['catid'],
            'userid'=>$CONFIG['userid'],
            'isadmin'=>$CONFIG['isadmin'],
            'groupid'=>$CONFIG['groupid'],
            'is_wm'=>$CONFIG['is_wm'],
            'is_esi'=>$CONFIG['is_esi'],
            'attachment'=>$CONFIG['attachment'],
            'image_reduce'=>$CONFIG['image_reduce'],
            "pathFormat" => $CONFIG['scrawlPathFormat'],
            "maxSize" => $CONFIG['scrawlMaxSize'],
            "allowFiles" => $CONFIG['scrawlAllowFiles'],
            "oriName" => "scrawl.png"
        );
        $fieldName = $CONFIG['scrawlFieldName'];
        $base64 = "base64";
        break;
    case 'uploadvideo':
        $config = array(
            'siteid'=>$CONFIG['siteid'],
            'module'=>$CONFIG['module'],
            'catid'=>$CONFIG['catid'],
            'userid'=>$CONFIG['userid'],
            'isadmin'=>$CONFIG['isadmin'],
            'groupid'=>$CONFIG['groupid'],
            'is_wm'=>$CONFIG['is_wm'],
            'is_esi'=>$CONFIG['is_esi'],
            'attachment'=>$CONFIG['attachment'],
            'image_reduce'=>$CONFIG['image_reduce'],
            "pathFormat" => $CONFIG['videoPathFormat'],
            "maxSize" => $CONFIG['videoMaxSize'],
            "allowFiles" => $CONFIG['videoAllowFiles']
        );
        $fieldName = $CONFIG['videoFieldName'];
        break;
    case 'uploadword':
        $config = array(
            'siteid'=>$CONFIG['siteid'],
            'module'=>$CONFIG['module'],
            'catid'=>$CONFIG['catid'],
            'userid'=>$CONFIG['userid'],
            'isadmin'=>$CONFIG['isadmin'],
            'groupid'=>$CONFIG['groupid'],
            'is_wm'=>$CONFIG['is_wm'],
            'is_esi'=>$CONFIG['is_esi'],
            'attachment'=>$CONFIG['attachment'],
            'image_reduce'=>$CONFIG['image_reduce'],
            "pathFormat" => $CONFIG['wordPathFormat'],
            "maxSize" => $CONFIG['wordMaxSize'],
            "allowFiles" => $CONFIG['wordAllowFiles']
        );
        $fieldName = $CONFIG['wordFieldName'];
        break;
    case 'uploadfile':
    default:
        $config = array(
            'siteid'=>$CONFIG['siteid'],
            'module'=>$CONFIG['module'],
            'catid'=>$CONFIG['catid'],
            'userid'=>$CONFIG['userid'],
            'isadmin'=>$CONFIG['isadmin'],
            'groupid'=>$CONFIG['groupid'],
            'is_wm'=>$CONFIG['is_wm'],
            'is_esi'=>$CONFIG['is_esi'],
            'attachment'=>$CONFIG['attachment'],
            'image_reduce'=>$CONFIG['image_reduce'],
            "pathFormat" => $CONFIG['filePathFormat'],
            "maxSize" => $CONFIG['fileMaxSize'],
            "allowFiles" => $CONFIG['fileAllowFiles']
        );
        $fieldName = $CONFIG['fileFieldName'];
        break;
    case 'uploadscreen':
        $config = array(
            'siteid'=>$CONFIG['siteid'],
            'module'=>$CONFIG['module'],
            'catid'=>$CONFIG['catid'],
            'userid'=>$CONFIG['userid'],
            'isadmin'=>$CONFIG['isadmin'],
            'groupid'=>$CONFIG['groupid'],
            'is_wm'=>$CONFIG['is_wm'],
            'is_esi'=>$CONFIG['is_esi'],
            'attachment'=>$CONFIG['attachment'],
            'image_reduce'=>$CONFIG['image_reduce'],
            "pathFormat" => $CONFIG['snapscreenPathFormat'],
            "maxSize" => $CONFIG['snapscreenMaxSize'],
            "allowFiles" => $CONFIG['snapscreenAllowFiles']
        );
        $fieldName = $CONFIG['snapscreenFieldName'];
        break;
}

/* 生成上传实例对象并完成上传 */
$up = new Uploader($fieldName, $config, $base64);

/**
 * 得到上传文件所对应的各个参数,数组结构
 * array(
 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
 *     "url" => "",            //返回的地址
 *     "title" => "",          //新文件名
 *     "original" => "",       //原始文件名
 *     "type" => ""            //文件类型
 *     "size" => "",           //文件大小
 * )
 */

/* 返回数据 */
if (html2code($input->get('action'))=='uploadword') {
    $cache_file = $up->getFileInfo();
    $html = readWordToHtml(str_replace(SYS_UPLOAD_URL, SYS_UPLOAD_PATH, $cache_file['url']), $config['module'], $config['userid'], $config['catid'], $config['siteid'], $config['attachment'], $config['image_reduce'], md5(FC_NOW_URL.$input->get_user_agent().$input->ip_address().$config['userid']));
    return success($html);
} else {
    return json_encode($up->getFileInfo(), JSON_UNESCAPED_UNICODE);
}

/** 成功返回
 * @param string $msg         提示信息
 * @param int    $status      状态码
 * @param string $data        返回数据
 * @param int    $json_option json附加
 */
function success($data = '', $msg = '', $status = 1, $json_option = 0) {
	$success['msg'] = $msg;
	$success['status'] = $status;
	$success['data'] = $data;
	$return_data = json_encode($success, $json_option);
	exit($return_data);
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

function readWordToHtml($source, $module, $userid, $catid, $siteid, $attachment, $image_reduce, $rid) {
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
						$imageData = $ele2->getImageStringData(true);
						//$imageData = 'data:' . $ele2->getImageType() . ';base64,' . $imageData;
						$upload = new upload(trim($module),intval($catid),$siteid);
						$upload->set_userid($userid);
						$rt = $upload->base64_image(array(
							'ext' => $ele2->getImageExtension(),
							'content' => base64_decode($imageData),
							'watermark' => intval($input->get('watermark')),
							'attachment' => $upload->get_attach_info(intval($attachment), intval($image_reduce)),
						));
						$data = array();
						if (defined('SYS_ATTACHMENT_CF') && SYS_ATTACHMENT_CF && $rt['data']['md5']) {
							$att_db = pc_base::load_model('attachment_model');
							$att = $att_db->get_one(array('userid'=>$userid,'filemd5'=>$rt['data']['md5'],'fileext'=>$rt['data']['ext'],'filesize'=>$rt['data']['size']));
							if ($att) {
								$data = dr_return_data($att['aid'], 'ok');
								// 删除现有附件
								// 开始删除文件
								$storage = new storage(trim($module),intval($catid),$siteid);
								$storage->delete($upload->get_attach_info((int)$attachment), $rt['data']['file']);
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
						$html .= '<img src="'.$rt['data']['url'].'" title="'.$rt['data']['name'].'" alt="'.$rt['data']['name'].'"/>';
					}
				}
			}
			$html .= '</p>';
		}
	}
	return mb_convert_encoding($html, 'UTF-8', 'GBK');
}