<?php defined('IN_CMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>显示级层</td>
      <td><input type="text" name="setting[level]" value="<?php echo $setting['level'];?>" size="30" class="input-text"> 值越大地图显示越详细</td>
    </tr>
	<tr> 
      <td>宽度</td>
      <td><input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="10" class="input-text"> [整数]表示固定宽度；[整数%]表示百分比</td>
    </tr>
	<tr> 
      <td>高度</td>
      <td><input type="text" name="setting[height]" value="<?php echo $setting['height'];?>" size="10" class="input-text">px</td>
    </tr>
</table>