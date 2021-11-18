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
.myfbody {margin-bottom: 90px;}
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
.badge {font-size: 11px!important;font-weight: 300;color: #fff !important;}
.badge-danger {background-color: #ed6b75;}
</style>
<div class="page-content main-content">
<form class="form-horizontal" role="form" id="myform">
<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-green sbold ">系统信息</span>
                </div>

            </div>
            <div class="portlet-body">
                <div class="form-body fc-yun-list">

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('系统版本');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><a href="javascript:;" layuimini-content-href="?m=admin&c=cloud&a=upgrade&menuid=277&pc_hash=<?php echo dr_get_csrf_token();?>" data-title="版本升级" data-icon="fa fa-refresh"><?php echo CMS_VERSION?></a>
                                <a id="dr_cms_update" href="javascript:;" layuimini-content-href="?m=admin&c=cloud&a=upgrade&menuid=277&pc_hash=<?php echo dr_get_csrf_token();?>" data-title="版本升级" data-icon="fa fa-refresh" style="margin-left: 10px;display: none" class="badge badge-danger badge-roundless">  </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('发布时间');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><?php echo dr_date(strtotime(CMS_UPDATETIME), 'Y-m-d', 'red');?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('下载时间');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><?php echo dr_date(strtotime(CMS_DOWNTIME), null, 'red');?></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-green sbold "><?php echo L('服务器信息');?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-body fc-yun-list">


                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('上传最大值');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><a href="javascript:dr_iframe_show('show', '?m=admin&c=cloud&a=config&menuid=277');"><?php echo @ini_get("upload_max_filesize");?></a></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('POST最大值');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><a href="javascript:dr_iframe_show('show', '?m=admin&c=cloud&a=config&menuid=277');"><?php echo @ini_get("post_max_size");?></a></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('PHP内存上限');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><a href="javascript:dr_iframe_show('show', '?m=admin&c=cloud&a=config&menuid=277');"><?php echo @ini_get("memory_limit");?></a></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('提交表单数量');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><a href="javascript:dr_iframe_show('show', '?m=admin&c=cloud&a=config&menuid=277');"><?php echo @ini_get("max_input_vars");?></a></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('Web网站目录');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><?php echo CMS_PATH;?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('核心程序目录');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><?php echo PC_PATH;?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('附件存储目录');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><?php echo SYS_UPLOAD_PATH;?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo L('模板文件目录');?></label>
                        <div class="col-md-9">
                            <div class="form-control-static"><?php echo TPLPATH;?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>
<script>
    $(function () {
        $.ajax({type: "GET",dataType:"json", url: "?m=admin&c=index&a=public_version_cms",
            success: function(json) {
                if (json.code) {
                    $('#dr_cms_update').show();
                    $('#dr_cms_update').html(json.msg);
                }
            }
        });
    });
</script>
<script src="<?php echo JS_PATH?>layui/layui.js" charset="utf-8"></script>
<script src="<?php echo CSS_PATH?>layuimini/js/lay-config.js?v=2.0.0" charset="utf-8"></script>
<script src="<?php echo JS_PATH?>main.js" charset="utf-8"></script>
<script>
    layui.use(['layer', 'miniTab','echarts'], function () {
        var $ = layui.jquery,
            layer = layui.layer,
            miniTab = layui.miniTab,
            echarts = layui.echarts;

        miniTab.listen();
    });
</script>
</body>
</html>