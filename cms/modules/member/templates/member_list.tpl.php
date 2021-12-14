<?php defined('IS_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<link href="<?php echo CSS_PATH?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">var bs_selectAllText = '全选';var bs_deselectAllText = '全删';var bs_noneSelectedText = '没有选择'; var bs_noneResultsText = '没有找到 {0}';</script>
<link href="<?php echo JS_PATH?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH?>bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script type="text/javascript">jQuery(document).ready(function(){$('.bs-select').selectpicker();});</script>
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
<style type="text/css">
.dropdown::after {opacity: 0!important;}
:not(.input-group)>.bootstrap-select.form-control:not([class*=col-]) {width: auto;}
</style>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="m">
<input type="hidden" value="member" name="c">
<input type="hidden" value="manage" name="a">
<input type="hidden" value="<?php echo $this->input->get('menuid');?>" name="menuid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<?php echo L('regtime')?>：
        <div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $start_time;?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $end_time;?>" name="end_time" id="end_time">
            </div>
        </div>
				<?php if($_SESSION['roleid'] == 1) {?>
				<?php echo form::select($sitelist, $siteid, 'name="siteid[]" class="form-control bs-select" data-title="'.L('all_site').'" multiple="multiple"');}?>
							
				<select name="status[]" class="form-control bs-select" data-title="<?php echo L('status')?>" multiple="multiple">
					<option value='1' <?php if(isset($_GET['status']) && dr_in_array(1, $_GET['status'])){?>selected<?php }?>><?php echo L('lock')?></option>
					<option value='0' <?php if(isset($_GET['status']) && dr_in_array(0, $_GET['status'])){?>selected<?php }?>><?php echo L('normal')?></option>
				</select>
				<?php echo form::select($modellist, $modelid, 'name="modelid[]" class="form-control bs-select" data-title="'.L('member_model').'" multiple="multiple"')?>
				<?php echo form::select($grouplist, $groupid, 'name="groupid[]" class="form-control bs-select" data-title="'.L('member_group').'" multiple="multiple" data-actions-box="true"')?>
				
				<select name="type">
					<option value='1' <?php if(isset($_GET['type']) && $_GET['type']==1){?>selected<?php }?>><?php echo L('username')?></option>
					<option value='2' <?php if(isset($_GET['type']) && $_GET['type']==2){?>selected<?php }?>><?php echo L('uid')?></option>
					<option value='3' <?php if(isset($_GET['type']) && $_GET['type']==3){?>selected<?php }?>><?php echo L('email')?></option>
					<option value='4' <?php if(isset($_GET['type']) && $_GET['type']==4){?>selected<?php }?>><?php echo L('regip')?></option>
					<option value='5' <?php if(isset($_GET['type']) && $_GET['type']==5){?>selected<?php }?>><?php echo L('nickname')?></option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" id="myform" action="?m=member&c=member&a=delete" method="post" onsubmit="checkuid();return false;">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr class="heading">
			<th class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('userid[]');" />
                        <span></span>
                    </label></th>
			<th width="60" class="<?php echo dr_sorting('userid');?>" name="userid"><?php echo L('头像')?></th>
            <?php 
            if(is_array($list_field)){
            foreach($list_field as $i=>$t){
            ?>
            <th<?php if($t['width']){?> width="<?php echo $t['width'];?>"<?php }?><?php if($t['center']){?> style="text-align:center"<?php }?> class="<?php echo dr_sorting($i);?>" name="<?php echo $i;?>"><?php echo L($t['name']);?></th>
            <?php }}?>
			<th><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($memberlist)){
	foreach($memberlist as $k=>$v) {
?>
    <tr>
		<td class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" value="<?php echo $v['userid']?>" name="userid[]" />
                        <span></span>
                    </label></td>
		<td><a href="javascript:member_infomation(<?php echo $v['userid']?>, '<?php echo $v['modelid']?>', '')"><img src="<?php echo $v['avatar']?>" height="30" width="30" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'"></a></td>
		<?php 
		if(is_array($list_field)){
		foreach($list_field as $i=>$tt){
		?>
		<td<?php if($tt['center']){?> style="text-align:center"<?php }?>><?php echo dr_list_function($tt['func'], $v[$i], $param, $v, $field[$i]);?></td>
		<?php }}?>
		<td>
			<a href="javascript:edit(<?php echo $v['userid']?>, '<?php echo $v['username']?>')" class="btn btn-xs green"><?php echo L('edit')?></a>
			<a href="?m=member&c=member&a=alogin_index&id=<?php echo $v['userid']?>" target="_blank" class="btn btn-xs red"><?php echo L('login')?></a>
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" onclick="Dialog.confirm('<?php echo L('sure_delete')?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('delete')?></button></label>
        <label><button type="submit" onclick="document.myform.action='?m=member&c=member&a=lock'" class="btn dark btn-sm"> <i class="fa fa-lock"></i> <?php echo L('lock')?></button></label>
        <label><button type="submit" onclick="document.myform.action='?m=member&c=member&a=unlock'" class="btn green btn-sm"> <i class="fa fa-unlock"></i> <?php echo L('unlock')?></button></label>
        <label><button type="button" onclick="move();return false;" class="btn blue btn-sm"> <i class="fa fa-arrows"></i> <?php echo L('move')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function edit(id, name) {
	artdialog('edit','?m=member&c=member&a=edit&userid='+id,'<?php echo L('edit').L('member')?>《'+name+'》',700,500);
}
function move() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		Dialog.alert('<?php echo L('plsease_select').L('member')?>');
		return false;
	}
	artdialog('move','?m=member&c=member&a=move&ids='+ids,'<?php echo L('move').L('member')?>',700,500);
}

function checkuid() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		Dialog.alert('<?php echo L('plsease_select').L('member')?>');
		return false;
	} else {
		myform.submit();
	}
}

function member_infomation(userid, modelid, name) {
	omnipotent('modelinfo','?m=member&c=member&a=memberinfo&userid='+userid+'&modelid='+modelid,'<?php echo L('memberinfo')?>',1,700,500);
}

//-->
</script>
</body>
</html>