<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form name="myform" id="myform" action="?m=admin&c=badword&a=delete" method="post" onsubmit="checkuid();return false;">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
 <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('badid[]');" />
                        <span></span>
                    </label></th>
             <th ><?php echo L('badword_name')?></th>
            <th ><?php echo L('badword_replacename')?></th>
            <th width="80"><?php echo L('badword_level')?></th>
            <th width="120"><?php echo L('inputtime')?></th>
             <th width="120"><?php echo L('operations_manage')?></th>
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
                        <input type="checkbox" class="checkboxes" name="badid[]" value="<?php echo $info['badid']?>" />
                        <span></span>
                    </label></td>
         <td align="center"><span  class="<?php echo $info['style']?>"><?php echo $info['badword']?></span> </td>
        <td align="center"><?php echo $info['replaceword']?></td>
        <td align="center"><?php echo $level[$info['level']]?></td>
        <td align="center"><?php echo $info['lastusetime'] ? date('Y-m-d H:i', $info['lastusetime']):''?></td>
         <td align="center"><a href="javascript:edit(<?php echo $info['badid']?>, '<?php echo new_addslashes($info['badword'])?>')"><?php echo L('edit')?></a> | <a href="javascript:confirmurl('?m=admin&c=badword&a=delete&badid=<?php echo $info['badid']?>', '<?php echo L('badword_confirm_del')?>')"><?php echo L('delete')?></a> </td>
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
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('badword_confom_del')?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('remove_all_selected')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function edit(id, name) {
	artdialog('edit','?m=admin&c=badword&a=edit&badid='+id,'<?php echo L('badword_edit')?> '+name+' ',450,180);
}

function checkuid() {
	var ids='';
	$("input[name='badid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		Dialog.alert('<?php echo L('badword_pleasechose');?>');
		return false;
	} else {
		myform.submit();
	}
}
</script>

 