<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script type="text/javascript">
jQuery(document).ready(function() {
    $(":text").removeClass('input-text');
});
</script>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=category&a=public_cache&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('update_cache_all');?></a></p>
</div>
<div class="portlet bordered light form-horizontal">
    <div class="portlet-body">
        <div class="form-body">

            <form action="?m=admin&c=category&a=public_batch_category" class="form-horizontal" method="post" name="myform" id="myform">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('ismenu')?></label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='info[ismenu]' value='1' checked> <?php echo L('yes');?> <span></span></label>
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='info[ismenu]' value='0'  > <?php echo L('no');?> <span></span></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('可用')?></label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[disabled]' value='0' checked> <?php echo L('可用');?> <span></span></label>
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[disabled]' value='1'  > <?php echo L('禁用');?> <span></span></label>
                        </div>
                        <span class="help-block"><?php echo L('禁用状态下此栏目不能正常访问')?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('您现在的位置')?></label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[iscatpos]' value='1' checked> <?php echo L('display');?> <span></span></label>
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[iscatpos]' value='0'  > <?php echo L('hidden');?> <span></span></label>
                        </div>
                        <span class="help-block"><?php echo L('前端栏目面包屑导航调用不会显示，但可以正常访问，您现在的位置不显示')?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('左侧')?></label>
                    <div class="col-md-9">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[isleft]' value='1' checked> <?php echo L('display');?> <span></span></label>
                            <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[isleft]' value='0'> <?php echo L('hidden');?> <span></span></label>
                        </div>
                        <span class="help-block"><?php echo L('前端栏目调用左侧不会显示，但可以正常访问')?></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>