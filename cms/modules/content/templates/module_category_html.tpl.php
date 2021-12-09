<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<script type="text/javascript">
$(function(){
    $(":text").removeClass('input-text');
})
</script>
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.portlet.light>.portlet-title {padding: 0;color: #181C32;font-weight: 500;}
.portlet.bordered>.portlet-title {border-bottom: 0;}
.portlet>.portlet-title {padding: 0;margin-bottom: 2px;-webkit-border-radius: 4px 4px 0 0;-moz-border-radius: 4px 4px 0 0;-ms-border-radius: 4px 4px 0 0;-o-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;}
.portlet>.portlet-title>.caption {float: left;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;}
.portlet.light>.portlet-title>.caption.caption-md>.caption-subject, .portlet.light>.portlet-title>.caption>.caption-subject {font-size: 15px;}
.font-dark {color: #2f353b!important;}
@media (max-width:480px) {select[multiple],select[size]{width:100% !important;}}
</style>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=category&a=public_cache&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('更改数据之后需要更新缓存之后才能生效');?></a></p>
</div>
<div class="portlet bordered light form-horizontal">
    <div class="portlet-body">
        <div class="form-body">

            <form action="?m=content&c=create_html&a=public_batch_category" class="form-horizontal" method="post" name="myform" id="myform">
                <div class="form-group">
                    <label class="col-md-2 control-label">栏目生成Html</label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[ishtml]' value='1'  onClick="$('#category_php_ruleid').css('display','none');$('#category_html_ruleid').css('display','');$('#tr_domain').css('display','');"> 是 <span></span></label>
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[ishtml]' value='0' checked  onClick="$('#category_php_ruleid').css('display','');$('#category_html_ruleid').css('display','none');$('#tr_domain').css('display','none');"> 否 <span></span></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">内容页生成Html</label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[content_ishtml]' value='1'  onClick="$('#show_php_ruleid').css('display','none');$('#show_html_ruleid').css('display','')"> 是 <span></span></label>
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[content_ishtml]' value='0' checked  onClick="$('#show_php_ruleid').css('display','');$('#show_html_ruleid').css('display','none')"> 否 <span></span></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">栏目页URL规则</label>
                    <div class="col-md-9">
                        <label id="category_php_ruleid"><?php echo form::urlrule('content','category',0,'','name="category_php_ruleid"');?></label>
                        <label id="category_html_ruleid" style="display:none"><?php echo form::urlrule('content','category',1,'','name="category_html_ruleid"');?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">内容页URL规则</label>
                    <div class="col-md-9">
                        <label id="show_php_ruleid"><?php echo form::urlrule('content','show',0,'','name="show_php_ruleid"');?></label>
                        <label id="show_html_ruleid" style="display:none"><?php echo form::urlrule('content','show',1,'','name="show_html_ruleid"');?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">&nbsp;</label>
                    <div class="col-md-9">
                        <label><button type="button" onclick="dr_ajax_submit('?m=content&c=create_html&a=public_batch_category', 'myform', '2000')" class="btn green"> <i class="fa fa-save"></i> 保存</button></label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>