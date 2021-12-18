<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script type="text/javascript">
jQuery(document).ready(function() {
    $(":text").removeClass('input-text');
});
</script>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('更改数据之后需要更新缓存之后才能生效');?></a></p>
</div>
<div class="portlet bordered light form-horizontal">
    <div class="portlet-body">
        <div class="form-body">

            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo L('首页静态');?></label>
                <div class="col-md-9">
                    <label><a href="javascript:;" onclick="dr_ajax_open_close(this, '?m=content&c=create_html&a=public_index_edit&share=1&pc_hash='+pc_hash, 0)" class="badge badge-<?php echo (!$ishtml ? 'no' : 'yes');?>"> <i class="fa fa-<?php echo (!$ishtml ? 'times' : 'check');?>"></i> </a></label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo L('手机静态');?></label>
                <div class="col-md-9">
                    <label><a href="javascript:;" onclick="dr_ajax_open_close(this, '?m=content&c=create_html&a=public_index_edit&share=0&pc_hash='+pc_hash, 0)" class="badge badge-<?php echo (!$mobilehtml ? 'no' : 'yes');?>"> <i class="fa fa-<?php echo (!$mobilehtml ? 'times' : 'check');?>"></i> </a></label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo L('网站首页');?></label>
                <div class="col-md-9">
                    <label><button type="button" onclick="dr_admin_menu_ajax('?m=content&c=create_html&a=public_index_ajax', 1)" class="btn blue"> <i class="fa fa-file-o"></i> <?php echo L('生成首页静态文件');?> </button></label>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    // ajax关闭或启用
    function dr_ajax_open_close(e, url, fan) {
        var index = layer.load(2, {
            shade: [0.3,'#fff'], //0.1透明度的白色背景
            time: 10000
        });
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "json",
            success: function (json) {
                layer.close(index);
                if (json.code == 1) {
                    if (json.data.value == fan) {
                        $(e).attr('class', 'badge badge-no');
                        $(e).html('<i class="fa fa-times"></i>');
                    } else {
                        $(e).attr('class', 'badge badge-yes');
                        $(e).html('<i class="fa fa-check"></i>');
                    }
                    dr_tips(1, json.msg);
                } else {
                    dr_tips(0, json.msg);
                }
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError);
            }
        });
    }
</script>
</body>
</html>