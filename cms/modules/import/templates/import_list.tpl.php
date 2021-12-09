<?php
defined('IS_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10"> 
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		<?php echo L('all_type')?>: &nbsp;&nbsp; <a href="?m=import&c=import&a=init"><?php echo L('all_import')?></a> &nbsp;&nbsp;
		<a href="?m=import&c=import&a=init&type=content"><?php echo L('content_import')?></a>&nbsp;
		<a href="?m=import&c=import&a=init&type=member"><?php echo L('member_import')?></a>&nbsp;
		<a href="?m=import&c=import&a=init&type=other"><?php echo L('other_import')?></a>&nbsp;
				</div>
		</td>
		</tr>
    </tbody>
</table>

<form name="myform" id="myform" action="?m=import&c=import&a=delete" method="post" >
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('importid[]');" />
                        <span></span>
                    </label></th>
 			<th><?php echo L('import_name')?></th>
			<th align="center"><?php echo L('import_desc')?></th>
			<th width="160" align="center"><?php echo L('add_time')?></th>
			<th width='160' align="center"><?php echo L('import_time')?></th>
  			<th width="100" align="center"><?php echo L('import_type')?></th>
			<th align="center"><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="importid[]" value="<?php echo $info['id']?>" />
                        <span></span>
                    </label></td>
 		<td><?php echo $info['import_name']?></td>
		<td align="center"><?php echo $info['desc'];?> </td>
		<td align="center"><?php echo dr_date($info['addtime'], null, 'red');?></td>
		<td align="center"><?php if($info['lastinputtime']){echo dr_date($info['lastinputtime'], null, 'red');}else {echo '<font color=red>未执行</font>';}?></td>
 	 
		<td align="center"><?php echo $info['type'];?></td>
		<td align="center">
		<a class="btn btn-xs green" href="?m=import&c=import&a=choice&importid=<?php echo $info['id'];?>&type=<?php echo $info['type']?>" title="<?php echo L('edit')?>"><?php echo L('edit')?></a> <a class="btn btn-xs yellow" href="?m=import&c=import&a=do_import&importid=<?php echo $info['id'];?>&type=<?php echo $info['type']?>" title="<?php echo L('edit')?>"><?php echo L('do_import');?></a>
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
    <div class="col-md-7 list-select">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" onclick="Dialog.confirm('<?php echo L('delete_confirm')?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('delete_select')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
