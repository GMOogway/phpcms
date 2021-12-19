<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('formguide');?>--<?php if ($formid) echo $r['name']; else echo L('public')?><?php echo L('field_manage');?></h2>
<div class="content-menu ib-a blue line-x"><a href="?m=formguide&c=formguide&a=init&s=3&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('表单向导');?></em></a>
　<a class="add fb" href="?m=formguide&c=formguide_field&a=add&formid=<?php echo $formid?>&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('add_field');?></em></a>
　<a class="on" href="?m=formguide&c=formguide_field&a=init&formid=<?php echo $formid?>"><em><?php echo L('manage_field');?></em></a><?php if ($formid) {?><span>|</span><a href="?m=formguide&c=formguide&a=public_preview&formid=<?php echo $formid?>&menuid=<?php echo $this->input->get('menuid')?>"><em><?php echo L('priview_modelfield');?></em></a><?php }?>
</div></div>
<div class="pad-lr-10">
<form name="myform" action="?m=formguide&c=formguide_field&a=listorder&formid=<?php echo $formid?>" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
			<th width="70"><?php echo L('listorder')?></th>
            <th><?php echo L('fields')?></th>
			<th width="150"><?php echo L('type');?></th>
			<th width="50"><?php echo L('system');?></th> 
            <th width="50"><?php echo L('must_input');?></th>
            <th width="50"><?php echo L('search');?></th>
            <th width="50"><?php echo L('contribute');?></th>
			<th width="150"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
	<?php
	foreach($datas as $r) {
		$tablename = L($r['tablename']);
	?>
    <tr>
		<td align='center'><input name='listorders[<?php echo $r['fieldid'] ? $r['fieldid'] : $r['field']?>]' type='text' size='3' value='<?php echo $r['listorder']?>' class='input-text-c'></td>
		<td><?php echo $r['name']?> / <?php echo $r['field']?></td>
		<td align='center'><?php echo $r['formtype']?></td>
		<td align='center'><?php echo $r['issystem'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'><?php echo $r['minlength'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'><?php echo $r['issearch'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'><?php echo $r['isadd'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'> <a class="btn btn-xs green" href="?m=formguide&c=formguide_field&a=edit&formid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&field=<?php echo $r['field']?>&menuid=<?php echo $this->input->get('menuid')?>"><?php echo L('edit');?></a>
		<?php if ($formid) { if(!in_array($r['field'],$forbid_fields)) { ?>
		<a class="btn btn-xs dark" href="?m=formguide&c=formguide_field&a=disabled&disabled=<?php echo $r['disabled'];?>&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $this->input->get('menuid')?>"><?php echo $r['disabled'] ? L('enable') : L('field_disabled');?></a>
		<?php } ?><?php } ?> 
		<a class="btn btn-xs red" href="javascript:confirmurl('?m=formguide&c=formguide_field&a=delete&formid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&field=<?php echo $r['field']?>&menuid=<?php echo $this->input->get('menuid')?>','<?php echo L('confirm',array('message'=>$r['name']))?>')"><?php echo L('delete')?></a>  </td>
	</tr>
	<?php } ?>
    </tbody>
    </table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder');?>" /></label>
    </div>
    <div class="col-md-5 list-page"></div>
</div>
</form>
</div>
</body>
</html>