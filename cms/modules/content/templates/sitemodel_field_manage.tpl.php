<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="subnav">
<?php if($modelid==-1) {?>
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('category').L('field_manage');?></h2>
<?php } else if($modelid==-2) {?>
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('category_page').L('field_manage');?></h2>
<?php } else if($modelid) {?>
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('model_manage');?>--<?php echo $r['name'];?><?php echo L('field_manage');?></h2>
<?php } else {?>
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('sites').L('field_manage');?></h2>
<?php }?>
<div class="content-menu ib-a blue line-x">
<?php if($modelid==-1) {?>
<a href="?m=admin&c=category&a=init&module=admin&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('管理栏目');?></em></a>
<?php } else if($modelid==-2) {?>
<a href="?m=admin&c=category&a=init&module=admin&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('管理栏目');?></em></a>
<?php } else if($modelid) {?>
<a href="?m=content&c=sitemodel&a=init&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('模型管理');?></em></a>
<?php } else {?>
<a href="?m=admin&c=site&a=init&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('站点管理');?></em></a>
<?php }?>
　<a class="add fb" href="?m=content&c=sitemodel_field&a=add&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('add_field');?></em></a>
　<a class="on" href="?m=content&c=sitemodel_field&a=init&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>"><em><?php if($modelid==-1) {echo L('category').L('field_manage');} else if($modelid==-2) {echo L('category_page').L('field_manage');} else if($modelid) {echo L('manage_field');} else {echo L('sites').L('field_manage');}?></em></a><?php if($modelid && $modelid!=-1 && $modelid!=-2) {?><span>|</span>
<a href="javascript:;" onclick="javascript:openwinx('?m=content&c=sitemodel_field&a=public_priview&modelid=<?php echo $modelid?>&menuid=<?php echo $this->input->get('menuid')?>&pc_hash=<?php echo dr_get_csrf_token();?>','')"><em><?php echo L('priview_modelfield');?></em></a>
<?php }?>
</div></div>
<div class="pad-lr-10">
<form name="myform" action="?m=content&c=sitemodel_field&a=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr class="heading">
			<th width="70" class="<?php echo dr_sorting('listorder')?>" name="listorder"><?php echo L('listorder')?></th>
            <th class="<?php echo dr_sorting('field')?>" name="field"><?php echo L('fieldname')?></th>
			<th width="150" class="<?php echo dr_sorting('name')?>" name="name"><?php echo L('cnames');?></th>
			<th width="150" class="<?php echo dr_sorting('formtype')?>" name="formtype"><?php echo L('type');?></th>
			<th width="50"><?php echo L('system');?></th> 
            <th width="50"><?php echo L('must_input');?></th>
            <th width="50"<?php if(!$modelid || $modelid==-1) {echo ' style="display: none;"';}?>><?php echo L('search');?></th>
            <th width="50"<?php if(!$modelid || $modelid==-1) {echo ' style="display: none;"';}?>><?php echo L('listorder');?></th>
            <th width="50"<?php if(!$modelid || $modelid==-1) {echo ' style="display: none;"';}?>><?php echo L('contribute');?></th>
			<th width="150"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody class="td-line">
	<?php
	foreach($datas as $r) {
		$tablename = L($r['tablename']);
	?>
    <tr>
		<td align='center'><input name='listorders[<?php echo $r['fieldid']?>]' type='text' size='3' value='<?php echo $r['listorder']?>' class='input-text-c'></td>
		<td><?php echo $r['field']?></td>
		<td><?php echo $r['name']?></td>
		<td align='center'><?php echo $r['formtype']?></td>
		<td align='center'><?php echo $r['issystem'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'><?php echo $r['minlength'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'<?php if(!$modelid || $modelid==-1) {echo ' style="display: none;"';}?>><?php echo $r['issearch'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'<?php if(!$modelid || $modelid==-1) {echo ' style="display: none;"';}?>><?php echo $r['isorder'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'<?php if(!$modelid || $modelid==-1) {echo ' style="display: none;"';}?>><?php echo $r['isadd'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'> <a class="btn btn-xs green" href="?m=content&c=sitemodel_field&a=edit&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $this->input->get('menuid')?>"><?php echo L('edit');?></a>
		<?php if(!in_array($r['field'],$forbid_fields)) { ?>
		<a class="btn btn-xs dark" href="?m=content&c=sitemodel_field&a=disabled&disabled=<?php echo $r['disabled'];?>&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $this->input->get('menuid')?>"><?php echo $r['disabled'] ? L('field_enabled') : L('field_disabled');?></a>
		<?php } ?><?php if(!in_array($r['field'],$forbid_delete)) {?> 
		<a class="btn btn-xs red" href="javascript:confirmurl('?m=content&c=sitemodel_field&a=delete&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $this->input->get('menuid')?>','<?php echo L('confirm',array('message'=>$r['name']))?>')"><?php echo L('delete')?></a><?php }?> </td>
	</tr>
	<?php } ?>
    </tbody>
    </table>
</div>
   <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder');?>" /></div>
</form>
</div>
</body>
</html>
