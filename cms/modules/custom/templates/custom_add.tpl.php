<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
</style>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.my-sysfield .col-md-2 {width: 100%!important;}
.my-sysfield .control-label {text-align: left!important;margin-bottom: 10px;}
</style>
<div class="page-content main-content">
<form name="myform" id="myform" action="?m=custom&c=custom&a=add" class="form-horizontal" method="post">
<div class="myfbody">
        <div class="row ">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green sbold "></span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="form-body clear">

<div class="form-group">
    <label class="control-label col-md-2"><?php echo L('custom_title')?></label>
    <div class="col-md-10">
        <input type="text" name="custom[title]" id="custom_title" value="" style="width:100%;" class="measure-input">
        <span class="help-block" id="dr_title_tips">（<?php echo L('custom_title_tips')?>）</span>
    </div>
</div>
<div class="form-group" id="dr_row_content">
    <label class="control-label col-md-2"><?php echo L('content');?></label>
    <div class="col-md-10">
        <textarea class="dr_ueditor" name="custom[content]" id="content"></textarea>
        <?php echo form::editor('content',"full");?>
    </div>
</div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
<input type="hidden" name="forward" value="?m=custom&c=custom&a=add">
<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="<?php echo L('submit')?>">
</form>
</div>
</body>
</html> 