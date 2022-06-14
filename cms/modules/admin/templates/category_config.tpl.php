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
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=category&a=public_cache&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('变更栏目属性之后，需要一键更新栏目配置信息');?></a></p>
</div>
<form action="?m=admin&c=category&a=config_add" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<input type="hidden" name="menuid" value="<?php echo $this->input->get('menuid');?>">
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('栏目属性设置').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-table"></i> <?php if (!is_mobile(0)) {echo L('栏目属性设置');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('默认展开顶级栏目下层');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="data[popen]" value="1"<?php if ($data['popen']) {?> checked<?php }?> /> <?php echo L('open');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="data[popen]" value="0"<?php if (empty($data['popen'])) {?> checked<?php }?> /> <?php echo L('close');?> <span></span></label>
                            </div>

                            <span class="help-block"><?php echo L('进入栏目管理时默认展开顶级栏目的下级子栏目');?></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('后台列表显示字段');?></label>
                        <div class="col-md-9">

                            <div class="table-scrollable">

                            <table class="table table-striped table-bordered table-hover table-checkable dataTable">
                                <thead>
                                <tr class="heading">
                                    <th class="myselect">
                                        <?php echo L('显示');?>
                                    </th>
                                    <th width="180"> <?php echo L('字段');?> </th>
                                    <th> <?php echo L('说明');?> </th>
                                </tr>
                                </thead>
                                <tbody class="field-sort-items2">
                                <?php 
                                if(is_array($sysfield)){
                                foreach($sysfield as $n => $t){
                                ?>
                                <tr class="odd gradeX">
                                    <td class="myselect">
                                        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" name="data[sys_field][]" value="<?php echo $n;?>"<?php if (dr_in_array($n, $data['sys_field'])){?> checked<?php }?> />
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?php echo $t[0];?></td>
                                    <td><?php echo $t[1];?></td>
                                </tr>
                                <?php }}?>
                                </tbody>
                            </table></div>

                                <div class="table-scrollable" style="margin-top: 30px">
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
                                    foreach($field as $n => $t){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="myselect">
                                            <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" name="data[list_field][<?php echo $t['field'];?>][use]" value="1" <?php if ($data['list_field'][$t['field']]['use']){?> checked<?php }?> />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><?php echo L($t['name']);?> (<?php echo $t['field'];?>)</td>
                                        <td><input class="form-control" type="text" name="data[list_field][<?php echo $t['field'];?>][name]" value="<?php echo $data['list_field'][$t['field']]['name'] ? htmlspecialchars($data['list_field'][$t['field']]['name']) : $t['name'];?>" /></td>
                                        <td> <input class="form-control" type="text" name="data[list_field][<?php echo $t['field'];?>][width]" value="<?php echo htmlspecialchars($data['list_field'][$t['field']]['width']);?>" /></td>
                                        <td><input type="checkbox" name="data[list_field][<?php echo $t['field'];?>][center]" <?php if ($data['list_field'][$t['field']]['center']){?> checked<?php }?> value="1"  data-on-text="<?php echo L('居中');?>" data-off-text="<?php echo L('默认');?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                                        </td>
                                        <td> <div class="input-group" style="width:250px">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-success" href="javascript:help('?m=content&c=sitemodel&a=public_help&pc_hash='+pc_hash);"><?php echo L('回调');?></a>
                                                </span>
                                            <input class="form-control" type="text" name="data[list_field][<?php echo $t['field'];?>][func]" value="<?php echo htmlspecialchars($data['list_field'][$t['field']]['func']);?>" />
                                        </div></td>
                                    </tr>
                                    <?php }}?>
                                    </tbody>
                                </table>
                        </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <button type="button" onclick="dr_ajax_submit('?m=admin&c=category&a=config_add&page='+$('#dr_page').val(), 'myform', '2000')" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit')?></button>
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
</script>
</body>
</html>