<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="page-content main-content">
<form action="" class="form-horizontal" method="post" name="myform" id="myform">
<input name="dosubmit" type="hidden" value="1">
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li class="active">
                <a data-toggle="tab_0"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('database_export').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-th-large"></i> <?php if (!is_mobile(0)) {echo L('database_export');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="table-list">
<table width="100%" cellspacing="0" class="table-checkable">
 <?php 
if(is_array($infos)){
?>
    <thead>
       <tr>
           <th class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" data-set=".checkboxes" />
                        <span></span>
                    </label></th>
           <th width="280"><?php echo L('database_tblname')?></th>
           <th width="150"><?php echo L('database_type')?></th>
           <th width="180"><?php echo L('database_char')?></th>
           <th width="100"><?php echo L('database_records')?></th>
           <th width="150"><?php echo L('database_size')?></th>
           <th width="180"><?php echo L('updatetime')?></th>
           <th><?php echo L('database_op')?></th>
       </tr>
    </thead>
    <tbody>
    <?php foreach($infos['cmstables'] as $v){?>
    <tr>
    <td align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="tables[]" value="<?php echo $v['name']?>" />
                        <span></span>
                    </label></td>
    <td align="center"><a href="javascript:void(0);" onclick="show('<?php echo $v['name']?>')"><?php echo $v['name']?></a></td>
    <td align="center"><?php echo $v['engine']?></td>
    <td align="center"><?php echo $v['collation']?></td>
    <td align="center"><?php echo $v['rows']?></td>
    <td align="center"><?php echo format_file_size($v['size'])?></td>
    <td align="center"><?php echo dr_date($v['updatetime'], null, 'red')?></td>
    <td align="center"><a href="?m=admin&c=database&a=public_repair&operation=optimize&tables=<?php echo $v['name']?>"><?php echo L('database_optimize')?></a> | <a href="?m=admin&c=database&a=public_repair&operation=repair&tables=<?php echo $v['name']?>"><?php echo L('database_repair')?></a> | <a href="?m=admin&c=database&a=public_repair&operation=flush&tables=<?php echo $v['name']?>"><?php echo L('database_flush')?></a> | <a href="?m=admin&c=database&a=public_repair&operation=jc&tables=<?php echo $v['name']?>"><?php echo L('database_check')?></a> | <a href="javascript:void(0);" onclick="showcreat('<?php echo $v['name']?>')"><?php echo L('database_showcreat')?></a></td>
    </tr>
    <?php } ?>
    </tbody>
<?php 
}
?>
</table>
</div>
<?php if(is_array($infos)){?>
<div class="row list-footer table-checkable">
    <div class="col-md-12 col-sm-12 table-footer-button">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox" class="group-checkable" data-set=".checkboxes" /><span></span></label>
        <label><button name="dosubmit" type="button" class="btn green btn-sm btn-backup"> <i class="fa fa-database"></i> <?php echo L('backup_starting');?></button></label>
        <label><button name="dosubmit" type="button" onclick="dr_bfb_submit('<?php echo L('batch_optimize')?>', 'myform', '<?php echo SELF;?>?m=admin&c=database&a=public_add&operation=y')" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('batch_optimize');?></button></label>
        <label><button name="dosubmit" type="button" onclick="dr_bfb_submit('<?php echo L('batch_repair')?>', 'myform', '<?php echo SELF;?>?m=admin&c=database&a=public_add&operation=x')" class="btn blue btn-sm"> <i class="fa fa-wrench"></i> <?php echo L('batch_repair');?></button></label>
        <label><button name="dosubmit" type="button" onclick="dr_bfb_submit('<?php echo L('batch_flush')?>', 'myform', '<?php echo SELF;?>?m=admin&c=database&a=public_add&operation=s')" class="btn yellow btn-sm"> <i class="fa fa-cogs"></i> <?php echo L('batch_flush');?></button></label>
        <label><button name="dosubmit" type="button" onclick="dr_bfb_submit('<?php echo L('batch_check')?>', 'myform', '<?php echo SELF;?>?m=admin&c=database&a=public_add&operation=jc')" class="btn red btn-sm"> <i class="fa fa-retweet"></i> <?php echo L('batch_check');?></button></label>
        <label><button name="dosubmit" type="button" onclick="dr_bfb_submit('<?php echo L('batch_utf8mb4')?>', 'myform', '<?php echo SELF;?>?m=admin&c=database&a=public_add&operation=ut')" class="btn dark btn-sm"> <i class="fa fa-database"></i> <?php echo L('batch_utf8mb4');?></button></label>
    </div>
</div>
<?php }?>
    </div>
</div>
</form>
</div>
</body>
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
            url: '?m=admin&c=database&a=import&menuid=<?php echo $this->input->get('menuid');?>&pc_hash='+pc_hash,
            data: $("#myform").serialize(),
            success: function(json) {
                layer.close(loading);
                if (json.code == 1) {
                    if (json.data.url) {
                        setTimeout("window.location.href = '"+json.data.url+"'", 2000);
                    } else {
                        setTimeout("window.location.reload(true)", 2000);
                    }
                }
                dr_tips(json.code, json.msg);
                return false;
            },
            error: function(HttpRequest, ajaxOptions, thrownError) {
                dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
            }
        });
    });
});
function show_tbl(obj) {
    var pdoname = $(obj).val();
    location.href='?m=admin&c=database&a=export&pdoname='+pdoname+'&menuid=<?php echo $this->input->get('menuid');?>&pc_hash=<?php echo dr_get_csrf_token()?>';
}
function showcreat(tblname) {
    omnipotent('show','?m=admin&c=database&a=public_repair&operation=showcreat&menuid=<?php echo $this->input->get('menuid');?>&tables='+tblname,tblname,1,'60%','70%')
}
function show(tblname) {
    omnipotent('show','?m=admin&c=database&a=public_repair&operation=show&menuid=<?php echo $this->input->get('menuid');?>&tables='+tblname,tblname,1,'60%','70%')
}
</script>
</html>
