<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
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
<div class="pad-lr-10">
<form name="searchform" action="?m=admin&c=index&a=public_error_log" method="get" >
<input type="hidden" value="admin" name="m">
<input type="hidden" value="index" name="c">
<input type="hidden" value="public_error_log" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"><div class="formdate">
            <div class="input-group input-time date date-picker">
                        <input type="text" class="form-control" name="time" value="<?php echo $time;?>">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div></div>
		<input type="submit" value="搜索" class="button" name="dosubmit">
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<form name="myform" id="myform" action="" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="80" align="left"><?php echo L('编号');?></th>
            <th width="160" align="left"><?php echo L('时间');?></th>
            <th width="80" style="text-align: center;"><?php echo L('类型');?></th>
            <th align="left"><?php echo L('日志');?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($list)){
	foreach($list as $t){
?>   
	<tr>
	<td><?php echo $t['id'];?></td>
	<td><?php echo $t['time'];?></td>
	<td style="text-align: center"><?php echo $t['type'];?></td>
	<td><a href="javascript:show_file_code()" style="color:#ff0000;"><?php echo $t['message'];?></a></td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
</div>
<div class="list-footer table-checkable clear">
<?php if($list){?>
    <div class="col-md-7 list-select">
        <label><button type="button" onclick="ajax_option('?m=admin&c=index&a=public_error_log_del&time=<?php echo $time;?>', '你确定要清空全部记录吗？')" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('清空全部')?></button></label>
    </div>
<?php }?>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
<!--
function show_file_code() {
	openwinx('?m=admin&c=index&a=public_error_log_show&time=<?php echo $time;?>','查看文件','80%','80%');
}
function ajax_option(url, msg) {
	Dialog.confirm(msg,function(){location.href = url;});
}
//-->
</script>