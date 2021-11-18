	function downfile($field, $value, $fieldinfo) {
		$list_str = $str = '';
		extract(string2array($fieldinfo['setting']));
		if($value){
			$value_arr = explode('|',$value);
			$value = $value_arr['0'];
			$sel_server = $value_arr['1'] ? explode(',',$value_arr['1']) : '';
			$edit = 1;
		} else {
			$edit = 0;
		}
		$server_list = getcache('downservers','commons');
		if(is_array($server_list)) {
			foreach($server_list as $_k=>$_v) {
				if (in_array($_v['siteid'],array(0,$fieldinfo['siteid']))) {
					$checked = $edit ? ((is_array($sel_server) && in_array($_k,$sel_server)) ? ' checked' : '') : ' checked';
					$list_str .= "<lable id='downfile{$_k}' class='ib lh24' style='width:25%'><input type='checkbox' value='{$_k}' name='{$field}_servers[]' {$checked}>  {$_v['sitename']}</lable>";
				}
			}
		}
	
		$string = '
		<fieldset class="blue pad-10">
        <legend>'.L('mirror_server_list').'</legend>';
		$string .= $list_str;
		$string .= '</fieldset>
		<div class="bk10"></div>
		';	
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'h5upload/h5editor.js"></script>';
			define('IMAGES_INIT', 1);
		} else {
			$str = '';
		}
		$authkey = upload_key($this->input->get('siteid').",$upload_number,$upload_allowext,$isselectimage,,,,$attachment,$image_reduce");
		$p = dr_authcode(array(
			'siteid' => $this->input->get('siteid'),
			'file_upload_limit' => $upload_number,
			'file_types_post' => $upload_allowext,
			'allowupload' => $isselectimage,
			'thumb_width' => '',
			'thumb_height' => '',
			'watermark_enable' => '',
			'attachment' => $attachment,
			'image_reduce' => $image_reduce,
		), 'ENCODE');
		$string .= $str."<input type='text' name='info[$field]' id='$field' value='$value' class='input-text' style='width:80%'/>  <input type='button' class='button' onclick=\"javascript:h5upload('".SELF."', '{$field}_downfield', '".L('attachment_upload')."','{$field}','submit_files','{$p}','content','$this->catid','{$authkey}',".SYS_EDITOR.")\"/ value='".L('upload_soft')."'>";
		return $string;
	}
