<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<link href="<?php echo JS_PATH;?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            format: "yyyy-mm-dd",
            orientation: "left",
            autoclose: true
        });
    }
});
</script>
<div class="pad_10">
<form action="?" method="get">
<input type="hidden" name="m" value="block">
<input type="hidden" name="c" value="block_admin">
<input type="hidden" name="a" value="public_search_content">
<table width="100%" class="table_form">
		<tr>
			<td width="80"><?php echo L('category')?>:</td> 
			<td><?php if(isset($_GET['dosubmit'])){?><div class="rt"><a href="javascript:void(0)" onclick="$('#search').toggle()"><?php echo L('folded_up_in_search_of')?></a></div><?php } echo form::select_category('category_content_'.$this->siteid, $catid, 'name="catid" id="catid"', '', '', '0', 1)?> </td>
		</tr>
		<tbody id="search" <?php if(isset($_GET['dosubmit'])) echo 'style="display:none"';?>>
		<tr>
			<td><?php echo L('posterize_time')?>:</td> 
			<td>
        <div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $start_time ? date('Y-m-d', $start_time) : '';?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $end_time ? date('Y-m-d', $end_time) : '';?>" name="end_time" id="end_time">
            </div></td>
		</tr>
		<tr>
			<td><?php echo L('recommend')?>：</td> 
			<td>
			<?php echo form::select(array(''=>L('all'), '1'=>L('recommend'), '2'=>L('not_recommend')), $posids, 'name="posids"')?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('search_mode')?>：</td>
			<td>
			<?php echo form::select(array('1'=>L('title'), '2'=>L('desc'), '3'=>L('username'), '4'=>'ID'), $searchtype, 'name="searchtype"')?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('key_word')?>：</td>
			<td>
			<input name="keyword" type="text" value="<?php echo $keyword?>" class="input-text" />
</td>
		</tr>
		<tr>
			<td></td>
			<td>
			<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" />
</td>
		</tr>
		</tbody>
	</table>
	</form>
<?php if (isset($_GET['dosubmit']) && !empty($data)) :?>	
	<label class="mt-checkbox mt-checkbox-outline"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"><span></span></label><input type="button" value="<?php echo L('insert_a_comment_about_the_selected_text')?>" class="button" onclick="insert_form()">
<div class="table-list">
<table width="100%">
<tbody>
<?php foreach ($data as $v):?>
<tr>
<td align="center" width="40"><label class="mt-checkbox mt-checkbox-outline"><input class="inputcheckbox " name="ids[]" value="{title:'<?php echo str_replace('\'', '\\\'', $v['title'])?>', thumb:'<?php echo $v['thumb']?>', desc:'<?php echo str_replace(array('\'', "\r","\n"), array('\\\'', "", ""), $v['description'])?>', url:'<?php echo $v['url']?>'}" type="checkbox"><span></span></label></td>
<td><?php echo $v['title']?> <?php if ($v['thumb']) echo '<font color="red">['.L('pic').']</font>'?></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label><label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="button" value="<?php echo L('insert_a_comment_about_the_selected_text')?>" class="button" onclick="insert_form()"></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
<?php endif;?>	
	</div>
<script type="text/javascript">
<!--
function insert_form() {
	$("input[type='checkbox'][name='ids[]']:checked").each(function(i,n){parent.insert_forms($(n).val());});
	ownerDialog.close();
}
//-->
</script>
</body>
</html>