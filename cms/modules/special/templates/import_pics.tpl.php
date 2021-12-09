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
<input type="hidden" value="public_get_pics" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 			<?php echo $model_form?>&nbsp;&nbsp; 
<span id="catids"></span>&nbsp;&nbsp; <span id="title" style="display:none;"><?php echo L('title')?>：<input type="text" name="title" size="20"></span>
				<?php echo L('input_time')?>：
				<?php $start_f = $this->input->get('start_time') ? $this->input->get('start_time') : format::date(SYS_TIME-2592000);$end_f = $this->input->get('end_time') ? $this->input->get('end_time') : format::date(SYS_TIME+86400);?>
        <div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $start_f;?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $end_f;?>" name="end_time" id="end_time">
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
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			<th><?php echo L('content_title')?></th>
			</tr>
        </thead>
<tbody>
    <?php if(is_array($data)) { foreach ($data as $r) {?>
        <tr>
		<td><div class="mt-radio-inline"><label class="mt-radio mt-radio-outline" style="display:block"><input type="radio" onclick="choosed(<?php echo $r['id']?>, <?php echo $r['catid']?>, '<?php echo $r['title']?>')" class="inputcheckbox" name='ids' value="<?php echo $r['id'];?>"> <?php echo $r['title'];?><span></span></label></div></td>
		</tr>
     <?php } }?>
</tbody>
     </table>
</div>
<input type="hidden" name="msg_id" id="msg_id">
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select"></div>
    <div class="col-md-5 list-page"><?php echo $pages;?></div>
</div>
</div>
</body>
</html>
<script type="text/javascript">

	function choosed(contentid, catid, title) {
		var msg = contentid+'|'+catid+'|'+title;
		$('#msg_id').val(msg);
	}

	function select_categorys(modelid, id) {
		if(modelid) {
			$.get('', {m: 'special', c: 'special', a: 'public_categorys_list', modelid: modelid, catid: id, pc_hash: pc_hash }, function(data){
				if(data) {
					$('#catids').html(data);
					$('#title').show();
				} else {
					$('#catids').html('');
					$('#title').hide();
				}
			});
		}
	}
	select_categorys(<?php echo $_GET['modelid']?>, <?php echo $_GET['catid']?>);
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){Dialog.alert(msg,function(){$(obj).focus();})}});
		$("#typeid").formValidator({tipid:"msg_id",onshow:"<?php echo L('please_choose_type')?>",oncorrect:"<?php echo L('true')?>"}).inputValidator({min:1,onerror:"<?php echo L('please_choose_type')?>"});	
	});
	$("#myform").submit(function (){
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')==true) str = 1;
		});
		if(str==0) {
			Dialog.alert('<?php echo L('choose_news')?>');
			return false;
		}
		return true;
	});
</script>