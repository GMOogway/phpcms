	function datetime($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		if($setting['fieldtype']=='int') {
			if($setting['format']) {
				$value = dr_date($value, 'Y-m-d h:i:s');
			} else {
				$value = dr_date($value, 'Y-m-d');
			}
			if(!$value) $value = $setting['format'] ? dr_date(SYS_TIME, 'Y-m-d H:i:s') : dr_date(SYS_TIME, 'Y-m-d');
		} elseif($setting['fieldtype']=='varchar') {
			if(!$value) $value = $setting['format2'] ? dr_date(SYS_TIME, 'H:i:s') : dr_date(SYS_TIME, 'H:i');
		}
		return $value;
	}
