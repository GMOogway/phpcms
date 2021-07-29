<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link href="<?php echo JS_PATH?>bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>bootstrap-switch/js/bootstrap-switch.min.js"></script>
<style type="text/css">
.form-control {width: 100%;}
</style>
<div class="pad-10">
<form method="post" action="?m=bdts&c=bdts&a=url_add&menuid=<?php echo $_GET['menuid'];?>">
    <h3 class="page-title">
        <small></small>
    </h3>
    <div style="padding: 12px 20px 15px;">

        <div class="portlet-title" style="min-height: 30px; border-bottom: 1px solid #eef1f5;">
            <div style="caption">
                <span style="font-size: 16px !important;color: #40aae3 !important;"> <i class="fa fa-paw"></i> <b style="font-weight: 600 !important;"><?php echo L('bdts_bdts');?></b></span>
            </div>
        </div>
        <div class="portlet-body" style="padding-top: 8px;">

            <div class="row">
                <div class="portlet-body form">

                    <div style="padding: 8px; height: 45px;">
                        <label style="text-align: right;margin-bottom: 0;padding-top: 7px;margin-top: 1px;font-weight: 400;width: 16.66667%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;"><?php echo L('输入URL');?>：</label>
                        <div style="width: 75%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-top: 5px;margin-bottom: 5px;display: block;color: #737373;">
                            <input type="text" class="form-control" id="dr_table" name="url">
                        </div>
                    </div>
                    <div style="padding: 8px; margin-top: 15px; height: 45px;">
                        <label style="text-align: right;margin-bottom: 0;padding-top: 7px;margin-top: 1px;font-weight: 400;width: 16.66667%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;"></label>
                        <div style="width: 75%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <span style="margin-top: 5px;margin-bottom: 5px;display: block;color: #737373;"><input value="<?php echo $r['siteid'];?>" type="hidden" name="siteid"><button type="submit" name="dosubmit" class="btn blue" style="color: #fff;background-color: #32c5d2;border-color: #32c5d2;line-height: 1.44;outline: 0!important;box-shadow: none!important;display: inline-block;margin-bottom: 0;vertical-align: middle;cursor: pointer;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;line-height: 1.42857;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;"> <i class="fa fa-save"></i> <?php echo L('the_save');?></button></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</body>
</html>