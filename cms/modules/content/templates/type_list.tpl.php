<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<form name="myform" action="?m=content&c=type_manage&a=listorder" method="post">
<input name="dosubmit" type="hidden" value="1">
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
	<tr class="heading">
	<th width="80" class="<?php echo dr_sorting('listorder')?>" name="listorder"><?php echo L('listorder');?></td>
	<th width="80" class="<?php echo dr_sorting('typeid')?>" name="typeid">ID</th>
	<th width="200" class="<?php echo dr_sorting('name')?>" name="name"><?php echo L('type_name');?></th>
	<th class="<?php echo dr_sorting('description')?>" name="description"><?php echo L('description');?></th>
	<th><?php echo L('operations_manage');?></th>
	</tr>
        </thead>
    <tbody>
    

<?php
if (is_array($datas)) {
foreach($datas as $r) {
?>
<tr>
<td align="center"><input type="text" name="listorders[<?php echo $r['typeid']?>]" value="<?php echo $r['listorder']?>" size="3" class='input-text-c'></td>
<td align="center"><?php echo $r['typeid']?></td>
<td align="center"><?php echo $r['name']?></td>
<td ><?php echo $r['description']?></td>
<td align="center"><a class="btn btn-xs green" href="javascript:edit('<?php echo $r['typeid']?>','<?php echo trim(new_addslashes($r['name']))?>')"><?php echo L('edit');?></a> <a class="btn btn-xs red" href="javascript:;" onclick="data_delete(this,'<?php echo $r['typeid']?>','<?php echo trim(new_addslashes($r['name']));?>')"><?php echo L('delete')?></a> </td>
</tr>
<?php }} ?>
	</tbody>
    </table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label><button type="submit" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('listorder')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php if(isset($pages)){echo $pages;}?></div>
</div>
</div>
</form>

<script type="text/javascript"> 
<!--
window.top.$('#display_center_id').css('display','none');
function edit(id, name) {
	artdialog('edit','?m=content&c=type_manage&a=edit&typeid='+id,'<?php echo L('edit_type');?>《'+name+'》',780,500);
}
function data_delete(obj,id,name){
	Dialog.confirm(name,function(){
		$.get('?m=content&c=type_manage&a=delete&typeid='+id+'&pc_hash='+pc_hash,function(data){
			if(data) {
				$(obj).parent().parent().fadeOut("slow");
			}
		}) 	
	});
};
//-->
</script>
</body>
</html>
