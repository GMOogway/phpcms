<?php
defined('IS_ADMIN') or exit('No permission resources.');
$show_validator = $show_dialog = 1;
include $this->admin_tpl('header','admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">var bs_selectAllText = '全选';var bs_deselectAllText = '全删';var bs_noneSelectedText = '没有选择'; var bs_noneResultsText = '没有找到 {0}';</script>
<link href="<?php echo JS_PATH?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH?>bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script type="text/javascript">jQuery(document).ready(function(){$('.bs-select').selectpicker();});</script>
<div class="page-content main-content">
<div class="row my-content-top-tool">
    <div class="col-md-12 col-sm-12">
        <label style="margin-right:10px"><a href="javascript:;" class="btn red"> <i class="fa fa-plus"></i> <?php echo L('add_field');?></a></label>
        <label><?php if (isset($formid) && !empty($formid)) {?><a href="?m=formguide&c=formguide_field&a=init&modelid=<?php echo $formid?>&menuid=<?php echo $_GET['menuid']?>" class="btn green"> <i class="fa fa-reorder"></i> <?php echo L('manage_field');?></a><?php } else {?><a href="?m=formguide&c=formguide_field&a=init&menuid=<?php echo $_GET['menuid']?>" class="btn green"> <i class="fa fa-reorder"></i> <?php echo L('public_field_manage')?></a><?php }?></label>
    </div>
</div>
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('更改数据之后需要更新缓存之后才能生效');?></a></p>
</div>
<form action="" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<input name="dosubmit" type="hidden" value="1">
<input name="menuid" type="hidden" value="<?php echo $this->input->get('menuid');?>">
<input name="info[modelid]" type="hidden" value="<?php echo $formid?>">
    <div class="portlet light bordered myfbody">
        <div class="portlet-title tabbable-line">
            <ul class="nav nav-tabs" style="float:left;">
                <li<?php if ($page==0) {?> class="active"<?php }?>>
                    <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('基本设置').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('基本设置');}?> </a>
                </li>
                <li<?php if ($page==1) {?> class="active"<?php }?>>
                    <a data-toggle="tab_1" onclick="$('#dr_page').val('1')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('字段样式').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-code"></i> <?php if (!is_mobile(0)) {echo L('字段样式');}?> </a>
                </li>
                <li<?php if ($page==2) {?> class="active"<?php }?>>
                    <a data-toggle="tab_2" onclick="$('#dr_page').val('2')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('数据验证').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-crop"></i> <?php if (!is_mobile(0)) {echo L('数据验证');}?> </a>
                </li>
                <li<?php if ($page==3) {?> class="active"<?php }?>>
                    <a data-toggle="tab_3" onclick="$('#dr_page').val('3')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('字段权限').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-user"></i> <?php if (!is_mobile(0)) {echo L('字段权限');}?> </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body form">
            <div class="tab-content">
                <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                    <div class="form-body">
                        <div class="form-group" id="dr_row_formtype">
                            <label class="col-md-2 control-label"><?php echo L('field_type');?></label>
                            <div class="col-md-9">
                                <?php echo form::select($all_field,'','name="info[formtype]" id="formtype" onchange="javascript:field_setting(this.value);"',L('select_fieldtype'));?>
                            </div>
                        </div>
                        <div class="form-group" id="dr_row_name">
                            <label class="col-md-2 control-label"><?php echo L('field_nickname')?></label>
                            <div class="col-md-9">
                                <label><input class="form-control" type="text" name="info[name]" value="" id="name" onblur="topinyin('field','name','?m=formguide&c=formguide_field&a=public_ajax_pinyin');"></label>
                                <span class="help-block"><?php echo L('nickname_tips')?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo L('fieldname')?></label>
                            <div class="col-md-9">
                                <label><input class="form-control" type="text" name="info[field]" value="" id="field"></label>
                                <span class="help-block"><?php echo L('fieldname_tips')?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body" id="setting"></div>
                </div>
                <div class="tab-pane<?php if ($page==1) {?> active<?php }?>" id="tab_1">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo L('field_tip')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:120px" name="info[tips]"></textarea>
                                <span class="help-block"><?php echo L('field_tips')?></span>
                            </div>
                        </div>
                        <div class="form-group" id="formattribute">
                            <label class="col-md-2 control-label"><?php echo L('form_attr')?></label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="info[formattribute]" value="">
                                <span class="help-block"><?php echo L('form_attr_tips')?></span>
                            </div>
                        </div>
                        <div class="form-group" id="css">
                            <label class="col-md-2 control-label"><?php echo L('form_css_name')?></label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="info[css]" value="">
                                <span class="help-block"><?php echo L('form_css_name_tips')?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane<?php if ($page==2) {?> active<?php }?>" id="tab_2">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo L('string_size')?></label>
                            <div class="col-md-9">
                                <label><?php echo L('minlength');?>：</label>
                                <label><input class="form-control" type="text" name="info[minlength]" value="0" id="field_minlength"></label>
                                <label><?php echo L('maxlength');?>：</label>
                                <label><input class="form-control" type="text" name="info[maxlength]" value="" id="field_maxlength"></label>
                                <span class="help-block"><?php echo L('string_size_tips')?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo L('data_preg')?></label>
                            <div class="col-md-9">
                                <label><input class="form-control" type="text" name="info[pattern]" value="" id="pattern"></label>
                                <label><select name="pattern_select" onchange="javascript:$('#pattern').val(this.value)">
                                    <option value=""><?php echo L('often_preg');?></option>
                                    <option value="/^[0-9.-]+$/"><?php echo L('figure');?></option>
                                    <option value="/^[0-9-]+$/"><?php echo L('integer');?></option>
                                    <option value="/^[a-z]+$/i"><?php echo L('letter');?></option>
                                    <option value="/^[0-9a-z]+$/i"><?php echo L('integer_letter');?></option>
                                    <option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
                                    <option value="/^[0-9]{5,20}$/">QQ</option>
                                    <option value="/^http(s?):\/\//"><?php echo L('hyperlink');?></option>
                                    <option value="/^(1)[0-9]{10}$/"><?php echo L('mobile_number');?></option>
                                    <option value="/^[0-9-]{6,13}$/"><?php echo L('tel_number');?></option>
                                    <option value="/^[0-9]{6}$/"><?php echo L('zip');?></option>
                                </select></label>
                                <span class="help-block"><?php echo L('data_preg_tips')?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo L('data_passed_msg')?></label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="info[errortips]" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane<?php if ($page==3) {?> active<?php }?>" id="tab_3">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo L('disabled_groups_field')?></label>
                            <div class="col-md-9">
                                <label style="min-width: 200px;">
                                    <select class="form-control bs-select" name="unsetgroupids[]" id="unsetgroupids" multiple data-actions-box="true">
                                        <?php if(is_array($grouplist)){
                                        foreach($grouplist as $key=>$value){?>
                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                        <?php }}?>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="portlet-body form myfooter">
        <div class="form-actions text-center">
            <button type="button" id="my_submit" onclick="dr_ajax_submit('?m=formguide&c=formguide_field&a=add&page='+$('#dr_page').val(), 'myform', '2000')" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit')?></button>
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
function field_setting(fieldtype) {
    $('#formattribute').css('display','none');
    $('#css').css('display','none');
    if(fieldtype) {
        $.getJSON("?m=formguide&c=formguide_field&a=public_field_setting&fieldtype="+fieldtype, function(data){
            if(data.field_allow_search=='1') {
                $('#field_allow_search0').attr("disabled",false);
                $('#field_allow_search1').attr("disabled",false);
            } else {
                $('#field_allow_search0').attr("checked",true);
                $('#field_allow_search0').attr("disabled",true);
                $('#field_allow_search1').attr("disabled",true);
            }
            if(data.field_allow_isunique=='1') {
                $('#field_allow_isunique0').attr("disabled",false);
                $('#field_allow_isunique1').attr("disabled",false);
            } else {
                $('#field_allow_isunique0').attr("checked",true);
                $('#field_allow_isunique0').attr("disabled",true);
                $('#field_allow_isunique1').attr("disabled",true);
            }
            $('#field_minlength').val(data.field_minlength);
            $('#field_maxlength').val(data.field_maxlength);
            $('#setting').html(data.setting);
    
        });
    }
}
</script>
</body>
</html>