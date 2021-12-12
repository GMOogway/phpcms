<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.main-content2 {background: #fff!important}
.main-content2 .note.note-danger {background-color: #f5f6f8 !important}
.page-content3 {margin-left:0px !important; border-left: 0  !important;}
.page-content-white .page-bar .page-breadcrumb>li>i.fa-circle {top:0px !important;}
a.badge {color: #fff;}
.badge-no,.badge-yes {height: 22px;padding: 4px;width: 22px;}
.badge-no {background-color: #ed6b75;}
.badge-yes {background-color: #3ea9e2;}
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content main-content2">
                            <div class="page-body" style="padding-top:17px;margin-bottom:30px;">
<form id="myform" class="form-horizontal" style="padding: 0 30px;">

    <div class="form-body">
        <div class="table-list">

            <table class="table table-striped table-bordered table-hover table-checkable dataTable">
                <thead>
                <tr class="heading">
                    <th width="70" style="text-align:center"> Id </th>
                    <th> <?php echo L('栏目')?> </th>
                    <th width="100" style="text-align:center"> <?php echo L('栏目静态')?> </th>
                    <th width="100" style="text-align:center"> <?php echo L('内容静态')?> </th>
                    <th width="180"> <?php echo L('栏目URL规则')?> </th>
                    <th> <?php echo L('内容URL规则')?> </th>
                </tr>
                </thead>
                <tbody>
                <?php echo $string;?>
                </tbody>
            </table>

        </div>
    </div>
</form>
</div>
</div>
</div>
</div>
<script>
    function dr_save_urlrule(share, catid, value) {
        var index = layer.load(2, {
            shade: [0.3,'#fff'], //0.1透明度的白色背景
            time: 10000
        });
        $.ajax({
            type: "GET",
            cache: false,
            url: '?m=content&c=create_html&a=public_rule_edit&share='+share+'&value='+value+'&catid='+catid+'&pc_hash='+pc_hash,
            dataType: "json",
            success: function (json) {
                layer.close(index);
                if (json.code == 1) {
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
    // ajax关闭或启用
    function dr_cat_ajax_open_close(e, url, fan) {
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
                    setTimeout("window.location.reload(true)", 2000);
                }
                dr_tips(json.code, json.msg);
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError);
            }
        });
    }
</script>
</body>
</html>