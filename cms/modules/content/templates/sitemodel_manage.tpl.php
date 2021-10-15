<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-lr-10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr class="heading">
            <th width="100" class="<?php echo dr_sorting('modelid')?>" name="modelid">modelid</th>
            <th width="180" class="<?php echo dr_sorting('name')?>" name="name"><?php echo L('model_name');?></th>
            <th width="180" class="<?php echo dr_sorting('tablename')?>" name="tablename"><?php echo L('tablename');?></th>
            <th class="<?php echo dr_sorting('description')?>" name="description"><?php echo L('description');?></th>
            <th width="100" class="<?php echo dr_sorting('disabled')?>" name="disabled"><?php echo L('status');?></th>
            <th width="150"><?php echo L('items');?></th>
            <th><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
    <?php
    foreach($datas as $r) {
        $tablename = $r['name'];
    ?>
    <tr>
        <td align='center'><?php echo $r['modelid']?></td>
        <td align='center'><?php echo $tablename?></td>
        <td align='center'><?php echo $r['tablename']?></td>
        <td><?php echo $r['description']?></td>
        <td align='center'><?php echo $r['disabled'] ? L('icon_locked') : L('icon_unlock')?></td>
        <td align='center'><?php echo $r['items']?></td>
        <td align='center'><a class="btn btn-xs blue" href="?m=content&c=sitemodel_field&a=init&modelid=<?php echo $r['modelid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('field_manage');?></a><a class="btn btn-xs green" href="javascript:edit('<?php echo $r['modelid']?>','<?php echo addslashes($tablename);?>')"><?php echo L('edit');?></a><a class="btn btn-xs dark" href="?m=content&c=sitemodel&a=disabled&modelid=<?php echo $r['modelid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo $r['disabled'] ? L('field_enabled') : L('field_disabled');?></a><a class="btn btn-xs red" href="javascript:;" onclick="model_delete(this,'<?php echo $r['modelid']?>','<?php echo L('confirm_delete_model',array('message'=>addslashes($tablename)));?>','<?php echo $r['items']?>')"><?php echo L('delete')?></a><a class="btn btn-xs yellow" href="?m=content&c=sitemodel&a=export&modelid=<?php echo $r['modelid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('export');?></a></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>
  </div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select"></div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</div>
<script type="text/javascript"> 
<!--
window.top.$('#display_center_id').css('display','none');
function edit(id, name) {
    artdialog('edit','?m=content&c=sitemodel&a=edit&modelid='+id,'<?php echo L('edit_model')?>《'+name+'》',580,420);
}
function model_delete(obj,id,name,items){
    if(items!=0) {
        Dialog.alert('<?php echo L('model_does_not_allow_delete');?>');
        return false;
    }
    Dialog.confirm(name,function(){
        $.get('?m=content&c=sitemodel&a=delete&modelid='+id+'&pc_hash='+pc_hash,function(data){
            if(data) {
                $(obj).parent().parent().fadeOut("slow");
            }
        })     
    });
};

//-->
</script>
</body>
</html>
