<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
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
</style>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('操作之前请更新下全站缓存');?></a></p>
</div>
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('according_model').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-th-large"></i> <?php if (!is_mobile(0)) {echo L('according_model');}?> </a>
            </li>
            <?php if($_SESSION['roleid']==1 && ADMIN_FOUNDERS && dr_in_array($_SESSION['userid'], ADMIN_FOUNDERS)) {?>
            <li<?php if ($page==1) {?> class="active"<?php }?>>
                <a data-toggle="tab_1"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('按字段批量替换').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-database"></i> <?php if (!is_mobile(0)) {echo L('按字段批量替换');}?> </a>
            </li>
            <li<?php if ($page==2) {?> class="active"<?php }?>>
                <a data-toggle="tab_2"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('按字段批量设置').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-edit"></i> <?php if (!is_mobile(0)) {echo L('按字段批量设置');}?> </a>
            </li>
            <li<?php if ($page==3) {?> class="active"<?php }?>>
                <a data-toggle="tab_3"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('全模型替换').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-edit"></i> <?php if (!is_mobile(0)) {echo L('全模型替换');}?> </a>
            </li>
            <?php }?>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">
                <div class="table-list">
                    <table style="margin-top: 30px;" class="table table-striped table-bordered table-hover table-checkable dataTable">
                        <thead>
                        <tr class="heading">
                            <th width="50"> </th>
                            <th width="180"> <?php echo L('model_name');?> </th>
                            <th><?php echo L('operations_manage');?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $models = getcache('model','commons');
                        $i=1;
                        foreach($models as $_k=>$_v) {
                            if($_v['siteid']!=$this->siteid) continue;
                        ?>
                        <tr class="heading">
                            <td><?php echo $i;?></td>
                            <td><?php echo $_v['name'];?></td>
                            <td>
                                <button type="button" onclick="dr_submit_todo('', '?m=content&c=create_html&a=public_show_url&modelid=<?php echo $_v['modelid'];?>')" class="btn blue btn-xs"> <i class="fa fa-refresh"></i> <?php echo L('批量更新内容URL地址')?> </button>
                                <?php if (ADMIN_FOUNDERS && dr_in_array($_SESSION['userid'], ADMIN_FOUNDERS)) {?>
                                <button type="button" onclick="iframe_show('<?php echo L('批量操作')?>','?m=content&c=create_html&a=public_desc_index&modelid=<?php echo $_v['modelid'];?>')" class="btn drak btn-xs"> <i class="fa fa-th-large"></i> <?php echo L('批量提取描述字段')?> </button>
                                <button type="button" onclick="iframe_show('<?php echo L('批量操作')?>','?m=content&c=create_html&a=public_thumb_index&modelid=<?php echo $_v['modelid'];?>')" class="btn green btn-xs"> <i class="fa fa-photo"></i> <?php echo L('批量提取缩略图')?> </button>
                                <button type="button" onclick="iframe_show('<?php echo L('批量操作')?>','?m=content&c=create_html&a=public_tag_index&modelid=<?php echo $_v['modelid'];?>')" class="btn yellow btn-xs"> <i class="fa fa-tag"></i> <?php echo L('批量提取关键词')?> </button>
                                <?php }?>
                                <?php if($_SESSION['roleid']==1 && ADMIN_FOUNDERS && dr_in_array($_SESSION['userid'], ADMIN_FOUNDERS)) {?>
                                <button type="button" onclick="iframe_show('<?php echo L('批量操作')?>','?m=content&c=create_html&a=public_del_index&modelid=<?php echo $_v['modelid'];?>')" class="btn red btn-xs"> <i class="fa fa-trash"></i> <?php echo L('批量彻底删除内容')?> </button>
                                <button type="button" onclick="iframe_show('<?php echo L('批量操作')?>','?m=content&c=create_html&a=public_cat_index&modelid=<?php echo $_v['modelid'];?>')" class="btn green btn-xs"> <i class="fa fa-reorder"></i> <?php echo L('批量变更栏目')?> </button>
                                <?php }?>
                            </td>
                        </tr>
                        <?php $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane<?php if ($page==1) {?> active<?php }?>" id="tab_1">
                <form action="" class="form-horizontal" method="post" id="replaceform">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-2 control-label"> <?php echo L('表名称')?> </label>
                            <div class="col-md-9">
                                <label><select name="bm" class="form-control" onchange="dr_fd(this.value)">
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
                                <label id="dr_fd"><label><select class="form-control">
                                    <option value="0"><?php echo L('没有选择表')?></option>
                                </select></label></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('被替换内容')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" name="t1"></textarea>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('设置被替换的字符内容')?> </p>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('替换后的内容')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" name="t2"></textarea>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('将上面设置的被替换的字符替换成新的字符')?> </p>
                            </div>
                        </div>

                        <div class="form-actions row">
                            <label class="col-md-2 control-label">&nbsp;</label>
                            <div class="col-md-9" style="padding-left: 5px;">
                                <button type="button" onclick="dr_submit_post_todo('replaceform', '?m=content&c=create_html&a=public_replace_index')" class="btn blue"> <i class="fa fa-database"></i> <?php echo L('立即执行')?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane<?php if ($page==2) {?> active<?php }?>" id="tab_2">
                <form action="" class="form-horizontal" method="post" id="editform">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-2 control-label"> <?php echo L('表名称')?> </label>
                            <div class="col-md-9">
                                <label><select name="bm" class="form-control" onchange="dr_sz(this.value)">
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
                                <label id="dr_sz"><label><select class="form-control">
                                    <option value="0"><?php echo L('没有选择表')?></option>
                                </select></label></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('修改方式')?></label>
                            <div class="col-md-9">
                                <div class="mt-radio-inline">
                                    <label class="mt-radio mt-radio-outline"><input type="radio" name="ms" value="0" checked /> <?php echo L('完全替换指定值')?> <span></span></label>
                                    <label class="mt-radio mt-radio-outline"><input type="radio" name="ms" value="1"  /> <?php echo L('将新值插入在原值之前')?> <span></span></label>
                                    <label class="mt-radio mt-radio-outline"><input type="radio" name="ms" value="2"  /> <?php echo L('将新值插入在原值之后')?> <span></span></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('执行条件')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" name="t1"></textarea>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('设置批量替换的条件SQL语句，留空表示全部替换')?> </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('设置新的值')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" name="t2"></textarea>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('设置修改后的字符内容')?> </p>
                            </div>
                        </div>

                        <div class="form-actions row">
                            <label class="col-md-2 control-label">&nbsp;</label>
                            <div class="col-md-9" style="padding-left: 5px;">
                                <button type="button" onclick="dr_submit_post_todo('editform', '?m=content&c=create_html&a=public_all_edit')" class="btn blue"> <i class="fa fa-database"></i> <?php echo L('立即执行')?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane<?php if ($page==3) {?> active<?php }?>" id="tab_3">
                <form action="" class="form-horizontal" method="post" id="allform">
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-2 control-label"> </label>
                            <div class="col-md-9">
                                <div class="well well2">
                                    <?php echo L('当网站域名变更时可以在这里进行全模块替换')?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('被替换内容')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" id="alldb_t1"></textarea>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('设置被替换的字符内容')?> </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label"><?php echo L('替换后的内容')?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" style="height:100px" id="alldb_t2"></textarea>
                                <p style="padding-top:9px;" class="help-block"> <?php echo L('将上面设置的被替换的字符替换成新的字符')?> </p>

                            </div>
                        </div>

                        <script>
                        function dr_alldb_edit() {
                            var url = '?m=content&c=create_html&a=public_dball_edit&t1='+$('#alldb_t1').val()+'&t2='+$('#alldb_t2').val();
                            iframe_show('<?php echo L('批量操作')?>', url);
                        }
                        </script>

                        <div class="form-actions row">
                            <label class="col-md-2 control-label">&nbsp;</label>
                            <div class="col-md-9" style="padding-left: 5px;">
                                <button type="button" onclick="dr_alldb_edit();" class="btn blue"> <i class="fa fa-database"></i> <?php echo L('立即执行')?></button>
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
function dr_fd(v) {
    $.ajax({type: "get",dataType:"json", url: "?m=content&c=create_html&a=public_field_index&table="+v,
        success: function(json) {
            if (json.code == 1) {
                $('#dr_fd').html(json.msg);
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
function dr_sz(v) {
    $.ajax({type: "get",dataType:"json", url: "?m=content&c=create_html&a=public_field_index&table="+v,
        success: function(json) {
            if (json.code == 1) {
                $('#dr_sz').html(json.msg);
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
<script language="JavaScript">
<!--
window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>