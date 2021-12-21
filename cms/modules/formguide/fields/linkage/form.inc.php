	function linkage($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		$linkage = $setting['linkage'];
		return menu_linkage($linkage,$field,$value);
	}
