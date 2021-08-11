<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-container {margin: 0;padding: 0;position: relative;}
.page-container:after, .page-container:before {content: " ";display: table;}
.page-content-wrapper {float: left;width: 100%;}
.page-content-wrapper .page-content {margin-left: 158px;margin-top: 0;padding: 25px 20px 10px;}
.page-content3 {margin-left: 0px !important;border-left: 0 !important;}
.main-content {background: #fff!important;}
.page-content {margin-top: 0;padding: 0;}
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content">
                            <div class="page-body" style="padding-top:17px;margin-bottom:30px;">
<form class="form-horizontal" method="post" role="form" id="myform">
    <div class="form-body">

        <div class="form-group" id="dr_row_username">
            <label class="col-xs-3 control-label ajax_name">官方账号</label>
            <div class="col-xs-7">
                <input type="text" id="dr_username" class="form-control" name="data[username]">
            </div>
        </div>
        <div class="form-group" id="dr_row_password">
            <label class="col-xs-3 control-label ajax_name">登录密码</label>
            <div class="col-xs-7">
                <input type="password" id="dr_password" class="form-control" name="data[password]">
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