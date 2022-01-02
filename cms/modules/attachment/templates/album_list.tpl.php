<?php 
$show_header = $show_validator = $show_scroll = true; 
include $this->admin_tpl('header', 'attachment');
?>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
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
    $('.tooltips').tooltip();
});
</script>
<!--上传组件js-->
<script src="<?php echo JS_PATH?>assets/ds.min.js"></script>
<link href="<?php echo JS_PATH?>h5upload/h5upload.css" rel="stylesheet" type="text/css" />
<div style="float: left;">
<form name="myform" action="" method="get" >
<input type="hidden" value="attachment" name="m">
<input type="hidden" value="attachments" name="c">
<input type="hidden" value="album_load" name="a">
<input type="hidden" name="dosubmit" value="1">
<input type="hidden" value="<?php echo $this->input->get('args');?>" name="args">
<input type="hidden" value="<?php echo $this->input->get('authkey');?>" name="authkey">
<input type="hidden" value="<?php echo $file_types_post?>" name="site_allowext">
<input type="hidden" value="<?php echo $file_upload_limit?>" name="info[file_upload_limit]">
<div class="lh26" style="padding:0 0 10px">
<label><?php echo L('name')?></label>
<label><input type="text" value="<?php echo isset($filename) && $filename ? $filename : '';?>" class="input-text" name="info[filename]"></label>
<label><?php echo L('date')?></label>
<label><div class="formdate">
<div class="form-date input-group">
<div class="input-group input-time date date-picker">
<input type="text" class="form-control" name="info[uploadtime]" value="<?php echo $uploadtime;?>">
<span class="input-group-btn">
<button class="btn default" type="button">
<i class="fa fa-calendar"></i>
</button>
</span>
</div>
</div>
</div></label>
<label><button type="submit" class="btn green btn-sm" name="submit"> <i class="fa fa-search"></i> <?php echo L('search')?></button></label>
</div>
</form>
</div>
<div style="float: right;margin-right:10px;"><label><span id="all" class="btn green btn-sm" style="margin-right:10px;">全选</span></label><label><span id="allno" class="btn red btn-sm" style="margin-right:10px;">全不选</span></label><label><span id="other" class="btn dark btn-sm">反选</span></label></div>
<div class="bk20 hr"></div>
<div class="files clear">
<?php foreach($infos as $r) {?>
	<div class="files_row tooltips" data-original-title="<?php echo $r['filename']?>&nbsp;&nbsp;<?php echo format_file_size($r['filesize'])?>">
		<span class="checkbox"></span>
		<input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $r['aid']?>" />
		<a><img src="<?php echo $r['src']?>" id="<?php echo $r['aid']?>" width="<?php echo $r['width']?>" path="<?php echo dr_get_file_url($r)?>" size="<?php echo format_file_size($r['filesize'])?>" filename="<?php echo $r['filename']?>"/></a>
		<i class="size"> <?php echo format_file_size($r['filesize'])?> </i>
		<i class="name" title="<?php echo $r['filename']?>"><?php echo $r['filename']?></i>
	</div>
<?php } ?>
</div>
<div class="clear"></div>
<div class="col-md-12 text-center margin-bottom-20"><?php echo $pages?></div>
<script type="text/javascript">
$(document).ready(function(){
	set_status_empty();
});	
function set_status_empty(){
	parent.window.$('#att-status').html('');
	parent.window.$('#att-name').html('');
}
var ds = new DragSelect({
	selectables: document.getElementsByClassName('files_row'),
	multiSelectMode: true,
	//选中
	onElementSelect: function(element){
		var id = $(element).children("a").children("img").attr("id");
		var src = $(element).children("a").children("img").attr("path");
		var filename = $(element).children("a").children("img").attr("filename");
		var size = $(element).children("a").children("img").attr("size");
		var num = parent.window.$('#att-status').html().split('|').length;
		var file_upload_limit = '<?php echo $file_upload_limit?>';
		if(num > file_upload_limit) {
			//Dialog.alert('不能选择超过'+file_upload_limit+'个附件');
		}else{
			$(element).children("a").addClass("on");
			$.get('<?php echo SELF;?>?m=attachment&c=attachments&a=h5upload_json&aid='+id+'&src='+src+'&filename='+filename+'&size='+size);
			parent.window.$('#att-status').append('|'+src);
			parent.window.$('#att-name').append('|'+filename);
			$(element).addClass('on').find('input[type="checkbox"]').prop('checked', true);
		}
	},
	//取消选中
	onElementUnselect: function(element){
		$(element).children("a").removeClass("on");
		var id = $(element).children("a").children("img").attr("id");
		var src = $(element).children("a").children("img").attr("path");
		var filename = $(element).children("a").children("img").attr("filename");
		var size = $(element).children("a").children("img").attr("size");
		var imgstr = parent.window.$("#att-status").html();
		var length = $("a[class='on']").children("img").length;
		var strs = filenames = '';
		$.get('<?php echo SELF;?>?m=attachment&c=attachments&a=h5upload_json_del&aid='+id+'&src='+src+'&filename='+filename+'&size='+size);
		for(var i=0;i<length;i++){
			strs += '|'+$("a[class='on']").children("img").eq(i).attr('path');
			filenames += '|'+$("a[class='on']").children("img").eq(i).attr('filename');
		}
		parent.window.$('#att-status').html(strs);
		parent.window.$('#att-name').html(filenames);
		$(element).removeClass('on').find('input[type="checkbox"]').prop('checked', false);
	}
});
$(function(){
	//区域内的所有可选元素
	var selects = ds.selectables;

	//全选
	$('#all').click(function(){
		ds.setSelection(selects);
	});

	//全不选
	$('#allno').click(function(){
		ds.clearSelection();
	});

	//反选
	$('#other').click(function(){
		ds.toggleSelection(selects);
	});
});
</script>