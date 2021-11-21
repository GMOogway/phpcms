	function editor($field, $value, $fieldinfo) {
		//是否允许用户上传附件 ，后台管理员开启此功能
		extract($fieldinfo);
		extract(string2array($setting));
		// 表单宽度设置
		$width = is_mobile(0) ? '100%' : ($width ? $width : '100%');
		// 表单高度设置
		if(!$height) $height = 300;
		$allowupload = defined('IN_ADMIN') || $allowupload ? 1 : 0;
		$value = code2html(strlen($value) ? $value : $defaultvalue);
		if($minlength || $pattern) $allow_empty = '';
		if (SYS_EDITOR) {
			if($minlength) $this->checkall .= 'if(CKEDITOR.instances.'.$field.'.getData()==""){
				Dialog.alert("'.$errortips.'",function(){editor.focus();})
				return false;
			}';
		} else {
			if($minlength) $this->checkall .= 'if(UE.getEditor("'.$field.'").getContent()==""){
				Dialog.alert("'.$errortips.'",function(){UE.getEditor("'.$field.'").focus();})
				return false;
			}';
		}
		return "<div id='{$field}_tip'></div>".'<textarea class="dr_ueditor" name="info['.$field.']" id="'.$field.'" boxid="'.$field.'">'.$value.'</textarea>'.form::editor($field,$toolbar,$toolvalue,'member','','',$allowupload,1,'',$height,'',$autofloat,$autoheight,$theme,$watermark,$attachment,$image_reduce,$div2p,$enter,$simpleupload,$enablesaveimage,$width);
	}
