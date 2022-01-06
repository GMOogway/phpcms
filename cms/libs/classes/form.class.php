<?php
class form {
	/**
	 * 编辑器
	 * @param int $textareaid
	 * @param string $toolbar
	 * @param string $toolvalue
	 * @param string $module 模块名称
	 * @param int $catid 栏目id
	 * @param int $color 编辑器颜色
	 * @param boole $allowupload  是否允许上传
	 * @param boole $allowbrowser 是否允许浏览文件
	 * @param string $alowuploadexts 允许上传类型
	 * @param string $height 编辑器高度
	 * @param string $disabled_page 是否禁用分页和子标题
	 * @param string $autofloat
	 * @param string $autoheight
	 * @param string $theme
	 * @param string $watermark
	 * @param string $attachment
	 * @param string $image_reduce
	 * @param string $div2p
	 * @param string $enter
	 * @param string $enablesaveimage
	 * @param string $allowuploadnum
	 * @param string $upload_maxsize
	 * @param string $show_bottom_boot
	 * @param string $tool_select_1
	 * @param string $tool_select_2
	 * @param string $tool_select_3
	 * @param string $tool_select_4
	 * @param string $field
	 */
	public static function editor($textareaid = 'content', $toolbar = 'basic', $toolvalue = '', $module = '', $catid = '', $color = '', $allowupload = 0, $allowbrowser = 1,$alowuploadexts = '',$height = 300,$disabled_page = 0, $autofloat = 0, $autoheight = 0, $theme = '', $watermark = 1, $attachment = 0, $image_reduce = '', $div2p = 0, $enter = 0, $simpleupload = 0, $enablesaveimage = 1, $width = '100%', $allowuploadnum = '10', $upload_maxsize = 0, $show_bottom_boot = 0, $tool_select_1 = 0, $tool_select_2 = 0, $tool_select_3 = 0, $tool_select_4 = 0, $field = '') {
		$input = pc_base::load_sys_class('input');
		$siteid = $input->get('siteid') ? $input->get('siteid') : param::get_cookie('siteid');
		if(!$siteid) $siteid = get_siteid() ? get_siteid() : 1 ;
		if ($autofloat) {
			$autoFloatEnabled = 'true';
		} else {
			$autoFloatEnabled = 'false';
		}
		if ($autoheight) {
			$autoHeightEnabled = 'true';
		} else {
			$autoHeightEnabled = 'false';
		}
		$show_page = ($module == 'content' && !$disabled_page) ? 'true' : 'false';
		if($allowupload) {
			$authkey = upload_key("$siteid,$allowuploadnum,$alowuploadexts,$upload_maxsize,$allowbrowser,,,$watermark,$attachment,$image_reduce");
			$p = dr_authcode(array(
				'siteid' => $siteid,
				'file_upload_limit' => $allowuploadnum,
				'file_types_post' => $alowuploadexts,
				'size' => $upload_maxsize,
				'allowupload' => $allowbrowser,
				'thumb_width' => '',
				'thumb_height' => '',
				'watermark_enable' => $watermark,
				'attachment' => $attachment,
				'image_reduce' => $image_reduce,
			), 'ENCODE');
		}
		$str ='';
		if (SYS_EDITOR) {
			if(!defined('EDITOR_INIT')) {
				$str = '<script type="text/javascript" src="'.JS_PATH.'ckeditor/ckeditor.js"></script>';
				define('EDITOR_INIT', 1);
			}
			if($toolbar == 'basic') {
				$tool = defined('IS_ADMIN') && IS_ADMIN ? "['Source']," : '';
				$tool .= "['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],['Maximize'],\r\n";
			} elseif($toolbar == 'full') {
				if(defined('IS_ADMIN') && IS_ADMIN) {
					$tool = "['Source',";
				} else {
					$tool = '[';
				}
				$tool .= "'-','Templates'],
				['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
				['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['ShowBlocks'],['Image','Capture','Html5video'],['Maximize'],
				'/',
				['Bold','Italic','Underline','Strike','-'],
				['Subscript','Superscript','-'],
				['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
				['Link','Unlink','Anchor'],
				['Table','HorizontalRule','Smiley','SpecialChar'";
				if ($show_page=="true") {
					$tool .= ",'PageBreak'";
				}
				$tool .= "],
				'/',
				['Styles','Format','Font','FontSize'],
				['TextColor','BGColor'],\r\n";
			} elseif($toolbar == 'desc') {
				$tool = "['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Image', '-','Source'],['Maximize'],\r\n";
			} elseif($toolbar == 'standard') {
				if(defined('IS_ADMIN') && IS_ADMIN) {
					$tool = "['Source',";
				} else {
					$tool = '[';
				}
				$tool .= "'Undo', 'Redo', 'Bold', 'Italic', 'Underline', 'Superscript', 'Subscript', 'RemoveFormat','BlockQuote', 'SelectAll', 'Font', 'FontSize', '|', 'Indent', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'Link', 'Unlink', 'Anchor', '|', 'Image'";
				if ($show_page=="true") {
					$tool .= ", 'PageBreak'";
				}
				$tool .= "],['Maximize'],\r\n";
			} else {
				if(defined('IS_ADMIN') && IS_ADMIN) {
					$tool = "['Source',";
				} else {
					$tool = '[';
				}
				$tool .= "" . $toolvalue . "],['Maximize'],\r\n";
			}
			$str .= "<script type=\"text/javascript\">\r\n";
			$str .= "var editor = CKEDITOR.replace('$textareaid', {";
			$str .= "on:{";
			$str .= "change:function(evt){";
			$str .= "$('#".$textareaid."').html(evt.editor.getData());";
			$str .= "}";
			$str .= "},";
			$str .= "width:\"".$width."\",";
			$str .= "height:{$height},";
			$str .="textareaid:'".$textareaid."',module:'".$module."',catid:'".$catid."',\r\n";
			if($allowupload) $str .= "filebrowserUploadUrl : '".SELF."?m=attachment&c=attachments&a=upload&module=".$module."&catid=".$catid."&dosubmit=1&args=".$p."&authkey=".$authkey."',\r\n";
			if($color) {
				$str .= "uiColor: '$color',";
			}
			$str .= "toolbar :\r\n";
			$str .= "[\r\n";
			$str .= $tool;
			$str .= "]\r\n";
			$str .= "});\r\n";
			$str .= '</script>';
		} else {
			if(!defined('EDITOR_INIT')) {
				$str .= '<script type="text/javascript" src="'.JS_PATH.'ueditor/ueditor.config.js"></script>';
				$str .= '<script type="text/javascript" src="'.JS_PATH.'ueditor/ueditor.all.js"></script>';
				define('EDITOR_INIT', 1);
			}
			if($toolbar == 'basic') {
				$tool = defined('IS_ADMIN') && IS_ADMIN ? "['Source'," : '[';
				$tool .= "'Bold', 'Italic', '|', 'InsertOrderedList', 'InsertUnorderedList', '|', 'Link', 'Unlink' ]";
			} elseif($toolbar == 'standard') {
				if(defined('IS_ADMIN') && IS_ADMIN) {
					$tool = "['Source',";
				} else {
					$tool = '[';
				}
				$tool .= "'FullScreen', 'Undo', 'Redo', '|', 'Bold', 'Italic', 'Underline', 'StrikeThrough', 'Superscript', 'Subscript', 'RemoveFormat', 'FormatMatch', 'AutoTypeSet', '|', 'BlockQuote', '|', 'PastePlain', '|', 'ForeColor', 'BackColor', 'InsertOrderedList', 'InsertUnorderedList', 'SelectAll', 'ClearDoc', '|', 'CustomStyle', 'Paragraph', '|', 'RowSpacingTop', 'RowSpacingBottom', 'LineHeight', '|', 'FontFamily', 'FontSize', '|', 'DirectionalityLtr', 'DirectionalityRtl', '|', '', 'Indent', '|', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyJustify', '|', 'Link', 'Unlink', 'Anchor', '|', 'ImageNone', 'ImageLeft', 'ImageRight', 'ImageCenter', '|', 'SimpleUpload', 'InsertImage', 'Emotion', 'Scrawl', 'InsertVideo', 'Attachment', 'Map', 'InsertFrame'";
				if ($show_page=="true") {
					$tool .= ", 'PageBreak'";
				}
				$tool .= ", 'HighlightCode', '|', 'Horizontal', 'Date', 'Time', 'Spechars', '|', 'InsertTable', 'DeleteTable', 'InsertParagraphBeforeTable', 'InsertRow', 'DeleteRow', 'InsertCol', 'DeleteCol', 'MergeCells', 'MergeRight', 'MergeDown', 'SplittoCells', 'SplittoRows', 'SplittoCols', '|', 'Print', 'Preview', 'SearchReplace', 'Help']";
			} elseif($toolbar == 'desc') {
				$tool = "['Bold', 'Italic', '|', 'InsertOrderedList', 'InsertUnorderedList', '|', 'Link', 'Unlink', '|', 'SimpleUpload', 'InsertImage', '|', 'Source']";
			} elseif($toolbar == 'full') {
				if(defined('IS_ADMIN') && IS_ADMIN) {
					$tool = "['Source',";
				} else {
					$tool = '[';
				}
				$tool .= "'Fullscreen', '|', 'Undo', 'Redo', '|',
				'Bold', 'Italic', 'Underline', 'Fontborder', 'Strikethrough', 'Superscript', 'Subscript', 'Removeformat', 'Formatmatch', 'Autotypeset', 'Blockquote', 'Pasteplain', '|', 'Forecolor', 'Backcolor', 'Insertorderedlist', 'Insertunorderedlist', 'Selectall', 'Cleardoc', '|',
				'Rowspacingtop', 'Rowspacingbottom', 'Lineheight', '|',
				'Customstyle', 'Paragraph', 'Fontfamily', 'Fontsize', '|',
				'Directionalityltr', 'Directionalityrtl', 'Indent', '|',
				'Justifyleft', 'Justifycenter', 'Justifyright', 'Justifyjustify', '|', 'Touppercase', 'Tolowercase', '|',
				'Link', 'Unlink', 'Anchor', '|', 'Imagenone', 'Imageleft', 'Imageright', 'Imagecenter', '|',
				'Simpleupload', 'Insertimage', 'Emotion', 'Scrawl', 'Insertvideo', 'Attachment', 'Map', 'Insertframe', 'Insertcode'";
				if ($show_page=="true") {
					$tool .= ", 'PageBreak', 'Subtitle'";
				}
				$tool .= ", 'Template', 'Background', '|',
				'Horizontal', 'Date', 'Time', 'Spechars', '|',
				'Inserttable', 'Deletetable', 'Insertparagraphbeforetable', 'Insertrow', 'Deleterow', 'Insertcol', 'Deletecol', 'Mergecells', 'Mergeright', 'Mergedown', 'Splittocells', 'Splittorows', 'Splittocols', 'Charts', '|',
				'Print', 'Preview', 'Searchreplace', 'Help']";
			} else {
				if(defined('IS_ADMIN') && IS_ADMIN) {
					$tool = "['Source',";
				} else {
					$tool = '[';
				}
				$tool .= "'Fullscreen', '|', " . $toolvalue . "]";
			}
			// 低版本浏览器关闭单图上传
			if (preg_match('/Chrome\/([0-9]+)\./iU', $_SERVER['HTTP_USER_AGENT'], $mt)) {
				$chrome = intval($mt[1]);
				if ($chrome && $chrome < 78) {
					$tool = str_replace(['"Simpleupload", ', ', "Simpleupload"',"'Simpleupload', ", ", 'Simpleupload'", '"Simpleupload",', ',"Simpleupload"',"'Simpleupload',", ",'Simpleupload'"], '', $tool);
				}
			}
			// 后台设置的关闭单图上传
			if (isset($simpleupload) && $simpleupload) {
				$tool = str_replace(['"Simpleupload", ', ', "Simpleupload"',"'Simpleupload', ", ", 'Simpleupload'", '"Simpleupload",', ',"Simpleupload"',"'Simpleupload',", ",'Simpleupload'"], '', $tool);
			}
			$str .= "<script type=\"text/javascript\">\r\n";
			$opt = array();
			if($tool) {$opt[] = "toolbars:[".$tool."]";}
			if($theme && $theme!='default') {$opt[] = "theme:'".$theme."'";}
			$opt[] = "initialFrameWidth:\"".$width."\"";
			$opt[] = "initialFrameHeight:".$height;
			$opt[] = "autoHeightEnabled:".$autoHeightEnabled;
			$opt[] = "autoFloatEnabled:".$autoFloatEnabled;
			$opt[] = "allowDivTransToP:".($div2p ? 'true' : 'false');
			$enter ? $opt[] = "enterTag:'br'" : '';
			$str .= "var editor = new baidu.editor.ui.Editor({UEDITOR_HOME_URL:'".WEB_PATH."statics/js/ueditor/',serverUrl:'".WEB_PATH."api.php?op=controller&module=".$module."&catid=".$catid."&is_wm=".intval($watermark)."&is_esi=".intval($enablesaveimage)."&attachment=".intval($attachment)."&image_reduce=".intval($image_reduce)."&siteid=".intval($siteid)."',".join(",",$opt)."});editor.render('$textareaid');\n";
			$str .= '</script>';
		}
		if (isset($show_bottom_boot) && $show_bottom_boot) {
			$ext_str .= '<div class="mt-checkbox-inline" style="margin-top: 10px;">';
			$ext_str .= '
				 <label style="margin-bottom: 5px;" class="mt-checkbox mt-checkbox-outline">
				  <input name="is_auto_description_'.$field.'" type="checkbox" '.($tool_select_1 ? 'checked' : '').' value="1"> '.L('提取内容').' <span></span>
				 </label><label style="width: 80px;margin-right: 15px;"><input type="text" name="auto_description_'.$field.'" value="200" class="form-control" style="width: 80px;"></label><label style="margin-right: 15px;">'.L('作为描述信息').'</label>';
			$ext_str .= '     <label style="margin-bottom: 5px;" class="mt-checkbox mt-checkbox-outline">
				  <input name="is_auto_thumb_'.$field.'" type="checkbox" '.($tool_select_2 ? 'checked' : '').' value="1"> '.L('提取第').' <span></span>
				 </label><label style="width: 80px;margin-right: 15px;"><input type="text" name="auto_thumb_'.$field.'" value="1" class="form-control" style="width: 80px;"></label><label style="margin-right: 15px;">'.L('个图片为缩略图').'</label>';
			if (!intval($enablesaveimage)) {
				$ext_str .= '
				 <label style="margin-bottom: 5px;" class="mt-checkbox mt-checkbox-outline">
				  <input name="is_auto_down_img_'.$field.'" type="checkbox" '.($tool_select_3 ? 'checked' : '').' value="1"> '.L('下载远程图片').' <span></span>
				 </label>';
			}
			$ext_str .= '
				 <label style="margin-bottom: 5px;" class="mt-checkbox mt-checkbox-outline">
				  <input name="is_remove_a_'.$field.'" type="checkbox" '.($tool_select_4 ? 'checked' : '').' value="1"> '.L('去除站外链接').' <span></span>
				 </label>';
			$ext_str .= '</div>';
		}
		$ext_str .= "<div class='editor_bottom'>";
		if(!defined('IMAGES_INIT')) {
			$ext_str .= '<script type="text/javascript" src="'.JS_PATH.'h5upload/h5editor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$ext_str .= "<div class='cke_footer'>";
		if ($show_page=="true") {
			$ext_str .= "<a href='javascript:insert_page(\"$textareaid\")'>".L('pagebreak')."</a><a href='javascript:insert_page_title(\"$textareaid\")'>".L('subtitle')."</a>";
		}
		if($allowupload) {
			$ext_str.="<a onclick=\"h5upload('".SELF."', 'h5upload', '".L('attachmentupload')."','{$textareaid}','','{$p}','{$module}','{$catid}','{$authkey}',".SYS_EDITOR.");return false;\" href=\"javascript:void(0);\">".L('attachmentupload')."</a>";
		}
		$ext_str .= "</div>";
		if ($show_page=="true") {
			$ext_str .= "<div id='page_title_div'><div class='title'>".L('subtitle')."<span id='msg_page_title_value'></span><a class='close' href='javascript:;' onclick='javascript:$(\"#page_title_div\").hide();'><span>×</span></a></div><div class='page_content'><input name='page_title_value' id='page_title_value' class='input-text' value='' size='28'>&nbsp;<input type='button' class='button' value='".L('submit')."' onclick=insert_page_title(\"$textareaid\",1)></div></div>";
		}
		$ext_str .= "</div>";
		if(is_ie()) $ext_str .= "<div style='display:none'><OBJECT id='PC_Capture' classid='clsid:021E8C6F-52D4-42F2-9B36-BCFBAD3A0DE4'><PARAM NAME='_Version' VALUE='0'><PARAM NAME='_ExtentX' VALUE='0'><PARAM NAME='_ExtentY' VALUE='0'><PARAM NAME='_StockProps' VALUE='0'></OBJECT></div>";
		$str .= $ext_str;
		return $str;
	}
	
	/**
	 * 
	 * @param string $name 表单名称
	 * @param int $id 表单id
	 * @param string $value 表单默认值
	 * @param string $moudle 模块名称
	 * @param int $catid 栏目id
	 * @param int $size 表单大小
	 * @param string $class 表单风格
	 * @param string $ext 表单扩展属性 如果 js事件等
	 * @param string $alowexts 允许图片格式
	 * @param array $thumb_setting 
	 * @param int $watermark_setting  0或1
	 * @param int $attachment
	 * @param int $image_reduce
	 */
	public static function images($name, $id = '', $value = '', $moudle='', $catid='', $size = 50, $class = '', $ext = '', $alowexts = '',$thumb_setting = array(),$watermark_setting = 0,$attachment = 0, $image_reduce = '', $upload_maxsize = 0) {
		$input = pc_base::load_sys_class('input');
		$siteid = $input->get('siteid') ? $input->get('siteid') : param::get_cookie('siteid');
		if(!$siteid) $siteid = get_siteid() ? get_siteid() : 1 ;
		if(!$id) $id = $name;
		if(!$size) $size= 50;
		if(!empty($thumb_setting) && count($thumb_setting)) $thumb_ext = $thumb_setting[0].','.$thumb_setting[1];
		else $thumb_ext = ',';
		if(!$alowexts) $alowexts = 'jpg|jpeg|gif|bmp|png';
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'h5upload/h5editor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$value = new_html_special_chars($value);
		$authkey = upload_key("$siteid,1,$alowexts,$upload_maxsize,1,$thumb_ext,$watermark_setting,$attachment,$image_reduce");
		$p = dr_authcode(array(
			'siteid' => $siteid,
			'file_upload_limit' => 1,
			'file_types_post' => $alowexts,
			'size' => $upload_maxsize,
			'allowupload' => 1,
			'thumb_width' => isset($thumb_setting[0]) && $thumb_setting[0] ? $thumb_setting[0] : '',
			'thumb_height' => isset($thumb_setting[1]) && $thumb_setting[1] ? $thumb_setting[1] : '',
			'watermark_enable' => $watermark_setting,
			'attachment' => $attachment,
			'image_reduce' => $image_reduce,
		), 'ENCODE');
		return $str."<label><input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"".($class ? $class : 'form-control input-xlarge')."\" $ext/></label> <label><button type=\"button\" onclick=\"javascript:h5upload('".SELF."', '{$id}_images', '".L('attachmentupload')."','{$id}','submit_images','{$p}','{$moudle}','{$catid}','{$authkey}',".SYS_EDITOR.")\" class=\"btn green\"> <i class=\"fa fa-plus\"></i> ".L('imagesupload')."</button></label>";
	}

	/**
	 * 
	 * @param string $name 表单名称
	 * @param int $id 表单id
	 * @param string $value 表单默认值
	 * @param string $moudle 模块名称
	 * @param int $catid 栏目id
	 * @param int $size 表单大小
	 * @param string $class 表单风格
	 * @param string $ext 表单扩展属性 如果 js事件等
	 * @param string $alowexts 允许上传的文件格式
	 * @param array $file_setting 
	 * @param int $attachment
	 * @param int $image_reduce
	 */
	public static function upfiles($name, $id = '', $value = '', $moudle='', $catid='', $size = 50, $class = '', $ext = '', $alowexts = '',$file_setting = array(),$attachment = 0, $image_reduce = '', $upload_maxsize = 0) {
		$input = pc_base::load_sys_class('input');
		$siteid = $input->get('siteid') ? $input->get('siteid') : param::get_cookie('siteid');
		if(!$siteid) $siteid = get_siteid() ? get_siteid() : 1 ;
		if(!$id) $id = $name;
		if(!$size) $size= 50;
		if(!empty($file_setting) && count($file_setting)) $file_ext = $file_setting[0].','.$file_setting[1];
		else $file_ext = ',';
		if(!$alowexts) $alowexts = 'rar|zip';
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'h5upload/h5editor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$authkey = upload_key("$siteid,1,$alowexts,$upload_maxsize,1,$file_ext,,$attachment,$image_reduce");
		$p = dr_authcode(array(
			'siteid' => $siteid,
			'file_upload_limit' => 1,
			'file_types_post' => $alowexts,
			'size' => $upload_maxsize,
			'allowupload' => 1,
			'thumb_width' => isset($file_setting[0]) && $file_setting[0] ? $file_setting[0] : '',
			'thumb_height' => isset($file_setting[1]) && $file_setting[1] ? $file_setting[1] : '',
			'watermark_enable' => '',
			'attachment' => $attachment,
			'image_reduce' => $image_reduce,
		), 'ENCODE');
		return $str."<label><input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"".($class ? $class : 'form-control input-xlarge')."\" $ext/></label><label><button type=\"button\" onclick=\"javascript:h5upload('".SELF."', '{$id}_files', '".L('attachmentupload')."','{$id}','submit_attachment','{$p}','{$moudle}','{$catid}','{$authkey}',".SYS_EDITOR.")\" class=\"btn green\"> <i class=\"fa fa-plus\"></i> ".L('filesupload')."</button></label>";
	}
	
	/**
	 * 日期时间控件
	 * 
	 * @param $name 控件name，id
	 * @param $value 选中值
	 * @param $isdatetime 是否显示时间
	 * @param $loadjs 是否重复加载js，防止页面程序加载不规则导致的控件无法显示
	 * @param $showweek 是否显示周，使用，true | false
	 */
	public static function date($name, $value = '', $isdatetime = 0, $loadjs = 0, $showweek = 'true', $timesystem = 1, $modelid = 0, $datepicker = 0, $is_left = 0, $color = '', $width = '') {
		if($value == '0000-00-00 00:00:00') $value = '';
		$id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
		$str = '';
		if($isdatetime==1 || !$isdatetime) {
			// 表单宽度设置
			$width = is_mobile(0) ? '100%' : ($width ? $width : 200);
			// 风格
			$style = 'style="width:'.$width.(is_numeric($width) ? 'px' : '').';"';
			if($loadjs || !defined('CALENDAR_INIT')) {
				if(!defined('CALENDAR_INIT')) {
					define('CALENDAR_INIT', 1);
				}
				$str .= '<link href="'.JS_PATH.'bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
				<link href="'.JS_PATH.'bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
				<script src="'.JS_PATH.'bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
				<script src="'.JS_PATH.'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>';
			}
			$model_db = pc_base::load_model('sitemodel_model');
			$model = $model_db->get_one(array('modelid'=>$modelid));
			$module_setting = dr_string2array($model['setting']);
			$updatetime_select = isset($module_setting['updatetime_select']) && $module_setting['updatetime_select'] ? $module_setting['updatetime_select'] : '';
			defined('ROUTE_M')=='content' && ROUTE_M=='content' && $model && $id == 'updatetime' && $str .= '<input type="hidden" name="old_'.$id.'" value="'.$value.'">';
			// 字段默认值
			//!$value && $value = SYS_TIME;
			if ($value == 'SYS_TIME' || (defined('ROUTE_M')=='content' && ROUTE_M=='content' && $model && $id == 'updatetime')) {
				$value = SYS_TIME;
			} elseif (strpos($value, '-') === 0) {
			} elseif (strpos($value, '-') !== false) {
				$value = strtotime($value);
			}
			$value = $isdatetime ? dr_date($value, 'Y-m-d H:i:s') : dr_date($value, 'Y-m-d');
			$shuru = '<input type="text" name="'.$name.'" id="'.$id.'" '.$style.' value="'.$value.'" class="form-control dateright field_date_'.$id.'">';
			$tubiao = '<span class="input-group-btn">
				<button class="btn default date-set"'.($color ? ' style="color: '.$color.';"' : '').' type="button">
					<i class="fa fa-calendar"></i>
				</button>
			</span>';
			if($datepicker) {
				$str .= '<div class="form-date input-group"><div class="input-group date">';
				$str .= $is_left ? $shuru.$tubiao : $tubiao.$shuru;
				$str .= '</div></div>';
				defined('ROUTE_M')=='content' && ROUTE_M=='content' && $model && $id == 'updatetime' && $str .= '<div class="mt-checkbox-inline"><label class="mt-checkbox mt-checkbox-outline"><input name="no_time"'.(isset($updatetime_select) && $updatetime_select ? ' checked' : '').' class="dr_no_time" type="checkbox" value="1" /> '.L('不更新').'<span></span></label></div>';
			} else {
				$str .= '<div class="formdate"><div class="form-date input-group"><div class="input-group date">';
				$str .= $is_left ? $shuru.$tubiao : $tubiao.$shuru;
				$str .= '</div></div></div>';
				defined('ROUTE_M')=='content' && ROUTE_M=='content' && $model && $id == 'updatetime' && $str .= '<div class="mt-checkbox-inline"><label class="mt-checkbox mt-checkbox-outline"><input name="no_time"'.(isset($updatetime_select) && $updatetime_select ? ' checked' : '').' class="dr_no_time" type="checkbox" value="1" /> '.L('不更新').'<span></span></label></div>';
			}
			if ($isdatetime) {
				// 日期 + 时间
				$str.= '
				<script type="text/javascript">
				$(function(){
					$(".field_date_'.$id.'").datetimepicker({
						format: "yyyy-mm-dd hh:ii:ss",
						autoclose: true,
						todayBtn: "linked"
					});
				});
				</script>
				';
			} else {
				// 日期
				$str.= '
				<script type="text/javascript">
				$(function(){
					$(".field_date_'.$id.'").datepicker({
						format: "yyyy-mm-dd",
						autoclose: true,
						todayBtn: "linked"
					});
				});
				</script>
				';
			}
		}
		if($isdatetime==2 || $isdatetime==3) {
			// 表单宽度设置
			$width = is_mobile(0) ? '100%' : ($width ? $width : 100);
			// 风格
			$style = 'style="width:'.$width.(is_numeric($width) ? 'px' : '').';"';
			$format = (int)$isdatetime==2 ? 'H:i:s' : 'H:i';
			// 字段默认值
			if ($value == 'SYS_TIME') {
				$value = dr_date(SYS_TIME, $format);
			}
			if($loadjs || !defined('CALENDAR_INIT')) {
				if(!defined('CALENDAR_INIT')) {
					define('CALENDAR_INIT', 1);
				}
				$str .= '<link href="'.JS_PATH.'bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
				<script src="'.JS_PATH.'bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>';
			}
			$shuru = '<input type="text" name="'.$name.'" id="'.$id.'" '.$style.' value="'.$value.'" class="form-control timepicker dateright field_time_'.$id.'">';
			$tubiao = '<span class="input-group-btn">
				<button class="btn default"'.($color ? ' style="color: '.$color.';"' : '').' type="button">
					<i class="fa fa-clock-o"></i>
				</button>
			</span>';
			if($datepicker) {
				$str .= '<div class="form-date input-group"><div class="input-group">';
				$str .= $is_left ? $shuru.$tubiao : $tubiao.$shuru;
				$str .= '</div></div>';
			} else {
				$str .= '<div class="formdate"><div class="form-date input-group"><div class="input-group">';
				$str .= $is_left ? $shuru.$tubiao : $tubiao.$shuru;
				$str .= '</div></div></div>';
			}
			$str.= '
			<script>
			$(function(){
				$(".field_time_'.$id.'").timepicker({
					autoclose: true,
					defaultTime:"'.($value ? $value : dr_date(SYS_TIME, $format)).'",
					minuteStep: 1,
					secondStep: 1,
					showSeconds: '.($format == 'H:i:s' ? 'true' : 'false').',
					showMeridian: false
				});
				$(".timepicker").parent(".input-group").on("click", ".input-group-btn", function(e){
					$(this).parent(".input-group").find(".timepicker").timepicker("showWidget");
				});
				$( document ).scroll(function(){
					$(".field_time_'.$id.'").timepicker("place");
				});
			});
			</script>
			';
		}
		return $str;
	}

	/**
	 * 栏目选择
	 * @param string $file 栏目缓存文件名
	 * @param intval/array $catid 别选中的ID，多选是可以是数组
	 * @param string $str 属性
	 * @param string $default_option 默认选项
	 * @param intval $modelid 按所属模型筛选
	 * @param intval $type 栏目类型
	 * @param intval $onlysub 只可选择子栏目
	 * @param intval $siteid 如果设置了siteid 那么则按照siteid取
	 */
	public static function select_category($file = '',$catid = 0, $str = '', $default_option = '', $modelid = 0, $type = -1, $onlysub = 0,$siteid = 0,$is_push = 0) {
		$tree = pc_base::load_sys_class('tree');
		if(!$siteid) $siteid = param::get_cookie('siteid');
		if (!$file) {
			$file = 'category_content_'.$siteid;
		}
		$result = getcache($file,'commons');
		$string = '<label><select '.$str.(!strpos($str,'class') ? ' class="form-control"' : '').'>';
		if($default_option) $string .= "<option value='0'>$default_option</option>";
		//加载权限表模型 ,获取会员组ID值,以备下面投入判断用
		if($is_push=='1'){
			$priv = pc_base::load_model('category_priv_model');
			$user_groupid = param::get_cookie('_groupid') ? param::get_cookie('_groupid') : 8;
		}
		if (is_array($result)) {
			foreach($result as $r) {
 				//检查当前会员组，在该栏目处是否允许投稿？
				if($is_push=='1' and $r['child']=='0'){
					$sql = array('catid'=>$r['catid'],'roleid'=>$user_groupid,'action'=>'add');
					$array = $priv->get_one($sql);
					if(!$array){
						continue;	
					}
				}
				if($siteid != $r['siteid'] || ($type >= 0 && $r['type'] != $type)) continue;
				$r['selected'] = '';
				if(is_array($catid)) {
					$r['selected'] = in_array($r['catid'], $catid) ? 'selected' : '';
				} elseif(is_numeric($catid)) {
					$r['selected'] = $catid==$r['catid'] ? 'selected' : '';
				}
				$r['html_disabled'] = "0";
				if (!empty($onlysub) && $r['child'] != 0) {
					$r['html_disabled'] = "1";
				}
				$categorys[$r['catid']] = $r;
				if($modelid && $r['modelid']!= $modelid ) unset($categorys[$r['catid']]);
			}
		}
		$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>;";
		$str2 = "<optgroup label='\$spacer \$catname'></optgroup>";

		$tree->init($categorys);
		$string .= $tree->get_tree_category(0, $str, $str2);
			
		$string .= '</select></label>';
		return $string;
	}

	public static function select_linkage($keyid = 0, $name = 'parentid', $id ='') {
		$linkage_db = pc_base::load_model('linkage_model');
		$result = $linkage_db->get_one(array('id'=>$keyid));
		$id = $id ? $id : $name;
		return menu_linkage($result['code'],$id,0);
	}
	/**
	 * 下拉选择框
	 */
	public static function select($array = array(), $id = 0, $str = '', $default_option = '') {
		$string = '<select '.$str.(!strpos($str,'class') ? ' class="form-control"' : '').'>';
		$default_selected = (empty($id) && $default_option) ? 'selected' : '';
		if($default_option) $string .= "<option value='' $default_selected>$default_option</option>";
		if(!is_array($array) || count($array)== 0) return false;
		if(is_array($id)) {
			foreach($array as $key=>$value) {
				$selected = in_array($key, $id) ? 'selected' : '';
				$string .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
			}
			$string .= '</select>';
		} else {
			$ids = array();
			if(isset($id)) $ids = explode(',', $id);
			foreach($array as $key=>$value) {
				$selected = in_array($key, $ids) ? 'selected' : '';
				$string .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
			}
			$string .= '</select>';
		}
		return $string;
	}
	
	/**
	 * 复选框
	 * 
	 * @param $array 选项 二维数组
	 * @param $id 默认选中值，多个用 '逗号'分割
	 * @param $str 属性
	 * @param $defaultvalue 是否增加默认值 默认值为 -99
	 * @param $width 宽度
	 */
	public static function checkbox($array = array(), $id = '', $str = '', $defaultvalue = '', $width = 0, $field = '') {
		$string = '';
		$id = trim($id);
		if($id != '') $id = strpos($id, ',') ? explode(',', $id) : array($id);
		if($defaultvalue) $string .= '<input type="hidden" '.$str.' value="-99">';
		$i = 1;
		$string .= '<div class="mt-checkbox-inline">';
		foreach($array as $key=>$value) {
			$key = trim($key);
			$checked = ($id && in_array($key, $id)) ? 'checked' : '';
			$string .= '<label class="mt-checkbox mt-checkbox-outline"';
			if($width) $string .= ' style="width:'.$width.'px"';
			$string .= '>';
			$string .= '<input type="checkbox" '.$str.' id="'.$field.'_'.$i.'" '.$checked.' value="'.new_html_special_chars($key).'"> '.new_html_special_chars($value);
			$string .= '<span></span></label>';
			$i++;
		}
		$string .= '</div>';
		return $string;
	}

	/**
	 * 单选框
	 * 
	 * @param $array 选项 二维数组
	 * @param $id 默认选中值
	 * @param $str 属性
	 */
	public static function radio($array = array(), $id = 0, $str = '', $width = 0, $field = '') {
		$string = '';
		$string .= '<div class="mt-radio-inline">';
		foreach($array as $key=>$value) {
			$checked = trim($id)==trim($key) ? 'checked' : '';
			$string .= '<label class="mt-radio mt-radio-outline"';
			if($width) $string .= ' style="width:'.$width.'px"';
			$string .= '>';
			$string .= '<input type="radio" '.$str.' id="'.$field.'_'.new_html_special_chars($key).'" '.$checked.' value="'.$key.'"> '.$value;
			$string .= '<span></span></label>';
		}
		$string .= '</div>';
		return $string;
	}
	/**
	 * 模板选择
	 * 
	 * @param $style  风格
	 * @param $module 模块
	 * @param $id 默认选中值
	 * @param $str 属性
	 * @param $pre 模板前缀
	 */
	public static function select_template($style, $module, $id = '', $str = '', $pre = '') {
		$tpl_root = SYS_TPL_ROOT;
		$templatedir = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR;
		$confing_path = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.'config.php';
		$localdir = str_replace(array('/', '\\'), '', $tpl_root).'|'.$style.'|'.$module;
		$templates = glob($templatedir.$pre.'*.html');
		if(empty($templates)) {
			$style = 'default';
			$templatedir = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR;
			$confing_path = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.'config.php';
			$localdir = str_replace(array('/', '\\'), '', $tpl_root).'|'.$style.'|'.$module;
			$templates = glob($templatedir.$pre.'*.html');
		}
		if(empty($templates)) return false;
		$files = @array_map('basename', $templates);
		$names = array();
		if(file_exists($confing_path)) {
			$names = include $confing_path;
		}
		$templates = array();
		if(is_array($files)) {
			foreach($files as $file) {
				$key = substr($file, 0, -5);
				$templates[$key] = isset($names['file_explan'][$localdir][$file]) && !empty($names['file_explan'][$localdir][$file]) ? $names['file_explan'][$localdir][$file].'('.$file.')' : $file;
			}
		}
		ksort($templates);
		return self::select($templates, $id, $str,L('please_select'));
	}
	
	/**
	 * 验证码
	 * @param string $id            生成的验证码ID
	 * @param integer $code_len     生成多少位验证码
	 * @param integer $font_size    验证码字体大小
	 * @param integer $width        验证图片的宽
	 * @param integer $height       验证码图片的高
	 * @param string $font          使用什么字体，设置字体的URL
	 * @param string $font_color    字体使用什么颜色
	 * @param string $background    背景使用什么颜色
	 */
	public static function checkcode($id = 'checkcode',$code_len = 4, $font_size = 20, $width = 130, $height = 50, $font = '', $font_color = '', $background = '') {
		if (defined('IS_ADMIN') && IS_ADMIN) {
			$setting = getcache('common','commons');
			$sysadmincodemodel = isset($setting['sysadmincodemodel']) ? (int)$setting['sysadmincodemodel'] : 0;
			$js = '<div id="voices" style="width: 0px; height: 0px; overflow:hidden; text-indent:-99999px;"></div><script type="text/javascript">function voice() {$(\'#voices\').html(\'<audio id="audio" controls="controls" autoplay="autoplay"><source src="'.SITE_PROTOCOL.SITE_HURL.WEB_PATH.'api.php?op=voice&\'+Math.random()+\'" type="audio/mpeg"></audio>\');$(\'#audio\').play();$(\'#captcha\').val(\'\');$(\'#captcha\').focus();}</script>';
			return "<img id='$id' onclick='this.src=this.src+\"&\"+Math.random();".($sysadmincodemodel==1 || $sysadmincodemodel==2 ? 'voice();' : '')."' src='".SITE_PROTOCOL.SITE_HURL.WEB_PATH."api.php?op=checkcode&code_len=$code_len&font_size=$font_size&width=$width&height=$height&font_color=".urlencode($font_color)."&background=".urlencode($background)."' style=\"vertical-align: middle;\">".($sysadmincodemodel==1 || $sysadmincodemodel==2 ? $js : '');
		} else {
			return "<img id='$id' onclick='this.src=this.src+\"&\"+Math.random()' src='".SITE_PROTOCOL.SITE_HURL.WEB_PATH."api.php?op=checkcode&code_len=$code_len&font_size=$font_size&width=$width&height=$height&font_color=".urlencode($font_color)."&background=".urlencode($background)."' style=\"vertical-align: middle;\">";
		}
	}
	/**
	 * url  规则调用
	 * 
	 * @param $module 模块
	 * @param $file 文件名
	 * @param $ishtml 是否为静态规则
	 * @param $id 选中值
	 * @param $str 表单属性
	 * @param $default_option 默认选项
	 */
	public static function urlrule($module, $file, $ishtml, $id, $str = '', $default_option = '') {
		if(!$module) $module = 'content';
		$urlrules = getcache('urlrules_detail','commons');
		$array = array();
		foreach($urlrules as $roleid=>$rules) {
			if($rules['module'] == $module && $rules['file']==$file && $rules['ishtml']==$ishtml) $array[$roleid] = $rules['example'];
		}
		
		return form::select($array, $id,$str,$default_option);
	}
}

?>