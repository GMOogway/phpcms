<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-10">
<form method="post" name="myform" id="myform" action="?m=bdts&c=bdts&a=del&menuid=<?php echo $_GET['menuid'];?>" enctype="multipart/form-data">
    <h3 class="page-title">
        <small></small>
    </h3>
<div style="padding: 12px 20px 15px;">

        <div class="portlet-title" style="min-height: 30px; border-bottom: 1px solid #eef1f5;">
            <div class="caption">
                <span style="font-size: 16px;color: #32c5d2!important;font-weight: 600!important;"><?php echo L('主动推送的记录日志');?></span>
            </div>
        </div>
        <div class="portlet-body" style="padding-top: 8px;">

            <div class="row">
                <div class="portlet-body form">

                    <div class="table-list">
                        <table class="table" width="100%">
                            <tbody>
                            <?php foreach ($list as $t) {?>
                            <tr>
                                <td style="text-align:left;padding: 8px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"><?php echo $t;?></td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('你确定要清空全部记录吗？')?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('清空全部')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
        </div>
    </div>
	</form>
</div>
<script>
//全选取消
function checkall(form)
{
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.Name!="chkall")
       e.checked=form.chkall.checked;
    }
}
</script>
</body>
</html>