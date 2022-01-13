<?php defined('IS_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="note note-danger">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('update_cache_all');?></a></p>
</div>
<div class="right-card-box">
<form name="myform" id="myform" action="?m=member&c=member_modelfield&a=sort" method="post" onsubmit="check();return false;">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
			<th width="70"><?php echo L('listorder')?></th>
            <th><?php echo L('fields')?></th>
			<th width="150"><?php echo L('type');?></th>
            <th width="50"><?php echo L('must_input');?></th>
            <th width="50"><?php echo L('search');?></th>
			<th width="100"><?php echo L('disabled');?></th>
			<th width="150"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
	<?php
	foreach($datas as $r) {
	?>
    <tr>
		<td align='center'>
			<input name='listorders[<?php echo $r['fieldid']?>]' type='text' size='3' value='<?php echo $r['listorder']?>' class='input-text-c'>
		</td>
		<td><?php echo $r['name']?> / <?php echo $r['field']?></td>
		<td align='center'><?php echo $r['formtype']?></td>
		<td align='center'><?php echo $r['isbase'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'><?php echo $r['issearch'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'><?php echo $r['disabled'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'>
			<a class="btn btn-xs green" href="?m=member&c=member_modelfield&a=edit&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('modify')?></a>
			<?php if(!$r['disabled']) {?>
			<a class="btn btn-xs dark" href="?m=member&c=member_modelfield&a=disable&disabled=1&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('disable')?></a>
			<?php } else {?>
			<a class="btn btn-xs dark" href="?m=member&c=member_modelfield&a=disable&disabled=0&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('enable')?></a>
			<?php }?>
			<a class="btn btn-xs red" href="javascript:confirmurl('?m=member&c=member_modelfield&a=delete&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $_GET['menuid']?>','<?php echo L('sure_delete')?>')"><?php echo L('delete')?></a>
		</td>
	</tr>
	<?php } ?>
    </tbody>
    </table>
</div>
<div class="row list-footer table-checkable">
    <div class="col-md-5 list-select">
        <label><button type="submit" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('listorder')?></button></label>
    </div>
    <div class="col-md-7 list-page"><?php if(isset($pages)){echo $pages;}?></div>
</div>
</form>
<script language="JavaScript">
<!--
function move(id, name) {
	artdialog('move','?m=member&c=member_model&a=move&modelid='+id,'<?php echo L('move')?>《'+name+'》',700,500);
}

function check() {
	if(myform.action == '?m=member&c=member_model&a=delete') {
		var ids='';
		$("input[name='modelid[]']:checked").each(function(i, n){
			ids += $(n).val() + ',';
		});
		if(ids=='') {
			Dialog.alert('<?php echo L('plsease_select').L('member_model')?>');
			return false;
		}
	}
	myform.submit();
}
//-->
</script>
</div>
</div>
</div>
</div>
</body>
</html>