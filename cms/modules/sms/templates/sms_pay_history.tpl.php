<?php 
	defined('IS_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<form name="myform" action="?m=admin&c=position&a=listorder" method="post">
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
             <th width="80" align="center"><?php echo L('id')?></th>
			 <th width="200"><?php echo L('mobile')?></th>
			 <th width="100"><?php echo L('id_code')?></th>
			 <th><?php echo L('msg')?></th>
			 <th><?php echo L('send_userid')?></th>
			 <th><?php echo L('return_id')?></th>
			 <th><?php echo L('status')?></th>		 
			 <th><?php echo L('ip')?></th>
             <th width="160"><?php echo L('posttime')?></th>
            </tr>
        </thead>
    <tbody>
<?php 
if(is_array($paylist_arr)) foreach($paylist_arr as $info){
?>
	<tr>
	<td align="center"><?php echo $info['id']?></td>
	<td align="center"><?php echo $info['mobile']?></td>
	<td align="center"><?php echo $info['id_code']?></td>
	<td align="left"><?php if(CHARSET=='gbk') {echo iconv('utf-8','gbk',$info['msg']);}else{ echo $info['msg'];}?></td>
	<td align="center"><?php echo $info['sms_uid']?></td>	
	<td align="center"><?php echo CHARSET=="gbk" ? iconv('utf-8','gbk',$info['return_id']) : $info['return_id'];?></td>
	<td align="center"><?php echo sms_status($info['status']);?></td>
	<td align="center"><?php echo $info['ip']?></td>
	<td align="center"><?php echo dr_date($info['posttime'], null, 'red')?></td>
	</tr>
<?php 

}
?>
    </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 text-right"><?php echo $pages?></div>
</div>
</div>
</div>
</form>
</body>
</html>