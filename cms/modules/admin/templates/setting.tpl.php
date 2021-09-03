<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.myfbody {margin-bottom: 90px;}
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
.input-large {width: 320px!important;}
@media (max-width:768px) {
.input-large {width: 250px!important;}
.input-xlarge {width: 300px!important;}
}
</style>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){Dialog.alert(msg,function(){$(obj).focus();})}});
		$("#js_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_js_path')?>",onfocus:"<?php echo L('setting_js_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_js_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_js_path').L('setting_end_with_x')?>"});
		$("#css_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_css_path')?>",onfocus:"<?php echo L('setting_css_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_css_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_css_path').L('setting_end_with_x')?>"});

		$("#img_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_img_path')?>",onfocus:"<?php echo L('setting_img_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_img_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_img_path').L('setting_end_with_x')?>"});
		$("#mobile_js_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_mobile_js_path')?>",onfocus:"<?php echo L('setting_mobile_js_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_mobile_js_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_mobile_js_path').L('setting_end_with_x')?>"});
		$("#mobile_css_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_mobile_css_path')?>",onfocus:"<?php echo L('setting_mobile_css_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_mobile_css_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_mobile_css_path').L('setting_end_with_x')?>"});

		$("#mobile_img_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_mobile_img_path')?>",onfocus:"<?php echo L('setting_mobile_img_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_mobile_img_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_mobile_img_path').L('setting_end_with_x')?>"});

		$("#errorlog_size").formValidator({onshow:"<?php echo L('setting_errorlog_hint')?>",onfocus:"<?php echo L('setting_input').L('setting_error_log_size')?>"}).inputValidator({onerror:"<?php echo L('setting_error_log_size').L('setting_input_error')?>"}).regexValidator({regexp:"num",datatype:"enum",onerror:"<?php echo L('setting_errorlog_type')?>"});	
	})
//-->
</script>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('操作之前请更新下全站缓存');?></a></p>
</div>
<form action="?m=admin&c=setting&a=save" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('setting_basic_cfg').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('setting_basic_cfg');}?> </a>
            </li>
            <li<?php if ($page==1) {?> class="active"<?php }?>>
                <a data-toggle="tab_1" onclick="$('#dr_page').val('1')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('setting_safe_cfg').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-shield"></i> <?php if (!is_mobile(0)) {echo L('setting_safe_cfg');}?> </a>
            </li>
            <li<?php if ($page==2) {?> class="active"<?php }?>>
                <a data-toggle="tab_2" onclick="$('#dr_page').val('2')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('setting_mail_cfg').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-envelope"></i> <?php if (!is_mobile(0)) {echo L('setting_mail_cfg');}?> </a>
            </li>
            <li<?php if ($page==3) {?> class="active"<?php }?>>
                <a data-toggle="tab_3" onclick="$('#dr_page').val('3')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('setting_connect').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-html5"></i> <?php if (!is_mobile(0)) {echo L('setting_connect');}?> </a>
            </li>
            <li<?php if ($page==4) {?> class="active"<?php }?>>
                <a data-toggle="tab_4" onclick="$('#dr_page').val('4')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('setting_keyword_enable').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-tags"></i> <?php if (!is_mobile(0)) {echo L('setting_keyword_enable');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_admin_email')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="admin_email" name="setting[admin_email]" value="<?php echo $admin_email;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_category_ajax')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="category_ajax" name="setting[category_ajax]" value="<?php echo $category_ajax;?>" >
                            <span class="help-block"><?php echo L('setting_category_ajax_desc')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_gzip')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setconfig[gzip]" value="1"<?php echo ($gzip=='1') ? ' checked' : ''?>> <?php echo L('setting_yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setconfig[gzip]" value="0"<?php echo ($gzip=='0') ? ' checked' : ''?>> <?php echo L('setting_no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('editormode')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setconfig[sys_editor]" value="0"<?php echo ($sys_editor=='0') ? ' checked' : ''?>> <?php echo L('UEditor');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setconfig[sys_editor]" value="1"<?php echo ($sys_editor=='1') ? ' checked' : ''?>> <?php echo L('CKEditor');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_js_path')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="js_path" name="setconfig[js_path]" value="<?php echo $js_path;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_css_path')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="css_path" name="setconfig[css_path]" value="<?php echo $css_path;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_img_path')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="img_path" name="setconfig[img_path]" value="<?php echo $img_path;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_mobile_js_path')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="mobile_js_path" name="setconfig[mobile_js_path]" value="<?php echo $mobile_js_path;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_mobile_css_path')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="mobile_css_path" name="setconfig[mobile_css_path]" value="<?php echo $mobile_css_path;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_mobile_img_path')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="mobile_img_path" name="setconfig[mobile_img_path]" value="<?php echo $mobile_img_path;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_timezone')?></label>
                        <div class="col-md-9">
                            <label><select class="form-control" name="setconfig[timezone]">
                                <option value=""> -- </option>
                                <option value="-12"<?php echo ($timezone=='-12') ? ' selected' : ''?>>(GMT -12:00)</option>
                                <option value="-11"<?php echo ($timezone=='-11') ? ' selected' : ''?>>(GMT -11:00)</option>
                                <option value="-10"<?php echo ($timezone=='-10') ? ' selected' : ''?>>(GMT -10:00)</option>
                                <option value="-9"<?php echo ($timezone=='-9') ? ' selected' : ''?>>(GMT -09:00)</option>
                                <option value="-8"<?php echo ($timezone=='-8') ? ' selected' : ''?>>(GMT -08:00)</option>
                                <option value="-7"<?php echo ($timezone=='-7') ? ' selected' : ''?>>(GMT -07:00)</option>
                                <option value="-6"<?php echo ($timezone=='-6') ? ' selected' : ''?>>(GMT -06:00)</option>
                                <option value="-5"<?php echo ($timezone=='-5') ? ' selected' : ''?>>(GMT -05:00)</option>
                                <option value="-4"<?php echo ($timezone=='-4') ? ' selected' : ''?>>(GMT -04:00)</option>
                                <option value="-3.5"<?php echo ($timezone=='-3.5') ? ' selected' : ''?>>(GMT -03:30)</option>
                                <option value="-3"<?php echo ($timezone=='-3') ? ' selected' : ''?>>(GMT -03:00)</option>
                                <option value="-2"<?php echo ($timezone=='-2') ? ' selected' : ''?>>(GMT -02:00)</option>
                                <option value="-1"<?php echo ($timezone=='-1') ? ' selected' : ''?>>(GMT -01:00)</option>
                                <option value="0"<?php echo ($timezone=='0') ? ' selected' : ''?>>(GMT)</option>
                                <option value="1"<?php echo ($timezone=='1') ? ' selected' : ''?>>(GMT +01:00)</option>
                                <option value="2"<?php echo ($timezone=='2') ? ' selected' : ''?>>(GMT +02:00)</option>
                                <option value="3"<?php echo ($timezone=='3') ? ' selected' : ''?>>(GMT +03:00)</option>
                                <option value="3.5"<?php echo ($timezone=='3.5') ? ' selected' : ''?>>(GMT +03:30)</option>
                                <option value="4"<?php echo ($timezone=='4') ? ' selected' : ''?>>(GMT +04:00)</option>
                                <option value="4.5"<?php echo ($timezone=='4.5') ? ' selected' : ''?>>(GMT +04:30)</option>
                                <option value="5"<?php echo ($timezone=='5') ? ' selected' : ''?>>(GMT +05:00)</option>
                                <option value="5.5"<?php echo ($timezone=='5.5') ? ' selected' : ''?>>(GMT +05:30)</option>
                                <option value="5.75"<?php echo ($timezone=='6') ? ' selected' : ''?>>(GMT +05:45)</option>
                                <option value="6"<?php echo ($timezone=='6.5') ? ' selected' : ''?>>(GMT +06:00)</option>
                                <option value="6.5"<?php echo ($timezone=='7') ? ' selected' : ''?>>(GMT +06:30)</option>
                                <option value="7"<?php echo ($timezone=='7.5') ? ' selected' : ''?>>(GMT +07:00)</option>
                                <option value="8"<?php echo ($timezone=='' || $timezone=='8') ? ' selected' : ''?>>(GMT +08:00)</option>
                                <option value="9"<?php echo ($timezone=='9') ? ' selected' : ''?>>(GMT +09:00)</option>
                                <option value="9.5"<?php echo ($timezone=='9.5') ? ' selected' : ''?>>(GMT +09:30)</option>
                                <option value="10"<?php echo ($timezone=='10') ? ' selected' : ''?>>(GMT +10:00)</option>
                                <option value="11"<?php echo ($timezone=='11') ? ' selected' : ''?>>(GMT +11:00)</option>
                                <option value="12"<?php echo ($timezone=='12') ? ' selected' : ''?>>(GMT +12:00)</option>
                            </select></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_time')?></label>
                        <div class="col-md-9">
                            <p class="form-control-static" id="site_time"><?php echo dr_date(SYS_TIME);?></p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==1) {?> active<?php }?>" id="tab_1">
                <div class="form-body">

                    <div class="form-group hidden">
                        <label class="col-md-2 control-label"><?php echo L('setting_csrf')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[sys_csrf]" value="1" type="radio" <?php echo ($sys_csrf=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[sys_csrf]" value="0" type="radio" <?php echo ($sys_csrf=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?> <span></span></label>
                            </div>
                            <span class="help-block"><?php echo L('setting_csrf_desc')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('need_check_come_url')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[needcheckcomeurl]" value="1" type="radio" <?php echo ($needcheckcomeurl=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[needcheckcomeurl]" value="0" type="radio" <?php echo ($needcheckcomeurl=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_admin_log')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[admin_log]" value="1" type="radio" <?php echo ($admin_log=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[admin_log]" value="0" type="radio" <?php echo ($admin_log=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_error_log')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[errorlog]" value="1" type="radio" <?php echo ($errorlog=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[errorlog]" value="0" type="radio" <?php echo ($errorlog=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_error_log_size')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="errorlog_size" name="setting[errorlog_size]" value="<?php echo $errorlog_size;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_admin_code')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincode]" value="0" type="radio" <?php echo (!$sysadmincode) ? ' checked' : ''?> onclick="$('#sysadmincodemodel').removeClass('hidden');"> <?php echo L('setting_yes')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincode]" value="1" type="radio" <?php echo ($sysadmincode) ? ' checked' : ''?> onclick="$('#sysadmincodemodel').addClass('hidden');$('#captcha_charset').addClass('hidden');$('#sysadmincodevoicemodel').addClass('hidden');"> <?php echo L('setting_no')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group<?php echo ($sysadmincode) ? ' hidden' : ''?>" id="sysadmincodemodel">
                        <label class="col-md-2 control-label"><?php echo L('setting_admin_code_model')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincodemodel]" value="0" type="radio" <?php echo (!$sysadmincodemodel) ? ' checked' : ''?> onclick="$('#captcha_charset').addClass('hidden');$('#sysadmincodevoicemodel').addClass('hidden');"> <?php echo L('setting_confusion')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincodemodel]" value="1" type="radio" <?php echo ($sysadmincodemodel==1) ? ' checked' : ''?> onclick="$('#captcha_charset').addClass('hidden');$('#sysadmincodevoicemodel').addClass('hidden');"> <?php echo L('setting_digital')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincodemodel]" value="2" type="radio" <?php echo ($sysadmincodemodel==2) ? ' checked' : ''?> onclick="$('#captcha_charset').addClass('hidden');$('#sysadmincodevoicemodel').removeClass('hidden');"> <?php echo L('setting_letters')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincodemodel]" value="3" type="radio" <?php echo ($sysadmincodemodel==3) ? ' checked' : ''?> onclick="$('#captcha_charset').removeClass('hidden');$('#sysadmincodevoicemodel').addClass('hidden');"> <?php echo L('setting_character')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group<?php echo ($sysadmincode || $sysadmincodemodel=='0' || $sysadmincodemodel=='1' || $sysadmincodemodel=='2') ? ' hidden' : ''?>" id="captcha_charset">
                        <label class="col-md-2 control-label"><?php echo L('setting_code_character')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="captcha_charset" name="setting[captcha_charset]" value="<?php echo $captcha_charset;?>" >
                        </div>
                    </div>
                    <div class="form-group<?php echo ($sysadmincode || $sysadmincodemodel=='0' || $sysadmincodemodel=='1' || $sysadmincodemodel=='3') ? ' hidden' : ''?>" id="sysadmincodevoicemodel">
                        <label class="col-md-2 control-label"><?php echo L('setting_voice_model')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincodevoicemodel]" value="0" type="radio" <?php echo (!$sysadmincodevoicemodel) ? ' checked' : ''?>> <?php echo L('setting_voice_default')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincodevoicemodel]" value="1" type="radio" <?php echo ($sysadmincodevoicemodel==1) ? ' checked' : ''?>> <?php echo L('setting_voice_girl')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setting[sysadmincodevoicemodel]" value="2" type="radio" <?php echo ($sysadmincodevoicemodel==2) ? ' checked' : ''?>> <?php echo L('setting_voice_boy')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_maxloginfailedtimes')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="maxloginfailedtimes" name="setting[maxloginfailedtimes]" value="<?php echo intval($maxloginfailedtimes);?>" >
                            <span class="help-block"><?php echo L('setting_maxloginfailedtimes_desc')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_time_limit')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="sysadminlogintimes" name="setting[sysadminlogintimes]" value="<?php echo intval($sysadminlogintimes);?>" >
                            <span class="help-block"><?php echo L('setting_time_limit_desc')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_keys')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="auth_key" name="setconfig[auth_key]" value="<?php echo $auth_key ? '************' : '';?>" ></label>
                            <label><button class="button" type="button" name="button" onclick="to_key()"> <?php echo L('setting_regenerate')?> </button></label>
                            <span class="help-block"><?php echo L('setting_keys_desc')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_minrefreshtime')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="minrefreshtime" name="setting[minrefreshtime]" value="<?php echo intval($minrefreshtime);?>" >
                            <span class="help-block"><?php echo L('miao')?></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==2) {?> active<?php }?>" id="tab_2">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('mail_type')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setting[mail_type]" checkbox="mail_type" value="1" onclick="showsmtp(this)" type="radio" <?php echo $mail_type==1 ? ' checked' : ''?>> <?php echo L('mail_type_smtp')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setting[mail_type]" checkbox="mail_type" value="0" onclick="showsmtp(this)" type="radio" <?php echo $mail_type==0 ? ' checked' : ''?> <?php if(substr(strtolower(PHP_OS), 0, 3) == 'win') echo 'disabled'; ?>/> <?php echo L('mail_type_mail')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group<?php if($mail_type == 0) echo ' hidden'?>" id="smtpcfg">
                        <label class="col-md-2 control-label"><?php echo L('mail_server')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="mail_server" name="setting[mail_server]" value="<?php echo $mail_server;?>" >
                        </div>
                    </div>
                    <div class="form-group<?php if($mail_type == 0) echo ' hidden'?>" id="smtpcfg">
                        <label class="col-md-2 control-label"><?php echo L('mail_port')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="mail_port" name="setting[mail_port]" value="<?php echo $mail_port;?>" >
                        </div>
                    </div>
                    <div class="form-group<?php if($mail_type == 0) echo ' hidden'?>" id="smtpcfg">
                        <label class="col-md-2 control-label"><?php echo L('mail_from')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="mail_from" name="setting[mail_from]" value="<?php echo $mail_from;?>" >
                        </div>
                    </div>
                    <div class="form-group<?php if($mail_type == 0) echo ' hidden'?>" id="smtpcfg">
                        <label class="col-md-2 control-label"><?php echo L('mail_auth')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setting[mail_auth]" checkbox="mail_auth" value="1" type="radio" <?php echo $mail_auth==1 ? ' checked' : ''?>> <?php echo L('mail_auth_open')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setting[mail_auth]" checkbox="mail_auth" value="0" type="radio" <?php echo $mail_auth==0 ? ' checked' : ''?>> <?php echo L('mail_auth_close')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group<?php if($mail_type == 0) echo ' hidden'?>" id="smtpcfg">
                        <label class="col-md-2 control-label"><?php echo L('mail_user')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="mail_user" name="setting[mail_user]" value="<?php echo $mail_user;?>" >
                        </div>
                    </div>
                    <div class="form-group<?php if($mail_type == 0) echo ' hidden'?>" id="smtpcfg">
                        <label class="col-md-2 control-label"><?php echo L('mail_password')?></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" id="mail_password" name="setting[mail_password]" value="<?php echo $mail_password;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('mail_test')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="mail_to" name="mail_to" value="" ></label>
                            <label><button class="btn green" type="button" name="button" onclick="test_mail()"> <i class="fa fa-send"></i> <?php echo L('mail_test_send')?> </button></label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==3) {?> active<?php }?>" id="tab_3">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_snda_enable')?></label>
                        <div class="col-md-9">
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon">APP key</span>
                                    <input type="text" id="snda_akey" name="setconfig[snda_akey]" value="<?php echo $snda_akey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon">APP secret key</span>
                                    <input type="text" id="snda_skey" name="setconfig[snda_skey]" value="<?php echo $snda_skey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <span class="help-block"><a href="http://code.snda.com/index/oauth" target="_blank"><?php echo L('click_register')?></a></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_connect_sina')?></label>
                        <div class="col-md-9">
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon">APP key</span>
                                    <input type="text" id="sina_akey" name="setconfig[sina_akey]" value="<?php echo $sina_akey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon">APP secret key</span>
                                    <input type="text" id="sina_skey" name="setconfig[sina_skey]" value="<?php echo $sina_skey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <span class="help-block"><a href="http://open.t.sina.com.cn/wiki/index.php/<?php echo L('connect_micro')?>" target="_blank"><?php echo L('click_register')?></a></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_connect_qq')?></label>
                        <div class="col-md-9">
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon">APP key</span>
                                    <input type="text" id="qq_akey" name="setconfig[qq_akey]" value="<?php echo $qq_akey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon">APP secret key</span>
                                    <input type="text" id="qq_skey" name="setconfig[qq_skey]" value="<?php echo $qq_skey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <span class="help-block"><a href="http://open.t.qq.com/" target="_blank"><?php echo L('click_register')?></a></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_connect_qqnew')?></label>
                        <div class="col-md-9">
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon">APP ID</span>
                                    <input type="text" id="qq_appid" name="setconfig[qq_appid]" value="<?php echo $qq_appid;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon">APP key</span>
                                    <input type="text" id="qq_appkey" name="setconfig[qq_appkey]" value="<?php echo $qq_appkey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo L('setting_connect_qqcallback')?></span>
                                    <input type="text" id="qq_callback" name="setconfig[qq_callback]" value="<?php echo $qq_callback;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <span class="help-block"><a href="http://connect.qq.com" target="_blank"><?php echo L('click_register')?></a></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==4) {?> active<?php }?>" id="tab_4">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_keyword')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[keywordapi]" value="0" type="radio"<?php echo ($keywordapi=='0') ? ' checked' : ''?> onclick="$('#baidu').addClass('hidden');$('#xunfei').addClass('hidden');"> <?php echo L('setting_default')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[keywordapi]" value="1" type="radio"<?php echo ($keywordapi=='1') ? ' checked' : ''?> onclick="$('#baidu').removeClass('hidden');$('#xunfei').addClass('hidden');"> <?php echo L('setting_baidu')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input name="setconfig[keywordapi]" value="2" type="radio"<?php echo ($keywordapi=='2') ? ' checked' : ''?> onclick="$('#xunfei').removeClass('hidden');$('#baidu').addClass('hidden');"> <?php echo L('setting_xunfei')?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('setting_qcnum')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="baidu_qcnum" name="setconfig[baidu_qcnum]" value="<?php echo intval($baidu_qcnum);?>" >
                        </div>
                    </div>
                    <div class="form-group<?php echo ($keywordapi=='2' || $keywordapi=='0') ? ' hidden' : ''?>" id="baidu">
                        <label class="col-md-2 control-label"><?php echo L('setting_baidu_enable')?></label>
                        <div class="col-md-9">
                            <div class="input-inline input-large hidden">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo L('setting_keyword_appid')?></span>
                                    <input type="text" id="baidu_aid" name="setconfig[baidu_aid]" value="<?php echo $baidu_aid;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo L('setting_keyword_key')?></span>
                                    <input type="text" id="baidu_skey" name="setconfig[baidu_skey]" value="<?php echo $baidu_skey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo L('setting_keyword_skey')?></span>
                                    <input type="text" id="baidu_arcretkey" name="setconfig[baidu_arcretkey]" value="<?php echo $baidu_arcretkey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <span class="help-block"><a href="https://cloud.baidu.com/" target="_blank"><?php echo L('setting_keyword_register')?></a></span>
                            <span class="help-block"><?php echo L('setting_baidu_keyword')?></span>
                        </div>
                    </div>
                    <div class="form-group<?php echo ($keywordapi=='1' || $keywordapi=='0') ? ' hidden' : ''?>" id="xunfei">
                        <label class="col-md-2 control-label"><?php echo L('setting_xunfei_enable')?></label>
                        <div class="col-md-9">
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo L('setting_keyword_appid')?></span>
                                    <input type="text" id="xunfei_aid" name="setconfig[xunfei_aid]" value="<?php echo $xunfei_aid;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="input-inline input-large">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo L('setting_keyword_key')?></span>
                                    <input type="text" id="xunfei_skey" name="setconfig[xunfei_skey]" value="<?php echo $xunfei_skey;?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <span class="help-block"><a href="https://console.xfyun.cn/services/ke" target="_blank"><?php echo L('setting_keyword_register')?></a></span>
                            <span class="help-block"><?php echo L('setting_xunfei_keyword')?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <button type="submit" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit')?></button>
            </div>
        </div>
    </div>
</div>
</form>
</div>
<script type="text/javascript">
$('.nav-tabs a').click(function (e) {
    $('.nav-tabs').find('li').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(this).parent().addClass('active');
    $('#'+$(this).attr("data-toggle")).addClass('active');
})
function showsmtp(obj,hiddenid){
	hiddenid = hiddenid ? hiddenid : 'smtpcfg';
	var status = $(obj).val();
	if(status == 1) $("#"+hiddenid).show();
	else  $("#"+hiddenid).hide();
}
function test_mail() {
	var mail_type = $('input[checkbox=mail_type][checked]').val();
	var mail_auth = $('input[checkbox=mail_auth][checked]').val();
    $.post('?m=admin&c=setting&a=public_test_mail&mail_to='+$('#mail_to').val(),{mail_type:mail_type,mail_server:$('#mail_server').val(),mail_port:$('#mail_port').val(),mail_user:$('#mail_user').val(),mail_password:$('#mail_password').val(),mail_auth:mail_auth,mail_from:$('#mail_from').val()}, function(data){
	Dialog.alert(data);
	});
}
function to_key() {
   $.get('?m=admin&c=setting&a=public_syskey&pc_hash='+pc_hash, function(data){
		$('#auth_key').val(data);
	});
}
$(function() {
	setInterval(dr_site_time, 1000);
});
function dr_site_time() {
	$.ajax({
		type: "get",
		dataType: "json",
		url: "?m=admin&c=setting&a=public_site_time&pc_hash="+pc_hash,
		success: function(json) {
			$('#site_time').html(json.msg);
		}
	});
}
</script>
</body>
</html>