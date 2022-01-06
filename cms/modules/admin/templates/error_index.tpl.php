<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad-lr-10">
<form name="myform" id="myform" action="" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="80" align="left"><?php echo L('编号');?></th>
            <th width="160" align="left"><?php echo L('时间');?></th>
            <th align="left"><?php echo L('错误');?></th>
            <th width="260" align="left"><?php echo L('文件');?></th>
            <th width="100" align="left"><?php echo L('位置');?></th>
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
	<td><?php echo $t['info'];?></td>
	<td><?php echo $t['line'];?></td>
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
    <div class="col-md-5 col-sm-5 table-footer-button">
        <label><button type="button" onclick="ajax_option('?m=admin&c=index&a=public_error_del', '你确定要清空全部记录吗？')" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('清空全部')?></button></label>
    </div>
<?php }?>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
<!--
function show_file_code() {
	openwinx('?m=admin&c=index&a=public_log_show','查看文件','80%','80%');
}
//-->
</script>