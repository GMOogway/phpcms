	function images($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$list_str = '';
		if($value) {
			$value = string2array(new_html_entity_decode($value));
			if(is_array($value)) {
				foreach($value as $_k=>$_v) {
					if($show_type && defined('IS_ADMIN') && IS_ADMIN) {
						$list_str .= "<li id='image_{$field}_{$_k}'><div class='preview'><input type='hidden' name='{$field}_url[]' value='{$_v['url']}'><img src='{$_v['url']}' id='thumb_preview'></div><div class='intro'><textarea name='{$field}_alt[]' placeholder='图片描述...' onfocus=\"if(this.value == this.defaultValue) this.value = ''\" onblur=\"if(this.value.replace(' ','') == '') this.value = this.defaultValue;\">{$_v['alt']}</textarea></div><div class='action'><a href='javascript:;' class='img-left'><i class='am-icon-angle-double-left am-icon-fw'></i>左移</a><a href='javascript:;' class='img-right'><i class='am-icon-angle-double-right am-icon-fw'></i>右移</a><a href=\"javascript:remove_div('image_{$field}_{$_k}')\" class='img-del'>".L('remove_out', '', 'content')."</a></div></li>";
					} else {
						$list_str .= "<li id='image_{$field}_{$_k}'><input type='text' name='{$field}_url[]' value='{$_v['url']}' ondblclick='image_priview(this.value);' class='input-text'><input type='text' name='{$field}_alt[]' value='{$_v['alt']}' class='input-textarea' placeholder='图片描述...' onfocus=\"if(this.value == this.defaultValue) this.value = ''\" onblur=\"if(this.value.replace(' ','') == '') this.value = this.defaultValue;\"><a href='javascript:;' class='img-left'><i class='am-icon-angle-double-left am-icon-fw'></i>上移</a><a href='javascript:;' class='img-right'><i class='am-icon-angle-double-right am-icon-fw'></i>下移</a><a href=\"javascript:remove_div('image_{$field}_{$_k}')\" class='img-del'>".L('remove_out', '', 'content')."</a></li>";
					}
				}
			}
		} else {
			$list_str .= "<center><div class='onShow' id='nameTip'>".L('upload_pic_max', '', 'content')." <font color='red'>{$upload_number}</font> ".L('tips_pics', '', 'content')."</div></center>";
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
        <legend>'.L('pic_list').'</legend>';
		if($show_type && defined('IS_ADMIN') && IS_ADMIN) {
			$string .= '<div id="'.$field.'" class="picList">'.$list_str.'</div>';
		} else {
			$string .= '<div id="'.$field.'" class="txtList">'.$list_str.'</div>';
		}
		$string .= '</fieldset><script type="text/javascript">$("#'.$field.'").sortable();</script>
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
		if($show_type && defined('IS_ADMIN') && IS_ADMIN) {
			$string .= $str."<input type='button' class='button' onclick=\"javascript:h5upload('".SELF."', '{$field}_images', '".L('attachment_upload')."','{$field}','change_thumbs','{$p}','content','$this->catid','{$authkey}',".SYS_EDITOR.")\"/ value='".L('select_pic')."'>";
		} else {
		$string .= $str."<input type='button' class='button' onclick=\"javascript:h5upload('".SELF."', '{$field}_images', '".L('attachment_upload')."','{$field}','change_images','{$p}','content','$this->catid','{$authkey}',".SYS_EDITOR.")\"/ value='".L('select_pic')."'>";
		}
		return $string;
	}