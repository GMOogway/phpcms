<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="page-content main-content">
<form name="myform" id="myform" action="?m=custom&c=custom&a=edit&id=<?php echo $id; ?>" class="form-horizontal" method="post">
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
        <input type="text" name="custom[title]" id="custom_title" value="<?php echo $title;?>" style="width:100%;" class="measure-input">
        <span class="help-block" id="dr_title_tips">（<?php echo L('custom_title_tips')?>）</span>
    </div>
</div>
<div class="form-group" id="dr_row_content">
    <label class="control-label col-md-2"><?php echo L('content');?></label>
    <div class="col-md-10">
        <textarea class="dr_ueditor" name="custom[content]" id="content"><?php echo $content;?></textarea>
        <?php echo form::editor('content',"full");?>
    </div>
</div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
<input type="hidden" name="forward" value="?m=custom&c=custom&a=edit&id=<?php echo $id; ?>">
<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="<?php echo L('submit')?>">
</form>
</div>
</body>
</html> 