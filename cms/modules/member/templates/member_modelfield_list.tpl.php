<?php defined('IS_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="subnav">
<div class="content-menu ib-a blue">
<a href="?m=member&c=member_model&a=manage&menuid=<?php echo $this->input->get('menuid');?>"><i class="fa fa-cogs"></i> <?php echo L('管理会员模型');?></a>
</div></div>
<div class="content-header"></div>
<div class="pad-lr-10">
<div class="bk10"></div>
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
<div class="list-footer table-checkable clear">
    <div class="col-md-5 col-sm-5 table-footer-button">
        <label><button type="submit" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('listorder')?></button></label>
    </div>
    <div class="col-md-7 col-sm-7 text-right"><?php if(isset($pages)){echo $pages;}?></div>
</div>
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
</body>
</html>