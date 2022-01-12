<?php 
defined('IS_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = true; 
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
    <?php if(is_mobile(0)) {?>
    <div class="content-menu btn-group dropdown-btn-group"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-th-large"></i> 菜单 <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu">
            <?php if(isset($big_menu)) { echo '<li><a class="add fb" href="'.$big_menu[0].'"><i class="fa fa-plus"></i> '.$big_menu[1].'</a></li><div class="dropdown-line"></div>';} else {$big_menu = '';} ?>
            <?php echo admin::submenu($this->input->get('menuid'),$big_menu); ?>
            <div class="dropdown-line"></div>
            <li><a href="javascript:artdialog('setting','?m=formguide&c=formguide&a=setting','<?php echo L('module_setting')?>',540,350);void(0);"><i class="fa fa-cogs"></i> <?php echo L('module_setting')?></a></li>
        </ul>
    </div>
    <?php } else {?>
    <div class="content-menu ib-a blue">
    <?php if(isset($big_menu)) { echo '<a class="add fb" href="'.$big_menu[0].'"><i class="fa fa-plus"></i> '.$big_menu[1].'</a><i class="fa fa-circle"></i>';} else {$big_menu = '';} ?>
    <?php echo admin::submenu($this->input->get('menuid'),$big_menu); ?><i class="fa fa-circle"></i><a href="javascript:artdialog('setting','?m=formguide&c=formguide&a=setting','<?php echo L('module_setting')?>',540,350);void(0);"><i class="fa fa-cogs"></i> <?php echo L('module_setting')?></a>
    </div>
    <?php }?>
</div>
<div class="content-header"></div>
<div class="pad-lr-10">
<form name="myform" id="myform" action="?m=formguide&c=formguide&a=listorder" method="post">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('formid[]');" />
                        <span></span>
                    </label></th>
			<th><?php echo L('name_items')?></th>
			<th width='180'><?php echo L('tablename')?></th>
			<th width="180"><?php echo L('create_time')?></th>
			<th width="220"><?php echo L('call')?></th>
			<th width="80"><?php echo L('状态')?></th>
			<th><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $form){
?>
	<tr>
	<td class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="formid[]" value="<?php echo $form['modelid']?>" />
                        <span></span>
                    </label></td>
	<td><?php echo $form['name']?> <?php if ($form['items']) {?>(<?php echo $form['items']?>)<?php }?></td>
	<td align="center"><?php echo $form['tablename']?></td>
	<td align="center"><?php echo date('Y-m-d H:i:s', $form['addtime'])?></td>
	<td align="center"><input type="text" value="<script language='javascript' src='{APP_PATH}index.php?m=formguide&c=index&a=show&formid=<?php echo $form['modelid']?>&action=js&siteid=<?php echo $form['siteid']?>'></script>"></td>
	<td align="center"><a class="btn btn-xs dark" href="?m=formguide&c=formguide&a=disabled&formid=<?php echo $form['modelid']?>&val=<?php echo $form['disabled'] ? 0 : 1;?>"><?php if ($form['disabled']==0) {echo L('field_disabled');} else {echo L('enable');}?></a></td>
	<td align="center">
	<a class="btn btn-xs yellow" href="<?php echo APP_PATH;?>index.php?m=formguide&c=index&a=show&formid=<?php echo $form['modelid']?>&siteid=<?php echo $form['siteid']?>" target="_blank"><?php echo L('preview')?></a>
	<a class="btn btn-xs blue" href="?m=formguide&c=formguide_info&a=init&formid=<?php echo $form['modelid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('info_list')?></a>
	<a class="btn btn-xs green" href="?m=formguide&c=formguide&a=edit&formid=<?php echo $form['modelid']?>"><?php echo L('modify')?></a>
	<a class="btn btn-xs dark" href="?m=formguide&c=formguide_field&a=init&formid=<?php echo $form['modelid']?>"><?php echo L('field_manage')?></a>
	<a class="btn btn-xs red" href="###" onClick="Dialog.confirm('<?php echo L('confirm', array('message' => new_addslashes(new_html_special_chars($form['name']))))?>',function(){redirect('?m=formguide&c=formguide&a=delete&formid=<?php echo $form['modelid']?>&pc_hash='+pc_hash);});"><?php echo L('del')?></a>
	<a class="btn btn-xs yellow" href="javascript:stat('<?php echo $form['modelid']?>', '<?php echo safe_replace($form['name'])?>');void(0);"><?php echo L('stat')?></a></td>
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
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('affirm_delete')?>',function(){document.myform.action='?m=formguide&c=formguide&a=delete';$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('remove_all_selected')?></button></label>
    </div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $this->db->pages;?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function stat(id, title) {
	var w = 700;
	var h = 500;
	if (is_mobile()) {
		w = h = '100%';
	}
	var diag = new Dialog({
		id:'stat',
		title:'<?php echo L('stat_formguide')?>--'+title,
		url:'<?php echo SELF;?>?m=formguide&c=formguide&a=stat&formid='+id+'&pc_hash='+pc_hash,
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