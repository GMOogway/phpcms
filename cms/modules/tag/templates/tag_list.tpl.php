<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<form id="myform" name="myform" action="" method="get">
<input name="dosubmit" type="hidden" value="1">
<input type="hidden" name="m" value="tag" />
<input type="hidden" name="c" value="tag" />
<input type="hidden" name="a" value="del" />
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="80" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('id[]');" />
                        <span></span>
                    </label></th>
		<th><?php echo L('name')?></th>
		<th><?php echo L('stdcall')?></th>
		<th><?php echo L('stdcode')?></th>
		<th width="150"><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
?>
<tr>
<td width="80" align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" value="<?php echo $v['id']?>" name="id[]" />
                        <span></span>
                    </label></td>
<td align="center"><?php echo $v['name']?></td>
<td align="center"><?php switch($v['type']){case 0:echo L('model_configuration');break;case 1:echo L('custom_sql');break;case 2:echo L('block');}?></td>
<td align="center"><textarea ondblclick="copy_text(this)" style="width: 400px;height:30px" /><?php echo new_html_special_chars($v['tag'])?></textarea></td>
<td align="center"><a href="javascript:edit(<?php echo $v['id']?>, '<?php echo new_html_special_chars(new_addslashes($v['name']))?>')"><?php echo L('edit')?></a> | <a href="###" onclick="Dialog.confirm('<?php echo new_html_special_chars(new_addslashes(L('confirm', array('message'=>$v['name']))))?>',function(){redirect('?m=tag&c=tag&a=del&id=<?php echo $v['id']?>&pc_hash='+pc_hash);});"><?php echo L('delete')?></a></td>
</tr>
<?php 
	endforeach;
endif;
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
        <label><button type="button" onclick="Dialog.confirm('<?php echo L('sure_deleted')?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('delete')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function edit(id, name) {
	artdialog('edit','?m=tag&c=tag&a=edit&id='+id,'<?php echo L('editing_data_sources_call')?>《'+name+'》',700,500);
}

function copy_text(matter){
	matter.select();
	js1=matter.createTextRange();
	js1.execCommand("Copy");
	Dialog.alert('<?php echo L('copy_code');?>');
}
//-->
</script>
</body>
</html>