<?php defined('IN_CMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="150">文本域宽度</td>
      <td><input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="10" class="input-text">px</td>
    </tr>
	<tr> 
      <td>默认值</td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="input-text"></td>
    </tr>
	<tr> 
      <td>表单附加属性<br />可以通过此处加入javascript事件</td>
      <td><input type="text" name="setting[bformattribute]" value="<?php echo $setting['bformattribute'];?>" size="40" class="input-text"><br />javascript事件：get_wxurl('表单名称','标题字段名称','关键词字段名称','内容字段名称')，内容必须是编辑器。</td>
    </tr>
    <tr> 
      <td>是否保存远程图片：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablesaveimage]" value="1" <?php if($setting['enablesaveimage']==1) echo 'checked';?>>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablesaveimage]" value="0"  <?php if($setting['enablesaveimage']==0) echo 'checked';?>> 否 <span></span></label>
        </div></td>
    </tr>
	<tr> 
      <td>是否在图片上添加水印</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="1" <?php if($setting['watermark']) echo 'checked';?>>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="0" <?php if(!$setting['watermark']) echo 'checked';?>> 否 <span></span></label>
        </div></td>
    </tr>
    <?php echo attachment($setting, 1);?>
</table>