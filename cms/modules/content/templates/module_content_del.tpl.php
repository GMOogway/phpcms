<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.main-content2 {background: #fff!important}
.main-content2 .note.note-danger {background-color: #f5f6f8 !important}
.page-content3 {margin-left:0px !important; border-left: 0  !important;}
.page-content-white .page-bar .page-breadcrumb>li>i.fa-circle {top:0px !important; }
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content main-content2">
                            <div class="page-body" style="padding-top:17px;margin-bottom:30px;">
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