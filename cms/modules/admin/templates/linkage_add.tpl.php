<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content main-content2">
                            <div class="page-body">
<script type="text/javascript">
    $(function() { //防止回车提交表单
        document.onkeydown = function(e){
            var ev = document.all ? window.event : e;
            if (ev.keyCode==13) {
                return false;
            }
        }
    });
</script>
<form class="form-horizontal" role="form" id="myform" name="myform" action="?m=admin&c=linkage&a=add" method="post">
    <div class="form-body">
        <div class="form-group" id="dr_row_name">
            <label class="col-xs-3 control-label ajax_name"><?php echo L('名称');?></label>
            <div class="col-xs-7">
                <input type="text" onblur="topinyin('code','name','?m=admin&c=linkage&a=public_ajax_pinyin');" class="form-control" id="name" name="data[name]" value="">
                <span class="help-block"> <?php echo L('它的描述名称');?> </span>
            </div>
        </div>
        <div class="form-group" id="dr_row_code">
            <label class="col-xs-3 control-label ajax_name"><?php echo L('别名');?></label>
            <div class="col-xs-7">
                <input type="text" class="form-control" id="code" name="data[code]" value="">
                <span class="help-block"> <?php echo L('别名只能由字母或者字母+数字组成');?> </span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label ajax_name"><?php echo L('sites');?></label>
            <div class="col-xs-9">
                <?php echo form::select($sitelist,'','name="data[type]"',L('all_sites'))?>
                <span class="help-block"> <?php echo L('站点独立是指各个站点的联动菜单数据分开录入');?> </span>
            </div>
        </div>
    </div>
</form>
</div>
</div>
</div>
</div>
</body>
</html>