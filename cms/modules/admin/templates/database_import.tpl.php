<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.portlet.light>.portlet-title {padding: 0;color: #181C32;font-weight: 500;}
.portlet.bordered>.portlet-title {border-bottom: 0;}
.portlet>.portlet-title {padding: 0;margin-bottom: 2px;-webkit-border-radius: 4px 4px 0 0;-moz-border-radius: 4px 4px 0 0;-ms-border-radius: 4px 4px 0 0;-o-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;}
.portlet>.portlet-title>.caption {float: left;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;}
.portlet.light>.portlet-title>.caption.caption-md>.caption-subject, .portlet.light>.portlet-title>.caption>.caption-subject {font-size: 15px;}
.font-dark {color: #2f353b!important;}
@media (max-width:480px) {select[multiple],select[size]{width:100% !important;}}
</style>
<div class="page-content main-content">
<div class="note note-danger">
    <p>
        <a href="javascript:;" class="btn green btn-backup"><i class="fa fa-compress"></i> 立即备份</a>
        <span class="text-danger">如果你的数据过大，不建议采用此方式进行备份，会导致内存溢出的错误。</span>
    </p>
</div>
<form action="" class="form-horizontal" method="post" name="myform" id="myform">
    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr class="heading">
                <th width="120"> <?php echo L('ID');?></th>
                <th width="300"> <?php echo L('backup_file_name');?></th>
                <th width="120"> <?php echo L('backup_file_size');?></th>
                <th width="180"> <?php echo L('backup_file_time');?></th>
                <th> <?php echo L('database_op');?> </th>
            </tr>
            </thead>
            <tbody>
            <?php 
            if(is_array($infos)){
            foreach($infos as $i => $info){
            ?>   
            <tr class="odd gradeX">

                <td><?php echo $i+1;?></td>
                <td><?php echo $info['file'];?></td>
                <td><?php echo $info['size'];?></td>
                <td><?php echo $info['date'];?></td>
                <td>
                    <label><a href="javascript:;" class="btn btn-xs dark btn-restore" data-file="<?php echo $info['file'];?>"><i class="fa fa-reply"></i> <?php echo L('还原');?></a></label>
                    <label><a href="javascript:;" class="btn btn-xs red btn-delete" data-file="<?php echo $info['file'];?>"><i class="fa fa-trash"></i> <?php echo L('删除');?></a></label>
                </td>
            </tr>
            <?php 
            }
            }
            ?>
            </tbody>
        </table>
    </div>
</form>
</div>
<script type="text/javascript">
$(function() {
    $(document).on("click", ".btn-backup", function () {
        // 延迟加载
        var loading = layer.load(2, {
            shade: [0.3,'#fff'], //0.1透明度的白色背景
            time: 5000
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '?m=admin&c=database&a=import&pc_hash='+pc_hash,
            data: {action: 'backup'},
            success: function(json) {
                if (json.code == 1) {
                    layer.close(loading);
                    dr_tips(1, json.msg);
                    setTimeout("window.location.reload(true)", 2000);
                } else {
                    dr_tips(0, json.msg);
                }
                return false;
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
            }
        });
    });
    $(document).on("click", ".btn-restore", function () {
        var that = this;
        layer.confirm("确定恢复备份？<br><font color='red'>建议先备份当前数据后再进行恢复操作！！！</font><br><font color='red'>当前数据库将被清空覆盖，请谨慎操作！！！</font>", {
            type: 5,
            shade: 0,
            title: '提示',
            btn: ['确定', '取消'],
            skin: 'layui-layer-dialog layui-layer-fast'
        }, function (index) {
            // 延迟加载
            var loading = layer.load(2, {
                shade: [0.3,'#fff'], //0.1透明度的白色背景
                time: 100000000
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '?m=admin&c=database&a=import&pc_hash='+pc_hash,
                data: {action: 'restore', file: $(that).data('file')},
                success: function(json) {
                    if (json.code == 1) {
                        layer.close(loading);
                        layer.confirm("确定要刷新整个后台吗？", {
                            icon: 3,
                            shade: 0,
                            title: '提示',
                            btn: ['确定', '取消']
                        }, function(index) {
                            layer.close(index);
                            parent.location.href = '<?php echo SELF;?>';
                        }, function(index) {
                            layer.close(index);
                            window.location.reload(true);
                        });
                        return false;
                    } else {
                        dr_tips(0, json.msg);
                    }
                    return false;
                },
                error: function(HttpRequest, ajaxOptions, thrownError) {
                    dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
                }
            });
        });
    });
    $(document).on("click", ".btn-delete", function () {
        var that = this;
        layer.confirm('确定删除备份？',{
            icon: 3,
            shade: 0,
            title: '提示',
            btn: ['确定', '取消']
        }, function(index){
            layer.close(index);
            var loading = layer.load(2, {
                shade: [0.3,'#fff'], //0.1透明度的白色背景
                time: 5000
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '?m=admin&c=database&a=import&pc_hash='+pc_hash,
                data: {action: 'delete', file: $(that).data('file')},
                success: function(json) {
                    layer.close(loading);
                    if (json.code == 1) {
                        layer.close(loading);
                        dr_tips(1, json.msg);
                        setTimeout("window.location.reload(true)", 2000);
                    } else {
                        dr_tips(0, json.msg);
                    }
                    return false;
                },
                error: function(HttpRequest, ajaxOptions, thrownError) {
                    dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
                }
            });
        });
    });
});
</script>
</body>
</html>