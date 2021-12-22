<?php defined('IN_CMS') or exit('No permission resources.');?>

	<div class="form-group">
      <label class="col-md-2 control-label">默认值</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="input-text"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">表单附加属性</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[bformattribute]" value="<?php echo $setting['bformattribute'];?>" size="40" class="input-text"><br />javascript事件：get_wxurl('表单名称','标题字段名称','关键词字段名称','内容字段名称')，内容必须是编辑器。</label>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">是否保存远程图片</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablesaveimage]" value="1" <?php if($setting['enablesaveimage']==1) echo 'checked';?>>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablesaveimage]" value="0"  <?php if($setting['enablesaveimage']==0) echo 'checked';?>> 否 <span></span></label>
        </div></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">是否在图片上添加水印</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="1" <?php if($setting['watermark']) echo 'checked';?>>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="0" <?php if(!$setting['watermark']) echo 'checked';?>> 否 <span></span></label>
        </div></label>
      </div>
    </div>
    <?php echo attachment($setting);?>
