<?php 
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo JS_PATH;?>layui/css/layui.css" media="all" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>admin/css/global.css" media="all" />
<link href="<?php echo JS_PATH;?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            format: "yyyy-mm-dd",
            orientation: "left",
            autoclose: true
        });
    }
});
</script>
<style type="text/css">
.btn-group {margin-left: 10px;}
</style>
<script type="text/javascript" src="<?php echo JS_PATH;?>layui/layui.js"></script>
<div class="admin-main layui-anim layui-anim-upbit">
    <div class="note note-danger my-content-top-tool">
        <?php if ($remote) {?>
        <label><select name="remote" id="remote" class="form-control">
            <option value=""> - </option>
            <?php 
            if (is_array($remote)) {
            foreach ($remote as $t) {
            ?>
            <option value="<?php echo $t['id'];?>"<?php if ($this->input->get('remote')==$t['id']) {?> selected<?php }?>><?php echo $t['name'];?></option>
            <?php }} ?>
        </select></label>
        <?php }?>
        <label><input class="form-control" name="fileext" id="fileext" <?php if(isset($fileext)) echo $fileext;?> placeholder="<?php echo L('filetype')?>"></label>
        <label><input class="form-control" name="keyword" id="keyword" <?php if(isset($keyword)) echo $keyword;?> placeholder="<?php echo L('name')?>"></label>
        <label><div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $this->input->get('start_uploadtime');?>" name="start_uploadtime" id="start_uploadtime">
                <span class="input-group-addon"> <?php echo L('to')?> </span>
                <input type="text" class="form-control" value="<?php echo $this->input->get('end_uploadtime');?>" name="end_uploadtime" id="end_uploadtime">
            </div>
        </div></label>
        <label><button class="btn blue btn-sm onloading" id="search" data-type="reload"><i class="fa fa-search"></i> <?php echo L('search');?></button></label>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<script type="text/html" id="action">
    <a href="javascript:preview('{{d.filepath}}')" class="layui-btn layui-btn-xs layui-btn-normal"><i class="fa fa-eye"></i> <?php echo L('preview');?></a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete"><i class="fa fa-trash-o"></i> <?php echo L('delete')?></a>
</script>
<script type="text/html" id="topBtn">
    <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" id="delAll"><i class="fa fa-trash-o"></i> <?php echo L('thorough');?><?php echo L('delete');?></button>
    <div class="btn-group dropdown-btn-group">
        <button type="button" class="btn blue btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-th-large"></i> <?php echo L('moudle')?> <i class="fa fa-angle-down"></i></button>
        <ul class="dropdown-menu">
            <?php $i = 0;
            foreach ($modules as $module) {
            if(in_array($module['module'], array('pay','digg','search','scan','attachment','block','dbsource','template','release','cnzz','comment','mood'))) continue;
            if (isset($i) && $i) echo '<div class="dropdown-line"></div>';
            echo '<li><a href='.url_par('module='.$module['module']).' class="dropdown-item" id="link"><i class="fa fa-chain"></i> '.$module['name'].'</a></li>';
            $i++;
            }?>
        </ul>
    </div>
    <div class="btn-group dropdown-btn-group">
        <button type="button" class="btn blue btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-files-o"></i> <?php echo L('附件状态')?> <i class="fa fa-angle-down"></i></button>
        <ul class="dropdown-menu">
            <li><a href="<?php echo url_par('status=0')?>" class="dropdown-item"><i class="fa fa-chain"></i> <?php echo L('not_used');?></a></li>
            <div class="dropdown-line"></div>
            <li><a href="<?php echo url_par('status=1')?>" class="dropdown-item"><i class="fa fa-chain"></i> <?php echo L('used');?></a></li>
        </ul>
    </div>
</script>
<script>
layui.use(['table'], function(){
    var table = layui.table, $ = layui.jquery;
    var tableIn = table.render({
        id: 'content',
        elem: '#list',
        url:'?m=attachment&c=manage&a=init&module=<?php echo $this->input->get('module');?>&status=<?php echo $this->input->get('status');?>&pc_hash='+pc_hash,
        method: 'post',
        where: {csrf_test_name:csrf_hash},
        toolbar: '#topBtn',
        cellMinWidth: 80,
        page: true,
        cols: [[
            {type: "checkbox", fixed: 'left'},
            {field: 'aid', title: '<?php echo L('number');?>', width: 80, sort: true},
            {field: 'type', title: '<?php echo L('类型');?>', width: 80, align: 'center', sort: true},
            {field: 'module', title: '<?php echo L('moudle');?>', width:120, sort: true},
            {field: 'catname', title: '<?php echo L('catname');?>', width:120, sort: true},
            {field: 'filename', title: '<?php echo L('filename');?>', minWidth:200, sort: true, edit: 'text'},
            {field: 'fileext', title: '<?php echo L('fileext');?>', width:120, align: 'center', sort: true},
            {field: 'related', title: '<?php echo L('附件归属');?>', width:180},
            {field: 'filesize', title: '<?php echo L('filesize');?>', width:120, sort: true},
            {field: 'uploadtime', title: '<?php echo L('uploadtime');?>', width:180, sort: true},
            {width: 160, align: 'center', toolbar: '#action',title:'<?php echo L('operations_manage');?>'<?php if(!is_mobile(0)) {?>, fixed: 'right'<?php }?>}
        ]],
        limit: 10
    });
    //搜索
    $('#search').on('click', function () {
        var remote = $('#remote').val();
        var keyword = $('#keyword').val();
        var start_uploadtime = $('#start_uploadtime').val();
        var end_uploadtime = $('#end_uploadtime').val();
        var fileext = $('#fileext').val();
        /*if ($.trim(keyword) === '') {
            layer.msg('请输入<?php echo L('name')?>！', {icon: 0});
            return;
        }*/
        tableIn.reload({ page: {page: 1}, where: {remote: remote,keyword: keyword,start_uploadtime: start_uploadtime,end_uploadtime: end_uploadtime,fileext: fileext} });
    });
    //监听单元格编辑
    table.on('edit(list)',function(obj) {
        var value = obj.value, data = obj.data, field = obj.field;
        if (field=='filename' && value=='') {
            layer.tips('<?php echo L('attachment_name_not')?>',this,{tips: [1, '#fff']});
            return false;
        }else{
            $.ajax({
                type: 'post',
                url: '?m=attachment&c=manage&a=update&pc_hash='+pc_hash,
                data: {aid:data.aid,field:field,value:value,dosubmit:1},
                dataType: 'json',
                success: function(res) {
                    if (res.code == 1) {
                        layer.msg(res.msg, {time: 1000, icon: 1}, function () {
                            tableIn.reload();
                        });
                    }else{
                        dr_tips(0, res.msg);
                    }
                }
            });
        }
    });
    table.on('tool(list)', function(obj) {
        var data = obj.data;
        if(obj.event === 'delete'){
            Dialog.confirm('<?php echo L('del_confirm')?>', function() {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.ajax({
                    type: 'post',
                    url: '?m=attachment&c=manage&a=delete&pc_hash='+pc_hash,
                    data: {aid:data.aid},
                    dataType: 'json',
                    success: function(res) {
                        layer.close(loading);
                        if (res.code==1) {
                            layer.msg(res.msg,{icon: 1, time: 1000},function(){
                                tableIn.reload();
                            });
                        }else{
                            dr_tips(0, res.msg);
                        }
                    }
                });
            });
        }
    });
    $('body').on('click','#delAll',function() {
        var checkStatus = table.checkStatus('content'); //content即为参数id设定的值
        var ids = [];
        $(checkStatus.data).each(function (i, o) {
            ids.push(o.aid);
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
                            layer.msg(res.msg,{icon: 1, time: 1000},function(){
                                tableIn.reload();
                            });
                        }else{
                            dr_tips(0, res.msg);
                        }
                    }
                });
            });
        }
    })
});
</script>
</body>
</html>
<script type="text/javascript">
<!--
window.top.$('#display_center_id').css('display','none');
function preview(file) {
    if(IsImg(file)) {
        var width = 400;
        var height = 300;
        var att = 'height: 260px;';
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
            html:'<style type="text/css">a{text-shadow: none; color: #337ab7; text-decoration:none;}a:hover{cursor: pointer; color: #23527c; text-decoration: underline;}</style><p style="text-align: center;word-break: break-all;margin-bottom: 20px;"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center;"><a href="'+file+'" target="_blank"><img src="<?php echo IMG_PATH?>admin_img/down.gif"><?php echo L('click_open')?></a></p>',
            modal:true
        });
        diag.show();
    }
}

function att_delete(obj,aid){
    Dialog.confirm('<?php echo L('del_confirm')?>', function(){$.get('?m=attachment&c=manage&a=delete&aid='+aid+'&pc_hash='+pc_hash,function(data){if(data == 1) location.reload(true);})});
}

function showthumb(id, name) {
    var diag = new Dialog({
        id:'edit',
        title:'<?php echo L('att_thumb_manage')?>--'+name,
        url:'<?php echo SELF;?>?m=attachment&c=manage&a=pullic_showthumbs&aid='+id+'&pc_hash='+pc_hash,
        width:500,
        height:400,
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
//-->
</script>