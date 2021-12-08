<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<link href="<?php echo JS_PATH?>bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>bootstrap-switch/js/bootstrap-switch.min.js"></script>
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
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('更改数据之后需要更新缓存之后才能生效');?></a></p>
</div>
<form action="?m=bdts&c=bdts&a=config&menuid=<?php echo $this->input->get('menuid');?>" class="form-horizontal" method="post" name="myform" id="myform">
<input name="dosubmit" type="hidden" value="1">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('bdts_bdts').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('bdts_bdts');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('接口地址');?>：</label>
                        <div class="col-md-9">
                            <a href="https://ziyuan.baidu.com/linksubmit/index" target="_blank" class="btn yellow"><?php echo L('申请接口');?></a>
                        </div>
                    </div>
                    <?php foreach((array)$sitemodel_data as $t){?>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo $t['name'];?>：</label>
                        <div class="col-md-9">
                            <input type="checkbox" name="data[use][]" value="<?php echo $t['tablename'];?>" <?php if ($data['use'] && in_array($t['tablename'], $data['use'])) {echo ' checked';}?> data-on-text="<?php echo L('open')?>" data-off-text="<?php echo L('close')?>" data-on-color="success" data-off-color="danger" class="make-switch" data-size="small">
                        </div>
                    </div>
                    <?php }?>
                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-9">
                            <a href="javascript:add_menu();" class="btn blue"><i class="fa fa-plus"></i> <?php echo L('添加域名');?></a>
                        </div>
                    </div>
                    <div id="menu_body">
                        <?php foreach((array)$bdts as $t){?>
                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-9">
                                <label><input class="form-control" type="text" name="data[bdts][][site]" placeholder="<?php echo L('站点域名');?>" value="<?php echo $t['site'];?>"></label>
                                <label><input class="form-control" type="text" name="data[bdts][][token]" value="<?php echo $t['token'];?>" placeholder="<?php echo L('密钥token');?>"></label>
                                <label><a href="javascript:;" onClick="remove_menu(this)" class="btn red"><i class="fa fa-trash"></i> <?php echo L('删除');?></a></label>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('接口说明');?>：</label>
                        <div class="col-md-9">
                            <?php echo L('链接提交工具是网站主动向百度搜索推送数据的工具，本工具可缩短爬虫发现网站链接时间，网站时效性内容建议使用链接提交工具，实时向搜索推送数据。本工具可加快爬虫抓取速度，无法解决网站内容是否收录问题。');?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <button type="button" id="my_submit" onclick="dr_ajax_submit('?m=bdts&c=bdts&a=config&menuid=<?php echo $this->input->get('menuid');?>&page='+$('#dr_page').val(), 'myform', '2000')" class="btn green"> <i class="fa fa-save"></i> <?php echo L('the_save')?></button>
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
$(function() {
	$(".make-switch").bootstrapSwitch();
});
function add_menu() {
    var data = '<div class="form-group"><label class="col-md-2 control-label">&nbsp;</label><div class="col-md-8"><label><input class="form-control " type="text" name="data[bdts][][site]" placeholder="<?php echo L('站点域名');?>" value=""></label>&nbsp;<label><input class="form-control input-large" type="text" name="data[bdts][][token]" placeholder="<?php echo L('密钥token');?>"></label><label>&nbsp;<a href="javascript:;" onClick="remove_menu(this)" class="btn red"><i class="fa fa-trash"></i> <?php echo L('删除');?></a></label></div></div>';
    $('#menu_body').append(data);
}
function remove_menu(_this) {
    $(_this).parent().parent().parent().remove()
}
</script>
</body>
</html>