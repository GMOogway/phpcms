<?php defined('IS_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">

<div class="explain-col">
<?php echo L('move_member_model_index_alert')?>
</div>

<div class="bk10"></div>
<form name="myform" id="myform" action="?m=member&c=member_model&a=delete" method="post" onsubmit="check();return false;">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('modelid[]');" />
                        <span></span>
                    </label></th>
			<th width="70"><?php echo L('sort')?></th>
			<th width="100">ID</th>
			<th width="280"><?php echo L('model_name')?></th>
			<th width="180"><?php echo L('table_name')?></th>
			<th><?php echo L('model_description')?></th>
			<th width="100"><?php echo L('status')?></th>
			<th><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($member_model_list as $k=>$v) {
?>
    <tr>
		<td class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" value="<?php echo $v['modelid']?>" name="modelid[]" <?php if($v['modelid']==10) echo "disabled";?> />
                        <span></span>
                    </label></td>
		<td align="center"><input type="text" name="sort[<?php echo $v['modelid']?>]" class="input-text-c input-text" size="3" value="<?php echo $v['sort']?>"></td>
		<td align="center"><?php echo $v['modelid']?></td>
		<td align="center"><?php echo $v['name']?></td>
		<td align="center"><?php echo $this->db->db_tablepre.$v['tablename']?></td>
		<td><?php echo $v['description']?></td>
		<td align="center"><?php echo $v['disabled'] ? L('icon_locked') : L('icon_unlock')?></td>
		<td align="center">
		<a class="btn btn-xs blue" href="?m=member&c=member_modelfield&a=manage&modelid=<?php echo $v['modelid']?>&menuid=<?php echo $this->input->get('menuid');?>"><?php echo L('field').L('manage')?></a><a class="btn btn-xs green" href="javascript:edit(<?php echo $v['modelid']?>, '<?php echo $v['name']?>')"><?php echo L('edit')?></a><a class="btn btn-xs yellow" href="?m=member&c=member_model&a=export&modelid=<?php echo $v['modelid']?>"><?php echo L('export')?></a><a class="btn btn-xs dark" href="javascript:move(<?php echo $v['modelid']?>, '<?php echo $v['name']?>')"><?php echo L('move')?></a>
		</td>
    </tr>
<?php
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
        <label><button type="submit" onclick="document.myform.action='?m=member&c=member_model&a=sort'" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('sort')?></button></label>
        <label><button type="button" onclick="Dialog.confirm('<?php echo L('sure_delete')?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('delete')?></button></label>
    </div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $pages?></div>
</div>
</div>
</form>
<script language="JavaScript">
<!--
function edit(id, name) {
	artdialog('edit','?m=member&c=member_model&a=edit&modelid='+id,'<?php echo L('edit').L('member_model')?>《'+name+'》',700,500);
}

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

//修改菜单地址栏
function _M(menuid) {
	$.get("?m=admin&c=index&a=public_current_pos&menuid="+menuid, function(data){
		parent.$("#current_pos").html(data);
	});
}

//-->
</script>
</body>
</html>