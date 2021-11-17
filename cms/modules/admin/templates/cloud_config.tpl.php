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
.main-content2 {background: #fff!important}
.main-content2 .note.note-danger {background-color: #f5f6f8 !important}
.page-content3 {margin-left:0px !important; border-left: 0  !important;}
.page-content-white .page-bar .page-breadcrumb>li>i.fa-circle {top:0px !important; }
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content   main-content2">
<div class="note note-danger">
    <p>服务器的相关配置，最好是联系服务商专业的技术为您配置环境</p>
</div>

<p>php.ini文件位置不固定，每个主机的目录不一样，需要咨询服务商此文件的位置</p>



post_max_size
<p>
表单提交最大数值,此项不是限制上传单个文件的大小,而是针对整个表单的提交数据进行限制的
默认为8M，设置为自己需要的值，此参数建议要设置比upload_max_filesize大一些
</p>


upload_max_filesize
<p>
允许上传文件大小的最大值，默认为2M，设置为自己需要的值此参数建议不要超过post_max_size值，因为它受控于post_max_size值（就算upload_max_filesize设置了1G，而post_max_size只设置了2M时，大于2M的文件照样传不上去，因为它受控于post_max_size值）
</p>


max_input_vars
<p>
用来限制提交的表单数量，默认值为 1000， 如果你网站栏目太多的话，而且需要配置用户权限的时候会发现无法保存，这时候说明这个值太小了，设置10000一般够用。
</p>


max_execution_time
<p>
每个PHP页面运行的最大时间值(秒)，默认30秒
</p>

max_input_time
<p>
每个PHP页面接收数据所需的最大时间，默认60秒
</p>

memory_limit
<p>
每个PHP页面所需要的最大内存，默认8M
</p>

allow_url_fopen
<p>
使用QQ登录、微信、微博快捷登录、在线支付、下载远程图片等功能时必须开启allow_url_fopen，设置为 allow_url_fopen = On。
</p>
</div>
</div>
</div>
</body>
</html>