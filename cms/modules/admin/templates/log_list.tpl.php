<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header','admin');
?>
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
});
</script>
<div class="pad-lr-10"> 
<form name="searchform" action="?m=admin&c=log&a=search_log&menuid=<?php echo $this->input->get('menuid');?>" method="get" >
<input type="hidden" value="admin" name="m">
<input type="hidden" value="log" name="c">
<input type="hidden" value="search_log" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"><?php echo L('module')?>: <?php echo form::select($module_arr,'','name="search[module]"',$default)?> <?php echo L('username')?>  <input type="text" value="" class="input-text" name="search[username]" size='10'>  <?php echo L('times')?> <div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $this->input->get('search')['start_time'];?>" name="search[start_time]">
                <span class="input-group-addon"> <?php echo L('to')?> </span>
                <input type="text" class="form-control" value="<?php echo $this->input->get('search')['end_time'];?>" name="search[end_time]">
            </div>
        </div>   <input type="submit" value="<?php echo L('determine_search')?>" class="button" name="dosubmit"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" name="del_log_4" value="<?php echo L('removed_data')?>" onclick="location='?m=admin&c=log&a=delete&week=4&menuid=<?php echo $this->input->get('menuid');?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>'"  />
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<form name="myform" id="myform" action="?m=admin&c=log&a=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
 <table width="100%" cellspacing="0">
        <thead>
            <tr>
             <th width="80"><?php echo L('username')?></th>
            <th><?php echo L('module')?></th>
            <th><?php echo L('file')?></th>
             <th width="180"><?php echo L('time')?></th>
             <th>IP</th>
            </tr>
        </thead>
    <tbody>
 <?php
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr> 
        <td align="center"><?php echo $info['username']?></td>
        <td align="center"><?php echo $info['module']?></td>
        <td align="left" title="<?php echo $info['querystring']?>"><?php echo str_cut($info['querystring'], 40);?></td>
         <td align="center"><?php echo dr_date(strtotime($info['time']), null, 'red');//echo $info['lastusetime'] ? date('Y-m-d H:i', $info['lastusetime']):''?></td>
         <td align="center"><?php echo $info['ip']?>　</td> 
    </tr>
<?php
	}
}
?></tbody>
 </table>
 </div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select"></div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript"> 
function checkuid() {
	var ids='';
	$("input[name='logid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		Dialog.alert('<?php echo L('select_operations')?>');
		return false;
	} else {
		myform.submit();
	}
}
</script>
 