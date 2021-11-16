function file($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		extract($setting);
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'h5upload/h5editor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$html = '';
		$authkey = upload_key($this->input->get('siteid').",1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark,$attachment,$image_reduce");
		$p = dr_authcode(array(
			'siteid' => $this->input->get('siteid'),
			'file_upload_limit' => 1,
			'file_types_post' => $upload_allowext,
			'allowupload' => $isselectimage,
			'thumb_width' => $images_width,
			'thumb_height' => $images_height,
			'watermark_enable' => $watermark,
			'attachment' => $attachment,
			'image_reduce' => $image_reduce,
		), 'ENCODE');
		return $str."<input type='text' name='info[$field]' id='$field' value='$value' size='$size' class='input-text' />  <input type='button' class='button' onclick=\"h5upload('".SELF."', '{$field}_downfield', '".L('attachment_upload', '', 'content')."','{$field}','submit_attachment','{$p}','content','$this->catid','$authkey',".SYS_EDITOR.")\"/ value='".L('attachment_upload')."'>";
	}