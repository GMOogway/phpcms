<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content main-content2">
                            <div class="page-body" style="margin-top:20px;margin-bottom:30px;">
<form id="myform" class="form-horizontal" style="padding: 0 30px;">

    <div class="form-body">

        <div class="form-group">
            <select class="bs-select form-control" name='catid[]' id='catid' multiple="multiple" style="height:200px;" title="<?php echo L('push_ctrl_to_select');?>">
            <option value='0' selected><?php echo L('no_limit_category');?></option>
            <?php echo $string;?>
            </select>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-3" style="text-align:left">
                    <div class="form-group" style="margin-bottom:5px">
                        <label> <?php echo L('提取字数')?> </label>
                    </div>
                    <div class="form-group">
                        <label><input type="text" name="nums" value="100" class="form-control"></label>
                    </div>
                </div>
                <div class="col-md-6" style="text-align:left">
                    <div class="form-group" style="margin-bottom:5px">
                        <label> <?php echo L('提取范围')?> </label>
                    </div>
                    <div class="form-group">
                        <div class="mt-radio-inline">
                            <label class="mt-radio">
                                <input type="radio" name="keyword"  value="1" checked=""> <?php echo L('只提取空描述的内容')?>
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="keyword" value="0"> <?php echo L('重新提取全部内容')?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="text-align:center;padding-top:20px">
                    <button type="button" onclick="dr_content_submit_todo()" class="btn blue"> <i class="fa fa-tag"></i> <?php echo L('立即执行')?></button>
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