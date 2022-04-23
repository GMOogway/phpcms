<?php
/**
 * 获取微信文章接口
 */
defined('IN_CMS') or exit('No permission resources.');

$userid = intval($input->get('userid'));
$siteid = intval($input->get('siteid'));
$rid = md5(FC_NOW_URL.$input->get_user_agent().$input->ip_address().$userid);
if(!$siteid) $siteid = get_siteid() ? get_siteid() : 1 ;
$field = $input->get('field');
$fieldname = $input->get('fieldname');
$data = $input->post('info');
$url = $data[$field];
if (!$url) {
	dr_json(0, L($fieldname.'不能为空'));
}

$html = dr_catcher_data($url);
if (!$html) {
	dr_json(0, L('没有获取到任何内容'));
}

$preg = 'id="js_content" style="visibility: hidden;">';
if (preg_match('/'.$preg.'(.+)<\/div>/sU', $html, $mt)) {
	pc_base::load_sys_class('upload','',0);
	$upload = new upload($input->get('module'),intval($input->get('catid')),$siteid);
	$upload->set_userid($userid);
	$body = trim($mt[1]);
	$body = str_replace(array('style="display: none;"', ''), '', $body);
	$body = str_replace('data-src=', 'src=', $body);
	// 下载远程图片
	if (intval($input->get('is_esi')) && preg_match_all("/(src)=([\"|']?)([^ \"'>]+)\\2/i", $body, $imgs)) {
		foreach ($imgs[3] as $img) {
			$ext = get_image_ext($img);
			if (!$ext) {
				continue;
			}
			// 下载图片
			if (intval($input->get('is_esi')) && strpos($img, 'http') === 0) {
				$arr = parse_url($img);
				$domain = $arr['host'];
				if ($domain) {
					$sitedb = pc_base::load_model('site_model');
					$data = $sitedb->select();
					$sites = array();
					foreach ($data as $t) {
						$site_domain = parse_url($t['domain']);
						if ($site_domain['port']) {
							$sites[$site_domain['host'].':'.$site_domain['port']] = $t['siteid'];
						} else {
							$sites[$site_domain['host']] = $t['siteid'];
						}
					}
					if (isset($sites[$domain])) {
						// 过滤站点域名
					} elseif (strpos(SYS_UPLOAD_URL, $domain) !== false) {
						// 过滤附件白名单
					} else {
						if(strpos($img, '://') === false) continue;
						$zj = 0;
						$remote = getcache('attachment', 'commons');
						if ($remote) {
							foreach ($remote as $t) {
								if (strpos($t['url'], $domain) !== false) {
									$zj = 1;
									break;
								}
							}
						}
						if ($zj == 0) {
							// 可以下载文件
							// 下载远程文件
							$rt = $upload->down_file(array(
								'url' => $img,
								'timeout' => 5,
								'watermark' => intval($input->get('watermark')),
								'attachment' => $upload->get_attach_info(intval($input->get('attachment')), intval($input->get('image_reduce'))),
								'file_ext' => $ext,
							));
							$data = array();
							if (defined('SYS_ATTACHMENT_CF') && SYS_ATTACHMENT_CF && $rt['data']['md5']) {
								$att_db = pc_base::load_model('attachment_model');
								$att = $att_db->get_one(array('userid'=>$userid,'filemd5'=>$rt['data']['md5'],'fileext'=>$rt['data']['ext'],'filesize'=>$rt['data']['size']));
								if ($att) {
									$data = dr_return_data($att['aid'], 'ok');
									// 删除现有附件
									// 开始删除文件
									$storage = new storage($input->get('module'),intval($input->get('catid')),$siteid);
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
							$body = str_replace($img, $rt['data']['url'], $body);
						}
					}
				}
			}
		}
	}
} else {
	echo $url;exit;
	dr_json(0, L('没有获取到文章内容'));
}
if (preg_match('/<meta property="og:title" content="(.+)"/U', $html, $mt)) {
	$title = trim($mt[1]);
} else {
	dr_json(0, L('没有获取到文章标题'));
}

dr_json(1, L('导入成功'), array(
	'title' => $title,
	'keyword' => dr_get_keywords($title),
	'content' => $body,
));
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
?>