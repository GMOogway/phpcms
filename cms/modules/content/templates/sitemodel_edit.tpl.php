<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" href="<?php echo JS_PATH;?>bootstrap-switch/css/bootstrap-switch.min.css" media="all" />
<script type="text/javascript" src="<?php echo JS_PATH;?>bootstrap-switch/js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>jquery-ui/jquery-ui.min.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $(":text").removeClass('input-text');
});
</script>
<div class="page-content main-content">
<div class="note note-danger">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('update_cache_all');?></a></p>
</div>
<form action="?m=content&c=sitemodel&a=edit" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<input type="hidden" name="modelid" value="<?php echo $modelid;?>" />
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('basic_configuration').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('basic_configuration');}?> </a>
            </li>
            <li<?php if ($page==1) {?> class="active"<?php }?>>
                <a data-toggle="tab_1" onclick="$('#dr_page').val('1')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('后台列表显示字段').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-table"></i> <?php if (!is_mobile(0)) {echo L('后台列表显示字段');}?> </a>
            </li>
            <li<?php if ($page==2) {?> class="active"<?php }?>>
                <a data-toggle="tab_2" onclick="$('#dr_page').val('2')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('template_setting').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-html5"></i> <?php if (!is_mobile(0)) {echo L('template_setting');}?> </a>
            </li>
            <li<?php if ($page==3) {?> class="active"<?php }?>>
                <a data-toggle="tab_3" onclick="$('#dr_page').val('3')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('other_template_setting').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-internet-explorer"></i> <?php if (!is_mobile(0)) {echo L('other_template_setting');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('model_name');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="name" name="info[name]" value="<?php echo $name;?>" onblur="topinyin('tablename','name','?m=content&c=sitemodel&a=public_ajax_pinyin');"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('model_tablename');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="tablename" name="info[tablename]" value="<?php echo $tablename;?>" disabled></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('description');?></label>
                        <div class="col-md-9">
                            <textarea class="form-control " style="height:90px" name="info[description]"><?php echo $description;?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('updatetime_check');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[updatetime_select]" value="0"<?php echo (!$updatetime_select) ? ' checked' : ''?>> <?php echo L('check_not_default');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[updatetime_select]" value="1"<?php echo ($updatetime_select) ? ' checked' : ''?>> <?php echo L('check_default');?> <span></span></label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==1) {?> active<?php }?>" id="tab_1">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('列表默认排序');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-xlarge" type="text" name="setting[order]" value="<?php if ($order){?><?php echo htmlspecialchars($order);?><?php }else{?>updatetime DESC<?php }?>" ></label>
                            <span class="help-block"><?php echo L('排序格式符号MySQL的语法，例如：主表字段 desc');?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('列表时间搜索');?></label>
                        <div class="col-md-9">

                            <label><input class="form-control" type="text" name="setting[search_time]" value="<?php if ($search_time){?><?php echo htmlspecialchars($search_time);?><?php }else{?>updatetime<?php }?>" ></label>
                            <span class="help-block"><?php echo L('设置后台时间范围搜索字段，默认为更新时间字段：updatetime');?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('列表显示字段');?></label>
                        <div class="col-md-9">
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
                                                <input type="checkbox" class="checkboxes" name="setting[list_field][<?php echo $t['field'];?>][use]" value="1" <?php if ($list_field[$t['field']]['use']){?> checked<?php }?> />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><?php echo L($t['name']);?> (<?php echo $t['field'];?>)</td>
                                        <td><input class="form-control" type="text" name="setting[list_field][<?php echo $t['field'];?>][name]" value="<?php echo $list_field[$t['field']]['name'] ? htmlspecialchars($list_field[$t['field']]['name']) : $t['name'];?>" /></td>
                                        <td> <input class="form-control" type="text" name="setting[list_field][<?php echo $t['field'];?>][width]" value="<?php echo htmlspecialchars($list_field[$t['field']]['width']);?>" /></td>
                                        <td><input type="checkbox" name="setting[list_field][<?php echo $t['field'];?>][center]" <?php if ($list_field[$t['field']]['center']){?> checked<?php }?> value="1"  data-on-text="<?php echo L('居中');?>" data-off-text="<?php echo L('默认');?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                                        </td>
                                        <td> <div class="input-group" style="width:250px">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-success" href="javascript:dr_call_alert();"><?php echo L('回调');?></a>
                                                </span>
                                            <input class="form-control" type="text" name="setting[list_field][<?php echo $t['field'];?>][func]" value="<?php echo htmlspecialchars($list_field[$t['field']]['func']);?>" />
                                        </div></td>
                                    </tr>
                                    <?php }}}?>
                                    </tbody>
                                </table>
                            </div>

                            <span class="help-block"><?php echo L('拖动字段可以进行顺序排列');?></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==2) {?> active<?php }?>" id="tab_2">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('available_styles');?></label>
                        <div class="col-md-9">
                            <label><?php echo form::select($style_list, $default_style, 'name="info[default_style]" id="template_list" onchange="load_file_list(this.value)"', L('please_select'))?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('category_index_tpl');?></label>
                        <div class="col-md-9">
                            <label id="category_template"><?php echo form::select_template($default_style,'content', $category_template, 'name="setting[category_template]" id="template_category"', 'category')?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('category_list_tpl');?></label>
                        <div class="col-md-9">
                            <label id="list_template"><?php echo form::select_template($default_style,'content', $list_template, 'name="setting[list_template]" id="template_list"', 'list')?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('content_tpl');?></label>
                        <div class="col-md-9">
                            <label id="show_template"><?php echo form::select_template($default_style,'content', $show_template, 'name="setting[show_template]" id="template_show"','show')?></label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==3) {?> active<?php }?>" id="tab_3">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('other_template_setting');?></label>
                        <div class="col-md-9">
                            <div class="mt-checkbox-inline">
                                <label class="mt-checkbox mt-checkbox-outline"><input type="checkbox" name="other" id="other" value="1"<?php echo ($admin_list_template) ? ' checked' : ''?>> <?php echo L('other_template_setting');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="other_tab" style="display:none;">
                        <label class="col-md-2 control-label"><?php echo L('admin_content_list');?></label>
                        <div class="col-md-9">
                            <label id="admin_list_template"><?php echo $admin_list_template_f;?></label>
                        </div>
                    </div>
                    <div class="form-group" id="other_tab2" style="display:none;">
                        <label class="col-md-2 control-label"><?php echo L('member_content_add');?></label>
                        <div class="col-md-9">
                            <label id="member_add_template"><?php echo form::select_template($default_style,'member', $member_add_template, 'name="setting[member_add_template]" id="template_member_add"', 'content_publish')?></label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <button type="button" onclick="dr_ajax_submit('?m=content&c=sitemodel&a=edit&page='+$('#dr_page').val(), 'myform', '2000')" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit')?></button>
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
$(function() {
    $(".field-sort-items").sortable();
    $(".make-switch").bootstrapSwitch();
});
function load_file_list(id) {
    $.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id, function(data){$('#category_template').html(data.category_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
}
$("#other").click(function() {
    if ($('#other').attr('checked')) {
        $('#other_tab').show();
        $('#other_tab2').show();
    } else {
        $('#other_tab').hide();
        $('#other_tab2').hide();
    }
})
if ($('#other').attr('checked')) {
    $('#other_tab').show();
    $('#other_tab2').show();
} else {
    $('#other_tab').hide();
    $('#other_tab2').hide();
}
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