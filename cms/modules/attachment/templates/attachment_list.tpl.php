<?php 
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<link href="<?php echo JS_PATH;?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            orientation: "left",
            autoclose: true
        });
    }
});
</script>
<div class="page-content-white page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
    <div class="right-card-box">
        <div class="row table-search-tool">
            <form name="searchform" action="" method="get" >
            <input type="hidden" value="attachment" name="m">
            <input type="hidden" value="manage" name="c">
            <input type="hidden" value="init" name="a">
            <div class="col-md-12 col-sm-12">
                <label><div class="btn-group dropdown-btn-group">
                    <a class="btn blue btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false" href="javascript:;"><i class="fa fa-th-large"></i> <?php echo L('moudle')?> <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <?php $i = 0;
                        foreach ($modules as $module) {
                        if(in_array($module['module'], array('404','bdts','pay','digg','search','scan','attachment','block','dbsource','template','release','cnzz','comment','mood','mobile'))) continue;
                        if (isset($i) && $i) echo '<div class="dropdown-line"></div>';
                        echo '<li><a href='.url_par('module='.$module['module']).' class="dropdown-item"><i class="fa fa-chain"></i> '.$module['name'].'</a></li>';
                        $i++;
                        }?>
                    </ul>
                </div></label>
            </div>
            <?php if ($remote) {?>
            <div class="col-md-12 col-sm-12">
                <label><select name="remote" id="remote" class="form-control">
                    <option value=""> - </option>
                    <?php 
                    if (is_array($remote)) {
                    foreach ($remote as $t) {
                    ?>
                    <option value="<?php echo $t['id'];?>"<?php if ($param['remote']==$t['id']) {?> selected<?php }?>><?php echo $t['name'];?></option>
                    <?php }} ?>
                </select></label>
            </div>
            <?php }?>
            <div class="col-md-12 col-sm-12">
                <label><input class="form-control" name="fileext" id="fileext" value="<?php if(isset($param['fileext'])) echo $param['fileext'];?>" placeholder="<?php echo L('filetype')?>"></label>
                <label><input class="form-control" name="keyword" id="keyword" value="<?php if(isset($param['keyword'])) echo $param['keyword'];?>" placeholder="<?php echo L('name')?>"></label>
            </div>
            <div class="col-md-12 col-sm-12">
                <label>
                    <div class="input-group input-medium date-picker input-daterange" data-date="" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?php echo $param['start_uploadtime'];?>" name="start_uploadtime" id="start_uploadtime">
                        <span class="input-group-addon"> <?php echo L('to')?> </span>
                        <input type="text" class="form-control" value="<?php echo $param['end_uploadtime'];?>" name="end_uploadtime" id="end_uploadtime">
                    </div>
                </label>
            </div>
            <div class="col-md-12 col-sm-12">
                <label><button type="submit" class="btn blue btn-sm onloading"><i class="fa fa-search"></i> <?php echo L('search');?></button></label>
            </div>
            </form>
        </div>
        <form class="form-horizontal" role="form" id="myform">
            <div class="table-list">
                <table width="100%" cellspacing="0">
                    <thead>
                    <tr class="heading">
                        <th class="myselect table-checkable">
                            <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set=".checkboxes" />
                                <span></span>
                            </label>
                        </th>
                        <th style="text-align:center" width="90" class="<?php echo dr_sorting('aid');?>" name="aid"><?php echo L('number');?></th>
                        <th style="text-align:center" width="90" class="<?php echo dr_sorting('remote');?>" name="remote"><?php echo L('类型');?></th>
                        <th width="150" class="<?php echo dr_sorting('module');?>" name="module"><?php echo L('moudle');?></th>
                        <th width="120" class="<?php echo dr_sorting('catid');?>" name="catid"><?php echo L('catname');?></th>
                        <th class="<?php echo dr_sorting('filename');?>" name="filename"><?php echo L('filename');?></th>
                        <th style="text-align:center" width="120" class="<?php echo dr_sorting('fileext');?>" name="fileext"><?php echo L('fileext');?></th>
                        <th width="100" class="<?php echo dr_sorting('filesize');?>" name="filesize"><?php echo L('filesize');?></th>
                        <th width="160" class="<?php echo dr_sorting('uploadtime');?>" name="uploadtime"><?php echo L('uploadtime');?></th>
                        <th><?php echo L('附件归属');?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($array as $t) {?>
                    <tr class="odd gradeX" id="dr_row_<?php echo $t['aid'];?>">
                        <td class="myselect">
                            <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $t['aid'];?>" />
                                <span></span>
                            </label>
                        </td>
                        <td style="text-align:center">
                            <?php echo $t['aid'];?>
                        </td>
                        <td style="text-align:center">
                            <?php echo $t['type'];?>
                        </td>
                        <td><?php echo $t['module'];?></td>
                        <td><?php echo $t['catname'];?></td>
                        <td>
                            <a href="javascript:preview('<?php echo $t['filepath'];?>')"><?php echo $t['filename'];?></a>
                            <a class="btn blue btn-xs" href="javascript:iframe('<?php echo L('改名');?>', '?m=attachment&c=manage&a=public_name_edit&aid=<?php echo $t['aid'];?>', '350px', '220px');"><?php echo L('改名');?></a>
                        </td>
                        <td style="text-align:center"><?php echo $t['fileext'];?></td>
                        <td><?php echo $t['filesize'];?></td>
                        <td><?php echo $t['uploadtime'];?></td>
                        <td><?php echo $t['related'];?></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>

            <div class="row list-footer table-checkable">
                <div class="col-md-5 list-select">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" data-set=".checkboxes" />
                        <span></span>
                    </label>
                    <button type="button" id="delAll" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('delete');?></button>
                    <label>
                        <div class="btn-group dropup">
                            <a class="btn blue btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false" href="javascript:;"><i class="fa fa-files-o"></i> <?php echo L('附件状态')?> <i class="fa fa-angle-up"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo url_par('status=0')?>" class="dropdown-item"><i class="fa fa-chain"></i> <?php echo L('not_used');?></a></li>
                                <div class="dropdown-line"></div>
                                <li><a href="<?php echo url_par('status=1')?>" class="dropdown-item"><i class="fa fa-chain"></i> <?php echo L('used');?></a></li>
                            </ul>
                        </div>
                    </label>
                </div>
                <div class="col-md-7 list-page">
                    <?php echo $pages;?>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<script>
$(function() {
    $('body').on('click','#delAll',function() {
        var ids = [];
        $('input[name="ids[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            Dialog.confirm('<?php echo L('del_confirm')?>', function() {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.ajax({
                    type: 'post',
                    url: '?m=attachment&c=manage&a=public_delete_all',
                    data: {ids: ids},
                    dataType: 'json',
                    success: function(res) {
                        layer.close(loading);
                        if (res.code==1) {
                            setTimeout("window.location.reload(true)", 2000);
                        }
                        dr_tips(res.code, res.msg);
                    }
                });
            });
        }
    })
});
function preview(file) {
    if(IsImg(file)) {
        var width = 400;
        var height = 300;
        var att = 'width: 350px;height: 260px;';
        if (is_mobile()) {
            width = height = '90%';
            var att = 'height: 90%;';
        }
        var diag = new Dialog({
            title:'<?php echo L('preview')?>',
            html:'<style type="text/css">a{text-shadow: none; color: #337ab7; text-decoration:none;}a:hover{cursor: pointer; color: #23527c; text-decoration: underline;}</style><div style="'+att+'line-height: 24px;word-break: break-all;overflow: hidden auto;"><p style="word-break: break-all;text-align: center;margin-bottom: 20px;"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center;"><a href="'+file+'" target="_blank"><img style="max-width:100%" src="'+file+'"></a></p></div>',
            width:width,
            height:height,
            modal:true
        });
        diag.show();
    } else if(IsMp4(file)) {
        var width = 500;
        var height = 320;
        var att = 'width="420" height="238"';
        if (is_mobile()) {
            width = height = '90%';
            var att = 'width="90%" height="200"';
        }
        var diag = new Dialog({
            title:'<?php echo L('preview')?>',
            html:'<style type="text/css">a{text-shadow: none; color: #337ab7; text-decoration:none;}a:hover{cursor: pointer; color: #23527c; text-decoration: underline;}</style><p style="word-break: break-all;text-align: center;margin-bottom: 20px;"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center;"> <video class="video-js vjs-default-skin" controls="true" preload="auto" '+att+'><source src="'+file+'" type="video/mp4"/></video>\n</p>',
            width:width,
            height:height,
            modal:true
        });
        diag.show();
    } else if(IsMp3(file)) {
        var diag = new Dialog({
            title:'<?php echo L('preview')?>',
            html:'<style type="text/css">a{text-shadow: none; color: #337ab7; text-decoration:none;}a:hover{cursor: pointer; color: #23527c; text-decoration: underline;}</style><p style="text-align: center;word-break: break-all;margin-bottom: 20px;"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center;"><audio src="'+file+'" controls="controls"></audio></p>',
            modal:true
        });
        diag.show();
    } else {
        var diag = new Dialog({
            title:'<?php echo L('preview')?>',
            html:'<style type="text/css">a{text-shadow: none; color: #337ab7; text-decoration:none;}a:hover{cursor: pointer; color: #23527c; text-decoration: underline;}</style><p style="text-align: center;word-break: break-all;margin-bottom: 20px;"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center;"><a href="'+file+'" target="_blank"><i class="fa fa-download"></i> <?php echo L('click_open')?></a></p>',
            modal:true
        });
        diag.show();
    }
}

function att_delete(obj,aid){
    Dialog.confirm('<?php echo L('del_confirm')?>', function(){$.get('?m=attachment&c=manage&a=delete&aid='+aid+'&pc_hash='+pc_hash,function(data){if(data == 1) location.reload(true);})});
}

function showthumb(id, name) {
    var width = 500;
    var height = 400;
    if (is_mobile()) {
        width = height = '90%';
    }
    var diag = new Dialog({
        id:'edit',
        title:'<?php echo L('att_thumb_manage')?>--'+name,
        url:'<?php echo SELF;?>?m=attachment&c=manage&a=pullic_showthumbs&aid='+id+'&pc_hash='+pc_hash,
        width:width,
        height:height,
        modal:true
    });
    diag.show();
}
function hoverUse(target){
    if($("#"+target).css("display") == "none"){
        $("#"+target).show();
    }else{
        $("#"+target).hide();
    }
}
function IsImg(url){
    var sTemp;
    var b=false;
    var opt="jpg|gif|png|bmp|jpeg|webp";
    var s=opt.toUpperCase().split("|");
    for (var i=0;i<s.length ;i++ ){
        sTemp=url.substr(url.length-s[i].length-1);
        sTemp=sTemp.toUpperCase();
        s[i]="."+s[i];
        if (s[i]==sTemp){
            b=true;
            break;
        }
    }
    return b;
}
function IsMp4(url){
    var sTemp;
    var b=false;
    var opt="mp4";
    var s=opt.toUpperCase().split("|");
    for (var i=0;i<s.length ;i++ ){
        sTemp=url.substr(url.length-s[i].length-1);
        sTemp=sTemp.toUpperCase();
        s[i]="."+s[i];
        if (s[i]==sTemp){
            b=true;
            break;
        }
    }
    return b;
}
function IsMp3(url){
    var sTemp;
    var b=false;
    var opt="mp3";
    var s=opt.toUpperCase().split("|");
    for (var i=0;i<s.length ;i++ ){
        sTemp=url.substr(url.length-s[i].length-1);
        sTemp=sTemp.toUpperCase();
        s[i]="."+s[i];
        if (s[i]==sTemp){
            b=true;
            break;
        }
    }
    return b;
}
</script>
</body>
</html>