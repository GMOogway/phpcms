	function linkage($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		$result = dr_linkagepos($setting['linkage'], $value, $setting['space']);
		return $result;
	}

