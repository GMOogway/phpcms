<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<style type="text/css">
.btn.red:not(.btn-outline).active, .btn.red:not(.btn-outline):active, .btn.red:not(.btn-outline):hover, .open>.btn.red:not(.btn-outline).dropdown-toggle {color: #fff;background-color: #e12330 !important;border-color: #dc1e2b !important;}
</style>
<div class="pad-10">
<form method="post" action="?m=bdts&c=bdts&a=del&menuid=<?php echo $_GET['menuid'];?>" enctype="multipart/form-data">
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

                    <div style="padding: 8px; margin-top: 15px; height: 32px;">
                        <div style="padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <span style="margin-top: 5px;margin-bottom: 5px;display: block;color: #737373;"><button type="submit" name="submit" onclick="return confirm('你确定要清空全部记录吗？')" class="btn red" style="display: inline-block;margin-bottom: 0;font-weight: 400;text-align: center;vertical-align: middle;touch-action: manipulation;cursor: pointer;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;height: 34px;border-radius: 4px;color: #FFF;background-color: #e7505a;border-color: #e7505a;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"> <i class="fa fa-trash"></i> <?php echo L('清空全部');?></button></span>
                        </div>
                    </div>


                </div>
            </div>
            <div id="pages"><?php echo $pages;?></div>
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