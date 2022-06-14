<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script>
function dr_tree_data(catid) {
    var index = layer.load(2, {
        shade: [0.3,'#fff'], //0.1透明度的白色背景
        time: 100000
    });
    var value = $(".select-cat-"+catid).html();
    if (value == '[+]') {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "?m=admin&c=category&a=public_list_index&menuid=<?php echo $this->input->get('menuid');?>&pc_hash=<?php echo $this->input->get('pc_hash');?>&pid="+catid,
            success: function(json) {
                layer.close(index);
                if (json.code == 1) {
                    $(".dr_catid_"+catid).after(json.msg);
                    $(".select-cat-"+catid).html('[-]');
                    $('.tooltips').tooltip();
                } else {
                    dr_cmf_tips(json.code, json.msg);
                }
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                dr_ajax_alert_error(HttpRequest, this, thrownError);
            }
        });
    } else {
        layer.close(index);
        $(".dr_pid_"+catid).remove();
        $(".select-cat-"+catid).html('[+]');
    }
}
$(function() {
    $('.tooltips').tooltip();
    <?php if (defined('SYS_CAT_POPEN') && SYS_CAT_POPEN) {
    if(is_array($pcats)){
    foreach($pcats as $ii){
    ?>
    dr_tree_data(<?php echo $ii;?>);
    <?php }}}?>
});
</script>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
                <div class="page-body">
<div class="note note-danger">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=category&a=public_cache&pc_hash='+pc_hash+'&is_ajax=1');"><?php echo L('变更栏目属性之后，需要一键更新栏目配置信息');?></a></p>
</div>
<div class="right-card-box">

    <form class="form-horizontal" role="form" id="myform">
        <div class="table-list">
            <table>
                <thead>
                <?php echo $cat_head;?>
                </thead>
                <tbody>
                <?php echo $cat_list;?>
                </tbody>
            </table>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
<script>
$(function() {
    $('body').on('click','#del',function() {
        var that = this;
        Dialog.confirm('您确定要删除该栏目吗？', function() {
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.ajax({
                type: 'post',
                url: '?m=admin&c=category&a=delete&pc_hash='+pc_hash,
                data: {catid: $(that).data('catid'),dosubmit:1,csrf_test_name:csrf_hash},
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
    })
});
</script>
</body>
</html>