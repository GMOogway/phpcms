<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script type="text/javascript">
jQuery(document).ready(function() {
    $(":text").removeClass('input-text');
});
</script>
<div class="page-content main-content">
<div class="note note-danger">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('操作之前请更新下全站缓存');?></a></p>
</div>
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('SQL工具箱').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-th-large"></i> <?php if (!is_mobile(0)) {echo L('SQL工具箱');}?> </a>
            </li>
            <?php if(cleck_admin($_SESSION['roleid']) && ADMIN_FOUNDERS && dr_in_array($_SESSION['userid'], ADMIN_FOUNDERS)) {?>
            <li<?php if ($page==1) {?> class="active"<?php }?>>
                <a data-toggle="tab_1"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('执行sql语句').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-database"></i> <?php if (!is_mobile(0)) {echo L('执行sql语句');}?> </a>
            </li>
            <li<?php if ($page==2) {?> class="active"<?php }?>>
                <a data-toggle="tab_2"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('替换数据').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-edit"></i> <?php if (!is_mobile(0)) {echo L('替换数据');}?> </a>
            </li>
            <li<?php if ($page==3) {?> class="active"<?php }?>>
                <a data-toggle="tab_3"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('数据表分区').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-table"></i> <?php if (!is_mobile(0)) {echo L('数据表分区');}?> </a>
            </li>
            <?php }?>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">
                <form action="" class="form-horizontal" method="post" id="replaceform">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-2 control-label"> <?php echo L($name);?> </label>
                            <div class="col-md-9">
                                <p class="form-control-static"><?php echo L($description);?></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane<?php if ($page==1) {?> active<?php }?>" id="tab_1">
                <form action="" class="form-horizontal" method="post" id="sqlform">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('select_sql')?></label>
                            <div class="col-md-9">
                                <textarea name="sqls" id="sqls" style="height:200px;" class="form-control"></textarea>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('select_sql_desc')?> </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('execution')?></label>
                            <div class="col-md-9" id="sql_result">
                            </div>
                        </div>
                        <?php if ($sql_cache) {?>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('recently')?></label>
                            <div class="col-md-9">
                                <label><select class="form-control" onchange="$('#sqls').val(this.value)">
                                    <option value="">--</option>
                                    <?php foreach ($sql_cache as $t) {?>
                                    <option value="<?php echo $t?>"><?php echo str_cut($t, 50)?></option>
                                    <?php }?>
                                </select></label>
                            </div>
                        </div>
                        <?php }?>

                        <div class="form-actions row">
                            <label class="col-md-2 control-label">&nbsp;</label>
                            <div class="col-md-9" style="padding-left: 5px;">
                                <button type="button" onclick="dr_submit_sql_todo('sqlform', '?m=sqltoolplus&c=index&a=sqlquery')" class="btn blue"> <i class="fa fa-database"></i> <?php echo L('立即执行')?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane<?php if ($page==2) {?> active<?php }?>" id="tab_2">
                <form action="" class="form-horizontal" method="post" id="sqlreplace">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-2 control-label"> <?php echo L('表名称')?> </label>
                            <div class="col-md-9">
                                <label><select name="db_table" class="form-control" onchange="dr_sz(this.value)">
                                    <option value="0"><?php echo L('选择表')?></option>
                                    <?php foreach($tables as $t) {?>
                                    <option value="<?php echo $t['Name'];?>"><?php echo $t['Name'];?><?php if ($t['Comment']) {?>（<?php echo $t['Comment'];?>）<?php }?></option>
                                    <?php }?>
                                </select></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('待替换字段')?></label>
                            <div class="col-md-9">
                                <label id="dr_sz"><select class="form-control">
                                    <option value="0"><?php echo L('没有选择表')?></option>
                                </select></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('alternative')?></label>
                            <div class="col-md-9">
                                <?php echo form::radio(array('0'=>L('regularreplaced'),'1'=>L('replacematch'),'2'=>L('replaceordinary')),2,'name="replace_type" onclick="clk_replace_type(this.value)"',230)?>
                            </div>
                        </div>
                        <div class="form-group row" id="db_pr_tr">
                            <label class="col-md-2 control-label"><?php echo L('db_pr_field')?></label>
                            <div class="col-md-9">
                                <label><select id="db_pr_field" name="db_pr_field"></select></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('search_rule')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" name="search_rule"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('replace_data')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" name="replace_data"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('sql_where')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" name="sql_where"></textarea>
                            </div>
                        </div>

                        <div class="form-actions row">
                            <label class="col-md-2 control-label">&nbsp;</label>
                            <div class="col-md-9" style="padding-left: 5px;">
                                <button type="button" onclick="dr_submit_post_todo('sqlreplace', '?m=sqltoolplus&c=index&a=sqlreplace')" class="btn blue"> <i class="fa fa-database"></i> <?php echo L('立即执行')?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane<?php if ($page==3) {?> active<?php }?>" id="tab_3">
                <form action="" class="form-horizontal" method="post" id="dbtpatition">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('modelmx')?></label>
                            <div class="col-md-9">
                                <?php echo form::select($model_array,'','name="modelid"',L('select'))?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('foreachpartition')?></label>
                            <div class="col-md-9">
                                <?php echo form::select(array('100000'=>L('selectshiwan'),'500000'=>L('selectwushiwan'),'1000000'=>L('selectyibaiwan'),'5000000'=>L('selectwubaiwan')),'','name="dbtp_range"')?>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('foreachpartitiondesc')?> </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('partitions')?></label>
                            <div class="col-md-9">
                                <label><input type="text" name="dbtp_num" value="0" class="form-control"></label>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('partitionsdesc')?> </p>
                            </div>
                        </div>

                        <div class="form-actions row">
                            <label class="col-md-2 control-label">&nbsp;</label>
                            <div class="col-md-9" style="padding-left: 5px;">
                                <button type="button" onclick="dr_submit_post_todo('dbtpatition', '?m=sqltoolplus&c=index&a=dbtpatition')" class="btn blue"> <i class="fa fa-database"></i> <?php echo L('立即执行')?></button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>
<script>
$('.nav-tabs a').click(function (e) {
    $('.nav-tabs').find('li').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(this).parent().addClass('active');
    $('#'+$(this).attr("data-toggle")).addClass('active');
})
function clk_replace_type(v){
    if(v==2){
        $('#db_pr_tr').hide();
        $('#db_pr_field').html('');
    }else{
        $('#db_pr_tr').show();
        $('#db_pr_field').html($('#db_field').html());
    }
}
clk_replace_type(2);
function dr_sz(v) {
    $.ajax({type: "get",dataType:"json", url: "?m=sqltoolplus&c=index&a=public_field_index&table="+v,
        success: function(json) {
            if (json.code == 1) {
                $('#dr_sz').html(json.msg);
                if($('#db_pr_field').html()!=''){
                    $('#db_pr_field').html($('#db_field').html());
                }
            } else {
                dr_tips(0, json.msg);
            }
            return false;
        },
        error: function(HttpRequest, ajaxOptions, thrownError) {
            dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
        }
    });
}
</script>
</body>
</html>