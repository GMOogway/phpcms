<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<style type="text/css">
html,body{background:#f5f6f8!important;}
body{padding: 20px 20px 0px 20px;}
.note.note-danger {background-color: #fef7f8;border-color: #f0868e;color: #210406;}
.note.note-danger {border-radius: 4px;border-left: 4px solid #3ea9e2;background-color: #ffffff;color: #888;}
.note {margin: 0 0 20px;padding: 15px 30px 15px 15px;border-left: 5px solid #eee;border-radius: 0 4px 4px 0;}
.note, .tabs-right.nav-tabs>li>a:focus, .tabs-right.nav-tabs>li>a:hover {-webkit-border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;-ms-border-radius: 0 4px 4px 0;-o-border-radius: 0 4px 4px 0;}
.note p:last-child {margin-bottom: 0;}
.note p {margin: 0;}
.note p, .page-loading, .panel .panel-body {font-size: 13px;}
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
<?php if($list){?>
 <div class="btn"><input type="button" class="button" name="dosubmit" value="<?php echo L('清空全部')?>" onclick="ajax_option('?m=admin&c=index&a=public_email_log_del&time=<?php echo $time;?>', '你确定要清空全部记录吗？')" /></div>
<?php }?>
 <div id="pages"> <?php echo $pages?></div>
</div>
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