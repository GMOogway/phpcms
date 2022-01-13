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
            <th width="120"><?php echo L('payment_mode').L('name')?></th>
            <th width="100"><?php echo L('plus_version')?></th>
            <th width="120"><?php echo L('plus_author')?></th>
            <th><?php echo L('desc')?></th>
            <th width="80"><?php echo L('listorder')?></th>
            <th width="100"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos['data'])){
	foreach($infos['data'] as $info){
?>   
	<tr>
	<td><?php echo $info['pay_name']?></td>
	<td><?php echo $info['version']?></td>
	<td><?php echo $info['author']?></td>
	<td><?php echo $info['pay_desc']?></td>
	<td><?php echo $info['pay_order']?></td>
	<td>
	<?php if ($info['enabled']) {?>
	<a href="javascript:edit('<?php echo $info['pay_id']?>', '<?php echo $info['pay_name']?>')"><?php echo L('configure')?></a> | 
	<a href="javascript:confirmurl('?m=pay&c=payment&a=delete&id=<?php echo $info['pay_id']?>', '<?php echo L('confirm',array('message'=>$info['pay_name']))?>')"><?php echo L('plus_uninstall')?></a>
	<?php } else {?>
	<a class="btn btn-xs green" href="javascript:add('<?php echo $info['pay_code']?>', '<?php echo $info['pay_name']?>')"><?php echo L('plus_install')?></a>
	<?php }?>
	</td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 text-right"><?php echo $pages?></div>
</div>
</div>
</form>
</body>
</html>
<script type="text/javascript">
<!--
function add(id, name) {
	artdialog('add','?m=pay&c=payment&a=add&code='+id,'<?php echo L('edit')?>--'+name,700,500);
}
function edit(id, name) {
	artdialog('edit','?m=pay&c=payment&a=edit&id='+id,'<?php echo L('edit')?>--'+name,700,500);
}
//-->
</script>