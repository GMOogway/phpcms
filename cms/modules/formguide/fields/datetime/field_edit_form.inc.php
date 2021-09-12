<?php defined('IN_CMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" bgcolor="#ffffff">
    <tr> 
      <td><strong>宽度：</strong></td>
      <td><input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="40" class="input-text">[整数]表示固定宽度；[整数%]表示百分比</td>
    </tr>
    <tr> 
      <td><strong>类型：</strong></td>
      <td>
        <div class="mt-radio-inline">
            <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[fieldtype]" value="int" onclick="$('#date').show();$('#time').hide();" <?php if($setting['fieldtype']=='int') echo 'checked';?>>日期<span></span></label>
            <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[fieldtype]" value="varchar" onclick="$('#date').hide();$('#time').show();" <?php if($setting['fieldtype']=='varchar') echo 'checked';?>>时间<span></span></label>
        </div>
      </td>
    </tr>
    <tr id="date"<?php if($setting['fieldtype']=='varchar') echo ' style="display:none;"';?>> 
      <td><strong>日期格式：</strong></td>
      <td>
        <div class="mt-radio-inline">
            <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[format]" value="1" <?php if($setting['format']) echo 'checked';?>>日期时间格式<span></span></label>
            <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[format]" value="0" <?php if(!$setting['format']) echo 'checked';?>>日期格式<span></span></label>
        </div>
      </td>
    </tr>
    <tr id="time"<?php if($setting['fieldtype']=='int') echo ' style="display:none;"';?>> 
      <td><strong>时间格式：</strong></td>
      <td>
        <div class="mt-radio-inline">
            <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[format2]" value="0" <?php if(!$setting['format2']) echo 'checked';?>>时分格式<span></span></label>
            <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[format2]" value="1" <?php if($setting['format2']) echo 'checked';?>>时分秒格式<span></span></label>
        </div>
      </td>
    </tr>
    <tr> 
      <td><strong>图标显示：</strong></td>
      <td>
        <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[is_left]" value="0"<?php if(!$setting['is_left']) echo ' checked';?>/>左侧图标<span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[is_left]" value="1"<?php if($setting['is_left']) echo ' checked';?>/>右侧图标<span></span></label>
        </div>
     </td>
    </tr>
    <tr> 
      <td><strong>默认值：</strong></td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="input-text"></div>
     </td>
    </tr>
    <tr> 
      <td><strong>图标颜色：</strong></td>
      <td><?php echo color_select('setting[color]', $setting['color']);?></td>
    </tr>
</table>