<?php
defined('IS_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10"> 
<form name="myform" id="myform" action="?m=message&c=message&a=delete_outbox" method="post" onsubmit="checkuid();return false;">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('messageid[]');" />
                        <span></span>
                    </label></th>
			<th><?php echo L('subject')?></th>
			<th width="300" align="center"><?php echo L('content')?></th>
			<th width="120" align="center"><?php echo L('touserid')?></th>
			<th width='160' align="center"><?php echo L('send_time')?></th>
			<th align="center"><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="messageid[]" value="<?php echo $info['messageid']?>" />
                        <span></span>
                    </label></td>
		<td><?php echo $info['subject']?></td>
		<td><?php echo $info['content'];?></td>
		<td align="center"><?php echo $info['send_to_id'];?></td>
		<td align="center"><?php echo dr_date($info['message_time'], null, 'red');?></td>
		<td align="center"> <a class="btn btn-xs red"
			href='###'
			onClick="Dialog.confirm('<?php echo L('confirm', array('message' => new_addslashes($info['subject'])))?>',function(){redirect('?m=message&c=message&a=delete&messageid=<?php echo $info['messageid']?>&pc_hash='+pc_hash);});"><?php echo L('delete')?></a>
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
    <div class="col-md-5 col-sm-5 table-footer-button">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('confirm', array('message' => L('selected')))?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('remove_all_selected')?></button></label>
    </div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">

function see_all(id, name) {
	artdialog('edit','?m=message&c=message&a=see_all&messageid='+id,'<?php echo L('details');//echo L('edit')?> '+name+' ',700,450);
}
function checkuid() {
	var ids='';
	$("input[name='messageid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		Dialog.alert("<?php echo L('before_select_operation')?>");
		return false;
	} else {
		myform.submit();
	}
}

</script>
</body>
</html>
