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
            <li><a href="javascript:artdialog('setting','?m=poster&c=space&a=setting','<?php echo L('module_setting')?>',540,320);void(0);"><i class="fa fa-cog"></i> <?php echo L('module_setting')?></a></li>
        </ul>
    </div>
    <?php } else {?>
    <div class="content-menu ib-a">
    <?php if(isset($big_menu)) { echo '<a class="add fb" href="'.$big_menu[0].'"><i class="fa fa-plus"></i> '.$big_menu[1].'</a><i class="fa fa-circle"></i>';} else {$big_menu = '';} ?>
    <?php echo admin::submenu($this->input->get('menuid'),$big_menu); ?><i class="fa fa-circle"></i><a href="javascript:artdialog('setting','?m=poster&c=space&a=setting','<?php echo L('module_setting')?>',540,320);void(0);"><i class="fa fa-cog"></i> <?php echo L('module_setting')?></a>
    </div>
    <?php }?>
</div>
<div class="content-header"></div>
<div class="pad-lr-10">
<form name="myform" action="?m=poster&c=space&a=delete" method="post" id="myform">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('spaceid[]');" />
                        <span></span>
                    </label></th>
			<th><?php echo L('boardtype')?></th>
			<th width="100" align="center"><?php echo L('ads_type')?></th>
			<th width='120' align="center"><?php echo L('size_format')?></th>
			<th width="80" align="center"><?php echo L('ads_num')?></th>
			<th align="center"><?php echo L('description')?></th>
			<th align="center"><?php echo L('operations_manage')?></th>
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
                        <input type="checkbox" class="checkboxes" name="spaceid[]" value="<?php echo $info['spaceid']?>" />
                        <span></span>
                    </label></td>
	<td><?php echo $info['name']?></td>
	<td align="center"><?php echo $TYPES[$info['type']]?></td>
	<td align="center"><?php echo $info['width']?>*<?php echo $info['height']?></td>
	<td align="center"><?php echo $info['items']?></td>
	<td align="center"><?php echo $info['description']?></td>
	<td align="center">
	<a class="btn btn-xs blue" href="?m=poster&c=space&a=public_preview&spaceid=<?php echo $info['spaceid']?>" target="_blank"><?php echo L('preview')?></a> <a class="btn btn-xs dark" href="javascript:call(<?php echo $info['spaceid']?>);void(0);"><?php echo L('get_code')?></a> <a class="btn btn-xs yellow" href='?m=poster&c=poster&a=init&spaceid=<?php echo $info['spaceid']?>&menuid=<?php echo $_GET['menuid']?>' ><?php echo L('ad_list')?></a> 
	<a class="btn btn-xs green" href="###" onclick="edit(<?php echo $info['spaceid']?>, '<?php echo new_addslashes(new_html_special_chars($info['name']))?>')" title="<?php echo L('edit')?>" ><?php echo L('edit')?></a>
	<a class="btn btn-xs red" href='###' onClick="Dialog.confirm('<?php echo L('confirm', array('message' => new_addslashes(new_html_special_chars($info['name']))))?>',function(){redirect('?m=poster&c=space&a=delete&spaceid=<?php echo $info['spaceid']?>&pc_hash='+pc_hash);});"><?php echo L('delete')?></a>
	<a class="btn btn-xs blue" href="<?php echo SELF;?>?m=poster&c=poster&a=add&spaceid=<?php echo $info['spaceid']?>&menuid=<?php echo $_GET['menuid']?>&pc_hash=<?php echo dr_get_csrf_token()?>">添加广告</a>
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
    <div class="col-md-5 col-sm-5 table-footer-button">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('confirm', array('message' => L('selected')))?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('remove_all_selected')?></button></label>
    </div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function edit(id, name){
	artdialog('testIframe'+id,'?m=poster&c=space&a=edit&spaceid='+id,'<?php echo L('edit_space')?>--'+name,540,320);
};
function call(id) {
	omnipotent('call','?m=poster&c=space&a=public_call&sid='+id,'<?php echo L('get_code')?>',1,600,470);
}
//-->
</script>
</body>
</html>