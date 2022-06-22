<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="subnav">
    <?php if(is_mobile(0)) {?>
    <div class="content-menu btn-group dropdown-btn-group"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-th-large"></i> 菜单 <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu">
            <?php if($modelid==-1) {?>
            <li><a href="?m=admin&c=category&a=init&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-reorder"></i> <?php echo L('管理栏目');?></a></li>
            <?php } else if($modelid==-2) {?>
            <li><a href="?m=admin&c=category&a=init&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-reorder"></i> <?php echo L('管理栏目');?></a></li>
            <?php } else if($modelid) {?>
            <li><a href="?m=content&c=sitemodel&a=init&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-cogs"></i> <?php echo L('模型管理');?></a></li>
            <?php } else {?>
            <li><a href="?m=admin&c=site&a=init&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-home"></i> <?php echo L('站点管理');?></a></li>
            <?php }?>
            <div class="dropdown-line"></div>
            <li><a class="add fb" href="?m=content&c=sitemodel_field&a=add&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-plus"></i> <?php echo L('add_field');?></a></li>
            <div class="dropdown-line"></div>
            <li><a class="on" href="?m=content&c=sitemodel_field&a=init&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-code"></i> <?php if($modelid==-1) {echo L('category').L('field_manage');} else if($modelid==-2) {echo L('category_page').L('field_manage');} else if($modelid) {echo L('manage_field');} else {echo L('sites').L('field_manage');}?></a></li><?php if($modelid && $modelid!=-1 && $modelid!=-2) {?><div class="dropdown-line"></div><li><a href="javascript:;" onclick="javascript:openwinx('?m=content&c=sitemodel_field&a=public_priview&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>&pc_hash=<?php echo dr_get_csrf_token();?>','')"><i class="fa fa-eye"></i> <?php echo L('priview_modelfield');?></a></li>
            <?php }?>
        </ul>
    </div>
    <?php } else {?>
    <div class="content-menu ib-a">
<?php if($modelid==-1) {?>
<a href="?m=admin&c=category&a=init&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-reorder"></i> <?php echo L('管理栏目');?></a>
<?php } else if($modelid==-2) {?>
<a href="?m=admin&c=category&a=init&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-reorder"></i> <?php echo L('管理栏目');?></a>
<?php } else if($modelid) {?>
<a href="?m=content&c=sitemodel&a=init&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-cogs"></i> <?php echo L('模型管理');?></a>
<?php } else {?>
<a href="?m=admin&c=site&a=init&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-home"></i> <?php echo L('站点管理');?></a>
<?php }?>
<i class="fa fa-circle"></i><a class="add fb" href="?m=content&c=sitemodel_field&a=add&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-plus"></i> <?php echo L('add_field');?></a>
<i class="fa fa-circle"></i><a class="on" href="?m=content&c=sitemodel_field&a=init&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>"><i class="fa fa-code"></i> <?php if($modelid==-1) {echo L('category').L('field_manage');} else if($modelid==-2) {echo L('category_page').L('field_manage');} else if($modelid) {echo L('manage_field');} else {echo L('sites').L('field_manage');}?></a><?php if($modelid && $modelid!=-1 && $modelid!=-2) {?><i class="fa fa-circle"></i><a href="javascript:;" onclick="javascript:openwinx('?m=content&c=sitemodel_field&a=public_priview&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>&pc_hash=<?php echo dr_get_csrf_token();?>','')"><i class="fa fa-eye"></i> <?php echo L('priview_modelfield');?></a>
<?php }?>
    </div>
    <?php }?>
</div>
<div class="content-header"></div>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="note note-danger">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('update_cache_all');?></a></p>
</div>
<div class="right-card-box">
<form name="myform" action="?m=content&c=sitemodel_field&a=listorder" method="post">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr class="heading">
			<th width="70"><?php echo L('listorder')?></th>
            <th><?php echo L('fields')?></th>
			<th width="150"><?php echo L('type');?></th>
			<th width="50"><?php echo L('system');?></th> 
            <th width="50"><?php echo L('must_input');?></th>
            <th width="50"<?php if(!$modelid || $modelid==-1 || $modelid==-2) {echo ' style="display: none;"';}?>><?php echo L('search');?></th>
            <th width="50"<?php if(!$modelid || $modelid==-1 || $modelid==-2) {echo ' style="display: none;"';}?>><?php echo L('contribute');?></th>
			<th width="150"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
	<?php foreach($datas as $r) {?>
    <tr>
		<td align='center'><input name='listorders[<?php echo $r['fieldid']?>]' type='text' size='3' value='<?php echo $r['listorder']?>' class='input-text-c'></td>
		<td><?php echo $r['name']?> / <?php echo $r['field']?></td>
		<td align='center'><?php echo $r['formtype']?></td>
		<td align='center'><?php echo $r['issystem'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'><?php echo $r['minlength'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'<?php if(!$modelid || $modelid==-1 || $modelid==-2) {echo ' style="display: none;"';}?>><?php echo $r['issearch'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'<?php if(!$modelid || $modelid==-1 || $modelid==-2) {echo ' style="display: none;"';}?>><?php echo $r['isadd'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'> <a class="btn btn-xs green" href="?m=content&c=sitemodel_field&a=edit&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $this->input->get('menuid')?>"><?php echo L('edit');?></a>
		<?php if(!in_array($r['field'],$forbid_fields)) { ?>
		<a class="btn btn-xs dark" href="?m=content&c=sitemodel_field&a=disabled&disabled=<?php echo $r['disabled'];?>&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $this->input->get('menuid')?>"><?php echo $r['disabled'] ? L('enable') : L('field_disabled');?></a>
		<?php } ?><?php if(!in_array($r['field'],$forbid_delete)) {?> 
		<a class="btn btn-xs red" href="javascript:confirmurl('?m=content&c=sitemodel_field&a=delete&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $this->input->get('menuid')?>','<?php echo L('confirm',array('message'=>$r['name']))?>')"><?php echo L('delete')?></a><?php }?> </td>
	</tr>
	<?php } ?>
    </tbody>
    </table>
</div>
<div class="row list-footer table-checkable">
    <div class="col-md-5 list-select">
        <label><button type="submit" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('listorder')?></button></label>
    </div>
    <div class="col-md-7 list-page"></div>
</div>
</form>
</div>
</div>
</div>
</div>
</body>
</html>
