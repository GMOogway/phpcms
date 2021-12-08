<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-content {margin-left: 0;margin-top: 0;padding: 25px 20px 10px;}
.page-content3 {margin-left: 0px !important;border-left: 0 !important;}
.main-content {background: #f5f6f8;}
.portlet.light, .portlet.light.bordered {border: none !important;}
.portlet.light.bordered {border: 1px solid #e7ecf1!important;}
.portlet.light {padding: 12px 20px 15px;background-color: #fff;}
.portlet.bordered {border-left: 2px solid #e6e9ec!important;}
.portlet {-webkit-border-radius: 4px;-moz-border-radius: 4px;-ms-border-radius: 4px;-o-border-radius: 4px;margin-top: 0;margin-bottom: 25px;padding: 0;border-radius: 4px;}
.portlet.light>.portlet-title {padding: 0;color: #181C32;font-weight: 500;}
.portlet.bordered>.portlet-title {border-bottom: 0;}
.right-card-box {position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-orient: vertical;-webkit-box-direction: normal;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 0 solid #f7f7f7;border-radius: .25rem;padding: 1.5rem;}
.portlet>.portlet-title {padding: 0;margin-bottom: 2px;-webkit-border-radius: 4px 4px 0 0;-moz-border-radius: 4px 4px 0 0;-ms-border-radius: 4px 4px 0 0;-o-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;}
.portlet>.portlet-title:after, .portlet>.portlet-title:before {content: " ";display: table;}
.portlet.light>.portlet-title>.caption {color: #181C32;padding: 10px 0;}
.portlet>.portlet-title>.caption {float: left;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;}
.portlet.light>.portlet-title>.caption.caption-md>.caption-subject, .portlet.light>.portlet-title>.caption>.caption-subject {font-size: 15px;}
.font-green {color: #40aae3!important;}
.sbold {font-weight: 600!important;}
form .portlet.light .portlet-body {padding-top: 20px;padding-bottom: 20px;}
.portlet.light .portlet-body {padding-top: 20px;}
.portlet>.portlet-body {-webkit-border-radius: 0 0 4px 4px;-moz-border-radius: 0 0 4px 4px;-ms-border-radius: 0 0 4px 4px;-o-border-radius: 0 0 4px 4px;border-radius: 0 0 4px 4px;}
.btn-group-vertical>.btn-group:after, .btn-toolbar:after, .clearfix:after, .container-fluid:after, .container:after, .dropdown-menu>li>a, .feeds li:after, .form .form-actions:after, .form-horizontal .form-group:after, .form-recaptcha-img, .modal-footer:after, .modal-header:after, .nav:after, .navbar-collapse:after, .navbar-header:after, .navbar:after, .pager:after, .panel-body:after, .portlet-form .form-actions:after, .portlet>.portlet-body, .portlet>.portlet-title:after, .row:after, .scroller-footer:after, .tabbable:after, .table-toolbar:after, .ui-helper-clearfix:after {clear: both;}
.myfooter {margin: 0 -20px!important;font-size: 13px;position: fixed;left: 0;right: 0;z-index: 100;bottom: 0;}
.form {padding: 0!important;}
.table {width: 100%;margin-bottom: 20px;table-layout: fixed;}
.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th {padding: 8px;line-height: 1.42857;border-top: 1px solid #e7ecf1;}
.table>thead>tr>th {border-bottom: 2px solid #e7ecf1;}
.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th {border-top: 0;}
.table>tbody+tbody {border-top: 2px solid #e7ecf1;}
.table .table {background-color: #fff;}
.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th {padding: 5px;}
.table-bordered,.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th {border: 1px solid #e7ecf1;}
.table-bordered>thead>tr>td,.table-bordered>thead>tr>th {border-bottom-width: 2px;}
.table-hover>tbody>tr:hover,.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active {background-color: #eef1f5;}
table col[class*=col-] {position: static;float: none;display: table-column;}
table td[class*=col-],table th[class*=col-] {position: static;float: none;display: table-cell;}
.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover {background-color: #dee5ec;}
.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success {background-color: #abe7ed;}
.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover {background-color: #96e1e8;}
.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info {background-color: #e0ebf9;}
.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover {background-color: #caddf4;}
.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning {background-color: #f9e491;}
.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover {background-color: #f7de79;}
.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger {background-color: #fbe1e3;}
.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover {background-color: #f8cace;}
.table-checkable tr>td:first-child,.table-checkable tr>th:first-child {text-align: center;max-width: 50px;min-width: 40px;padding-left: 0;padding-right: 0;}
.table td,.table th {white-space: nowrap;text-overflow: ellipsis;overflow: hidden;}
.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th {vertical-align: middle;}
.head-table thead th {background-color: #edf2f7;}
.table-striped>tbody>tr:nth-of-type(odd) {background-color: #fff!important;}
.label-success {background-color: #3ea9e2;color: #fff!important;}
.label-success[href]:focus, .label-success[href]:hover {background-color: #27a4b0;}
</style>
<div class="page-content main-content">
<div class="note note-danger">
    <p>升级程序之前，请务必备份全站数据</p>
</div>
<div class="right-card-box">
<form class="form-horizontal" role="form" id="myform">
    <div class="table-list">
        <table class="table table-striped table-bordered table-hover table-checkable dataTable">
            <thead>
            <tr class="heading">
                <th width="80"> 类型</th>
                <th width="250"> 程序名称</th>
                <th width="110"> 更新时间 </th>
                <th width="100"> 版本 </th>
                <th width="110" style="text-align: center"> 备份 </th>
                <th> </th>
            </tr>
            </thead>
            <tbody>
            <tr class="odd gradeX">
                <td>系统</td>
                <td>CMS</td>
                <td> <?php echo CMS_UPDATETIME;?> </td>
                <td><a href="javascript:dr_show_log('<?php echo CMS_ID;?>', '<?php echo CMS_VERSION;?>');"><?php echo CMS_VERSION;?></a></td>
                <td align="center">
                    <?php if ($backup) {?>
                    <a href="javascript:dr_tips(1, '备份目录：<?php echo $backup;?>', -1);" class="label label-success"> 已备份 </a>
                    <?php } else {?>
                    <span class="label label-danger"> 未备份 </span>
                    <?php }?>
                </td>
                <td>
                    <label style="display: none" id="dr_update_cms">
                    <button type="button" onclick="dr_update_cms('?m=admin&c=cloud&a=todo_update&id=<?php echo CMS_ID;?>&dir=cms', '升级前请做好系统备份，你确定要升级吗？', 1)" class="btn red btn-xs"> <i class="fa fa-cloud-upload"></i> 在线升级</button>
                    </label>
                    <label class="dr_check_version" id="dr_row_cms"></label>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</form>
</div>
</div>
<script type="text/javascript">

    $(function() {
        $("#dr_row_cms").html("<img style='height:17px' src='<?php echo JS_PATH;?>layer/theme/default/loading-0.gif'>");
        $("#dr_update_cms").hide();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "?m=admin&c=cloud&a=check_version&id=<?php echo CMS_ID;?>&version=<?php echo CMS_VERSION;?>&pc_hash="+pc_hash,
            success: function(json) {
                if (json.code) {
                    $("#dr_row_cms").html(json.msg);
                    $("#dr_update_cms").show();
                } else {
                    $("#dr_row_cms").html("<font color='red'>"+json.msg+"</font>");
                }
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                $("#dr_row_cms").html("<font color='red'>网络异常，请稍后再试</font>");
            }
        });
    });

    // ajax 批量操作确认
    function dr_update_cms(url, msg, remove) {
        layer.confirm(
        msg,
        {
            icon: 3,
            shade: 0,
            title: '提示',
            btn: ['直接升级','备份再升级', '取消']
        }, function(index, layero){
            layer.close(index);
            dr_todo_cms(url+'&is_bf=1');
        }, function(index){
            layer.close(index);
            dr_todo_cms(url+'&is_bf=0');
        });
    }

    function dr_todo_cms(url) {
        var width = '500px';
        var height = '280px';
        if (is_mobile()) {
            width = '100%';
            height = '100%';
        }
        var login_url = '?m=admin&c=cloud&a=login&pc_hash='+pc_hash;
        layer.open({
            type: 2,
            title: '登录官方云账号',
            fix:true,
            scrollbar: false,
            shadeClose: true,
            shade: 0,
            area: [width, height],
            btn: ['确定', '取消'],
            yes: function(index, layero){
                var body = layer.getChildFrame('body', index);
                $(body).find('.form-group').removeClass('has-error');
                // 延迟加载
                var loading = layer.load(2, {
                    shade: [0.3,'#fff'], //0.1透明度的白色背景
                    time: 100000000
                });
                $.ajax({type: "POST",dataType:"json", url: login_url, data: $(body).find('#myform').serialize(),
                    success: function(json) {
                        layer.close(loading);
                        if (json.code == 1) {
                            layer.close(index);
                            var yz_url = url+'&'+$('#myform').serialize()+'&ls='+json.data;
                            // 验证成功
                            layer.open({
                                type: 2,
                                title: '升级程序',
                                scrollbar: false,
                                resize: true,
                                maxmin: true, //开启最大化最小化按钮
                                shade: 0,
                                area: ['80%', '80%'],
                                success: function(layero, index){
                                    // 主要用于后台权限验证
                                    var body = layer.getChildFrame('body', index);
                                    var json = $(body).html();
                                    if (json.indexOf('"code":0') > 0 && json.length < 150){
                                        var obj = JSON.parse(json);
                                        layer.closeAll(index);
                                        dr_tips(0, obj.msg);
                                    }
                                },
                                content: yz_url
                            });
                        } else {
                            $(body).find('#dr_row_'+json.data.field).addClass('has-error');
                            dr_tips(0, json.msg);
                        }
                        return false;
                    },
                    error: function(HttpRequest, ajaxOptions, thrownError) {
                        dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
                    }
                });
                return false;
            },
            content: login_url+'&is_ajax=1'
        });
    }

    function dr_beifen_cms(url, msg, remove) {
        layer.confirm(
                msg,
                {
                    icon: 3,
                    shade: 0,
                    title: '提示',
                    btn: ['确定', '取消']
                }, function(index){
                    layer.close(index);
                    layer.open({
                        type: 2,
                        title: '备份程序',
                        scrollbar: false,
                        resize: true,
                        maxmin: true, //开启最大化最小化按钮
                        shade: 0,
                        area: ['80%', '80%'],
                        success: function(layero, index){
                            // 主要用于后台权限验证
                            var body = layer.getChildFrame('body', index);
                            var json = $(body).html();
                            if (json.indexOf('"code":0') > 0 && json.length < 150){
                                var obj = JSON.parse(json);
                                layer.closeAll(index);
                                dr_tips(0, obj.msg);
                            }
                        },
                        content: url
                    });
                });
    }
    
    function dr_show_log(id, v) {
        layer.open({
            type: 2,
            title: '版本日志',
            scrollbar: false,
            resize: true,
            maxmin: true, //开启最大化最小化按钮
            shade: 0,
            area: ['80%', '80%'],
            content: '?m=admin&c=cloud&a=log_show&id='+id+'&version='+v+'&pc_hash='+pc_hash,
        });
    }
</script>
</body>
</html>