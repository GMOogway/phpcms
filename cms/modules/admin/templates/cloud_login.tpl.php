<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-container {margin: 0;padding: 0;position: relative;}
.page-container:after, .page-container:before {content: " ";display: table;}
.page-content-wrapper {float: left;width: 100%;}
.page-content-wrapper .page-content {margin-left: 158px;margin-top: 0;min-height: 600px;padding: 25px 20px 10px;}
.page-content3 {margin-left: 0px !important;border-left: 0 !important;}
.main-content {background: #f5f6f8;}
.page-content {margin-top: 0;padding: 0;}
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content">
                            <div class="page-body" style="padding-top:17px;margin-bottom:30px;">
<form action="" class="form-horizontal" method="post" name="myform" id="myform">
    <div class="myfbody">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <div class="portlet light bordered" style="margin-top: 40px">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-green"><?php echo L('绑定账号');?></span>
                    </div>
                </div>
                <div class="portlet-body form">

                    <div class="form-body">

                        <div class="form-group" id="dr_row_username">
                            <label class="col-xs-3 control-label ">官方账号</label>
                            <div class="col-xs-7">
                                <input type="text" id="dr_username" class="form-control" name="data[username]">
                            </div>
                        </div>
                        <div class="form-group" id="dr_row_password">
                            <label class="col-xs-3 control-label ">登录密码</label>
                            <div class="col-xs-7">
                                <input type="password" id="dr_password" class="form-control" name="data[password]">
                            </div>
                        </div>
                        <div class="form-group">

                            <label class="col-xs-3 control-label "></label>
                            <div class="col-xs-7">
                            <button type="button" onclick="dr_post_submit('?m=admin&c=cloud&a=license&menuid=<?php echo $this->input->get('menuid')?>', 'myform', 3000, '?m=admin&c=cloud&a=upgrade&menuid=<?php echo $this->input->get('menuid')?>&pc_hash=<?php echo dr_get_csrf_token()?>');" class="btn red " style="margin-right: 20px;"> 绑定账号 </button>
                                <a href="http://ceshi.kaixin100.cn/index.php?m=member&c=index&a=register&siteid=1" target="_blank">免费注册账号</a>
                        </div>
                        </div>

                    </div>
                </div>
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