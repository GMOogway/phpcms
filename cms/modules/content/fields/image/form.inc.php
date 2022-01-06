	function image($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		extract($setting);
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'h5upload/h5editor.js"></script>';
			define('IMAGES_INIT', 1);
		} else {
			$str = '';
		}
		$html = '';
		if (defined('IS_ADMIN') && IS_ADMIN) {
			$html = "<label><button type=\"button\" onclick=\"crop_cut_".$field."($('#$field').val());return false;\" class=\"btn blue btn-sm\"> <i class=\"fa fa-cut\"></i> ".L('cut_the_picture','','content')."</button></label> <label><button type=\"button\" onclick=\"$('#".$field."_preview').attr('src','".IMG_PATH."icon/upload-pic.png');$('#".$field."').val('');return false;\" class=\"btn red btn-sm\"> <i class=\"fa fa-trash\"></i> ".L('cancel_the_picture','','content')."</button></label><script type=\"text/javascript\">function crop_cut_".$field."(id){
	if (id=='') { Dialog.alert('".L('upload_thumbnails', '', 'content')."');return false;}
	var w = 770;
	var h = 510;
	if (is_mobile()) {w = h = '100%';}
	var diag = new Dialog({id:'crop',title:'".L('cut_the_picture','','content')."',url:'".SELF."?m=content&c=content&a=public_crop&module=content&catid='+catid+'&spec=2&picurl='+window.btoa(unescape(encodeURIComponent(id)))+'&input=$field&preview=".($show_type && defined('IS_ADMIN') && IS_ADMIN ? $field."_preview" : '')."',width:w,height:h,modal:true});diag.onOk = function(){\$DW.dosbumit();return false;};diag.onCancel=function() {\$DW.close();};diag.show();
};</script>";
		}
		$authkey = upload_key($this->input->get('siteid').",1,$upload_allowext,$upload_maxsize,$isselectimage,$images_width,$images_height,$watermark,$attachment,$image_reduce");
		$p = dr_authcode(array(
			'siteid' => $this->input->get('siteid'),
			'file_upload_limit' => 1,
			'file_types_post' => $upload_allowext,
			'size' => $upload_maxsize,
			'allowupload' => $isselectimage,
			'thumb_width' => $images_width,
			'thumb_height' => $images_height,
			'watermark_enable' => $watermark,
			'attachment' => $attachment,
			'image_reduce' => $image_reduce,
		), 'ENCODE');
		if($show_type && defined('IS_ADMIN') && IS_ADMIN) {
			$preview_img = $value ? $value : IMG_PATH.'icon/upload-pic.png';
			return $str."<div class='upload-pic img-wrap'><input type='hidden' name='info[$field]' id='$field' value='$value'>
			<p><a href='javascript:void(0);' onclick=\"h5upload('".SELF."', '{$field}_images', '".L('attachment_upload', '', 'content')."','{$field}','thumb_images','{$p}','content','$this->catid','$authkey',".SYS_EDITOR.");return false;\">
			<img src='$preview_img' id='{$field}_preview' width='135' height='113' style='cursor:hand' /></a></p>".$html."</div>";
		} else {
			return $str."<label><input type='text' name='info[$field]' id='$field' value='$value' size='$size' class='form-control' /></label> <label><button type=\"button\" onclick=\"h5upload('".SELF."', '{$field}_images', '".L('attachment_upload', '', 'content')."','{$field}','submit_images','{$p}','content','$this->catid','$authkey',".SYS_EDITOR.")\" class=\"btn green\"> <i class=\"fa fa-plus\"></i> ".L('upload_pic', '', 'content')."</button></label>".$html;
		}
	}
