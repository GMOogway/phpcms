<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
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
    $('.tooltips').tooltip();
    $(":text").removeClass('input-text');
});
</script>
<style type="text/css">
body {background: #f5f6f8;}
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="note note-danger">
    <p><a href="?m=content&c=content&a=init&catid=<?php echo $catid;?>&pc_hash=<?php echo dr_get_csrf_token();?>" class="btn green">
            <i class="fa fa-check"></i> <?php echo L('check_passed');?>
        </a>
        <a href="javascript:;" onclick="javascript:$('#searchid').toggle();" class="btn blue">
            <i class="fa fa-search"></i> <?php echo L('search');?>
        </a></p>
</div>
<div class="right-card-box">
    <div class="row table-search-tool" id="searchid"<?php if (!$param['search']) {?> style="display:none;"<?php }?>>
        <form name="searchform" action="" method="get" >
        <input type="hidden" value="content" name="m">
        <input type="hidden" value="content" name="c">
        <input type="hidden" value="recycle_init" name="a">
        <input type="hidden" value="<?php echo $catid;?>" name="catid">
        <input type="hidden" value="1" name="search">
        <input type="hidden" value="<?php echo dr_get_csrf_token();?>" name="pc_hash">
        <div class="col-md-12 col-sm-12">
        <label><select id="posids" name="posids"><option value='' <?php if($param['posids']=='') echo 'selected';?>><?php echo L('all');?></option>
        <option value="1" <?php if($param['posids']==1) echo 'selected';?>><?php echo L('elite');?></option>
        <option value="2" <?php if($param['posids']==2) echo 'selected';?>><?php echo L('no_elite');?></option>
        </select></label>
        </div>
        <div class="col-md-12 col-sm-12">
        <label><select id="searchtype" name="searchtype" class="form-control">
            <option value='0' <?php if($param['searchtype']==0) echo 'selected';?>><?php echo L('title');?></option>
            <option value='1' <?php if($param['searchtype']==1) echo 'selected';?>><?php echo L('intro');?></option>
            <option value='2' <?php if($param['searchtype']==2) echo 'selected';?>><?php echo L('username');?></option>
            <option value='3' <?php if($param['searchtype']==3) echo 'selected';?>>ID</option>
        </select></label>
        <label><i class="fa fa-caret-right"></i></label>
        <label><input type="text" class="form-control" placeholder="" value="<?php echo $param['keyword'];?>" name="keyword" /></label>
        </div>
        <div class="col-md-12 col-sm-12">
        <label><div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $param['start_time'];?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $param['end_time'];?>" name="end_time" id="end_time">
            </div>
        </div></label>
        </div>
        <div class="col-md-12 col-sm-12">
        <label><button type="submit" class="btn blue btn-sm onloading"><i class="fa fa-search"></i> <?php echo L('search');?></button></label>
        </div>
        </form>
    </div>
<form class="form-horizontal" name="myform" id="myform" action="" method="post">
    <div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr class="heading">
            <th align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('id[]');" />
                        <span></span>
                    </label></th>
            <?php 
            if(is_array($list_field)){
            foreach($list_field as $i=>$t){
            ?>
            <th<?php if($t['width']){?> width="<?php echo $t['width'];?>"<?php }?><?php if($t['center']){?> style="text-align:center"<?php }?> class="<?php echo dr_sorting($i);?>" name="<?php echo $i;?>"><?php echo L($t['name']);?></th>
            <?php }}?>
            <th align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($datas)){
    foreach($datas as $r){
?>   
    <tr>
    <td align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="id[]" value="<?php echo $r['id']?>" />
                        <span></span>
                    </label></td>
    <?php 
    if(is_array($list_field)){
    foreach($list_field as $i=>$tt){
    ?>
    <td<?php if($tt['center']){?> style="text-align:center"<?php }?>><?php echo dr_list_function($tt['func'], $r[$i], $param, $r, $field[$i], $i);?></td>
    <?php }}?>
    <td align="center"><a href="<?php
        $sitelist = getcache('sitelist','commons');
        $release_siteurl = $sitelist[$category['siteid']]['url'];
        $path_len = -strlen(WEB_PATH);
        $release_siteurl = substr($release_siteurl,0,$path_len);
        if($r['status']==99) {
            if($r['islink']) {
                echo $r['url'];
            } elseif(strpos($r['url'],'http://')!==false || strpos($r['url'],'https://')!==false) {
                echo $r['url'];
            } else {
                echo $release_siteurl.$r['url'];
            }
        } else {
            echo '?m=content&c=content&a=public_preview&catid='.$r['catid'].'&id='.$r['id'].'';
        }?>" target="_blank" class="btn btn-xs blue"><i class="fa fa-eye"></i> <?php echo L('preview');?></a>
        <a class="btn btn-xs green" lay-event="restore"><i class="fa fa-window-restore"></i> <?php echo L('restore');?></a></td>
    </tr>
<?php 
    }
}
?>
</tbody>
    </table>
</div>
<div class="row list-footer table-checkable">
    <div class="col-md-5 list-select">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" id="delAll" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('thorough').L('delete');?></button></label>
        <label><button type="button" id="recycle" class="btn green btn-sm"> <i class="fa fa-window-restore"></i> <?php echo L('还原');?></button></label>
    </div>
    <div class="col-md-7 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
<script>
$(function() {
    $('body').on('click','#delAll',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            Dialog.confirm('确认要删除选中的内容吗？', function() {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.ajax({
                    type: 'post',
                    url: '?m=content&c=content&a=delete&catid=<?php echo $catid;?>&pc_hash='+pc_hash,
                    data: {ids: ids,dosubmit:1,csrf_test_name:csrf_hash},
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
    $('body').on('click','#recycle',function() {
        var ids = [];
        $('input[name="id[]"]:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.toString()=='') {
            layer.msg('\u81f3\u5c11\u9009\u62e9\u4e00\u6761\u4fe1\u606f',{time:1000,icon:2});
        } else {
            Dialog.confirm('确认要还原选中的内容吗？', function() {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.ajax({
                    type: 'post',
                    url: '?m=content&c=content&a=recycle&recycle=0&catid=<?php echo $catid;?>&pc_hash='+pc_hash,
                    data: {ids: ids,dosubmit:1,csrf_test_name:csrf_hash},
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
</div>
</div>
</div>
</body>
</html>