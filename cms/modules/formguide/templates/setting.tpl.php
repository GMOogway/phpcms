<?php
defined('IS_ADMIN') or exit('No permission resources.');
$show_header = true;
include $this->admin_tpl('header', 'admin');?>
<div class="page-content main-content">
<form action="?m=formguide&c=formguide&a=setting" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('module_setting').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('module_setting');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('allows_more_ip');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[allowmultisubmit]" value="1"<?php if($allowmultisubmit) {?> checked<?php }?>> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[allowmultisubmit]" value="0"<?php if(!$allowmultisubmit) {?> checked<?php }?>> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="setting"<?php if ($allowmultisubmit == 0) {?> style="display:none;"<?php }?>>
                        <label class="col-md-2 control-label"><?php echo L('interval');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="interval" name="setting[interval]" value="<?php echo $interval?>"></label>
                            <span class="help-block"><?php echo L('minute')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('allowunreg');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[allowunreg]" value="1"<?php if($allowunreg) {?> checked<?php }?>> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[allowunreg]" value="0"<?php if(!$allowunreg) {?> checked<?php }?>> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('code');?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[code]" value="1"<?php if($code) {?> checked<?php }?>> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[code]" value="0"<?php if(!$code) {?> checked<?php }?>> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="codelen"<?php if ($code == 0) {?> style="display:none;"<?php }?>>
                        <label class="col-md-2 control-label"><?php echo L('codelen');?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="codelen" name="setting[codelen]" value="<?php echo $codelen;?>"></label>
                            <span class="help-block"><?php echo L('multiple_with_commas')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('mailmessage');?></label>
                        <div class="col-md-9">
                            <textarea id="mailmessage" name="setting[mailmessage]" style="height:100px"><?php echo $mailmessage?></textarea>
                            <span class="help-block"><?php echo L('setting_message')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('smsmessage');?></label>
                        <div class="col-md-9">
                            <textarea id="smsmessage" name="setting[smsmessage]" style="height:100px"><?php echo $smsmessage?></textarea>
                            <span class="help-block"><?php echo L('setting_message')?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="dialog">
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

$("input:radio[name='setting[allowmultisubmit]']").click(function (){
	if($("input:radio[name='setting[allowmultisubmit]']:checked").val()==0) {
		$("#setting").hide();
	} else if($("input:radio[name='setting[allowmultisubmit]']:checked").val()==1) {
		$("#setting").show();
	}
});
$("input:radio[name='setting[code]']").click(function (){
	if($("input:radio[name='setting[code]']:checked").val()==0) {
		$("#codelen").hide();
	} else if($("input:radio[name='setting[code]']:checked").val()==1) {
		$("#codelen").show();
	}
});
</script>
</body>
</html>