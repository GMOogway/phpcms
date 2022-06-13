<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script type="text/javascript">var bs_selectAllText = '全选';var bs_deselectAllText = '全删';var bs_noneSelectedText = '没有选择'; var bs_noneResultsText = '没有找到 {0}';</script>
<link href="<?php echo JS_PATH?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH?>bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script type="text/javascript">jQuery(document).ready(function(){$('.bs-select').selectpicker();});</script>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content main-content2">
                            <div class="page-body" style="margin-top:20px;margin-bottom:30px;">
<form id="myform" class="form-horizontal" style="padding: 0 30px;">

    <div class="form-body">
        <div class="form-group">
            <select class="bs-select form-control" name='catid[]' id='catid' multiple="multiple" style="height:200px;">
            <option value='0'><?php echo L('全部栏目');?></option>
            <?php echo $string;?>
            </select>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-6" style="text-align:left">
                    <div class="form-group" style="margin-bottom:5px">
                        <label> <?php echo L('替换范围')?> </label>
                    </div>
                    <div class="form-group">
                        <div class="mt-radio-inline">
                            <label class="mt-radio">
                                <input type="radio" name="thumb"  value="1" checked=""> <?php echo L('只替换空图')?>
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="thumb" value="0"> <?php echo L('替换全部')?>
                                <span></span>
                            </label>
                        </div>

                    </div>
                </div>
                <div class="col-md-6" style="text-align:right;padding-top:25px">
                    <button type="button" onclick="dr_content_submit_todo()" class="btn blue"> <i class="fa fa-photo"></i> <?php echo L('立即执行')?></button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</div>
</div>
</div>
<script>
    function dr_content_submit_todo() {
        window.location.href = '<?php echo $todo_url;?>&'+$('#myform').serialize()
    }
</script>
</body>
</html>