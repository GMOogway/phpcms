<?php defined('IN_CMS') or exit('No permission resources.');?>

    <div class="form-group">
      <label class="col-md-2 control-label">路径分隔符</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[space]" value="<?php echo $setting['space'];?>" size="5" class="form-control"> 显示完整路径时生效</label>
      </div>
    </div>
    <?php echo linkage($setting);?>
    <div class="form-group">
      <label class="col-md-2 control-label">是否作为筛选字段</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[filtertype]" value="1" <?php if($setting['filtertype']) echo 'checked';?>> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[filtertype]" value="0" <?php if(!$setting['filtertype']) echo 'checked';?>> 否 <span></span></label>
          </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">默认值</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="form-control"></label>
      </div>
    </div>