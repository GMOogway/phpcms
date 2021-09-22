<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<div class="explain-col">
<?php echo L('linkage_tips');?>
</div>
<div class="bk10"></div>
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="80">ID</th>
		<th width="120"><?php echo L('linkage_name')?></th>
		<th ><?php echo L('linkage_desc')?></th>
		<th width="260"><?php echo L('linkage_calling_code')?></th>
		<th><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
		<?php 
		if(is_array($infos)){
			foreach($infos as $info){
		?>
		<tr>
		<td><?php echo $info['linkageid']?></td>
		<td><?php echo $info['name']?></td>
		<td><?php echo $info['description']?></td>
		<td><input type="text" value="{menu_linkage(<?php echo $info['linkageid']?>,'L_<?php echo $info['linkageid']?>')}" style="width:200px;"></td>
		<td><a class="btn btn-xs blue" href="?m=admin&c=linkage&a=public_manage_submenu&keyid=<?php echo $info['linkageid']?>"><?php echo L('linkage_manage_submenu')?></a><a class="btn btn-xs green" href="javascript:void(0);" onclick="edit('<?php echo $info['linkageid']?>','<?php echo new_addslashes($info['name'])?>')"><?php echo L('edit')?></a><a class="btn btn-xs red" href="javascript:confirmurl('?m=admin&c=linkage&a=delete&linkageid=<?php echo $info['linkageid']?>', '<?php echo L('linkage_is_del')?>')"><?php echo L('delete')?></a><a class="btn btn-xs dark" href="?m=admin&c=linkage&a=public_cache&linkageid=<?php echo $info['linkageid']?>"><?php echo L('update_backup')?></a></td>
		</tr>
		<?php 
			}
		}
		?>
</tbody>
</table>
</div>
</div>
</form>
<script type="text/javascript">
<!--
function edit(id, name) {
	artdialog('edit','?m=admin&c=linkage&a=edit&linkageid='+id,name,500,200);
}
//-->
</script>
</body>
</html>