<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<link href="<?php echo CSS_PATH?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.portlet.light>.portlet-title {padding: 0;color: #181C32;font-weight: 500;}
.portlet.bordered>.portlet-title {border-bottom: 0;}
.portlet>.portlet-title {padding: 0;margin-bottom: 2px;-webkit-border-radius: 4px 4px 0 0;-moz-border-radius: 4px 4px 0 0;-ms-border-radius: 4px 4px 0 0;-o-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;}
.portlet>.portlet-title>.caption {float: left;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;}
.portlet.light>.portlet-title>.caption.caption-md>.caption-subject, .portlet.light>.portlet-title>.caption>.caption-subject {font-size: 15px;}
.font-dark {color: #2f353b!important;}
.portlet>.portlet-title:after,.portlet>.portlet-title:before {content: " ";display: table;}
.portlet>.portlet-title:after {clear: both;}
.portlet>.portlet-title>.nav-tabs {background: 0 0;margin: 1px 0 0;float: right;display: inline-block;border: 0;}
.portlet>.portlet-title>.nav-tabs>li {background: 0 0;margin: 0;border: 0;}
.portlet>.portlet-title>.nav-tabs>li>a {background: 0 0;margin: 5px 0 0 1px;border: 0;padding: 8px 10px;color: #fff;}
.portlet>.portlet-title>.nav-tabs>li.active>a,.portlet>.portlet-title>.nav-tabs>li:hover>a {color: #333;background: #fff;border: 0;}
.portlet.light>.portlet-title>.nav-tabs>li {margin: 0;padding: 0;}
.portlet.light>.portlet-title>.nav-tabs>li>a {margin: 0;padding: 12px 13px 13px;color: #666;}
.portlet.light>.portlet-title>.nav-tabs>li>a {font-size: 14px!important;}
.tabbable-line>.nav-tabs {border: none;margin: 0;}
.tabbable-line>.nav-tabs>li {margin: 0;border-bottom: 4px solid transparent;}
.tabbable-line>.nav-tabs>li>a {background: 0 0!important;border: 0;margin: 0;padding-left: 15px;padding-right: 15px;color: #737373;cursor: pointer;}
.tabbable-line>.nav-tabs>li>a>i {color: #a6a6a6;}
.tabbable-line>.nav-tabs>li.active {background: 0 0;border-bottom: 4px solid #3ea9e2;position: relative;}
.tabbable-line>.nav-tabs>li.active>a {border: 0;color: #333;}
.tabbable-line>.nav-tabs>li.active>a>i {color: #404040;}
.tabbable-line>.nav-tabs>li.open,.tabbable-line>.nav-tabs>li:hover {background: 0 0;border-bottom: 4px solid #dadbde;}
.tabbable-line>.nav-tabs>li.open>a,.tabbable-line>.nav-tabs>li:hover>a {border: 0;background: 0 0!important;color: #333;}
.tabbable-line>.nav-tabs>li.open>a>i,.tabbable-line>.nav-tabs>li:hover>a>i {color: #a6a6a6;}
.tabbable-line>.nav-tabs>li.active {border-bottom: 4px solid #40aae3;}
.form .form-body,.portlet-form .form-body {padding: 20px;}
</style>
<div class="page-content main-content">
<form action="" class="form-horizontal" method="post" name="myform" id="myform">
<input name="dosubmit" type="hidden" value="1">
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li class="active">
                <a data-toggle="tab_0"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('database_export').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-th-large"></i> <?php if (!is_mobile(0)) {echo L('database_export');}?> </a>
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
    <div class="col-md-7 list-select">
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
