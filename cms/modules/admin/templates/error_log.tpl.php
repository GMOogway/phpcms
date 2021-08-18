<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad-lr-10">
<form name="searchform" action="?m=admin&c=index&a=public_error_log" method="get" >
<input type="hidden" value="admin" name="m">
<input type="hidden" value="index" name="c">
<input type="hidden" value="public_error_log" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"><?php echo form::date('time',$time,'0')?><input type="submit" value="搜索" class="button" name="dosubmit">
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
            <th align="left"><?php echo L('错误');?></th>
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