<?php defined('IN_CMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>是否在图片上添加水印</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="1" <?php if($setting['watermark']) echo 'checked';?>>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="0" <?php if(!$setting['watermark']) echo 'checked';?>> 否 <span></span></label>
        </div></td>
    </tr>
    <?php echo attachment($setting, 1);?>
</table>