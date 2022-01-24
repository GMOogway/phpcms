<?php
defined('IS_ADMIN') or exit('No permission resources.');
$show_validator = true;include $this->admin_tpl('header');?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#dr_rolename").formValidator({onshow:"<?php echo L('input').L('role_name')?>",onfocus:"<?php echo L('role_name').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('role_name').L('not_empty')?>"});
})
//-->
</script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $(":text").removeClass('input-text');
});
</script>
<div class="page-content main-content">
<form action="?m=admin&c=role&a=edit" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<input name="menuid" type="hidden" value="<?php echo $this->input->get('menuid');?>">
<input type="hidden" name="roleid" value="<?php echo $roleid?>"></input>
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('角色').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('角色');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group" id="dr_row_rolename">
                        <label class="col-md-2 control-label"><?php echo L('role_name')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="dr_rolename" name="info[rolename]" value="<?php echo $rolename?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('role_description')?></label>
                        <div class="col-md-9">
                            <textarea name="info[description]" id="description" class="form-control" style="height:100px;"><?php echo $description?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('enabled')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="info[disabled]" value="0" <?php echo (!$disabled)?' checked':''?>> <?php echo L('enable')?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="info[disabled]" value="1" <?php echo ($disabled)?' checked':''?>><?php echo L('ban')?><span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('listorder')?></label>
                        <div class="col-md-9">
                            <input class="form-control input-large" type="text" id="listorder" name="info[listorder]" value="<?php echo $listorder?>" >
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <button type="button" onclick="dr_ajax_submit('?m=admin&c=role&a=edit&page='+$('#dr_page').val(), 'myform', '2000')" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit')?></button>
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
</script>
</body>
</html>