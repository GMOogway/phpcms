<?php defined('IN_CMS') or exit('No permission resources.');?>

	<div class="form-group">
      <label class="col-md-2 control-label">文本框长度</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[size]" value="<?php echo $setting['size'];?>" size="10" class="input-text"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">默认值</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="input-text"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">是否为密码框</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[ispassword]" value="1" <?php if($setting['ispassword']) echo 'checked';?>> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[ispassword]" value="0" <?php if(!$setting['ispassword']) echo 'checked';?>> 否 <span></span></label>
        </div></label>
      </div>
    </div>
