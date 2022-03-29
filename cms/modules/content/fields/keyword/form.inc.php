	function keyword($field, $value, $fieldinfo) {
		// 表单宽度设置
		$width = is_mobile(0) ? '100%' : 400;
		extract($fieldinfo);
		return "<input type='text' name='info[$field]' id='$field' value='$value' style='width:".$width.(is_numeric($width) ? "px" : "").";' {$formattribute} class='form-control {$css}'>";
	}
