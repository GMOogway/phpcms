<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<?php echo load_css(JS_PATH.'layui/css/layui.css');?>
<?php echo load_js(JS_PATH.'content_addtop.js');?>
<?php echo load_css(JS_PATH.'jquery-minicolors/jquery.minicolors.css');?>
<?php echo load_js(JS_PATH.'jquery-minicolors/jquery.minicolors.min.js');?>
<script type="text/javascript">var catid=<?php echo $catid;?></script>
<div class="page-content-white page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li> <a href="javascript:location.reload(true);" class="on"> <?php echo L('page_manage');?></a> <i class="fa fa-circle"></i> </li>
        <li> <a href="<?php if(strpos($category['url'],'http://')===false && strpos($category['url'],'https://') ===false) echo siteurl($this->siteid);echo $category['url'];?>" target="_blank"> <i class="fa fa-home"></i> <?php echo L('click_vistor');?></a> <i class="fa fa-circle"></i> </li>
        <li> <a href="?m=block&c=block_admin&a=public_visualization&catid=<?php echo $catid;?>&type=page"> <i class="fa fa-code"></i> <?php echo L('visualization_edit');?></a> </li>
    </ul>
</div>
<form name="myform" id="myform" action="?m=content&c=content&a=add" class="form-horizontal" method="post" enctype="multipart/form-data">
<input type="hidden" name="dosubmit" value="1" />
<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
<input type="hidden" name="edit" value="<?php echo $title ? 1 : 0;?>" />
<input type="hidden" name="info[updatetime]" value="<?php echo dr_date($updatetime, 'Y-m-d H:i:s');?>" />
<div class="myfbody" style="margin-top: 20px;padding-top:15px;">
        <div class="row ">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-blue sbold"></span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="form-body">
<?php
if(is_array($forminfos['base'])) {
 foreach($forminfos['base'] as $field=>$info) {
     if($info['isomnipotent']) continue;
     if($info['formtype']=='omnipotent') {
        foreach($forminfos['base'] as $_fm=>$_fm_value) {
            if($_fm_value['isomnipotent']) {
                $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
            }
        }
        foreach($forminfos['senior'] as $_fm=>$_fm_value) {
            if($_fm_value['isomnipotent']) {
                $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
            }
        }
    }
 ?>
<div class="form-group" id="dr_row_<?php echo $field?>">
    <label class="control-label col-md-2"><?php if($info['star']){ ?><span class="required" aria-required="true"> * </span><?php } ?><?php echo $info['name']?></label>
    <div class="col-md-10">
        <?php echo $info['form']?>
        <span class="help-block" id="dr_<?php echo $field?>_tips"><?php echo $info['tips']?></span>
    </div>
</div>
<?php
} }
?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="portlet-body form myfooter">
        <div class="form-actions text-center">
            <label><button type="button" id="my_submit" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit');?></button></label>
        </div>
    </div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#my_submit').click(function () {
        url = '?m=content&c=content&a=add';
        var loading = layer.load(2, {
            shade: [0.3,'#fff'], //0.1透明度的白色背景
            time: 1000
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: $("#myform").serialize(),
            success: function(json) {
                layer.close(loading);
                if (json.code) {
                    dr_tips(1, json.msg);
                    setTimeout("window.location.reload(true)", 2000)
                } else {
                    dr_tips(0, json.msg);
                    if (json.data.field) {
                        $('#dr_row_'+json.data.field).addClass('has-error');
                        $('#'+json.data.field).focus();
                    }
                }
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
            }
        });
    });
});
</script>
</div>
</div>
</body>
</html>