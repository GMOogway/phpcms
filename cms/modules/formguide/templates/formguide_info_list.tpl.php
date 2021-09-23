<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
<div class="content-menu ib-a blue line-x">
<a href="?m=formguide&c=formguide&a=init&s=3&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('表单向导');?></em></a>
</div></div>
<div class="pad-lr-10">
<form name="myform" id="myform" action="?m=formguide&c=formguide_info&a=delete" method="post">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('did[]');" />
                        <span></span>
                    </label></th>
			<th align="center"><?php echo L('username')?></th>
			<th width='200' align="center"><?php echo L('userip')?></th>
			<th width='180' align="center"><?php echo L('times')?></th>
			<th align="center"><?php echo L('operation')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($datas)){
	foreach($datas as $d){
?>   
	<tr>
	<td align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="did[]" value="<?php echo $d['dataid']?>" />
                        <span></span>
                    </label></td>
	<td><?php if ($d['username']) {echo $d['username'];} else {echo '<font color="red">无</font>';}?></td>
	<td align="center"><?php echo $d['ip']?></td>
	<td align="center"><?php echo dr_date($d['datetime'], null, 'red')?></td>
	<td align="center"><a class="btn btn-xs blue" href="javascript:check('<?php echo $formid?>', '<?php echo $d['dataid']?>', '<?php echo safe_replace($d['username'])?>');void(0);"><?php echo L('check')?></a><a class="btn btn-xs red" href="###" onClick="Dialog.confirm('<?php echo L('confirm', array('message' => L('delete')))?>',function(){redirect('?m=formguide&c=formguide_info&a=public_delete&formid=<?php echo $formid?>&did=<?php echo $d['dataid']?>&pc_hash='+pc_hash);});"><?php echo L('del')?></a></td>
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
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('affirm_delete')?>',function(){document.myform.action='?m=formguide&c=formguide_info&a=public_delete&formid=<?php echo $formid?>';$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('remove_all_selected')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function check(id, did, title) {
	var diag = new Dialog({
		id:'check',
		title:'<?php echo L('check')?>--'+title+'<?php echo L('submit_info')?>',
		url:'<?php echo SELF;?>?m=formguide&c=formguide_info&a=public_view&formid='+id+'&did='+did+'&pc_hash='+pc_hash,
		width:700,
		height:500,
		modal:true
	});
	diag.onCancel=function() {
		$DW.close();
	};
	diag.show();
}
</script>