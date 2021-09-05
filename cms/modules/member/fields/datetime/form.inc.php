	function datetime($field, $value, $fieldinfo) {
		extract(string2array($fieldinfo['setting']));
		$isdatetime = 0;
		$timesystem = 0;
		if($fieldtype=='int') {
			if(!$value) $value = $defaultvalue ? strtotime($defaultvalue) : SYS_TIME;
			$format_txt = $format == 'm-d' ? 'm-d' : $format;
			if($format == 'Y-m-d Ah:i:s') $format_txt = 'Y-m-d h:i:s';
			$value = date($format_txt,$value);
			$isdatetime = strlen($format) > 6 ? 1 : 0;		
		} elseif($fieldtype=='datetime') {
			$isdatetime = 1;
		} elseif($fieldtype=='datetime_a') {
			$isdatetime = 1;
		}
		return form::date("info[$field]",$value,$isdatetime,1,'true',$timesystem,0,1,$is_left,$color);
	}
