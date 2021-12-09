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
             <th width="100" align="left"><?php echo L('productid')?></th>
			 <th width="180"><?php echo L('product_name')?></th>
			 <th><?php echo L('product_description')?></th>
			 <th><?php echo L('totalnum')?></th>
			 <th><?php echo L('give_away')?></th>
             <th><?php echo L('product_price').L('yuan')?></th>
             <th width="160"><?php echo L('recharge_time')?></th>
            </tr>
        </thead>
    <tbody>
<?php 
if(is_array($payinfo_arr)) foreach($payinfo_arr as $info){
?>   
	<tr>
	<td><?php echo $info['sms_pid']?></td>
	<td align="center"><?php if(CHARSET=='gbk') {echo iconv('utf-8','gbk',$info['name']);}else{ echo $info['name'];}?></td>
	<td align="center"><?php if(CHARSET=='gbk') {echo iconv('utf-8','gbk',$info['description']);}else{ echo $info['description'];}?></td>
	<td align="center"><?php echo $info['totalnum']?></td>
	<td align="center"><?php echo $info['give_away']?></td>
	<td align="center"><?php echo $info['price']?></td>	
	<td align="center"><?php echo dr_date($info['recharge_time'], null, 'red')?></td>
	</tr>
<?php 

}
?>
    </tbody>
    </table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select"></div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</div>
</div>
</form>
</body>
</html>