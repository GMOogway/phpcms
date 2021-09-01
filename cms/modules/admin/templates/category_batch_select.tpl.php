<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link href="<?php echo CSS_PATH?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">var bs_selectAllText = '全选';var bs_deselectAllText = '全删';var bs_noneSelectedText = '没有选择'; var bs_noneResultsText = '没有找到 {0}';</script>
<link href="<?php echo JS_PATH?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH?>bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script type="text/javascript">jQuery(document).ready(function(){$('.bs-select').selectpicker();});</script>
<style type="text/css">
.dropdown::after {opacity: 0!important;}
:not(.input-group)>.bootstrap-select.form-control:not([class*=col-]) {width: auto;}
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
    <p><a href="?m=admin&c=category&a=init&menuid=<?php echo $this->input->get('menuid');?>"><?php echo L('category_manage');?></a></p>
</div>
<form action="?m=admin&c=category&a=batch_edit" class="form-horizontal" method="post" name="myform" id="myform">
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li class="active">
                <a data-toggle="tab_0"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('category_batch_edit').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-edit"></i> <?php if (!is_mobile(0)) {echo L('category_batch_edit');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_0">
                <div class="form-body">

                    <div class="form-group row">
                        <label class="col-md-2 control-label"> <?php echo L('category_batch_edit');?> </label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="type" value="0" <?php if($type==0) echo 'checked';?>> <?php echo L('category_batch_edit');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="type" value="1" <?php if($type==1) echo 'checked';?>> <?php echo L('category_type_page');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label"><?php echo L('from_where','','content');?></label>
                        <div class="col-md-9">
                            <label><select name='catids[]' id='catids' class="form-control bs-select" data-title="<?php echo L('from_category','','content');?>" multiple="multiple" data-actions-box="true">
                            <?php echo $string;?>
                            </select></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <input type="hidden" value="<?php echo $type;?>">
                <button name="submit" type="submit" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit');?></button>
            </div>
        </div>
    </div>
</div>
</form>
</div>
<script language="JavaScript">
<!--
function addedit(url, name) {
	artdialog('content_id',url,name,'80%','80%');
}
window.top.$('#display_center_id').css('display','none');
//-->
</script>