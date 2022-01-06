<?php defined('IS_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<form name="myform" action="?m=collection&c=node&a=import_program_add&nodeid=<?php if(isset($nodeid)) echo $nodeid?>&type=<?php echo $type?>&ids=<?php echo $ids?>&catid=<?php echo $catid?>" method="post" id="myform">
<input name="dosubmit" type="hidden" value="1">
<fieldset>
	<legend><?php echo L('the_new_publication_solutions')?></legend>
	
		<table width="100%" class="table_form">
			<tr>
			<td width="120"><?php echo L('category')?>：</td> 
			<td>
			<?php echo $cat['catname'];?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('the_withdrawal_of_the_summary')?>：</td> 
			<td>
			<label class="mt-checkbox mt-checkbox-outline"><input name="add_introduce" type="checkbox"  value="1"><?php echo L('if_the_contents_of_intercepted')?><span></span></label><input type="text" name="introcude_length" value="200" size="3"><?php echo L('characters_to_a_summary_of_contents')?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('the_withdrawal_of_thumbnails')?>：</td> 
			<td>
			<label class="mt-checkbox mt-checkbox-outline"><input type='checkbox' name='auto_thumb' value="1"><?php echo L('whether_access_to_the_content_of')?><span></span></label><input type="text" name="auto_thumb_no" value="1" size="2" class=""><?php echo L('picture_a_caption_pictures')?>
			
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('import_article_state')?>：</td> 
			<td>
			<?php if(!empty($cat['setting']['workflowid'])) {echo form::radio(array('1'=>L('pendingtrial'), '99'=>L('fantaoboys')), '1', 'name="content_status"');} else {echo form::radio(array('99'=>L('fantaoboys')), '99', 'name="content_status"');}?>
			</td>
		</tr>
	</table>
</fieldset>
<div class="bk10"></div>
<fieldset>
	<legend><?php echo L('corresponding_labels_and_a_database_ties') ?></legend>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left"><?php echo L('the_original_database_field')?></th>
			<th align="left"><?php echo L('explain')?></th>
			<th align="left"><?php echo L('label_field__collected_with_the_result_')?></th>
			<th align="left"><?php echo L('handler_functions')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($model as $k=>$v) {
		if (in_array($v['formtype'], array('catid', 'typeid', 'posids', 'groupid', 'readpoint','template'))) continue;
?>
    <tr>
		<td align="left"><?php echo $v['field']?></td>
		<td align="left"><?php echo $v['name']?></td>
		<td align="left"><input type="hidden" name="model_field[]" value="<?php echo $v['field']?>"><?php echo form::select($node_field, (in_array($v['field'], array('inputtime', 'updatetime')) ? 'time' : $v['field']), 'name="node_field[]"')?></td>
		<td align="left"><input type="text" id="funcs" name="funcs[]" class="funcs"><?php echo form::select($spider_funs, '', 'name="" onchange="$(\'#funcs\').val(this.value);"', '请选择')?></td>
    </tr>
<?php
	}

?>
</tbody>
</table>
</div>
</fieldset>
<div class="list-footer table-checkable clear">
    <div class="col-md-5 col-sm-5 table-footer-button">
        <label><button type="submit" class="btn green btn-sm"> <i class="fa fa-save"></i> <?php echo L('submit')?></button></label>
    </div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>