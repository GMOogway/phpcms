<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
                            <div class="page-body" style="padding-top:0px;margin-bottom:30px;">
<div class="note note-danger">
    <p><a href="javascript:dr_update_cache_all();"><?php echo L('更改系统配置之后需要重新生成一次缓存文件');?></a></p>
</div>

<div class="right-card-box">
    <div class="table-scrollable">

        <table class="table table-fc-upload table-striped table-bordered table-hover table-checkable dataTable">
            <thead>
            <tr class="heading">
                <th width="55"> </th>
                <th width="350"> <?php echo L('更新项目');?> </th>
                <th> </th>
            </tr>
            </thead>
            <tbody>
            <?php 
            if(is_array($list)){
            foreach($list as $id => $t){
            ?>  
            <tr>
                <td>
                    <span class="badge badge-success"> <?php echo $id+1;?> </span>
                </td>
                <td>
                    <?php echo L($t['name']);?>
                </td>
                <td style="overflow:auto">
                    <label>
                        <a href="javascript:;" onclick="my_update_cache('<?php echo $id;?>', '<?php echo $t['function'];?>', '<?php echo $t['mod'];?>', '<?php echo $t['file'];?>', '<?php echo $t['param'];?>');" class="btn red btn-xs"><i class="fa fa-refresh"></i> <?php echo L('立即更新');?> </a>
                    </label>
                    <label id="dr_<?php echo $id;?>_result" >

                    </label>
                </td>
            </tr>
            <?php }}?>

            </tbody>
        </table>
    </div>
</div>
<script>
function dr_update_cache_all() {
    $('.btn-xs').trigger('click');
}
function my_update_cache(id, m, mod, file, param) {
    var obj = $('#dr_'+id+'_result');
    obj.html("<img style='height:17px' src='<?php echo JS_PATH;?>layer/theme/default/loading-0.gif' />");

    if (m == 'attachment') {
        my_update_attachment(id, 0);
    } else {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "?m=admin&c=cache_all&a=public_cache&id="+m+"&mod="+mod+"&file="+file+"&param="+param,
            success: function (json) {
                if (json.code == 0) {
                    obj.html('<font color="red">'+json.msg+'</font>');
                } else {
                    obj.html('<font color="green">'+json.msg+'</font>');
                }
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                obj.html('<a href="javascript:dr_show_file_code(\'<?php echo L('查看日志');?>\', \'?m=admin&c=index&a=public_error_log&menuid=249&pc_hash=<?php echo dr_get_csrf_token()?>\');" style="color:red"><?php echo L("系统崩溃，请将错误日志发送给官方处理");?></a>');
            }
        });
    }


}
function my_update_attachment(id, page) {
    var obj = $('#dr_'+id+'_result');
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "?m=admin&c=cache_all&a=public_cache&id=attachment&page="+page,
        success: function (json) {
            if (json.code == 0) {
                obj.html('<font color="red">'+json.msg+'</font>');

            } else {
                if (json.data == 0) {
                    obj.html('<font color="green">'+json.msg+'</font>');
                } else {
                    my_update_attachment(id, json.data);
                    obj.html('<font color="blue">'+json.msg+'</font>');
                }
            }
        },
        error: function(HttpRequest, ajaxOptions, thrownError) {
            obj.html('<a href="javascript:dr_show_file_code(\'<?php echo L('查看日志');?>\', \'?m=admin&c=index&a=public_error_log&menuid=249&pc_hash=<?php echo dr_get_csrf_token()?>\');" style="color:red"><?php echo L("系统崩溃，请将错误日志发送给官方处理");?></a>');
        }
    });
}
</script>
</div>
</div>
</div>
</div>
</body>
</html>