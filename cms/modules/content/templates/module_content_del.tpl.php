<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content main-content2">
                            <div class="page-body" style="margin-top:20px;margin-bottom:30px;">
<form id="myform" class="form-horizontal" style="padding: 0 30px; margin-top: -20px">
    <div class="form-body">
        <div class="form-group">
            <select class="bs-select form-control" name='catid[]' id='catid' multiple="multiple" style="height:200px;" title="<?php echo L('push_ctrl_to_select');?>">
            <option value='0' selected><?php echo L('no_limit_category');?></option>
            <?php echo $string;?>
            </select>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom:5px">
                        <label> <?php echo L('按管理员账号或按管理员uid')?> </label>
                    </div>
                    <div class="form-group">
                        <label><input type="text" name="author" class="form-control"></label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group" style="margin-bottom:5px">
                        <label> <?php echo L('按id范围')?> </label>
                    </div>
                    <div class="form-group">
                        <label><input type="text" name="id1" class="form-control"></label>
                        <label><?php echo L('到')?></label>
                        <label><input type="text" name="id2" class="form-control"></label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" style="margin-bottom:5px">
                        <label> <?php echo L('自定义条件')?> </label>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" style="height:100px" name="sql"></textarea>
                        <p style="padding-top:9px;" class="help-block"> <?php echo L('支持自定义条件的SQL语句')?> </p>
                    </div>
                </div>
                <div class="col-md-12" style="text-align:center;padding-top:20px">
                    <button type="button" onclick="dr_content_submit_todo()" class="btn red"> <i class="fa fa-trash"></i> <?php echo L('立即执行')?></button>
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