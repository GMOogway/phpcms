	function touchspin($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$setting = string2array($setting);
		// 表单宽度设置
		$width = is_mobile(0) ? '100%' : ($setting['width'] ? $setting['width'] : 200);
		// 风格
		$style = 'style="width:'.$width.(is_numeric($width) ? 'px' : '').';"';
		// 按钮颜色
		$up = $setting['up'] ? $setting['up'] : '';
		$down = $setting['down'] ? $setting['down'] : '';
		!$setting['maxnumber'] && $setting['maxnumber'] = 999999999999999;
		!$setting['minnumber'] && $setting['minnumber'] = 0;
		if(!$value) $value = $defaultvalue;
		if(!defined('TOUCHSPIN_INIT')) {
			$str = '<link href="'.JS_PATH.'bootstrap-touchspin/bootstrap.touchspin.css" rel="stylesheet" type="text/css" />
			<script src="'.JS_PATH.'bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>';
			define('TOUCHSPIN_INIT', 1);
		} else {
			$str = '';
		}
		if($up || $down) {
			$str .= '<style type="text/css">';
			if($up && $up!='#ffffff' && $up!='#fff') {
				$str .= '.btn.up:not(.btn-outline){color: #FFF;background-color: '.$up.';border-color: '.$up.';}';
			}
			if($down && $down!='#ffffff' && $down!='#fff') {
				$str .= '.btn.down:not(.btn-outline){color: #FFF;background-color: '.$down.';border-color: '.$down.';}';
			}
			$str .= '</style>';
		}
		$js = '<script type="text/javascript">
    $(function(){
        $("#dr_'.$field.'").TouchSpin({
            buttondown_class: "btn down",
            buttonup_class: "btn up",
            verticalbuttons: '.(!$setting['show'] ?  'true' : 'false').',
            step: '.$setting['step'].',
            min: '.$setting['minnumber'].',
            max: '.$setting['maxnumber'].'
        });
    });
</script>';
		return $str."<div $style><input type='text' name='info[$field]' id='dr_$field' value='$value' class='form-control'></div>".$js;
	}
