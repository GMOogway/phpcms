	function linkage($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		$linkage = $setting['linkage'];
		$defaultvalue = $setting['defaultvalue'];
		if(!$value) $value = $defaultvalue;
		return menu_linkage($linkage,$field,$value);
	}
