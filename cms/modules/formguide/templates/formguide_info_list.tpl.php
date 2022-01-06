<?php 
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
<div class="content-menu ib-a blue">
<a href="?m=formguide&c=formguide&a=init&s=3&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-table"></i> <?php echo L('表单向导');?></a>
</div></div>
<div class="content-header"></div>
<div class="pad-lr-10">
<form name="myform" id="myform" action="?m=formguide&c=formguide_info&a=delete" method="post">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr class="heading">
            <th align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('did[]');" />
                        <span></span>
                    </label></th>
			<?php 
			if(is_array($list_field)){
			foreach($list_field as $i=>$t){
			?>
			<th<?php if($t['width']){?> width="<?php echo $t['width'];?>"<?php }?><?php if($t['center']){?> style="text-align:center"<?php }?> class="<?php echo dr_sorting($i);?>" name="<?php echo $i;?>"><?php echo L($t['name']);?></th>
			<?php }}?>
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
	<?php 
	if(is_array($list_field)){
	foreach($list_field as $i=>$tt){
	?>
	<td<?php if($tt['center']){?> style="text-align:center"<?php }?>><?php echo dr_list_function($tt['func'], $d[$i], $param, $d, $field[$i], $i);?></td>
	<?php }}?>
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
    <div class="col-md-5 col-sm-5 table-footer-button">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('affirm_delete')?>',function(){document.myform.action='?m=formguide&c=formguide_info&a=public_delete&formid=<?php echo $formid?>';$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('remove_all_selected')?></button></label>
    </div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function check(id, did, title) {
	var w = 700;
	var h = 500;
	if (is_mobile()) {
		w = h = '100%';
	}
	var diag = new Dialog({
		id:'check',
		title:'<?php echo L('check')?>--'+title+'<?php echo L('submit_info')?>',
		url:'<?php echo SELF;?>?m=formguide&c=formguide_info&a=public_view&formid='+id+'&did='+did+'&pc_hash='+pc_hash,
		width:w,
		height:h,
		modal:true
	});
	diag.onCancel=function() {
		$DW.close();
	};
	diag.show();
}
</script>