<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
		<?php echo L('select_pdo_op')?> <?php echo form::select($pdos,$pdoname,'name="pdo_select" onchange="show_tbl(this)"',L('select_pdo'))?>
		<input type="submit" value="<?php echo L('pdo_look')?>" class="button" name="dosubmit">
		</div>
		</td>
		</tr>
    </tbody>
</table>
<form method="post" id="myform" name="myform">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('filenames[]');" />
                        <span></span>
                    </label></th>
            <th><?php echo L('backup_file_name')?></th>
            <th width="15%"><?php echo L('backup_file_size')?></th>
            <th width="15%"><?php echo L('backup_file_time')?></th>
            <th width="15%"><?php echo L('backup_file_number')?></th>
            <th width="15%"><?php echo L('database_op')?></th>
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
                        <input type="checkbox" class="checkboxes" name="filenames[]" value="<?php echo $info['filename']?>" id="sql_cms" boxid="sql_cms" />
                        <span></span>
                    </label></td>
	<td align="center"><?php echo $info['filename']?></td>
	<td align="center"><?php echo $info['filesize']?></td>
	<td align="center"><?php echo $info['maketime']?></td>
	<td align="center"><?php echo $info['number']?></td>
	<td align="center">
	<a href="javascript:confirmurl('?m=admin&c=database&pdoname=<?php echo $pdoname?>&a=import&menuid=<?php echo $this->input->get('menuid');?>&pre=<?php echo $info['pre']?>&dosubmit=1', '<?php echo L('confirm_recovery')?>')"><?php echo L('backup_import')?></a><!-- | <a href="?m=admin&c=database&a=public_down&pdoname=<?php echo $pdoname?>&filename=<?php echo $info['filename']?>"><?php echo L('backup_down')?></a>-->
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
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox" class="group-checkable" data-set=".checkboxes" /><span></span></label>
        <label><button type="button" onclick="Dialog.confirm('<?php echo L('confirm_delete')?>',function(){document.myform.action='?m=admin&c=database&a=delete&pdoname=<?php echo $pdoname?>&menuid=<?php echo $this->input->get('menuid');?>';$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('backup_del')?></button></label>
    </div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
<!--
function show_tbl(obj) {
	var pdoname = $(obj).val();
	location.href='?m=admin&c=database&a=import&pdoname='+pdoname+'&menuid='+<?php echo $this->input->get('menuid')?>+'&pc_hash=<?php echo $_SESSION['pc_hash']?>';
}
//-->
</script>