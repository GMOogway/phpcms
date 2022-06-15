<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script type="text/javascript">
jQuery(document).ready(function() {
    $(":text").removeClass('input-text');
});
</script>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="note note-danger">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=category&a=public_cache&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('update_cache_all');?></a></p>
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
</div>
</div>
</body>
</html>