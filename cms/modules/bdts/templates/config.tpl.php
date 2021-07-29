<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link href="<?php echo JS_PATH?>bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>bootstrap-switch/js/bootstrap-switch.min.js"></script>
<div class="pad-10">
<form method="post" action="?m=bdts&c=bdts&a=config&menuid=<?php echo $_GET['menuid'];?>">
<input name="dosubmit" type="hidden" value="1">
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
                        <label style="text-align: right;margin-bottom: 0;padding-top: 7px;margin-top: 1px;font-weight: 400;width: 16.66667%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;"><?php echo L('接口地址');?>：</label>
                        <div style="width: 75%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <a href="https://ziyuan.baidu.com/linksubmit/index" target="_blank" class="btn yellow" style="color: #fff;background-color: #c49f47;border-color: #c49f47;line-height: 1.44;outline: 0!important;box-shadow: none!important;display: inline-block;margin-bottom: 0;vertical-align: middle;cursor: pointer;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;line-height: 1.42857;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;"><?php echo L('申请接口');?></a>
                        </div>
                    </div>
                    <?php foreach((array)$sitemodel_data as $t){?>
                    <div style="padding: 8px; height: 45px;">
                        <label style="text-align: right;margin-bottom: 0;padding-top: 7px;margin-top: 1px;font-weight: 400;width: 16.66667%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;"><?php echo $t['name'];?>：</label>
                        <div style="width: 75%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <input type="checkbox" name="data[use][]" value="<?php echo $t['tablename'];?>"<?php if ($data['use'] && in_array($t['tablename'], $data['use'])) {?> checked<?php }?> data-on-text="开启" data-off-text="关闭" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <?php }?>
                    <div style="padding: 8px; height: 45px;">
                        <label style="text-align: right;margin-bottom: 0;padding-top: 7px;margin-top: 1px;font-weight: 400;width: 16.66667%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;"></label>
                        <div style="width: 75%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <a href="javascript:add_menu();" class="btn blue" style="color: #fff;background-color: #3598dc;border-color: #3598dc;line-height: 1.44;outline: 0!important;box-shadow: none!important;display: inline-block;margin-bottom: 0;vertical-align: middle;cursor: pointer;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;line-height: 1.42857;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;"><i class="fa fa-plus"></i> <?php echo L('添加域名');?></a>
                        </div>
                    </div>
                    <div id="menu_body">
                        <?php foreach((array)$bdts as $t){?>
                        <div style="padding: 8px; height: 45px;">
                            <label style="text-align: right;margin-bottom: 0;padding-top: 7px;margin-top: 1px;font-weight: 400;width: 16.66667%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;">&nbsp;</label>
                            <div style="width: 75%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                                <label><input type="text" name="data[bdts][][site]" placeholder="<?php echo L('站点域名');?>" value="<?php echo $t['site'];?>" style="width: 180px;height: 34px;padding: 6px 12px;background-color: #fff;border: 1px solid #c2cad8;border-radius: 4px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"></label>
                                <label><input type="text" name="data[bdts][][token]" value="<?php echo $t['token'];?>" placeholder="<?php echo L('密钥token');?>" style="width: 320px;height: 34px;padding: 6px 12px;background-color: #fff;border: 1px solid #c2cad8;border-radius: 4px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"></label>
                                <label><a href="javascript:;" onClick="remove_menu(this)" class="btn red" style="color: #fff;background-color: #e7505a;border-color: #e7505a;line-height: 1.44;outline: 0!important;box-shadow: none!important;display: inline-block;margin-bottom: 0;vertical-align: middle;cursor: pointer;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;line-height: 1.42857;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;"><i class="fa fa-trash"></i> <?php echo L('删除');?></a></label>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <div style="padding: 8px; height: 45px;">
                        <label style="text-align: right;margin-bottom: 0;padding-top: 7px;margin-top: 1px;font-weight: 400;width: 16.66667%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;"><?php echo L('接口说明');?>：</label>
                        <div style="width: 75%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-top: 5px;margin-bottom: 5px;display: block;color: #737373;">
                            <?php echo L('链接提交工具是网站主动向百度搜索推送数据的工具，本工具可缩短爬虫发现网站链接时间，网站时效性内容建议使用链接提交工具，实时向搜索推送数据。本工具可加快爬虫抓取速度，无法解决网站内容是否收录问题。');?>
                        </div>
                    </div>
                    <div style="margin: 0 -20px!important;font-size: 13px;position: fixed;left: 0;right: 0;z-index: 1000;bottom: 0;">
                        <div style="background-color: #ecf0f1 !important;padding: 15px !important;padding: 20px;margin: 0;background-color: #f5f5f5;border-top: 1px solid #e7ecf1;text-align: center;">
                            <button type="submit" class="btn blue"> <i class="fa fa-save"></i> <?php echo L('the_save');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $(".make-switch").bootstrapSwitch();
});
function add_menu() {
    var data = '<div style="padding: 8px; height: 45px;"><label style="text-align: right;margin-bottom: 0;padding-top: 7px;margin-top: 1px;font-weight: 400;width: 16.66667%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;">&nbsp;</label><div style="width: 75%;float: left;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"><label><input class="form-control " type="text" name="data[bdts][][site]" placeholder="<?php echo L('站点域名');?>" value="" style="width: 180px;height: 34px;padding: 6px 12px;background-color: #fff;border: 1px solid #c2cad8;border-radius: 4px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"></label>&nbsp;&nbsp;<label><input class="form-control input-large" type="text" name="data[bdts][][token]" placeholder="<?php echo L('密钥token');?>" style="width: 320px;height: 34px;padding: 6px 12px;background-color: #fff;border: 1px solid #c2cad8;border-radius: 4px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"></label><label>&nbsp;&nbsp;<a href="javascript:;" onClick="remove_menu(this)" class="btn red" style="color: #fff;background-color: #e7505a;border-color: #e7505a;line-height: 1.44;outline: 0!important;box-shadow: none!important;display: inline-block;margin-bottom: 0;vertical-align: middle;cursor: pointer;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;line-height: 1.42857;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;"><i class="fa fa-trash"></i> <?php echo L('删除');?></a></label></div></div>';
    $('#menu_body').append(data);
}
function remove_menu(_this) {
    $(_this).parent().parent().parent().remove()
}
</script>
</body>
</html>