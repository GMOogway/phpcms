	function image($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		extract($setting);
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'h5upload/h5editor.js"></script>';
			define('IMAGES_INIT', 1);
		} else {
			$str = '';
		}
		$authkey = upload_key($this->input->get('siteid').",1,$upload_allowext,$upload_maxsize,$isselectimage,$images_width,$images_height,,$attachment,$image_reduce");
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
		if($show_type) {
			$preview_img = $value ? $value : IMG_PATH.'icon/upload-pic.png';
			return $str."<div class='upload-pic img-wrap'><input type='hidden' name='info[$field]' id='$field' value='$value'>
			<a href='javascript:;' onclick=\"javascript:h5upload('".SELF."', '{$field}_images', '".L('attachment_upload')."','{$field}',thumb_images,'{$p}','member','','{$authkey}',".SYS_EDITOR.")\">
			<img src='$preview_img' id='{$field}_preview' width='135' height='113' style='cursor:hand' /></a></div>";
		} else {
			return $str."<input type='text' name='info[$field]' id='$field' value='$value' size='$size' class='input-text' />  <input type='button' class='button' onclick=\"javascript:h5upload('".SELF."', '{$field}_images', '".L('attachment_upload')."','{$field}','submit_images','{$p}','member','','{$authkey}',".SYS_EDITOR.")\"/ value='".L('image_upload')."'>";
		}
	}
