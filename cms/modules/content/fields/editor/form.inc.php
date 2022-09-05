	function editor($field, $value, $fieldinfo) {
		$grouplist = getcache('grouplist','member');
		$_groupid = param::get_cookie('_groupid');
		if ($_groupid) {
			$grouplist = $grouplist[$_groupid];
		}
		extract($fieldinfo);
		extract(string2array($setting));
		$disabled_page = isset($disabled_page) ? $disabled_page : 0;
		// 表单宽度设置
		$width = is_mobile(0) ? '100%' : ($width ? $width : '100%');
		// 表单高度设置
		if(!$height) $height = 300;
		$allowupload = defined('IS_ADMIN') && IS_ADMIN ? 1 : (isset($grouplist['allowattachment']) && $grouplist['allowattachment'] && $allowupload ? 1: 0);
		$value = code2html(strlen($value) ? $value : $defaultvalue);
		//if(!$toolvalue) $toolvalue = '\'Source\',\'Bold\', \'Italic\', \'Underline\'';
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
		return "<div id='{$field}_tip'></div>".'<textarea class="dr_ueditor" name="info['.$field.']" id="'.$field.'" boxid="'.$field.'">'.$value.'</textarea>'.form::editor($field,$toolbar,'content',$this->catid,$color,$allowupload,1,'',$height,$disabled_page,$upload_number,$this->modelid,$toolvalue,$autofloat,$autoheight,$theme,$language,$watermark,$attachment,$image_reduce,$div2p,$enter,$enablesaveimage,$width,$upload_maxsize,$show_bottom_boot,$tool_select_1,$tool_select_2,$tool_select_3,$tool_select_4);
	}
