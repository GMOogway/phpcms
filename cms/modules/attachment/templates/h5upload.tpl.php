<?php $show_header = $show_validator = $show_scroll = true; include $this->admin_tpl('header', 'attachment');?>
<script src="<?php echo JS_PATH?>assets/ds.min.js"></script>
<link href="<?php echo JS_PATH?>h5upload/h5upload.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo JS_PATH?>layui/css/layui.css" media="all" />
<script type="text/javascript" src="<?php echo JS_PATH?>layui/layui.js"></script>
<script type="text/javascript">
<?php echo initupload($this->input->get('module'),$this->input->get('catid'),$args,$this->userid,$this->groupid,$this->isadmin)?>
</script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $(":text").removeClass('input-text');
});
</script>
<div class="page-content main-content">
<form action="" class="form-horizontal" method="post" name="myform" id="myform">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('upload_attachment').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-upload"></i> <?php if (!is_mobile(0)) {echo L('upload_attachment');}?> </a>
            </li>
            <li<?php if ($page==1) {?> class="active"<?php }?>>
                <a data-toggle="tab_1" onclick="$('#dr_page').val('1')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('net_file').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-download"></i> <?php if (!is_mobile(0)) {echo L('net_file');}?> </a>
            </li>
            <?php if($allowupload && $this->admin_username && $_SESSION['userid']) {?>
            <li<?php if ($page==2) {?> class="active"<?php }?>>
                <a data-toggle="tab_2" onclick="$('#dr_page').val('2');"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('gallery').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-photo"></i> <?php if (!is_mobile(0)) {echo L('gallery');}?> </a>
            </li>
            <li<?php if ($page==3) {?> class="active"<?php }?>>
                <a data-toggle="tab_3" onclick="$('#dr_page').val('3');"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('directory_browse').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-folder-open"></i> <?php if (!is_mobile(0)) {echo L('directory_browse');}?> </a>
            </li>
            <?php }?>
            <?php if($att_not_used!='') {?>
            <li<?php if ($page==4) {?> class="active"<?php }?>>
                <a data-toggle="tab_4" onclick="$('#dr_page').val('4');"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('att_not_used').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-ban"></i> <?php if (!is_mobile(0)) {echo L('att_not_used');}?> </a>
            </li>
            <?php }?>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div>
                        <div id="queue"></div>
                        <button type="button" class="layui-btn" id="file_upload"><i class="layui-icon">&#xe67c;</i><?php echo L('select_file')?></button>
                        <div id="nameTip" class="onShow"><?php echo L('upload_up_to')?><font color="red"> <?php echo $file_upload_limit?></font> <?php echo L('attachments')?>,<?php echo L('largest')?> <font color="red"><?php echo $file_size_limit;?> MB</font></div>
                        <div class="bk3"></div>
                        <div class="lh24"><?php echo L('supported')?> <font style="font-family: Arial, Helvetica, sans-serif"><?php echo str_replace('|','、',$file_types_post)?></font> <?php echo L('formats')?></div>
                        <div id="progress" class="fileupload-progress fade" style="display:none">
                            <div class="layui-progress layui-progress-big progress progress-striped active" lay-showpercent="yes" lay-filter="progress">
                                <div class="layui-progress-bar progress-bar progress-bar-success" lay-percent=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="bk10"></div>
                    <fieldset class="blue pad-10" id="h5upload">
                        <legend><?php echo L('lists')?></legend>
                        <div id="fsUploadProgress"></div>
                        <div class="files" id="fsUpload"></div>
                    </fieldset>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==1) {?> active<?php }?>" id="tab_1">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('enter_address')?></label>
                        <div class="col-md-9">
                            <input type="text" id="dr_filename" name="info[filename]" class="form-control" value="" onblur="addonlinefile(this)">
                            <span class="help-block"><?php echo L('当目标文件过大或者对方服务器拒绝下载时会导致下载失败')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-9">
                            <label><button type="button" onclick="dr_download('filename');" class="btn green btn-sm"> <i class="fa fa-download"></i> <?php echo L('下载文件')?></button></label>
                        </div>
                    </div>

                </div>
            </div>
            <?php if($allowupload && $this->admin_username && $_SESSION['userid']) {?>
            <div class="tab-pane<?php if ($page==2) {?> active<?php }?>" id="tab_2">
                <div class="form-body">

                    <ul class="attachment-list">
                        <iframe name="album-list" src="<?php echo SELF;?>?m=attachment&c=attachments&a=album_load&args=<?php echo $args?>&authkey=<?php echo $authkey;?>" frameborder="false" scrolling="auto" style="overflow-x:hidden;border:none" width="100%" height="380" allowtransparency="true" id="album_list"></iframe>
                    </ul>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==3) {?> active<?php }?>" id="tab_3">
                <div class="form-body">

                    <ul class="attachment-list">
                        <iframe name="album-dir" src="<?php echo SELF;?>?m=attachment&c=attachments&a=album_dir&args=<?php echo $args?>&authkey=<?php echo $authkey;?>" frameborder="false" scrolling="auto" style="overflow-x:hidden;border:none" width="100%" height="380" allowtransparency="true" id="album_dir"></iframe>
                    </ul>

                </div>
            </div>
            <?php }?>
            <?php if($att_not_used!='') {?>
            <div class="tab-pane<?php if ($page==4) {?> active<?php }?>" id="tab_4">
                <div class="form-body">

                    <ul class="attachment-list">
                        <iframe name="att-not" src="<?php echo SELF;?>?m=attachment&c=attachments&a=att_not&args=<?php echo $args?>&authkey=<?php echo $authkey;?>" frameborder="false" scrolling="auto" style="overflow-x:hidden;border:none" width="100%" height="380" allowtransparency="true" id="att_not"></iframe>
                    </ul>

                </div>
            </div>
            <?php }?>
            <div id="att-status" class="hidden"></div>
            <div id="att-status-del" class="hidden"></div>
            <div id="att-name" class="hidden"></div>
        </div>
    </div>
</div>
</form>
</div>
<script>
$('.nav-tabs a').click(function (e) {
    $('.nav-tabs').find('li').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(this).parent().addClass('active');
    $('#'+$(this).attr("data-toggle")).addClass('active');
})
function addonlinefile(obj) {
    var strs = $(obj).val() ? '|'+ $(obj).val() :'';
    $('#att-status').html(strs);
}
function dr_download(obj) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '<?php echo SELF;?>?m=attachment&c=attachments&a=download',
        data: {module:'<?php echo $this->input->get('module');?>',catid:'<?php echo $this->input->get('catid');?>',args:'<?php echo $args;?>',authkey:'<?php echo $authkey;?>',filename:$('#dr_'+obj).val()},
        success: function(json) {
            if (json.code) {
                dr_tips(json.code, json.msg);
                $('#dr_'+obj).val(json.info.url);
                var strs = json.info.url ? '|'+ json.info.url : '';
                $('#att-status').html(strs);
            } else {
                dr_tips(json.code, json.msg);
            }
        },
        error: function(HttpRequest, ajaxOptions, thrownError) {
            dr_ajax_admin_alert_error(HttpRequest, ajaxOptions, thrownError)
        }
    });
}
</script>
</body>
</html>