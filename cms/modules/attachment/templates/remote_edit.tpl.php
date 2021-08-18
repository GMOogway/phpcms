<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.note.note-danger {background-color: #fef7f8;border-color: #f0868e;color: #210406;}
.note.note-danger {border-radius: 4px;border-left: 4px solid #f0868e;background-color: #ffffff;color: #888;}
.my-content-top-tool {margin-top: -25px;margin-bottom: 10px;}
.note {margin: 0 0 20px;padding: 15px 30px 15px 15px;border-left: 5px solid #eee;border-radius: 0 4px 4px 0;}
.note, .tabs-right.nav-tabs>li>a:focus, .tabs-right.nav-tabs>li>a:hover {-webkit-border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;-ms-border-radius: 0 4px 4px 0;-o-border-radius: 0 4px 4px 0;}
.note p:last-child {margin-bottom: 0;}
.note p {margin: 0;}
.note p, .page-loading, .panel .panel-body {font-size: 13px;}
.note.note-danger a {color: #666;}
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
</style>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('操作之前请更新下全站缓存');?></a></p>
</div>
<form action="?m=attachment&c=attachment&a=remote_edit&id=<?php echo $data['id']?>&menuid=<?php echo $this->input->get('menuid');?>" class="form-horizontal" method="post" name="myform" id="myform">
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li class="active">
                <a data-toggle="tab_0"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('存储策略').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cloud"></i> <?php if (!is_mobile(0)) {echo L('存储策略');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_0">

                <div class="form-body form">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('名称');?></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control input-large" value="<?php echo htmlspecialchars($data['name']);?>" name="data[name]" />
                            <span class="help-block"><?php echo L('给它一个描述名称');?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('存储类型');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <?php foreach ($this->type as $i=>$n) {?>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="data[type]" onclick="dr_remote('<?php echo $i;?>')" value="<?php echo $i;?>"<?php echo ((int)$data['type']==$i) ? ' checked' : ''?> /> <?php echo L($n['name']);?> <span></span> </label>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group r r0">
                        <label class="col-md-2 control-label"><?php echo L('使用说明');?></label>
                        <div class="col-md-9">
                            <p class="form-control-static"> <?php echo L('本地磁盘存储是将文件存储到本地的一块盘之中');?> </p>
                        </div>
                    </div>
                    <div class="form-group r r0">
                        <label class="col-md-2 control-label"><?php echo L('本地存储路径');?></label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="data[value][0][path]" value="<?php echo htmlspecialchars($data['value']['path']);?>" />
                            <span class="help-block"><?php echo L('填写磁盘绝对路径或者相当于附件目录的目录路径，一定要以“/”结尾');?></span>
                        </div>
                    </div>

                    <?php foreach ($this->load_file as $i=>$tp) {?>
                    <?php include $tp?>
                    <?php }?>

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('附件远程访问URL');?></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['url']);?>" name="data[url]" />
                            <span class="help-block"><?php echo L('浏览器可访问的URL地址，必须以http://或https://开头，要以“/”结尾');?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <button name="dosubmit" type="submit" class="btn green"> <i class="fa fa-save"></i> <?php echo L('保存');?></button>
                <button type="button" onclick="dr_test_attach()" class="btn red"> <i class="fa fa-cloud"></i> <?php echo L('测试');?></button>
            </div>
        </div>
    </div>
</div>
</form>
</div>
<script type="text/javascript">
$(function() {
    dr_remote(<?php echo intval($data['type']);?>);
});
$('.nav-tabs a').click(function (e) {
    $('.nav-tabs').find('li').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(this).parent().addClass('active');
    $('#'+$(this).attr("data-toggle")).addClass('active');
})
function dr_test_attach() {
    var loading = layer.load(2, {
        shade: [0.3,'#fff'], //0.1透明度的白色背景
        time: 10000
    });
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "?m=attachment&c=attachment&a=public_test_attach",
        data: $("#myform").serialize(),
        success: function(json) {
            layer.close(loading);
            dr_tips(json.code, json.msg, -1);
        },
        error: function(HttpRequest, ajaxOptions, thrownError) {
            dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
        }
    });
}
function dr_remote(i) {
    $('.r').hide();
    $('.r'+i).show();
}
</script>
</body>
</html>