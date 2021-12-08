<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad-lr-10">
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="80"><?php echo L('listorder');?></th>
		<th width="80">ID</th>
		<th><?php echo L('role_name');?></th>
		<th width="200"><?php echo L('role_desc');?></th>
		<th width="80"><?php echo L('role_status');?></th>
		<th><?php echo L('role_operation');?></th>
		</tr>
        </thead>
<tbody>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td align="center"><input name='listorders[<?php echo $info['roleid']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c"></td>
<td align="center"><?php echo $info['roleid']?></td>
<td><?php echo $info['rolename']?></td>
<td><?php echo $info['description']?></td>
<td><a href="?m=admin&c=role&a=change_status&roleid=<?php echo $info['roleid']?>&disabled=<?php echo ($info['disabled']==1 ? 0 : 1)?>"><?php echo $info['disabled']? L('icon_locked'):L('icon_unlock')?></a></td>
<td>
<?php if($info['roleid'] > 1) {?>
<a class="btn btn-xs blue" href="javascript:setting_role(<?php echo $info['roleid']?>, '<?php echo new_addslashes($info['rolename'])?>')"><?php echo L('role_setting');?></a> <a class="btn btn-xs dark" href="javascript:void(0)" onclick="setting_cat_priv(<?php echo $info['roleid']?>, '<?php echo new_addslashes($info['rolename'])?>')"><?php echo L('usersandmenus')?></a>
<?php }?>
<a class="btn btn-xs yellow" href="?m=admin&c=role&a=member_manage&roleid=<?php echo $info['roleid']?>&menuid=<?php echo $this->input->get('menuid')?>"><?php echo L('role_member_manage');?></a>
<?php if($info['roleid'] > 1) {?><a class="btn btn-xs green" href="?m=admin&c=role&a=edit&roleid=<?php echo $info['roleid']?>&menuid=<?php echo $this->input->get('menuid')?>"><?php echo L('edit')?></a>
<a class="btn btn-xs red" href="javascript:confirmurl('?m=admin&c=role&a=delete&roleid=<?php echo $info['roleid']?>', '<?php echo L('posid_del_cofirm')?>')"><?php echo L('delete')?></a>
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
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder');?>" /></label>
    </div>
    <div class="col-md-5 list-page"></div>
</div>
</form>
</body>
<script type="text/javascript">
<!--
function setting_role(id, name) {
	openwinx('?m=admin&c=role&a=priv_setting&roleid='+id+'&pc_hash='+pc_hash,'<?php echo L('sys_setting')?>《'+name+'》','80%','80%');
}

function setting_cat_priv(id, name) {
	openwinx('?m=admin&c=role&a=setting_cat_priv&roleid='+id+'&pc_hash='+pc_hash,'<?php echo L('usersandmenus')?>《'+name+'》','80%','80%');
}
//-->
</script>
</html>
