	function downfiles($field, $value, $fieldinfo) {
		extract(string2array($fieldinfo['setting']));
		$list_str = '';
		if($value) {
			$value = string2array(new_html_entity_decode($value));
			if(is_array($value)) {
				foreach($value as $_k=>$_v) {
				$list_str .= "<li id='multifile{$_k}'><input type='text' name='{$field}_fileurl[]' value='{$_v['fileurl']}' class='input-text'> <input type='text' name='{$field}_filename[]' value='{$_v['filename']}' placeholder='附件说明...' onfocus=\"if(this.value == this.defaultValue) this.value = ''\" onblur=\"if(this.value.replace(' ','') == '') this.value = this.defaultValue;\" class='input-textarea'> <a href='javascript:;' class='img-left btn blue btn-xs'><i class='fa fa-arrow-up'></i></a> <a href='javascript:;' class='img-right btn blue btn-xs'><i class='fa fa-arrow-down'></i></a> <a href=\"javascript:remove_div('multifile{$_k}')\" class=\"btn red btn-xs\"><i class=\"fa fa-trash\"></i></a></li>";
				}
			}
		}
		if(!defined('JQUERYUI_INIT')) {
			$string = '<link rel="stylesheet" href="'.JS_PATH.'jquery-ui/jquery-ui.min.css">
			<script type="text/javascript" src="'.JS_PATH.'jquery-ui/jquery-ui.min.js"></script>';
			define('JQUERYUI_INIT', 1);
		} else {
			$string = '';
		}
		$string .= '<input name="info['.$field.']" type="hidden" value="1">
		<fieldset class="blue pad-10">
        <legend>'.L('file_list').'</legend>';
		$string .= '<ul id="'.$field.'" class="txtList">'.$list_str.'</ul>
		</fieldset><script type="text/javascript">$("#'.$field.'").sortable();</script>
		<div class="bk10"></div>
		';
		
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'h5upload/h5editor.js"></script>';
			define('IMAGES_INIT', 1);
		} else {
			$str = '';
		}
		$authkey = upload_key($this->input->get('siteid').",$upload_number,$upload_allowext,$upload_maxsize,$isselectimage,,,,$attachment,$image_reduce");
		$p = dr_authcode(array(
			'siteid' => $this->input->get('siteid'),
			'file_upload_limit' => $upload_number,
			'file_types_post' => $upload_allowext,
			'size' => $upload_maxsize,
			'allowupload' => $isselectimage,
			'thumb_width' => '',
			'thumb_height' => '',
			'watermark_enable' => '',
			'attachment' => $attachment,
			'image_reduce' => $image_reduce,
		), 'ENCODE');
		$string .= $str."<label><button type=\"button\" onclick=\"javascript:h5upload('".SELF."', '{$field}_multifile', '".L('attachment_upload')."','{$field}','change_multifile','{$p}','content','$this->catid','{$authkey}',".SYS_EDITOR.")\" class=\"btn green btn-sm\"> <i class=\"fa fa-plus\"></i> ".L('multiple_file_list')."</button></label> <label><button type=\"button\" onclick=\"add_multifile('{$field}')\" class=\"btn blue btn-sm\"> <i class=\"fa fa-plus\"></i> ".L('add_remote_url')."</button></label>";
		return $string;
	}
