<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">var bs_selectAllText = '全选';var bs_deselectAllText = '全删';var bs_noneSelectedText = '没有选择'; var bs_noneResultsText = '没有找到 {0}';</script>
<link href="<?php echo JS_PATH?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH?>bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script type="text/javascript">jQuery(document).ready(function(){$('.bs-select').selectpicker();});</script>
<div class="page-content main-content">
<form action="?m=content&c=content&a=remove" class="form-horizontal" method="post" name="myform" id="myform">
<div class="portlet light bordered myfbody">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li class="active">
                <a data-toggle="tab_0"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('remove').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-arrows"></i> <?php if (!is_mobile(0)) {echo L('remove');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_0">
                <div class="form-body">

                    <div class="form-group row">
                        <label class="col-md-2 control-label"> <?php echo L('from_where');?> </label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="type" value="0" checked id="fromtype_1" onclick="if(this.checked){$('#frombox_1').show();$('#frombox_2').hide();}"> <?php echo L('从指定ID');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="type" value="1" id="fromtype_2" onclick="if(this.checked){$('#frombox_1').hide();$('#frombox_2').show();}"> <?php echo L('从指定栏目');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="frombox_1" style="display:;">
                        <label class="col-md-2 control-label"> <?php echo L('从指定ID');?> </label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="ids" style="height:80px;"><?php echo $ids;?></textarea>
                            <span class="help-block"><?php echo L('move_tips')?></span>
                        </div>
                    </div>
                    <div class="form-group row" id="frombox_2" style="display:none;">
                        <label class="col-md-2 control-label"> <?php echo L('从指定栏目');?> </label>
                        <div class="col-md-9">
                            <label><select name="fromid[]" id="fromid" class="form-control bs-select" data-title="<?php echo L('from_category');?>" multiple="multiple" data-actions-box="true">
                                <option value='0' style="background:#F1F3F5;color:blue;"><?php echo L('from_category');?></option>
                                <?php echo $source_string;?>
                            </select></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label"><?php echo L('move_to_categorys');?></label>
                        <div class="col-md-9">
                            <label><select name="tocatid" id="tocatid" class="form-control bs-select" data-title="<?php echo L('move_to_categorys');?>">
                                <option value='0' style="background:#F1F3F5;color:blue;"><?php echo L('move_to_categorys');?></option>
                                <?php echo $string;?>
                            </select></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <input type="submit" class="dialog" id="dosubmit" value="<?php echo L('submit');?>" name="dosubmit"/>
            </div>
        </div>
    </div>
</div>
</form>
</div>
</body>
</html>