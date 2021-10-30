<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="80"><?php echo L('userid')?></th>
		<th><?php echo L('username')?></th>
		<th width="150"><?php echo L('userinrole')?></th>
		<th width="180"><?php echo L('lastloginip')?></th>
		<th width="180"><?php echo L('lastlogintime')?></th>
		<th width="200"><?php echo L('email')?></th>
		<th width="100"><?php echo L('realname')?></th>
		<th><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php $admin_founders = explode(',', ADMIN_FOUNDERS);?>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td><?php echo $info['userid']?></td>
<td><?php echo $info['username']?><?php if($info['islock']) {?><img onmouseover="layer.tips('<?php echo L('lock')?>',this,{tips: [1, '#000']});" onmouseout="layer.closeAll();" src="<?php echo IMG_PATH?>icon/icon_padlock.gif"><?php }?></td>
<td><?php echo $roles[$info['roleid']]?></td>
<td><?php echo $info['lastloginip']?></td>
<td><?php echo $info['lastlogintime'] ? date('Y-m-d H:i:s',$info['lastlogintime']) : ''?></td>
<td><?php echo $info['email']?></td>
<td><?php echo $info['realname']?></td>
<td>
<a class="btn btn-xs green" href="javascript:edit(<?php echo $info['userid']?>, '<?php echo new_addslashes($info['username'])?>')"><?php echo L('edit')?></a>
<?php if(!in_array($info['userid'],$admin_founders)) {?>
<?php if($info['islock']) {?>
<a class="btn btn-xs yellow" href="?m=admin&c=admin_manage&a=unlock&userid=<?php echo $info['userid']?>"><?php echo L('unlock')?></a>
<?php } else { ?>
<a class="btn btn-xs dark" href="?m=admin&c=admin_manage&a=lock&userid=<?php echo $info['userid']?>"><?php echo L('lock')?></a>
<?php } ?>
<a class="btn btn-xs red" href="javascript:confirmurl('?m=admin&c=admin_manage&a=delete&userid=<?php echo $info['userid']?>', '<?php echo L('admin_del_cofirm')?>')"><?php echo L('delete')?></a>
<?php } ?>
</td>
</tr>
<?php 
	}
}
?>
</tbody>
</table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select"></div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
<!--
function edit(id, name) {
	artdialog('edit','?m=admin&c=admin_manage&a=edit&userid='+id,'<?php echo L('edit')?>--'+name,500,400);
}
//-->
</script>