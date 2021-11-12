	function title($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$style_arr = explode(';',$this->data['style']);
		$style_color = $style_arr[0];
		$style_font_weight = $style_arr[1] ? $style_arr[1] : '';

		$style = 'color:'.$this->data['style'];
		if(!$value) $value = $defaultvalue;
		$errortips = $this->fields[$field]['errortips'];
		$errortips_max = L('title_is_empty');
		if($errortips) $this->formValidator .= '$("#'.$field.'").formValidator({onshow:"",onfocus:"'.$errortips.'"}).inputValidator({min:'.$minlength.',max:'.$maxlength.',onerror:"'.$errortips_max.'"});';
		$str = '<input type="text" style="width:400px;'.($style_color ? 'color:'.$style_color.';' : '').($style_font_weight ? 'font-weight:'.$style_font_weight.';' : '').'" name="info['.$field.']" id="'.$field.'" value="'.$value.'" style="'.$style.'" class="measure-input " onBlur="check_title(\'?m='.(defined('IN_ADMIN') ? 'content' : 'member').'&c=content&a=public_check_title&catid='.$this->catid.'&id='.intval($this->input->get('id')).'\',\''.$field.'\');$.post(\''.WEB_PATH.'api.php?op=get_keywords&sid=\'+Math.random()*5, {data:$(\'#'.$field.'\').val()}, function(data){if(data && $(\'#keywords\').val()==\'\') {$(\'#keywords\').val(data); $(\'#keywords\').tagsinput(\'add\', data);} });" onkeyup="strlen_verify(this, \'title_len\', '.$maxlength.');"/>
		<input type="hidden" name="style_font_weight" id="style_font_weight" value="'.$style_font_weight.'">';
		if(defined('IN_ADMIN')) $str .= '<input type="button" class="button" id="check_title_alt" value="'.L('check_title','','content').'" onclick="$.get(\'?m='.(defined('IN_ADMIN') ? 'content' : 'member').'&c=content&a=public_check_title&catid='.$this->catid.'&id='.intval($this->input->get('id')).'&sid=\'+Math.random()*5, {data:$(\'#'.$field.'\').val()}, function(data){if(data==\'1\') {$(\'#check_title_alt\').val(\''.L('title_repeat').'\');$(\'#check_title_alt\').css(\'background-color\',\'#E7505A\');} else if(data==\'0\') {$(\'#check_title_alt\').val(\''.L('title_not_repeat').'\');$(\'#check_title_alt\').css(\'background-color\',\'#1E9FFF\')}});" style="width:80px;"/><input type="hidden" name="style_color" id="style_color" value="'.$style_color.'"><script type="text/javascript">$(function(){$("#style_color").minicolors({control:$("#style_color").attr("data-control")||"hue",defaultValue:$("#style_color").attr("data-defaultValue")||"",inline:"true"===$("#style_color").attr("data-inline"),letterCase:$("#style_color").attr("data-letterCase")||"lowercase",opacity:$("#style_color").attr("data-opacity"),position:$("#style_color").attr("data-position")||"bottom left",change:function(t,o){t&&(o&&(t+=", "+o),"object"==typeof console&&console.log(t));$("#'.$field.'").css("color",$("#style_color").val())},theme:"bootstrap"})});</script>
		<a href="javascript:;" onclick="set_title_color(\'\');$(\'.minicolors-swatch-color\').css(\'background\',\'\');">'.L('清空').'</a>
		<img src="'.IMG_PATH.'icon/bold.png" width="10" height="10" onclick="input_font_bold()" style="cursor:hand"/> ';
		$str .= L('can_enter').'<B><span id="title_len">'.$maxlength.'</span></B> '.L('characters');
		return $str;
	}
