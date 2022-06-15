<?php
defined('IS_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');?>
<link href="<?php echo JS_PATH;?>codemirror/lib/codemirror.css" rel="stylesheet" type="text/css" />
<link href="<?php echo JS_PATH;?>codemirror/theme/neat.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>codemirror/lib/codemirror.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>codemirror/mode/javascript/javascript.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>codemirror/mode/xml/xml.js" type="text/javascript"></script>
<style type="text/css">
html{_overflow:hidden}
.frmaa{float:left;width:80%; min-width: 870px; _width:870px;}
.rraa{float: right; width:230px;}
.pt{margin-top: 4px;}
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<form action="" class="form-horizontal" method="post" name="myform" id="myform">
<div class="portlet light bordered myfbody">
    <div class="portlet-body form">

        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">文件路径</label>
                <div class="col-md-10">
                    <p class="form-control-static">/cms/templates/<?php echo $this->style?>/<?php echo $dir?>/<?php echo $file?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">文件别名</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="cname" name="cname" value="<?php echo htmlspecialchars($cname)?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2"></label>
                <div class="col-md-10">
                    <div class="col-md-10">
                        <textarea name="file_code" id="file_code"><?php echo $data?></textarea>
                        <div class="bk10"></div>
                        标题截取：从20个字符开始到100个字符：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{str_cut($r[\'title\'], \'20,100\', \'...\')}')" value="{str_cut($r['title'], '20,100', '...')}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/>前100字符：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{str_cut($r[\'title\'], \'100\', \'...\')}')" value="{str_cut($r['title'], '100', '...')}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        标题样式：随机颜色关闭：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{title_style($r[\'style\'])}')" value="{title_style($r['style'])}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/>随机颜色开启：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{title_style($r[\'style\'], 1)}')" value="{title_style($r['style'], 1)}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        时间格式：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{wordtime($r[\'inputtime\'])}')" value="{wordtime($r['inputtime'])}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/>显示：刚刚、几秒前、几分钟前、几小时前、几天前、几星期前、几个月前、几年前<br />
                        时间格式：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{formatdate($r[\'inputtime\'])}')" value="{formatdate($r['inputtime'])}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/>显示：刚刚、几秒前、几分钟前、几小时前、几天前、几星期前、几个月前、几年前<br />
                        时间格式：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{mtime($r[\'inputtime\'])}')" value="{mtime($r['inputtime'])}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/>显示：今天08:00、昨天08:00、前天08:00<br />
                        时间格式：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{mdate($r[\'inputtime\'])}')" value="{mdate($r['inputtime'])}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/>显示：刚刚、几分钟前、几小时前<br />
                        时间格式：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{timediff(date(\'Y-m-d H:i:s\',$r[\'inputtime\']),date(\'Y-m-d H:i:s\'))}')" value="{timediff(date('Y-m-d H:i:s',$r['inputtime']),date('Y-m-d H:i:s'))}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/>显示：1天1小时1分钟1秒<br />
                        友好的时间：<input type="button" class="btn blue btn-sm pt" onClick="javascript:insertText('{dr_fdate($r[\'inputtime\'])}')" value="{dr_fdate($r['inputtime'], 'Y-m-d')}" title="<?php echo L('友好的时间')?>"/><br />
                        <div class="bk10"></div>
                        <div id="html_result"></div>
                        <?php if ($is_write==0){echo '<font color="red">'.L("file_does_not_writable").'</font>';}?>
                    </div>
                    <div class="col-md-2">
                        <h3 class="f14"><?php echo L('common_variables')?></h3>
                        <div class="bk10"></div>
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{CSS_PATH}')" value="{CSS_PATH}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{JS_PATH}')" value="{JS_PATH}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{IMG_PATH}')" value="{IMG_PATH}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{APP_PATH}')" value="{APP_PATH}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{get_siteid()}')" value="{get_siteid()}" onmouseover="layer.tips('<?php echo L('获取站点ID')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{loop $data $n $r}')" value="{loop $data $n $r}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{$r[\'url\']}')" value="{$r['url']}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{$r[\'title\']}')" value="{$r['title']}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{$r[\'thumb\']}')" value="{$r['thumb']}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('{clearhtml($r[\'description\'])}')" value="{clearhtml($r['description'])}" onmouseover="layer.tips('<?php echo L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                        <?php if (is_array($file_t_v[$file_t])) { foreach($file_t_v[$file_t] as $k => $v) {?>
                         <input type="button" class="btn yellow btn-sm pt" onClick="javascript:insertText('<?php echo $k?>')" value="<?php echo str_replace('\\', '', $k)?>" onmouseover="layer.tips('<?php echo $v ? $v :L('click_into')?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/><br />
                         <?php } }?>
                    </div>
                </div>
            </div>

        </div>
        <div class="portlet-body form myfooter">
            <div class="form-actions text-center">
                <?php if (module_exists('tag')) {?><label><button type="button" onClick="create_tag()" class="btn blue"> <i class="fa fa-plus"></i> <?php echo L('create_tag')?></button></label>
                <label><button type="button" onClick="select_tag()" class="btn dark"> <i class="fa fa-code"></i> <?php echo L('select_tag')?></button></label>
                <?php }?>
                <label><button type="button" id="my_submit" class="btn green"> <i class="fa fa-save"></i> <?php echo L('submit')?></button></label>
                <label><button type="button" onclick="location.href='?m=template&c=file&a=init&style=<?php echo $this->style?>&dir=<?php echo $dir?>&pc_hash=<?php echo dr_get_csrf_token();?>'" class="btn yellow"> <i class="fa fa-mail-reply-all"></i> <?php echo L('returns_list_style')?></button></label>
            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>
</div>
<script type="text/javascript">
var myTextArea = document.getElementById('file_code');
var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
    lineNumbers: true,
    matchBrackets: true,
    styleActiveLine: true,
    theme: "neat",
    mode: 'javascript'
});
jQuery(document).ready(function() {
    $('#my_submit').click(function () {

        url = '?m=template&c=file&a=edit_file&style=<?php echo $this->style?>&dir=<?php echo $dir?>&file=<?php echo $file?>';

        var loading = layer.load(2, {
            shade: [0.3,'#fff'], //0.1透明度的白色背景
            time: 1000
        });

        $("#html_result").html(' ... ');

        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: {cname:$("#cname").val(), code: myCodeMirror.getValue(), pc_hash: pc_hash<?php if(SYS_CSRF) { ?>, csrf_test_name: csrf_hash<?php } ?>},
            success: function(json) {
                layer.close(loading);
                if (json.code == 1) {
                    dr_tips(1, json.msg);
                    setTimeout("window.location.reload(true)", 2000)
                } else {
                    dr_tips(0, '<?php echo L('模板语法解析错误')?>');
                    $("#html_result").html('<div class="alert alert-danger">'+json.msg+'</div>');
                }
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                dr_ajax_alert_error(HttpRequest, this, thrownError);;
            }
        });
    });
});
function create_tag() {
    artdialog('add','?m=tag&c=tag&a=add&ac=js',"<?php echo L('create_tag')?>",700,500);
}

function insertText(text) {
    myCodeMirror.replaceSelection(text);
}

function select_tag() {
    omnipotent('list','?m=tag&c=tag&a=lists',"<?php echo L('tag_list')?>",1,700,500);
}
</script>
</body>
</html>