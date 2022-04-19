<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link href="<?php echo JS_PATH;?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
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
<div class="page-content-white page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li class="dropdown"> <a href="javascript:;" class="on"> <i class="fa fa-gears"></i>  <?php echo L('模型');?></a> <a class="dropdown-toggle on" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-angle-double-down"></i></a>
            <ul class="dropdown-menu">
            <?php 
            foreach($datas2 as $r) {
                echo "<li><a href=\"?m=content&c=content&a=initall&modelid=".$r['modelid']."&menuid=".$param['menuid']."&pc_hash=".dr_get_csrf_token()."\" class=\"";
                if($r['modelid']==$modelid) {echo "on";}
                if ($r['modelid']==2) {
                    echo "\"><i class=\"fa fa-download\"></i> ".$r['name']."(".$r['items'].")</a></li>".PHP_EOL;
                } else if ($r['modelid']==3) {
                    echo "\"><i class=\"fa fa-image\"></i> ".$r['name']."(".$r['items'].")</a></li>".PHP_EOL;
                } else {
                    echo "\"><i class=\"fa fa-list\"></i> ".$r['name']."(".$r['items'].")</a></li>".PHP_EOL;
                }
            }
            ?>
            </ul> <i class="fa fa-circle"></i>
        </li>
        <li class="dropdown"> <a href="javascript:;" class="on"> <i class="fa fa-users"></i>  <?php echo L('用户（总）');?></a> <a class="dropdown-toggle on" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-angle-double-down"></i></a>
            <ul class="dropdown-menu">
            <?php 
            if(is_array($infos)){
                foreach($infos as $info){
                    $total = $this->db->count(array('status'=>99,'username'=>$info['username']));
                    echo "<li><a href=\"?m=content&c=content&a=initall&modelid=".$modelid."&menuid=".$param['menuid']."&start_time=&end_time=&posids=&searchtype=2&keyword=".$info['username']."&pc_hash=".dr_get_csrf_token()."\" class=\"";
                    if($info['username']==$param['keyword'] && !$param['start_time'] && !$param['end_time']) {echo ' on';}
                    echo "\">";
                    echo $info['realname'] ? $info['realname'] : $info['username'];
                    echo "(总".$total.")</a></li>".PHP_EOL;
                }
            }
            ?>
            </ul> <i class="fa fa-circle"></i>
        </li>
        <li class="dropdown"> <a href="javascript:;" class="on"> <i class="fa fa-user"></i>  <?php echo L('用户（今）');?></a> <a class="dropdown-toggle on" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"><i class="fa fa-angle-double-down"></i></a>
            <ul class="dropdown-menu">
            <?php 
            if(is_array($infos)){
                foreach($infos as $info){
                    $total2 = $this->db->count("status=99 and username='".$info['username']."' and `inputtime` > '".strtotime(date("Ymd", time()))."' and `inputtime` < '".strtotime(date("Ymd", strtotime('+1 day',time())))."'");
                    echo "<li><a href=\"?m=content&c=content&a=initall&modelid=".$modelid."&menuid=".$param['menuid']."&start_time=".dr_date(SYS_TIME,'Y-m-d')."&end_time=".dr_date(SYS_TIME,'Y-m-d')."&posids=&searchtype=2&keyword=".$info['username']."&pc_hash=".dr_get_csrf_token()."\" class=\"";
                    if($info['username']==$param['keyword'] && dr_date(SYS_TIME,'Y-m-d')==$param['start_time'] && dr_date(SYS_TIME,'Y-m-d')==$param['end_time']) {echo ' on';}
                    echo "\">";
                    echo $info['realname'] ? $info['realname'] : $info['username'];
                    echo "(今".$total2.")</a></li>".PHP_EOL;
                }
            }
            ?>
            </ul>
        </li>
    </ul>
</div>
<div class="page-body" style="margin-top: 20px;margin-bottom:30px;padding-top:15px;">
<div class="right-card-box">
    <div class="row table-search-tool" id="searchid">
        <form name="searchform" action="" method="get" >
        <input type="hidden" value="content" name="m">
        <input type="hidden" value="content" name="c">
        <input type="hidden" value="initall" name="a">
        <input type="hidden" value="<?php echo $modelid;?>" name="modelid">
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
        <label>
            <div class="input-group input-medium date-picker input-daterange" data-date="" data-date-format="yyyy-mm-dd">
                <input type="text" class="form-control" value="<?php echo $param['start_time'];?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $param['end_time'];?>" name="end_time" id="end_time">
            </div>
        </label>
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
    <td<?php if($tt['center']){?> class="table-center" style="text-align:center"<?php }?>><?php echo dr_list_function($tt['func'], $r[$i], $param, $r, $field[$i], $i);?></td>
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
        }?>" target="_blank"<?php if($r['status']!=99) {?> onclick='window.open("?m=content&c=content&a=public_preview&catid=<?php echo $r['catid'];?>&id=<?php echo $r['id'];?>","manage")'<?php }?> class="btn btn-xs blue"><i class="fa fa-eye"></i> <?php echo L('preview');?></a>
        <a href="javascript:;" onclick="javascript:dr_content_submit('?m=content&c=content&a=edit&catid=<?php echo $r['catid'];?>&id=<?php echo $r['id'];?>','edit')" class="btn btn-xs green"><i class="fa fa-edit"></i> <?php echo L('edit');?></a>
        <a href="javascript:view_comment('<?php echo id_encode('content_'.$r['catid'],$r['id'],$this->siteid);?>','<?php echo safe_replace($r['title']);?>')" class="btn btn-xs yellow"><i class="fa fa-comment"></i> <?php echo L('comment');?></a></td>
    </tr>
<?php 
    }
}
?>
</tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 text-right"><?php echo $pages?></div>
</div>
</form>
</div>
</div>
<script type="text/javascript"> 
function view_comment(id, name) {
    var w = 800;
    var h = 500;
    if (is_mobile()) {
        w = h = '100%';
    }
    var diag = new Dialog({
        id:'view_comment',
        title:'<?php echo L('view_comment');?>：'+name,
        url:'<?php echo SELF;?>?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid='+id+'&pc_hash='+pc_hash,
        width:w,
        height:h,
        modal:true
    });
    diag.onCancel=function() {
        $DW.close();
    };
    diag.show();
}
</script>
</div>
</div>
</div>
</body>
</html>