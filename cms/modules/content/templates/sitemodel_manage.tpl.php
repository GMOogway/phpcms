<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="note note-danger">
    <p><a href="javascript:dr_admin_menu_ajax('?m=admin&c=cache_all&a=init&pc_hash='+pc_hash+'&is_ajax=1',1);"><?php echo L('update_cache_all');?></a></p>
</div>
<div class="right-card-box">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr class="heading">
            <th width="50"><?php echo L('可用');?></th>
            <th width="200"><?php echo L('model_name');?> / <?php echo L('tablename');?></th>
            <th width="150"><?php echo L('items');?></th>
            <th><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
    <?php foreach($datas as $r) {?>
    <tr>
        <td><a href="javascript:;" onclick="dr_ajax_open_close(this, '<?php echo '?m=content&c=sitemodel&a=disabled&modelid='.$r['modelid'].'&menuid='.$this->input->get('menuid');?>', 1);" class="badge badge-<?php echo $r['disabled'] ? 'no' : 'yes';?>"><i class="fa fa-<?php echo $r['disabled'] ? 'times' : 'check';?>"></i></a></td>
        <td><?php echo $r['name'];?> / <?php echo $r['tablename']?></td>
        <td><?php echo $r['items']?></td>
        <td>
            <a class="btn btn-xs blue" href="?m=content&c=sitemodel_field&a=init&modelid=<?php echo $r['modelid']?>&menuid=<?php echo $this->input->get('menuid');?>"> <i class="fa fa-code"></i> <?php echo L('field_manage');?></a>
            <a class="btn btn-xs green" href="?m=content&c=sitemodel&a=edit&modelid=<?php echo $r['modelid']?>&menuid=<?php echo $this->input->get('menuid');?>"> <i class="fa fa-edit"></i> <?php echo L('edit');?></a>
            <a class="btn btn-xs red" href="javascript:;" onclick="model_delete(this,'<?php echo $r['modelid']?>','<?php echo L('confirm_delete_model',array('message'=>new_addslashes($tablename)));?>','<?php echo $r['items']?>')"> <i class="fa fa-trash"></i> <?php echo L('delete')?></a>
            <a class="btn btn-xs yellow" href="?m=content&c=sitemodel&a=export&modelid=<?php echo $r['modelid']?>&menuid=<?php echo $this->input->get('menuid');?>"> <i class="fa fa-sign-out"></i> <?php echo L('export');?></a>
        </td>
    </tr>
    <?php } ?>
    </tbody>
    </table>
  </div>
<div class="row">
    <div class="col-md-12 col-sm-12 text-right"><?php echo $pages?></div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript"> 
<!--
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
