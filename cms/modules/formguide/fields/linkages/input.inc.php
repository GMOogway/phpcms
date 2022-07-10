	function linkages($field, $value) {
		$setting = string2array($this->fields[$field]['setting']);
		$values = dr_string2array($value);
		if ($values) {
			foreach ($values as $v) {
				$link = dr_linkage($setting['linkage'], $v);
				if (!$link) {
					if (IS_ADMIN) {
						dr_admin_msg(0, L('选项无效'), array('field' => $field));
					} else {
						dr_msg(0, L('选项无效'), array('field' => $field));
					}
				} elseif ($this->fields[$field]['minlength'] && $setting['ck_child'] && $link['child']) {
					if (IS_ADMIN) {
						dr_admin_msg(0, L('需要选择下级选项'), array('field' => $field));
					} else {
						dr_msg(0, L('需要选择下级选项'), array('field' => $field));
					}
				}
			}
		}
		$save = array();
		if ($value) {
			$value = dr_string2array($value);
			if ($value) {
				foreach ($value as $t) {
					if ($t) {
						$save[] = $t;
					}
				}
				$save = array_unique($save);
			}
		}
		// 判断超限
		if ($setting['limit'] && dr_count($save) > $setting['limit']) {
			$save = array_slice($save, 0, $setting['limit']);
		}
		return dr_array2string($save);
	}
