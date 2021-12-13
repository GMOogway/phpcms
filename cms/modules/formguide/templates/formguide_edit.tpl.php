<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<link rel="stylesheet" href="<?php echo JS_PATH;?>bootstrap-switch/css/bootstrap-switch.min.css" media="all" />
<script type="text/javascript" src="<?php echo JS_PATH;?>bootstrap-switch/js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>jquery-ui/jquery-ui.min.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-ui/jquery-ui.min.js"></script>
<link href="<?php echo JS_PATH;?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo JS_PATH;?>bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            format: "yyyy-mm-dd",
            orientation: "left",
            autoclose: true
        });
    }
    $(":text").removeClass('input-text');
});
</script>
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
.btn-success {color: #fff!important;background-color: #3ea9e2;border-color: #2bb8c4;}
.btn-success.focus,.btn-success:focus {color: #fff;background-color: #27a4b0;border-color: #14565c;}
.btn-success.active,.btn-success:active,.btn-success:hover,.open>.btn-success.dropdown-toggle {color: #fff;background-color: #27a4b0;border-color: #208992;}
.btn-success.active.focus,.btn-success.active:focus,.btn-success.active:hover,.btn-success:active.focus,.btn-success:active:focus,.btn-success:active:hover,.open>.btn-success.dropdown-toggle.focus,.open>.btn-success.dropdown-toggle:focus,.open>.btn-success.dropdown-toggle:hover {color: #fff;background-color: #208992;border-color: #14565c;}
.input-inline, .radio-list>label.radio-inline {display: inline-block;}
.badge, .input-inline {vertical-align: middle;}
.input-medium{width: 240px!important;}
.input-large {width: 320px!important;}
@media (max-width:768px) {
.input-large {width: 250px!important;}
.input-xlarge {width: 300px!important;}
}
</style>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('更改数据之后需要更新缓存之后才能生效');?></a></p>
</div>
<form action="?m=formguide&c=formguide&a=edit" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<input name="formid" id="formid" type="hidden" value="<?php echo $_GET['formid']?>">
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('基本设置').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('基本设置');}?> </a>
            </li>
            <li<?php if ($page==1) {?> class="active"<?php }?>>
                <a data-toggle="tab_1" onclick="$('#dr_page').val('1')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('后台显示字段').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-table"></i> <?php if (!is_mobile(0)) {echo L('后台显示字段');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('name');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="name" name="info[name]" value="<?php echo new_html_special_chars($data['name']);?>" onblur="topinyin('tablename','name','?m=formguide&c=formguide&a=public_ajax_pinyin');"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('tablename');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="tablename" name="info[tablename]" value="<?php echo $data['tablename'];?>"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('introduction');?></label>
                        <div class="col-md-9">
                            <textarea class="form-control " style="height:90px" name="info[description]"><?php echo $data['description'];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('time_limit');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enabletime]" value="1"<?php echo ($data['setting']['enabletime']) ? ' checked' : ''?>> <?php echo L('enable');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enabletime]" value="0"<?php echo (!$data['setting']['enabletime']) ? ' checked' : ''?>> <?php echo L('unenable');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="time"<?php echo (!$data['setting']['enabletime']) ? ' style="display:none;"' : ''?>>
                        <label class="col-md-2 control-label"><?php echo L('时间范围');?></label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group date-picker input-daterange " data-date="" data-date-format="yyyy-mm-dd">
                                    <input type="text" placeholder="<?php echo L('start_time');?>" class="form-control" value="<?php echo ($data['setting']['starttime'] ? dr_date($data['setting']['starttime'], 'Y-m-d') : '');?>" name="setting[starttime]">
                                    <span class="input-group-addon"> <?php echo L('到');?> </span>
                                    <input type="text" placeholder="<?php echo L('end_time');?>" class="form-control" value="<?php echo ($data['setting']['endtime'] ? dr_date($data['setting']['endtime'], 'Y-m-d') : '');?>" name="setting[endtime]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('allowed_send_mail');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[sendmail]" value="1"<?php echo ($data['setting']['sendmail']) ? ' checked' : ''?>> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[sendmail]" value="0"<?php echo (!$data['setting']['sendmail']) ? ' checked' : ''?>> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="mailaddress"<?php echo (!$data['setting']['sendmail']) ? ' style="display:none;"' : ''?>>
                        <label class="col-md-2 control-label"><?php echo L('e-mail_address');?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="mails" name="setting[mails]" value="<?php echo $data['setting']['mails'];?>" >
                            <span class="help-block"><?php echo L('multiple_with_commas')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('allows_more_ip');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[allowmultisubmit]" value="1"<?php echo ($data['setting']['allowmultisubmit']) ? ' checked' : ''?>> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[allowmultisubmit]" value="0"<?php echo (!$data['setting']['allowmultisubmit']) ? ' checked' : ''?>> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('allowunreg');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[allowunreg]" value="1"<?php echo ($data['setting']['allowunreg']) ? ' checked' : ''?>> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[allowunreg]" value="0"<?php echo (!$data['setting']['allowunreg']) ? ' checked' : ''?>> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('code');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[code]" value="1"<?php echo ($data['setting']['code']) ? ' checked' : ''?>> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[code]" value="0"<?php echo (!$data['setting']['code']) ? ' checked' : ''?>> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('提交成功提示文字');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="rt_text" name="setting[rt_text]" value="<?php echo $data['setting']['rt_text'];?>"></label>
                            <span class="help-block"><?php echo L('当用户提交表单成功之后显示的文字，默认为：感谢您的参与！')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('提交成功跳转URL');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="rt_url" name="setting[rt_url]" value="<?php echo $data['setting']['rt_url'];?>"></label>
                            <span class="help-block"><?php echo L('当用户提交表单成功之后跳转的链接，{APP_PATH}表示当前站点URL，{formid}表示当前表单的id号，{siteid}表示当前站点的id号')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('optional_style');?></label>
                        <div class="col-md-9">
                            <label><?php echo form::select($template_list, $data['default_style'], 'name="info[default_style]" id="style" onchange="load_file_list(this.value)"', L('please_select'))?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('template_selection')?></label>
                        <div class="col-md-9">
                            <label id="show_template"><script type="text/javascript">$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style=<?php echo $data['default_style']?>&id=<?php echo $data['show_template']?>&module=formguide&templates=show&name=info&pc_hash='+pc_hash, function(data){$('#show_template').html(data.show_template);});</script></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('js调用使用的模板');?></label>
                        <div class="col-md-9">
                            <label id="show_js_template"><script type="text/javascript">$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style=<?php echo $data['default_style']?>&id=<?php echo $data['js_template']?>&module=formguide&templates=show_js&name=info&pc_hash='+pc_hash, function(data){$('#show_js_template').html(data.show_js_template);});</script></label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==1) {?> active<?php }?>" id="tab_1">
                <div class="form-body">

                    <div class="table-list">
                        <table class="table table-striped table-bordered table-hover table-checkable dataTable">
                            <thead>
                            <tr class="heading">
                                <th class="myselect">
                                    <?php echo L('显示');?>
                                </th>
                                <th width="180"> <?php echo L('字段');?> </th>
                                <th width="150"> <?php echo L('名称');?> </th>
                                <th width="100"> <?php echo L('宽度');?> </th>
                                <th width="140"> <?php echo L('对其方式');?> </th>
                                <th> <?php echo L('回调方法');?> </th>
                            </tr>
                            </thead>
                            <tbody class="field-sort-items">
                            <?php 
                            if(is_array($field)){
                            foreach($field as $n=>$t){
                            if ($t['field']) {
                            ?>
                            <tr class="odd gradeX">
                                <td class="myselect">
                                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="setting[list_field][<?php echo $t['field'];?>][use]" value="1" <?php if ($data['setting']['list_field'][$t['field']]['use']){?> checked<?php }?> />
                                        <span></span>
                                    </label>
                                </td>
                                <td><?php echo L($t['name']);?> (<?php echo $t['field'];?>)</td>
                                <td><input class="form-control" type="text" name="setting[list_field][<?php echo $t['field'];?>][name]" value="<?php echo $data['setting']['list_field'][$t['field']]['name'] ? htmlspecialchars($data['setting']['list_field'][$t['field']]['name']) : $t['name'];?>" /></td>
                                <td> <input class="form-control" type="text" name="setting[list_field][<?php echo $t['field'];?>][width]" value="<?php echo htmlspecialchars($data['setting']['list_field'][$t['field']]['width']);?>" /></td>
                                <td><input type="checkbox" name="setting[list_field][<?php echo $t['field'];?>][center]" <?php if ($data['setting']['list_field'][$t['field']]['center']){?> checked<?php }?> value="1"  data-on-text="<?php echo L('居中');?>" data-off-text="<?php echo L('默认');?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                                </td>
                                <td> <div class="input-group" style="width:250px">
                                        <span class="input-group-btn">
                                            <a class="btn btn-success" href="javascript:dr_call_alert();"><?php echo L('回调');?></a>
                                        </span>
                                    <input class="form-control" type="text" name="setting[list_field][<?php echo $t['field'];?>][func]" value="<?php echo htmlspecialchars($data['setting']['list_field'][$t['field']]['func']);?>" />
                                </div></td>
                            </tr>
                            <?php }}}?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <button type="button" id="my_submit" onclick="dr_ajax_submit('?m=formguide&c=formguide&a=edit&page='+$('#dr_page').val(), 'myform', '2000')" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit')?></button>
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
    $(".field-sort-items").sortable();
    $(".make-switch").bootstrapSwitch();
});
function load_file_list(id) {
    if (id=='') return false;
    $.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&module=formguide&templates=show|show_js&name=info&pc_hash='+pc_hash, function(data){$('#show_template').html(data.show_template);$('#show_js_template').html(data.show_js_template);});
}
$(document).ready(function(){
    $.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){Dialog.alert(msg,function(){$(obj).focus();})}});
    $('#name').formValidator({onshow:"<?php echo L('input_form_title')?>",onfocus:"<?php echo L('title_min_3_chars')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('title_cannot_empty')?>"}).defaultPassed();
    $('#tablename').formValidator({onshow:"<?php echo L('please_input_tallename')?>", onfocus:"<?php echo L('standard')?>", oncorrect:"<?php echo L('right')?>"}).regexValidator({regexp:"^[a-zA-Z]{1}([a-zA-Z0-9]|[_]){0,19}$",onerror:"<?php echo L('tablename_was_wrong');?>"}).inputValidator({min:1,onerror:"<?php echo L('tablename_no_empty')?>"}).ajaxValidator({
        type : "get",
        url : "",
        data : "m=formguide&c=formguide&a=public_checktable&formid=<?php echo $_GET['formid']?>",
        datatype : "html",
        cached:false,
        getdata:{issystem:'issystem'},
        async:'false',
        success : function(data){    
            if( data == "1" ){
                return true;
            } else {
                return false;
            }
        },
        buttons: $("#dosubmit"),
        onerror : "<?php echo L('tablename_existed')?>",
        onwait : "<?php echo L('connecting_please_wait')?>"
    }).defaultPassed();
    $('#starttime').formValidator({onshow:"<?php echo L('select_stardate')?>",onfocus:"<?php echo L('select_stardate')?>",oncorrect:"<?php echo L('right_all')?>"}).defaultPassed();
    $('#endtime').formValidator({onshow:"<?php echo L('select_downdate')?>",onfocus:"<?php echo L('select_downdate')?>",oncorrect:"<?php echo L('right_all')?>"}).defaultPassed();
    $('#style').formValidator({onshow:"<?php echo L('select_style')?>",onfocus:"<?php echo L('select_style')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('select_style')?>"}).defaultPassed();
});
$("input:radio[name='setting[enabletime]']").click(function (){
    if($("input:radio[name='setting[enabletime]'][checked]").val()==0) {
        $("#time").hide();
    } else if($("input:radio[name='setting[enabletime]'][checked]").val()==1) {
        $("#time").show();
    }
});
$("input:radio[name='setting[sendmail]']").click(function (){
    if($("input:radio[name='setting[sendmail]'][checked]").val()==0) {
        $("#mailaddress").hide();
    } else if($("input:radio[name='setting[sendmail]'][checked]").val()==1) {
        $("#mailaddress").show();
    }
});
function dr_call_alert() {
    layer.open({
        type: 2,
        title: '<i class="fa fa-question-circle"></i> 在线帮助',
        shadeClose: true,
        scrollbar: false,
        shade: 0,
        area: ['80%', '90%'],
        content: '?m=content&c=sitemodel&a=public_help&pc_hash='+pc_hash
    });
}
</script>
</body>
</html>