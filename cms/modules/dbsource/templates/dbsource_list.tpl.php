<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="80">Siteid</th>
		<th width="180"><?php echo L('dbsource_name')?></th>
		<th width="300"><?php echo L('server_address')?></th>
		<th><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
?>
<tr>
<td align="center"><?php echo $v['id']?></td>
<td align="center"><?php echo $v['name']?></td>
<td align="center"><?php echo $v['host']?></td>
<td align="center"><a class="btn btn-xs green" href="javascript:edit(<?php echo $v['id']?>, '<?php echo new_html_special_chars(new_addslashes($v['name']))?>')"><?php echo L('edit')?></a><a class="btn btn-xs red" href="###" onclick="Dialog.confirm('<?php echo new_html_special_chars(new_addslashes(L('confirm', array('message'=>$v['name']))))?>',function(){redirect('?m=dbsource&c=dbsource_admin&a=del&id=<?php echo $v['id']?>&pc_hash='+pc_hash);});"><?php echo L('delete')?></a></td>
</tr>
<?php 
	endforeach;
endif;
?>
</tbody>
</table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select"></div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</div>
<script type="text/javascript">
<!--
function edit(id, name) {
	artdialog('edit','?m=dbsource&c=dbsource_admin&a=edit&id='+id,'<?php echo L('edit_dbsource')?>《'+name+'》',700,500);
}
//-->
</script>
</body>
</html>