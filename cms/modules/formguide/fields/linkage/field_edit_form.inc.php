<?php defined('IN_CMS') or exit('No permission resources.');?>

    <div class="form-group">
      <label class="col-md-2 control-label">路径分隔符</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[space]" value="<?php echo $setting['space'];?>" size="5" class="form-control"> 显示完整路径时生效</label>
      </div>
    </div>
    <?php echo linkage($setting);?>
    <div class="form-group">
      <label class="col-md-2 control-label">默认值</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="form-control"></label>
      </div>
    </div>