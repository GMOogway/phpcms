<?php 
defined('IS_ADMIN') or exit('No permission resources.'); 
$show_header = $show_validator = $show_scroll = 1; 
include $this->admin_tpl('header','admin');
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
<br />
<div class="pad-lr-10">
<div id="searchid" style="display:">
<form name="searchform" action="" method="get" >
<input type="hidden" value="special" name="m">
<input type="hidden" value="special" name="c">
<input type="hidden" value="import" name="a">
<input type="hidden" value="<?php echo $this->input->get('specialid')?>" name="specialid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 			<?php echo $model_form?>&nbsp;&nbsp; <?php echo L('keyword')?>：<input type='text' name="key" id="key" value="<?php echo $this->input->get('key');?>" size="25"> <div class="bk10"></div>
<span id="catids"></span>&nbsp;&nbsp; 
				<?php echo L('input_time')?>：
				<?php $start_f = $this->input->get('start_time') ? $this->input->get('start_time') : format::date(SYS_TIME-2592000);$end_f = $this->input->get('end_time') ? $this->input->get('end_time') : format::date(SYS_TIME+86400);?>
        <div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $this->input->get('start_time');?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $this->input->get('end_time');?>" name="end_time" id="end_time">
            </div>
        </div>
				 <input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<form name="myform" id="myform" action="?m=special&c=special&a=import&specialid=<?php echo $this->input->get('specialid')?>&modelid=<?php echo $this->input->get('modelid')?>" method="post">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			<th class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('ids[]');" />
                        <span></span>
                    </label></th>
            <th width="80"><?php echo L('listorder')?></th>
			<th><?php echo L('content_title')?></th>
            </tr>
        </thead>
<tbody>
    <?php if(is_array($data)) { foreach ($data as $r) {?>
        <tr>
		<td align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name='ids[]' value="<?php echo $r['id'];?>" />
                        <span></span>
                    </label></td>
        <td align='center'><input name='listorders[<?php echo $r['id'];?>]' type='text' size='3' value='<?php echo $r['listorder'];?>' class='input-text-c'></td>
		<td><?php echo $r['title'];?></td>
	</tr>
     <?php } }?>
</tbody>
     </table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><?php echo form::select($types, '', 'name="typeid" id="typeid"', L('please_choose_type'))?><span id="msg_id"></span><button type="submit" class="btn green btn-sm"> <i class="fa fa-save"></i> <?php echo L('import')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
	function select_categorys(modelid, id) {
		if(modelid) {
			$.get('', {m: 'special', c: 'special', a: 'public_categorys_list', modelid: modelid, catid: id, pc_hash: pc_hash }, function(data){
				if(data) {
					$('#catids').html(data);
				} else $('#catids').html('');
			});
		}
	}
	select_categorys(<?php echo $this->input->get('modelid')?>, <?php echo $this->input->get('catid')?>);
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){Dialog.alert(msg,function(){$(obj).focus();})}});
		$("#typeid").formValidator({tipid:"msg_id",onshow:"<?php echo L('please_choose_type')?>",oncorrect:"<?php echo L('true')?>"}).inputValidator({min:1,onerror:"<?php echo L('please_choose_type')?>"});	
	});
	$("#myform").submit(function (){
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')=='checked') str = 1;
		});
		if(str==0) {
			Dialog.alert('<?php echo L('choose_news')?>');
			return false;
		}
		return true;
	});
</script>