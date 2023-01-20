<?php 
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="page-content-white page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
    <div class="right-card-box">
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
                        <th width="50" class="<?php echo dr_sorting('id');?>" name="id"><?php echo L('number');?></th>
                        <th style="text-align:center" width="90" class="<?php echo dr_sorting('type');?>" name="type"><?php echo L('存储类型');?></th>
                        <th class="<?php echo dr_sorting('name');?>" name="name"><?php echo L('名称');?></th>
                        <th><?php echo L('operations_manage');?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($datas as $t) {?>
                    <tr class="odd gradeX" id="dr_row_<?php echo $t['id'];?>">
                        <td class="myselect">
                            <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" name="ids[]" value="<?php echo $t['id'];?>" />
                                <span></span>
                            </label>
                        </td>
                        <td><?php echo $t['id'];?></td>
                    <td style="text-align:center"> <span class="badge<?php if ($color[$t['type']]) {?> badge-<?php echo $color[$t['type']];?><?php }?>"> <?php echo $this->type[$t['type']]['name'];?> </span> </td>
                        <td><?php echo $t['name'];?></td>
                        <td>
                            <label><a href="?m=attachment&c=attachment&a=remote_edit&id=<?php echo $t['id'];?>&menuid=<?php echo $this->input->get('menuid');?>&pc_hash=<?php echo $this->input->get('pc_hash');?>" class="btn btn-xs green"><i class="fa fa-edit"></i> <?php echo L('edit');?></a></label>
                        </td>
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
            Dialog.confirm('<?php echo L('删除后，已关联的附件都会失效，确定要删除吗？')?>', function() {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.ajax({
                    type: 'post',
                    url: '?m=attachment&c=attachment&a=remote_delete&pc_hash='+pc_hash,
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
</script>
</body>
</html>