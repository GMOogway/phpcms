<?php
defined('IS_ADMIN') or exit('No permission resources.');
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
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="right-card-box">
<form name="myform" action="?m=poster&c=poster&a=listorder" method="post" id="myform">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%" cellspacing="0" class="contentWrap">
        <thead>
            <tr>
            <th align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('id[]');" />
                        <span></span>
                    </label></th>
			<th width="60">ID</th>
			<th width="80"><?php echo L('listorder')?></th>
			<th align="center"><?php echo L('poster_title')?></th>
			<th width="80" align="center"><?php echo L('poster_type')?></th>
			<th align="center"><?php echo L('for_postion')?></th>
			<th width="100" align="center"><?php echo L('status')?></th>
			<th width='100' align="center"><?php echo L('hits')?></th>
			<th width="160" align="center"><?php echo L('addtime')?></th>
			<th align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
        <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
		$space = $this->s_db->get_one(array('spaceid'=>$info['spaceid']), 'name');
?>   
	<tr>
	<td align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="id[]" value="<?php echo $info['id']?>" />
                        <span></span>
                    </label></td>
	<td align="center"><?php echo $info['id']?></td>
	<th><input type="text" size="5" name="listorder[<?php echo $info['id']?>]" value="<?php echo $info['listorder']?>" id="listorder" class="input-text-c"></th>
	<td><?php echo $info['name']?></td>
	<td align="center"><?php echo $types[$info['type']]?></td>
	<td align="center"><?php echo $space['name']?></td>
	<td align="center"><?php if($info['disabled']) { echo L('stop'); } elseif((strtotime($info['enddate'])<SYS_TIME) && (strtotime($info['enddate'])>0)) { echo L('past'); } else { echo L('start'); }?></td>
	<td align="center"><?php echo $info['clicks']?></td>
	<td align="center"><?php echo dr_date($info['addtime'], null, 'red');?></td>
	<td align="center"><a class="btn btn-xs green" href="<?php echo SELF;?>?m=poster&c=poster&a=edit&id=<?php echo $info['id'];?>&pc_hash=<?php echo dr_get_csrf_token();?>&menuid=<?php echo $_GET['menuid']?>" ><?php echo L('edit')?></a><a class="btn btn-xs blue" href="?m=poster&c=poster&a=stat&id=<?php echo $info['id']?>&spaceid=<?php echo $_GET['spaceid'];?>"><?php echo L('stat')?></a></td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
</div>
<div class="row list-footer table-checkable">
    <div class="col-md-5 list-select">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="submit" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('listorder')?></button></label>
        <label><button type="submit" onClick="document.myform.action='?m=poster&c=poster&a=public_approval&passed=0'" class="btn blue btn-sm"> <i class="fa fa-play-circle-o"></i> <?php echo L('start')?></button></label>
        <label><button type="submit" onClick="document.myform.action='?m=poster&c=poster&a=public_approval&passed=1'" class="btn dark btn-sm"> <i class="fa fa-stop-circle-o"></i> <?php echo L('stop')?></button></label>
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('confirm', array('message' => L('selected')))?>',function(){document.myform.action='?m=poster&c=poster&a=delete';$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('delete')?></button></label>
    </div>
    <div class="col-md-7 list-page"><?php echo $this->db->pages;?></div>
</div>
</form>
</div>
</div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
<!--
function edit(id, name) {
	artdialog('edit','?m=poster&c=poster&a=edit&id='+id,'<?php echo L('edit_ads')?>--'+name,600,430);
}
//-->
</script>