<?php defined('IN_CMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>宽度</td>
      <td><input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="20" class="input-text"> [整数]表示固定宽度；[整数%]表示百分比</td>
    </tr>
	<tr> 
      <td width="100">最大值</td>
      <td><input type="text" name="setting[maxnumber]" value="<?php echo $setting['maxnumber'];?>" size="20" class="input-text"></td>
    </tr>
	<tr> 
      <td>最小值</td>
      <td><input type="text" name="setting[minnumber]" value="<?php echo $setting['minnumber'];?>" size="20" class="input-text"></td>
    </tr>
	<tr> 
      <td>步长值：</td>
      <td><input type="text" name="setting[step]" value="<?php echo $setting['step'];?>" size="20" class="input-text"></td>
    </tr>
	<tr> 
      <td>默认值</td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="input-text"></td>
    </tr>
	<tr> 
	  <td>显示模式</td>
	  <td>
	  <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[show]" value="1" <?php if($setting['show']) echo 'checked';?> /> 按钮 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[show]" value="0" <?php if(!$setting['show']) echo 'checked';?> /> 箭头 <span></span></label>
          <span></span></label>
        </div>
	  </td>
	</tr>
    <tr> 
      <td>加按钮颜色：</td>
      <td><?php echo color_select('setting[up]', $setting['up']);?></td>
    </tr>
    <tr> 
      <td>减按钮颜色：</td>
      <td><?php echo color_select('setting[down]', $setting['down']);?></td>
    </tr>
</table>