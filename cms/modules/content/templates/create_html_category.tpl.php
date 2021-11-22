<?php
defined('IN_ADMIN') or exit('No permission resources.');
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
<div class="note note-danger">
    <p><?php echo L('确保网站目录必须有可写权限');?></p>
</div>
<div class="portlet bordered light form-horizontal">
    <div class="portlet-body">
        <div class="form-body">

            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo L('网站首页');?></label>
                <div class="col-md-9">
                    <label><button type="button" onclick="dr_admin_menu_ajax('?m=content&c=create_html&a=public_index_ajax', 1)" class="btn blue"> <i class="fa fa-file-o"></i> <?php echo L('生成首页静态文件');?> </button></label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo L('快捷配置');?></label>
                <div class="col-md-9">
                    <label><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);" class="btn default"> <?php echo L('一键更新栏目URL');?> </a></label>
                </div>
            </div>

            <form id="myform_category">
                <input type="hidden" name="dosubmit" value="1">
                <div class="form-group" style="border-top: 1px dashed #eef1f5; padding-top: 10px;">
                    <label class="col-md-2 control-label"><?php echo L('每轮更新几条信息');?></label>
                    <div class="col-md-9">
                        <label><input type="text" class="form-control" value="10" name="pagesize"></label>
                        <span class="help-block"><?php echo L('每轮更新几条信息');?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('最大分页限制');?></label>
                    <div class="col-md-9">
                        <label><input type="text" class="form-control" value="" name="maxsize"></label>

                        <span class="help-block"><?php echo L('当栏目页数过多时，设置此数量可以生成指定的页数，后面页数就不会再生成');?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('按所选栏目');?></label>
                    <div class="col-md-9">
                        <select class="bs-select form-control" name='catids[]' id='catids' multiple="multiple" style="width:350px;height:280px;" title="<?php echo L('push_ctrl_to_select');?>">
                            <option value='0' selected><?php echo L('no_limit_category');?></option>
                            <?php echo $string;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('生成栏目页面');?></label>
                    <div class="col-md-9">
                        <label><button type="button" onclick="dr_bfb('<?php echo L('生成栏目页面');?>', 'myform_category', '?m=content&c=create_html&a=category')" class="btn dark"> <i class="fa fa-th-large"></i> <?php echo L('开始生成静态');?> </button></label>
                        <label><button type="button" onclick="dr_bfb('<?php echo L('生成栏目页面');?>', 'myform_category', '?m=content&c=create_html&a=public_category_point')" class="btn red"> <i class="fa fa-th-large"></i> <?php echo L('上次未执行完毕时继续执行');?> </button></label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>