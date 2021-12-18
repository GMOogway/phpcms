<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div id="closeParentTime" style="display:none"></div>
<script type="text/javascript">
<!--
/*$(function(){
    window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.treemain.location = '?m=content&c=content&a=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>';
})
if(window.top.$("#current_pos").data('clicknum')==1) {
    parent.document.getElementById('display_center_id').style.display='';
    parent.document.getElementById('center_frame').src = '?m=content&c=content&a=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>';
    window.top.$("#current_pos").data('clicknum',0);
}
$(document).ready(function(){
    setInterval(closeParent,3000);
});
function closeParent() {
    if($('#closeParentTime').html() == '') {
        window.top.$(".left_menu").addClass("left_menu_on");
        window.top.$("#openClose").addClass("close");
        window.top.$("html").addClass("on");
        $('#closeParentTime').html('1');
        window.top.$("#openClose").data('clicknum',1);
    }
}*/
//-->
</script>
<?php if (SYS_EDITOR) {?>
<script type="text/javascript" src="<?php echo JS_PATH;?>ckeditor/ckeditor.js"></script>
<?php } else {?>
<script type="text/javascript" src="<?php echo JS_PATH;?>ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>ueditor/ueditor.all.js"></script>
<?php }?>
<script type="text/javascript" src="<?php echo JS_PATH;?>h5upload/h5editor.js"></script>
<?php define('EDITOR_INIT', 1);
define('IMAGES_INIT', 1);?>
<link rel="stylesheet" href="<?php echo JS_PATH?>layui/css/layui.css" media="all" />
<div class="page-content main-content">
<div class="row my-content-top-tool">
    <div class="col-md-12 col-sm-12">
        <label style="margin-right:10px"><a href="javascript:location.reload(true);" class="btn green"> <?php echo L('page_manage');?></a></label>
        <label style="margin-right:10px"><a href="<?php if(strpos($category['url'],'http://')===false && strpos($category['url'],'https://') ===false) echo siteurl($this->siteid);echo $category['url'];?>" target="_blank" class="btn red"> <i class="fa fa-home"></i> <?php echo L('click_vistor');?></a></label>
        <label style="margin-right:10px"><a href="?m=block&c=block_admin&a=public_visualization&catid=<?php echo $catid;?>&type=page" class="btn blue"> <i class="fa fa-code"></i> <?php echo L('visualization_edit');?></a></label>
    </div>
</div>
<form name="myform" id="myform" action="?m=content&c=content&a=add" class="form-horizontal" method="post" enctype="multipart/form-data">
<input type="hidden" name="dosubmit" value="1" />
<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
<input type="hidden" name="edit" value="<?php echo $title ? 1 : 0;?>" />
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
<div class="form-group" id="dr_row_title">
    <label class="control-label col-md-2"><?php echo L('title');?></label>
    <div class="col-md-10">
        <input type="text" style="width:400px;<?php echo ($style_color ? 'color:'.$style_color.';' : '').($style_font_weight ? 'font-weight:'.$style_font_weight.';' : '');?>" name="info[title]" id="title" value="<?php echo $title?>" style="color:<?php echo $style;?>" class="measure-input " onBlur="$.post('<?php echo WEB_PATH;?>api.php?op=get_keywords&sid='+Math.random()*5, {data:$('#title').val()}, function(data){if(data && $('#keywords').val()=='') {$('#keywords').val(data); $('#keywords').tagsinput('add', data);}})"/>
        <input type="hidden" name="style_font_weight" id="style_font_weight" value="<?php echo $style_font_weight;?>">
        <input type="hidden" name="style_color" id="style_color" value="<?php echo $style_color;?>">
        <script type="text/javascript">$(function(){$("#style_color").minicolors({control:$("#style_color").attr("data-control")||"hue",defaultValue:$("#style_color").attr("data-defaultValue")||"",inline:"true"===$("#style_color").attr("data-inline"),letterCase:$("#style_color").attr("data-letterCase")||"lowercase",opacity:$("#style_color").attr("data-opacity"),position:$("#style_color").attr("data-position")||"bottom left",change:function(t,o){t&&(o&&(t+=", "+o),"object"==typeof console&&console.log(t));$("#title").css("color",$("#style_color").val())},theme:"bootstrap"})});</script>
        <a href="javascript:;" onclick="set_title_color('');$('.minicolors-swatch-color').css('background','');"><?php echo L('清空');?></a>
        <img src="statics/images/icon/bold.png" width="10" height="10" onclick="input_font_bold()" style="cursor:hand"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2"><?php echo L('keywords');?></label>
    <div class="col-md-10">
        <input type="text" name="info[keywords]" id="keywords" value="<?php echo $keywords?>" size="50" style='width:400px' data-role='tagsinput'>
        <span class="help-block" id="dr_keywords_tips"><?php echo L('explode_keywords');?></span>
    </div>
</div>
<div class="form-group" id="dr_row_content">
    <label class="control-label col-md-2"><?php echo L('content');?></label>
    <div class="col-md-10">
        <textarea class="dr_ueditor" name="info[content]" id="content"><?php echo $content?></textarea>
        <?php echo form::editor('content','full','','',$catid,'',1,1);?>
    </div>
</div>
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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<link href="<?php echo JS_PATH?>jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH?>jquery-minicolors/jquery.minicolors.min.js"></script>
<script type="text/javascript">
$('body').keydown(function(e){
    if (e.keyCode == 13) {
        $('#my_submit').trigger('click');
    }
})
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
</body>
</html>