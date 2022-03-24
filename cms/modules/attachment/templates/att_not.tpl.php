<?php 
$show_header = $show_validator = $show_scroll = true; 
include $this->admin_tpl('header', 'attachment');
?>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('.tooltips').tooltip();
});
</script>
<!--上传组件js-->
<script src="<?php echo JS_PATH?>assets/ds.min.js"></script>
<link href="<?php echo JS_PATH?>h5upload/h5upload.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body{background: #fff;}
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content   main-content2" style="padding-top: 0px;">
                            <div class="page-body">
<div class="row">
    <div class="col-md-12 margin-bottom-20">
        <label><span id="all" class="btn green btn-sm" style="margin-right:10px;">全选</span></label><label><span id="allno" class="btn red btn-sm" style="margin-right:10px;">全不选</span></label><label><span id="other" class="btn dark btn-sm">反选</span></label>
    </div>
</div>
<div class="row">
    <div class="col-md-12 margin-bottom-20">
        <div class="note note-danger">
            <p><?php echo L('att_not_used_desc')?></p>
        </div>
    </div>
</div>
<form class="form-horizontal" method="post" role="form" id="myform">
<div class="files row">
<?php if(is_array($att) && !empty($att)){ foreach ($att as $_v) {?>
<div class="col-md-2 col-sm-2 col-xs-6">
    <div class="files_row tooltips" data-original-title="<?php echo $_v['filename']?>&nbsp;&nbsp;<?php echo format_file_size($_v['size'])?>">
        <span class="checkbox"></span>
        <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $_v['aid']?>" />
        <a><img width="<?php echo $_v['width']?>" id="<?php echo $_v['aid']?>" path="<?php echo $_v['src']?>" src="<?php echo $_v['fileimg']?>" filename="<?php echo $_v['filename']?>" size="<?php echo $_v['size']?>"></a>
        <i class="size"><?php echo $_v['size']?></i>
        <i class="name" title="<?php echo $_v['filename']?>"><?php echo $_v['filename']?></i>
    </div>
</div>
<?php }}?>
</div>
</form>
</div>
</div>
</div>
</div>
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
			$.get('<?php echo SELF;?>?m=attachment&c=attachments&a=h5upload_json_del&aid='+id+'&src='+src+'&filename='+filename+'&size='+size);
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
		$.get('<?php echo SELF;?>?m=attachment&c=attachments&a=h5upload_json&aid='+id+'&src='+src+'&filename='+filename+'&size='+size);
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