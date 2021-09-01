<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<style type="text/css">
html,body{background:#f5f6f8!important;}
body{padding: 20px 20px 0px 20px;}
</style>
<div class="pad-lr-10">
<div class="note note-danger">
    <p><?php echo L('邮件发送失败时返回的错误代码，格式为：时间 [邮件服务器 - 服务器账号 - 发送给的邮箱] 错误代码');?></p>
</div>
<form name="myform" id="myform" action="" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
    <tbody>
 <?php 
if(is_array($list)){
	foreach($list as $t){
?>   
	<tr>
	<td style="text-align:left;padding: 10px;"><?php echo $t;?></td>
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
        <label><button type="button" onclick="ajax_option('?m=admin&c=index&a=public_email_log_del', '你确定要清空全部记录吗？')" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('清空全部')?></button></label>
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
function ajax_option(url, msg) {
	Dialog.confirm(msg,function(){location.href = url;});
}
//-->
</script>