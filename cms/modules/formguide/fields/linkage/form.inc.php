	function linkage($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		$linkage = $setting['linkage'];
		$defaultvalue = $setting['defaultvalue'];
		$ck_child = $setting['ck_child'];
		if(!$value && $value!=0) $value = $defaultvalue;
		return menu_linkage($linkage,$field,$value,$ck_child);
	}
