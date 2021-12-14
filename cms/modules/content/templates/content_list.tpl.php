<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<script type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>layui/css/layui.css" media="all" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>admin/css/global.css" media="all" />
<link href="<?php echo JS_PATH;?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            format: "yyyy-mm-dd",
            orientation: "left",
            autoclose: true
        });
    }
    $('.tooltips').tooltip();
});
</script>
<style type="text/css">
a, a:link {text-shadow: none;color: #337ab7;text-decoration: none;}
a:hover {cursor: pointer;color: #23527c;}
.btn-group {margin-left: 10px;}
#search {height: 32px;line-height: 32px;}
</style>
<div class="admin-main layui-anim layui-anim-upbit">
    <!--<fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo L('list');?></legend>
    </fieldset>-->
    <blockquote class="layui-elem-quote">
        <a href="javascript:;" onclick="javascript:dr_content_submit('?m=content&c=content&a=add&menuid=&catid=<?php echo $catid;?>&pc_hash=<?php echo dr_get_csrf_token();?>','add');" class="layui-btn layui-btn-sm">
            <i class="fa fa-plus"></i> <?php echo L('add_content');?>
        </a>
        <a href="?m=content&c=content&a=init&catid=<?php echo $catid;?>&pc_hash=<?php echo dr_get_csrf_token();?>" class="layui-btn layui-btn-sm<?php if($steps==0 && !$this->input->get('reject')) echo ' on';?>">
            <i class="fa fa-check"></i> <?php echo L('check_passed');?>
        </a>
        <a href="?m=content&c=content&a=recycle_init&catid=<?php echo $catid;?>&pc_hash=<?php echo dr_get_csrf_token();?>" class="layui-btn layui-btn-sm layui-btn-danger">
            <i class="fa fa-trash-o"></i> <?php echo L('recycle');?>
        </a>
        <?php echo $workflow_menu;?>
        <a href="javascript:;" onclick="javascript:$('#searchid').toggle();" class="layui-btn layui-btn-sm layui-btn-normal">
            <i class="fa fa-search"></i> <?php echo L('search');?>
        </a>
        <?php if($category['ishtml']) {?>
        <a href="javascript:;" onclick="dr_bfb('<?php echo L('update_htmls',array('catname'=>$category['catname']));?>', 'myform', '?m=content&c=create_html&a=category&pagesize=30&dosubmit=1&modelid=0&catids[0]=<?php echo $catid;?>&pc_hash=<?php echo dr_get_csrf_token();?>&referer=<?php echo urlencode($_SERVER['QUERY_STRING']);?>')" class="layui-btn layui-btn-sm layui-btn-normal">
            <i class="fa fa-html5"></i> <?php echo L('update_htmls',array('catname'=>$category['catname']));?>
        </a>
        <?php }?>
    </blockquote>
    <div class="demoTable" id="searchid"<?php if (!$this->input->get('search')) {?> style="display:none;"<?php }?>>
        <form name="searchform" action="" method="get" >
        <input type="hidden" value="content" name="m">
        <input type="hidden" value="content" name="c">
        <input type="hidden" value="init" name="a">
        <input type="hidden" value="<?php echo $catid;?>" name="catid">
        <input type="hidden" value="<?php echo $steps;?>" name="steps">
        <input type="hidden" value="1" name="search">
        <input type="hidden" value="<?php echo dr_get_csrf_token();?>" name="pc_hash">
        <?php echo L('time');?>：
        <div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $this->input->get('start_time');?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $this->input->get('end_time');?>" name="end_time" id="end_time">
            </div>
        </div>
        <select id="posids" name="posids"><option value='' <?php if($this->input->get('posids')=='') echo 'selected';?>><?php echo L('all');?></option>
        <option value="1" <?php if($this->input->get('posids')==1) echo 'selected';?>><?php echo L('elite');?></option>
        <option value="2" <?php if($this->input->get('posids')==2) echo 'selected';?>><?php echo L('no_elite');?></option>
        </select>                
        <select id="searchtype" name="searchtype">
            <option value='0' <?php if($this->input->get('searchtype')==0) echo 'selected';?>><?php echo L('title');?></option>
            <option value='1' <?php if($this->input->get('searchtype')==1) echo 'selected';?>><?php echo L('intro');?></option>
            <option value='2' <?php if($this->input->get('searchtype')==2) echo 'selected';?>><?php echo L('username');?></option>
            <option value='3' <?php if($this->input->get('searchtype')==3) echo 'selected';?>>ID</option>
        </select>
        <div class="layui-inline">
            <input class="input-text" name="keyword" id="keyword" value="<?php if($this->input->get('keyword')) echo $this->input->get('keyword');?>" placeholder="请输入关键字">
        </div>
        <button type="submit" class="layui-btn" id="search" data-type="reload"><i class="fa fa-search"></i> <?php echo L('search');?></button>
        <div style="clear: both;"></div>
        </form>
    </div>
<form class="form-horizontal" name="myform" id="myform" action="" method="post">
    <div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr class="heading">
            <th align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('id[]');" />
                        <span></span>
                    </label></th>
            <?php 
            if(is_array($list_field)){
            foreach($list_field as $i=>$t){
            ?>
            <th<?php if($t['width']){?> width="<?php echo $t['width'];?>"<?php }?><?php if($t['center']){?> style="text-align:center"<?php }?> class="<?php echo dr_sorting($i);?>" name="<?php echo $i;?>"><?php echo L($t['name']);?></th>
            <?php }}?>
            <th align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($datas)){
    foreach($datas as $r){
?>   
    <tr>
    <td align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="id[]" value="<?php echo $r['id']?>" />
                        <span></span>
                    </label></td>
    <?php 
    if(is_array($list_field)){
    foreach($list_field as $i=>$tt){
    ?>
    <td<?php if($tt['center']){?> style="text-align:center"<?php }?>><?php echo dr_list_function($tt['func'], $r[$i], $param, $r, $field[$i]);?></td>
    <?php }}?>
    <td align="center"><a href="<?php echo $r['url'];?>" target="_blank" class="layui-btn layui-btn-xs layui-btn-normal"><i class="fa fa-eye"></i> <?php echo L('preview');?></a>
    <a href="javascript:;" onclick="javascript:dr_content_submit('?m=content&c=content&a=edit&catid=<?php echo $r['catid'];?>&id=<?php echo $r['id'];?>','edit')" class="layui-btn layui-btn-xs"><i class="fa fa-edit"></i> <?php echo L('edit');?></a>
    <a href="javascript:view_comment('<?php echo id_encode('content_'.$r['catid'],$r['id'],$this->siteid);?>','<?php echo safe_replace($r['title']);?>')" class="layui-btn layui-btn-xs layui-btn-danger"><i class="fa fa-comment"></i> <?php echo L('comment');?></a></td>
    </tr>
<?php 
    }
}
?>
</tbody>
    </table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" id="delAll" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('delete');?></button></label>
        <label>
            <div class="btn-group dropup">
                <a class="btn blue btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false" href="javascript:;"> <?php echo L('批量操作')?> <i class="fa fa-angle-up"></i>
                </a>
                <ul class="dropdown-menu">
                    <a href="javascript:;" class="dropdown-item" id="remove"><i class="fa fa-arrows"></i> <?php echo L('remove');?></a>
                    <?php if($category['content_ishtml']) {?>
                    <div class="dropdown-line"></div>
                    <a href="javascript:;" class="dropdown-item" id="createhtml"><i class="fa fa-check"></i> <?php echo L('createhtml');?></a>
                    <?php }
                    if($status!=99) {?>
                    <div class="dropdown-line"></div>
                    <a href="javascript:;" class="dropdown-item" id="passed"><i class="fa fa-check"></i> <?php echo L('passed_checked');?></a>
                    <?php }?>
                    <?php if(!$this->input->get('reject')) { ?>
                    <div class="dropdown-line"></div>
                    <a href="javascript:;" class="dropdown-item" id="push"><i class="fa fa-window-restore"></i> <?php echo L('push');?></a>
                    <div class="dropdown-line"></div>
                    <a href="javascript:;" class="dropdown-item" id="copy"><i class="fa fa-files-o"></i> <?php echo L('copy');?></a>
                    <?php }?>
                    <div class="dropdown-line"></div>
                    <a href="javascript:;" class="dropdown-item" id="recycle"><i class="fa fa-trash-o"></i> <?php echo L('in_recycle');?></a>
                    <?php if (module_exists('bdts')) {?>
                    <div class="dropdown-line"></div>
                    <a href="javascript:;" class="dropdown-item" id="bdts"><i class="fa fa-paw"></i> <?php echo L('批量百度主动推送');?></a>
                    <?php }?>
                </ul>
            </div>
        </label>
        <label>
            <?php if(!$this->input->get('reject')) { ?>
            <?php if($workflow_menu) { ?><div style='position:relative;'><button type="button" class="layui-btn layui-btn-danger layui-btn-sm" id="reject_check"><?php echo L('reject');?></button>
            <div id='reject_content' style='background-color: #fff;border:#e7ecf1 solid 1px;position:absolute;z-index:10;left:0px;top:-84px;padding:10px;display:none;'>
            <table cellpadding='0' cellspacing='1' border='0'><tr><tr><td colspan='2'><textarea class="form-control" name='reject_c' id='reject_c' style='width:200px;height:46px;margin-right:10px;' onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;"><?php echo L('reject_msg');?></textarea></td><td><button type="button" class="layui-btn layui-btn-danger layui-btn-sm" id="reject_check1"><?php echo L('submit');?></button></td></tr>
            </table></div></div>
            <?php }}?>
        </label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
<script>
$(function() {
    $('body').on('click','#delAll',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            Dialog.confirm('确认要删除选中的内容吗？', function() {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.ajax({
                    type: 'post',
                    url: '?m=content&c=content&a=delete&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&pc_hash='+pc_hash,
                    data: {ids: ids,dosubmit:1,csrf_test_name:csrf_hash},
                    dataType: 'json',
                    success: function(res) {
                        layer.close(loading);
                        if (res.code==1) {
                            setTimeout("window.location.reload(true)", 2000);
                        }
                        dr_tips(res.code, res.msg);
                    }
                });
            });
        }
    })
    $('body').on('click','#recycle',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            Dialog.confirm('确认要删除选中的内容吗？您可以在回收站恢复！', function() {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.ajax({
                    type: 'post',
                    url: '?m=content&c=content&a=recycle&recycle=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&pc_hash='+pc_hash,
                    data: {ids: ids,dosubmit:1,csrf_test_name:csrf_hash},
                    dataType: 'json',
                    success: function(res) {
                        layer.close(loading);
                        if (res.code==1) {
                            setTimeout("window.location.reload(true)", 2000);
                        }
                        dr_tips(res.code, res.msg);
                    }
                });
            });
        }
    })
    $('body').on('click','#push',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            artdialog('contentpush','?m=content&c=push&action=position_list&catid=<?php echo $catid?>&modelid=<?php echo $modelid?>&id='+ids.toString().replace(new RegExp(",","g"),'|'),'<?php echo L('push');?>：',800,500);
        }
    })
    $('body').on('click','#copy',function() {
        var ids='';
        $("input[name='id[]']:checked").each(function(i, n){
            ids += $(n).val() + ',';
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            artdialog('contentcopy','?m=content&c=copy&a=init&module=content&classname=push_api&action=category_list_copy&tpl=copy_to_category&modelid=<?php echo $modelid?>&catid=<?php echo $catid?>&id='+ids.toString().replace(new RegExp(",","g"),'|'),'<?php echo L('copy');?>：',800,500);
        }
    })
    <?php if (module_exists('bdts')) {?>
    $('body').on('click','#bdts',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.ajax({
                type: 'post',
                url: '?m=bdts&c=bdts&a=add&modelid=<?php echo $modelid;?>&pc_hash='+pc_hash,
                data: {ids: ids,csrf_test_name:csrf_hash},
                dataType: 'json',
                success: function(res) {
                    layer.close(loading);
                    if (res.code==1) {
                        setTimeout("window.location.reload(true)", 2000);
                    }
                    dr_tips(res.code, res.msg);
                }
            });
        }
    })
    <?php }?>
    $('body').on('click','#remove',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            artdialog('contentremove','?m=content&c=content&a=remove&catid=<?php echo $catid?>&ids='+ids,'<?php echo L('remove');?>：',800,500);
        }
    })
    <?php if($category['content_ishtml']) {?>
    $('body').on('click','#createhtml',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.ajax({
                type: 'post',
                url: '?m=content&c=create_html&a=batch_show&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&pc_hash='+pc_hash,
                data: {ids: ids, dosubmit: 1,csrf_test_name:csrf_hash},
                dataType: 'json',
                success:function(json) {
                    layer.close(loading);
                    if (json.code == 1) {
                        layer.open({
                            type:2,
                            title:'生成内容页面',
                            scrollbar:false,
                            resize:true,
                            maxmin:true,
                            shade:0,
                            area:[ "80%", "80%" ],
                            success:function(layero, index) {
                                var body = layer.getChildFrame("body", index);
                                var json = $(body).html();
                                if (json.indexOf('"code":0') > 0 && json.length < 150) {
                                    var obj = JSON.parse(json);
                                    layer.close(loading);
                                    dr_tips(0, obj.msg);
                                }
                            },
                            content:json.data.url,
                            cancel: function(e, t) {
                                var a = layer.getChildFrame("body", e);
                                if ("1" == $(a).find("#dr_check_status").val()) return layer.confirm("关闭后将中断操作，是否确认关闭呢？", {
                                    icon: 3,
                                    shade: 0,
                                    title: "提示",
                                    btn: ["确定", "取消"]
                                }, function(e) {
                                    layer.closeAll()
                                }), !1
                            }
                        });
                    } else {
                        dr_tips(0, json.msg, 90000);
                    }
                    return false;
                },
                error:function(HttpRequest, ajaxOptions, thrownError) {
                    dr_ajax_admin_alert_error(HttpRequest, ajaxOptions, thrownError);
                }
            });
        }
    })
    <?php }?>
    <?php if($workflow_menu) {?>
    $('body').on('click','#reject_check',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            $('#reject_content').toggle();
        }
    })
    $('body').on('click','#reject_check1',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.ajax({
                type: 'post',
                url: '?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&reject=1&pc_hash='+pc_hash,
                data: {ids: ids, reject_c: $('#reject_c').val(),csrf_test_name:csrf_hash},
                dataType: 'json',
                success: function(res) {
                    layer.close(loading);
                    if (res.code==1) {
                        setTimeout("window.location.reload(true)", 2000);
                    }
                    dr_tips(res.code, res.msg);
                }
            });
        }
    })
    <?php }?>
    <?php if($status!=99) {?>
    $('body').on('click','#passed',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.ajax({
                type: 'post',
                url: '?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&pc_hash='+pc_hash,
                data: {ids: ids,csrf_test_name:csrf_hash},
                dataType: 'json',
                success: function(res) {
                    layer.close(loading);
                    if (res.code==1) {
                        setTimeout("window.location.reload(true)", 2000);
                    }
                    dr_tips(res.code, res.msg);
                }
            });
        }
    })
    <?php }?>
});
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
<!--
function view_comment(id, name) {
    var w = 800;
    var h = 500;
    if (is_mobile()) {
        w = h = '100%';
    }
    var diag = new Dialog({
        id:'view_comment',
        title:'<?php echo L('view_comment');?>：'+name,
        url:'<?php echo SELF;?>?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid='+id+'&pc_hash='+pc_hash,
        width:w,
        height:h,
        modal:true
    });
    diag.onCancel=function() {
        $DW.close();
    };
    diag.show();
}
setcookie('refersh_time', 0);
function refersh_window() {
    var refersh_time = getcookie('refersh_time');
    if(refersh_time==1) {
        location.reload(true);
    }
}
setInterval("refersh_window()", 3000);
//-->
</script>
</body>
</html>