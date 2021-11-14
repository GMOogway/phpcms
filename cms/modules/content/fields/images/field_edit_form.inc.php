<?php defined('IN_CMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="120">允许上传的图片类型</td>
      <td><input type="text" name="setting[upload_allowext]" value="<?php echo $setting['upload_allowext'];?>" size="40" class="input-text"></td>
    </tr>
	<tr> 
      <td>是否从已上传中选择</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="1" <?php if($setting['isselectimage']) echo 'checked';?>>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="0" <?php if(!$setting['isselectimage']) echo 'checked';?>> 否 <span></span></label>
        </div></td>
    </tr>
	<tr> 
      <td>表单显示模式</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[show_type]" value="1" <?php if($setting['show_type']) echo 'checked';?>/> 图片模式 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio"  name="setting[show_type]" value="0" <?php if(!$setting['show_type']) echo 'checked';?>/> 文本框模式 <span></span></label>
        </div></td>
	<tr> 
      <td>允许同时上传的个数</td>
      <td><input type="text" name="setting[upload_number]" value="<?php echo $setting['upload_number'];?>" size=3 class="input-text"></td>
    </tr>
    <?php echo attachment($setting, 1);?>
</table>