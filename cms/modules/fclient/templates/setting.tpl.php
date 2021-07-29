<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<form method="post" action="?m=fclient&c=fclient&a=setting">
<table width="100%" cellpadding="0" cellspacing="1" class="table_form"> 
 
	<tr>
		<th width="20%"><?php echo L('网站过期跳转的URL')?>：</th>
		<td><input type='text' name='setting[pay_url]' value='<?php echo $pay_url?>'> 当网站过期后，客户站会调转到这个url地址上</td>
	</tr>
	<tr>
		<th><?php echo L('网站关闭跳转的URL')?>：</th>
		<td><input type='text' name='setting[close_url]' value='<?php echo $close_url?>'> 当网站关闭后，客户站会调转到这个url地址上</td>
	</tr>
	 
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="button">&nbsp;</td>
	</tr>
</table>
</form>
</body>
</html>
 