<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<script type="text/javascript">
$(function(){
	$(":text").removeClass('input-text');
})
</script>
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.portlet.light>.portlet-title {padding: 0;color: #181C32;font-weight: 500;}
.portlet.bordered>.portlet-title {border-bottom: 0;}
.portlet>.portlet-title {padding: 0;margin-bottom: 2px;-webkit-border-radius: 4px 4px 0 0;-moz-border-radius: 4px 4px 0 0;-ms-border-radius: 4px 4px 0 0;-o-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;}
.portlet>.portlet-title>.caption {float: left;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;}
.portlet.light>.portlet-title>.caption.caption-md>.caption-subject, .portlet.light>.portlet-title>.caption>.caption-subject {font-size: 15px;}
.font-dark {color: #2f353b!important;}
a.badge {color: #fff;}
.badge-no,.badge-yes {height: 22px;padding: 4px;width: 22px;}
.badge-no {background-color: #ed6b75;}
.badge-yes {background-color: #3ea9e2;}
@media (max-width:480px) {select[multiple],select[size]{width:100% !important;}}
</style>
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
                    setTimeout("window.location.reload(true)", 2000);
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