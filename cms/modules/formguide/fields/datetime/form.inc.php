	function datetime($field, $value, $fieldinfo) {
		extract(string2array($fieldinfo['setting']));
		$isdatetime = 0;
		$timesystem = 0;
		if($fieldtype=='int') {
			if(!$value) $value = $defaultvalue ? strtotime($defaultvalue) : SYS_TIME;
			$format_txt = $format == 'm-d' ? 'm-d' : $format;
			$value = date($format_txt,$value);
			$isdatetime = strlen($format) > 6 ? 1 : 0;
		} elseif($fieldtype=='datetime') {
			$isdatetime = 1;
		}
		return form::date("info[$field]",$value,$isdatetime,1,'true',$timesystem,0,1,$is_left,$color);
	}
