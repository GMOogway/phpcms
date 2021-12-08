<?php defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<link rel="stylesheet" href="<?php echo JS_PATH;?>bootstrap-switch/css/bootstrap-switch.min.css" media="all" />
<script type="text/javascript" src="<?php echo JS_PATH;?>bootstrap-switch/js/bootstrap-switch.min.js"></script>
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.portlet.light {padding: 12px 20px 15px;background-color: #fff;}
.portlet.light>.portlet-title {padding: 0;color: #181C32;font-weight: 500;}
.portlet.bordered>.portlet-title {border-bottom: 0;}
.portlet>.portlet-title {padding: 0;margin-bottom: 2px;-webkit-border-radius: 4px 4px 0 0;-moz-border-radius: 4px 4px 0 0;-ms-border-radius: 4px 4px 0 0;-o-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;}
.portlet>.portlet-title>.caption {float: left;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;}
.portlet.light>.portlet-title>.caption.caption-md>.caption-subject, .portlet.light>.portlet-title>.caption>.caption-subject {font-size: 15px;}
.font-dark {color: #2f353b!important;}
.portlet>.portlet-title:after,.portlet>.portlet-title:before {content: " ";display: table;}
.portlet>.portlet-title:after {clear: both;}
.portlet>.portlet-title>.nav-tabs {background: 0 0;margin: 1px 0 0;float: right;display: inline-block;border: 0;}
.portlet>.portlet-title>.nav-tabs>li {background: 0 0;margin: 0;border: 0;}
.portlet>.portlet-title>.nav-tabs>li>a {background: 0 0;margin: 5px 0 0 1px;border: 0;padding: 8px 10px;color: #fff;}
.portlet>.portlet-title>.nav-tabs>li.active>a,.portlet>.portlet-title>.nav-tabs>li:hover>a {color: #333;background: #fff;border: 0;}
.portlet.light>.portlet-title>.nav-tabs>li {margin: 0;padding: 0;}
.portlet.light>.portlet-title>.nav-tabs>li>a {margin: 0;padding: 12px 13px 13px;color: #666;}
.portlet.light>.portlet-title>.nav-tabs>li>a {font-size: 14px!important;}
.tabbable-line>.nav-tabs {border: none;margin: 0;}
.tabbable-line>.nav-tabs>li {margin: 0;border-bottom: 4px solid transparent;}
.tabbable-line>.nav-tabs>li>a {background: 0 0!important;border: 0;margin: 0;padding-left: 15px;padding-right: 15px;color: #737373;cursor: pointer;}
.tabbable-line>.nav-tabs>li>a>i {color: #a6a6a6;}
.tabbable-line>.nav-tabs>li.active {background: 0 0;border-bottom: 4px solid #3ea9e2;position: relative;}
.tabbable-line>.nav-tabs>li.active>a {border: 0;color: #333;}
.tabbable-line>.nav-tabs>li.active>a>i {color: #404040;}
.tabbable-line>.nav-tabs>li.open,.tabbable-line>.nav-tabs>li:hover {background: 0 0;border-bottom: 4px solid #dadbde;}
.tabbable-line>.nav-tabs>li.open>a,.tabbable-line>.nav-tabs>li:hover>a {border: 0;background: 0 0!important;color: #333;}
.tabbable-line>.nav-tabs>li.open>a>i,.tabbable-line>.nav-tabs>li:hover>a>i {color: #a6a6a6;}
.tabbable-line>.nav-tabs>li.active {border-bottom: 4px solid #40aae3;}
.form .form-body,.portlet-form .form-body {padding: 20px;}
.form-group .input-inline {margin-right: 5px;}
.input-inline, .radio-list>label.radio-inline {display: inline-block;}
.badge, .input-inline {vertical-align: middle;}
.input-medium{width: 240px!important;}
.input-large {width: 320px!important;}
@media (max-width:768px) {
.input-large {width: 250px!important;}
.input-xlarge {width: 300px!important;}
}
</style>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#defualtpoint").formValidator({tipid:"pointtip",onshow:"<?php echo L('input').L('defualtpoint')?>",onfocus:"<?php echo L('defualtpoint').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('defualtpoint').L('between_1_to_8_num')?>"});
	$("#defualtamount").formValidator({tipid:"starnumtip",onshow:"<?php echo L('input').L('defualtamount')?>",onfocus:"<?php echo L('defualtamount').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('defualtamount').L('between_1_to_8_num')?>"});
	$("#rmb_point_rate").formValidator({tipid:"rmb_point_rateid",onshow:"<?php echo L('input').L('rmb_point_rate')?>",onfocus:"<?php echo L('rmb_point_rate').L('between_1_to_8_num')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('rmb_point_rate').L('between_1_to_8_num')?>"});

});
//-->
</script>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('更改数据之后需要更新缓存之后才能生效');?></a></p>
</div>
<form action="?m=member&c=member_setting&a=manage" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('member_setting').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('member_setting');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_maxloginfailedtimes')?></label>
                        <div class="col-md-9">
                            <div class="input-inline input-medium">
                                <div class="input-group">
                                    <input type="text" name="info[maxloginfailedtimes]" id="maxloginfailedtimes" value="<?php echo intval($member_setting['maxloginfailedtimes']);?>" class="form-control">
                                    <span class="input-group-addon">
                                        <?php echo L('login_ci')?>
                                    </span>
                                </div>
                            </div>
                            <span class="help-block"><?php echo L('setting_maxloginfailedtimes_desc')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_time_limit')?></label>
                        <div class="col-md-9">
                            <div class="input-inline input-medium">
                                <div class="input-group">
                                    <input type="text" name="info[syslogintimes]" id="syslogintimes" value="<?php echo intval($member_setting['syslogintimes']);?>" class="form-control">
                                    <span class="input-group-addon">
                                        <?php echo L('minutes')?>
                                    </span>
                                </div>
                            </div>
                            <span class="help-block"><?php echo L('setting_time_limit_desc')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('allow_register')?></label>
                        <div class="col-md-9">
                            <input type="checkbox" name="info[allowregister]" value="1" <?php echo $member_setting['allowregister'] ? ' checked' : ''?> data-on-text="<?php echo L('open')?>" data-off-text="<?php echo L('close')?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('register_model')?></label>
                        <div class="col-md-9">
                            <input type="checkbox" name="info[choosemodel]" value="1" <?php echo $member_setting['choosemodel'] ? ' checked' : ''?> data-on-text="<?php echo L('open')?>" data-off-text="<?php echo L('close')?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('register_email_auth')?></label>
                        <div class="col-md-9">
                            <input type="checkbox" name="info[enablemailcheck]" value="1" <?php echo $member_setting['enablemailcheck'] ? ' checked' : ''?> data-on-text="<?php echo L('open')?>" data-off-text="<?php echo L('close')?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('enablcodecheck')?></label>
                        <div class="col-md-9">
                            <input type="checkbox" name="info[enablcodecheck]" value="1" <?php echo $member_setting['enablcodecheck'] ? ' checked' : ''?> data-on-text="<?php echo L('open')?>" data-off-text="<?php echo L('close')?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('mobile_checktype')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobile_checktype]" value="2"<?php echo ($member_setting['mobile_checktype']=='2') ? ' checked' : ''?><?php echo ($sms_disabled) ? ' disabled' : ''?> onclick="$('#sendsms_titleid').hide();"> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobile_checktype]" value="0"<?php echo (!$member_setting['mobile_checktype']) ? ' checked' : ''?> onclick="$('#sendsms_titleid').hide();"> <?php echo L('no');?> <span></span></label>
                            </div>
                            <label><a class="btn btn-sm red" href="?m=sms&c=sms&a=sms_setting"> <?php echo L('短信平台配置');?> </a></label>
                        </div>
                    </div>
                    <div class="form-group" id="sendsms_titleid" <?php if($member_setting['mobile_checktype']!='1'){?> style="display: none; " <?php }?>>
                        <label class="col-md-2 control-label"><?php echo L('user_sendsms_title')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="user_sendsms_title" name="info[user_sendsms_title]" value="<?php echo $member_setting['user_sendsms_title'];?>" ></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('register_verify')?></label>
                        <div class="col-md-9">
                            <input type="checkbox" name="info[registerverify]" value="1" <?php echo $member_setting['registerverify'] ? ' checked' : ''?> data-on-text="<?php echo L('open')?>" data-off-text="<?php echo L('close')?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('show_app_point')?></label>
                        <div class="col-md-9">
                            <input type="checkbox" name="info[showapppoint]" value="1" <?php echo $member_setting['showapppoint'] ? ' checked' : ''?> data-on-text="<?php echo L('open')?>" data-off-text="<?php echo L('close')?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <div class="form-group" id="dr_row_rmb_point_rate">
                        <label class="col-md-2 control-label"><?php echo L('rmb_point_rate')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="rmb_point_rate" name="info[rmb_point_rate]" value="<?php echo $member_setting['rmb_point_rate'];?>" ></label>
                            <span class="help-block"><?php echo L('rmb_point_rate').L('between_1_to_8_num')?></span>
                        </div>
                    </div>
                    <div class="form-group" id="dr_row_defualtpoint">
                        <label class="col-md-2 control-label"><?php echo L('defualtpoint')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="defualtpoint" name="info[defualtpoint]" value="<?php echo $member_setting['defualtpoint'];?>" >
                            <span class="help-block"><?php echo L('defualtpoint').L('between_1_to_8_num')?></span>
                        </div>
                    </div>
                    <div class="form-group" id="dr_row_defualtamount">
                        <label class="col-md-2 control-label"><?php echo L('defualtamount')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="defualtamount" name="info[defualtamount]" value="<?php echo $member_setting['defualtamount'];?>" >
                            <span class="help-block"><?php echo L('defualtamount').L('between_1_to_8_num')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('show_register_protocol')?></label>
                        <div class="col-md-9">
                            <input type="checkbox" name="info[showregprotocol]" value="1" <?php echo $member_setting['showregprotocol'] ? ' checked' : ''?> data-on-text="<?php echo L('open')?>" data-off-text="<?php echo L('close')?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('register_protocol')?></label>
                        <div class="col-md-9">
                            <textarea name='info[regprotocol]' id='regprotocol' class="form-control" style="width:80%;height:120px;"><?php echo $member_setting['regprotocol']?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('register_verify_message')?></label>
                        <div class="col-md-9">
                            <textarea name='info[registerverifymessage]' id='registerverifymessage' class="form-control" style="width:80%;height:120px;"><?php echo $member_setting['registerverifymessage']?></textarea>
                            <span class="help-block"><?php echo L('register_func_tips')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('forgetpasswordmessage')?></label>
                        <div class="col-md-9">
                            <textarea name='info[forgetpassword]' id='forgetpassword' class="form-control" style="width:80%;height:120px;"><?php echo $member_setting['forgetpassword']?></textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <button type="button" id="my_submit" onclick="dr_ajax_submit('?m=member&c=member_setting&a=manage&page='+$('#dr_page').val(), 'myform', '2000')" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit')?></button>
            </div>
        </div>
    </div>
</div>
</form>
</div>
<script type="text/javascript">
$('body').keydown(function(e){
    if (e.keyCode == 13) {
        $('#my_submit').trigger('click');
    }
})
$('.nav-tabs a').click(function (e) {
    $('.nav-tabs').find('li').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(this).parent().addClass('active');
    $('#'+$(this).attr("data-toggle")).addClass('active');
})
$(function() {
    $(".make-switch").bootstrapSwitch();
});
</script>
</body>
</html>