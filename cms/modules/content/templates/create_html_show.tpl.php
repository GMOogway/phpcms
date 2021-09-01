<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<link href="<?php echo JS_PATH;?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo JS_PATH;?>bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
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
            <form id="myform_category_show">
                <input type="hidden" name="dosubmit" value="1">
                <div class="form-group ">
                    <label class="col-md-2 control-label"><?php echo L('according_model');?></label>
                    <div class="col-md-9">
                        <label>
                        <?php $models = getcache('model','commons');
                        $model_datas = array();
                        foreach($models as $_k=>$_v) {
                            if($_v['siteid']!=$this->siteid) continue;
                            $model_datas[$_v['modelid']] = $_v['name'];
                        }
                        echo form::select($model_datas,$modelid,'name="modelid" onchange="change_model(this.value)"');
                        ?></label>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-md-2 control-label"><?php echo L('每页生成数量');?></label>
                    <div class="col-md-9">
                        <label><input type="text" placeholder="<?php echo L('建议不要太多');?>" class="form-control" value="10" name="pagesize"></label>
                        <span class="help-block">请与模板调用数量相同</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('last_information');?></label>
                    <div class="col-md-9">
                        <label><input type="text" placeholder="<?php echo L('last_information').'几'.L('information_items');?>" class="form-control" value="" name="number"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('按内容ID范围');?></label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group input-daterange">
                                <input type="text" placeholder="<?php echo L('按ID开始');?>" class="form-control" value="" name="fromid">
                                <span class="input-group-addon"> <?php echo L('到');?> </span>
                                <input type="text" placeholder="<?php echo L('按ID结束');?>" class="form-control" value="" name="toid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('按发布时间范围');?></label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group input-daterange">
                                <input type="text" placeholder="<?php echo L('按发布时间范围');?>" class="form-control" value="" name="fromdate" id="fromdate">
                                <script type="text/javascript">
                                $(function(){
                                    $("#fromdate").datepicker({
                                        isRTL: false,
                                        format: "yyyy-mm-dd",
                                        showMeridian: true,
                                        autoclose: true,
                                        pickerPosition: "bottom-right",
                                        todayBtn: "linked"
                                    });
                                });
                                </script>
                                <span class="input-group-addon"> <?php echo L('到');?> </span>
                                <input type="text" placeholder="<?php echo L('按发布时间范围');?>" class="form-control" value="" name="todate" id="todate">
                                <script type="text/javascript">
                                $(function(){
                                    $("#todate").datepicker({
                                        isRTL: false,
                                        format: "yyyy-mm-dd",
                                        showMeridian: true,
                                        autoclose: true,
                                        pickerPosition: "bottom-right",
                                        todayBtn: "linked"
                                    });
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('按所选栏目');?></label>
                    <div class="col-md-9">
                        <select class="bs-select form-control" name='catids[]' id='catids' multiple="multiple" style="width:350px;height:260px;" title="<?php echo L('push_ctrl_to_select');?>">
                            <option value='0' selected><?php echo L('no_limit_category');?></option>
                            <?php echo $string;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo L('生成内容页面');?></label>
                    <div class="col-md-9">
                        <label><button type="button" onclick="dr_bfb('<?php echo L('生成内容页面');?>', 'myform_category_show', '?m=content&c=create_html&a=show')" class="btn dark"> <i class="fa fa-th-large"></i> <?php echo L('开始生成静态');?> </button></label>
                        <label><button type="button" onclick="dr_bfb('<?php echo L('生成内容页面');?>', 'myform_category_show', '?m=content&c=create_html&a=public_show_point')" class="btn red"> <i class="fa fa-th-large"></i> <?php echo L('上次未执行完毕时继续执行');?> </button></label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script language="javascript">
function change_model(modelid) {
    window.location.href='?m=content&c=create_html&a=show&modelid='+modelid+'&pc_hash='+pc_hash;
}
</script>
</body>
</html>