<?php
	/**
	 * 返回附件类型图标
	 * @param $file 附件名称
	 * @param $type png为大图标，gif为小图标
	 */
	function file_icon($file,$type = 'png') {
		$ext = fileext($file);
		if ($type!='png') {
			if (is_file(CMS_PATH.'statics/images/ext/'.$ext.'.'.$type)) {
				return IMG_PATH.'ext/'.$ext.'.'.$type;
			} else {
				return IMG_PATH.'ext/blank.'.$type;
			}
		} elseif (is_file(CMS_PATH.'statics/images/ext/'.$ext.'.png')) {
			return IMG_PATH.'ext/'.$ext.'.png';
		} else {
			return IMG_PATH.'ext/do.png';
		}
	}
	
	/**
	 * 附件目录列表，暂时没用
	 * @param $dirpath 目录路径
	 * @param $currentdir 当前目录
	 */
	function file_list($dirpath,$currentdir) {
		$filepath = $dirpath.$currentdir;
		$list['list'] = glob($filepath.DIRECTORY_SEPARATOR.'*');
		if(!empty($list['list'])) rsort($list['list']);
		$list['local'] = str_replace(array(PC_PATH, DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('',DIRECTORY_SEPARATOR), $filepath);
		return $list;
	}
	
	/**
	 * h5upload上传初始化
	 * 初始化h5upload上传中需要的参数
	 * @param $module 模块名称
	 * @param $catid 栏目id
	 * @param $args 传递参数
	 * @param $userid 用户id
	 * @param $groupid 用户组id
	 * @param $isadmin 是否为管理员模式
	 */
	function initupload($module, $catid,$args, $userid, $groupid = '8', $isadmin = '0'){
		$grouplist = getcache('grouplist','member');
		if($isadmin==0 && !$grouplist[$groupid]['allowattachment']) return false;
		extract(geth5init($args));
		if ($file_upload_limit==1) {
			$multi = 'false';
		} else {
			$multi = 'true';
		}
		$sess_id = SYS_TIME;
		$h5_auth_key = md5(SYS_KEY.$sess_id);
		$init = "$(document).ready(function(){
			layui.use(['upload', 'element', 'layer'], function () {
				var upload = layui.upload,element = layui.element,layer = layui.layer;
				upload.render({
					elem:'#file_upload',
					accept:'file',
					field:'file_upload',
					data: {H5UPLOADSESSID : '".$sess_id."',module:'".$module."',catid:'".$catid."',userid:'".$userid."',siteid:'".$siteid."',dosubmit:'1',thumb_width:'".$thumb_width."',thumb_height:'".$thumb_height."',watermark_enable:'".$watermark_enable."',attachment:'".$attachment."',image_reduce:'".$image_reduce."',filetype_post:'".$file_types_post."',h5_auth_key:'".$h5_auth_key."',isadmin:'".$isadmin."',groupid:'".$groupid."'},
					url: '".APP_PATH."index.php?m=attachment&c=attachments&a=h5upload',
					exts: '".$file_types_post."',
					size: ".$file_size_limit.",
					multiple: ".$multi.",
					number: ".$file_upload_limit.",
					before: function (obj) {
						var number = $('#fsUpload .files_row').length;
						if (number >= ".$file_upload_limit.") {
							dr_tips(0, '".str_replace('{file_num}', $file_upload_limit, L('att_upload_num'))."');
							return delete files[index];
						}
						element.progress('progress', '0%');
						dr_tips(1, '上传中……', 999999);
					},
					done: function(json){
						if(json.code == 1){
							dr_tips(json.code, json.msg);
							var data = json.data;
							if(data.id == 0) {
								dr_tips(0, data.url)
								return false;
							}
							if(data.ext == 1) {
								var img = '<div onmouseover=\"layer.tips(\''+data.name+'&nbsp;&nbsp;'+data.size+'\',this,{tips: [1, \'#000\']});\" onmouseout=\"layer.closeAll();\"><span class=\"checkbox\"></span><input type=\"checkbox\" class=\"checkboxes\" name=\"ids[]\" value=\"'+data.id+'\" /><a href=\"javascript:;\" onclick=\"javascript:att_cancel(this,'+data.id+',\'upload\')\" class=\"on\"><div class=\"icon\"></div><img src=\"'+data.url+'\" width=\"80\" id=\"'+data.id+'\" path=\"'+data.url+'\" filename=\"'+data.name+'\"/><i class=\"size\">'+data.size+'</i><i class=\"name\" title=\"'+data.name+'\">'+data.name+'</i></a></div>';
							} else {
								var img = '<div onmouseover=\"layer.tips(\''+data.name+'&nbsp;&nbsp;'+data.size+'\',this,{tips: [1, \'#000\']});\" onmouseout=\"layer.closeAll();\"><span class=\"checkbox\"></span><input type=\"checkbox\" class=\"checkboxes\" name=\"ids[]\" value=\"'+data.id+'\" /><a href=\"javascript:;\" onclick=\"javascript:att_cancel(this,'+data.id+',\'upload\')\" class=\"on\"><div class=\"icon\"></div><img src=\"".IMG_PATH."ext/'+data.ext+'.png\" width=\"80\" id=\"'+data.id+'\" path=\"'+data.url+'\" filename=\"'+data.name+'\"/><i class=\"size\">'+data.size+'</i><i class=\"name\" title=\"'+data.name+'\">'+data.name+'</i></a></div>';
							}
							$.get('index.php?m=attachment&c=attachments&a=h5upload_json&aid='+data.id+'&src='+data.url+'&filename='+data.name+'&size='+data.size);
							$('#fsUpload').append('<div id=\"attachment_'+data.id+'\" class=\"files_row on\"></div>');
							$('#attachment_'+data.id).html(img);
							$('#att-status').append('|'+data.url);
							$('#att-name').append('|'+data.name);
						}else{
							dr_tips(json.code, json.msg);
						}
						$('#progress').hide();
						$('#progress').addClass('fade');
					},
					progress: function(n, elem, e){
						$('#progress').show();
						$('#progress').removeClass('fade');
						element.progress('progress', n + '%');
					}
				});
			});
		})";
		return $init;
	}
	/**
	 * 获取站点配置信息
	 * @param  $siteid 站点id
	 */
	function get_site_setting($siteid) {
		$siteinfo = getcache('sitelist', 'commons');
		return string2array($siteinfo[$siteid]['setting']);
	}
	/**
	 * 读取h5upload配置类型
	 * @param array $args h5上传配置信息
	 */
	function geth5init($args) {
		$args = dr_string2array(dr_authcode($args, 'DECODE'));
		$siteid = param::get_cookie('siteid');
		if(!$siteid) $siteid = get_siteid() ? get_siteid() : 1;
		$site_setting = get_site_setting($siteid);
		$site_allowext = $site_setting['upload_allowext'];
		$file_size_limit = $site_setting['upload_maxsize'];
		/*foreach($args as $k=>$v) {
			$arr[$k] = $v;
		}*/
		$arr['siteid'] = intval($args['siteid']) ? intval($args['siteid']) : intval($siteid);
		$arr['file_upload_limit'] = intval($args['file_upload_limit']) ? intval($args['file_upload_limit']) : 10;
		$arr['file_types_post'] = $args['file_types_post'] ? $args['file_types_post'] : $site_allowext;
		$arr['file_size_limit'] = $file_size_limit ? $file_size_limit : 0;
		$arr['allowupload'] = intval($args['allowupload']);
		$arr['thumb_width'] = intval($args['thumb_width']);
		$arr['thumb_height'] = intval($args['thumb_height']);
		$arr['watermark_enable'] = ($args['watermark_enable']=='') ? 1 : intval($args['watermark_enable']);
		$arr['attachment'] = intval($args['attachment']);
		$arr['image_reduce'] = intval($args['image_reduce']);
		return $arr;
	}
?>