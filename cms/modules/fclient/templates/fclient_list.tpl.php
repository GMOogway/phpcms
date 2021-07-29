<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<style type="text/css">
.btn {outline: 0!important;}
.btn {box-shadow: none!important;}
.btn-group-xs>.btn, .btn-xs {padding: 1px 5px;font-size: 12px;border-radius: 3px;}
/*.btn {display: inline-block;margin-bottom: 0;font-weight: 400;text-align: center;vertical-align: middle;touch-action: manipulation;cursor: pointer;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;line-height: 1.42857;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}*/
.btn:not(.btn-sm):not(.btn-lg) {line-height: 1.44;}
.btn.green:not(.btn-outline) {color: #FFF;background-color: #32c5d2;border-color: #32c5d2;}
.btn.green:not(.btn-outline).active, .btn.green:not(.btn-outline):active, .btn.green:not(.btn-outline):hover, .open>.btn.green:not(.btn-outline).dropdown-toggle {color: #FFF;background-color: #26a1ab;border-color: #2499a3;}
.btn.red:not(.btn-outline) {color: #fff;background-color: #e7505a;border-color: #e7505a;}
.btn.red:not(.btn-outline).active, .btn.red:not(.btn-outline):active, .btn.red:not(.btn-outline):hover, .open>.btn.red:not(.btn-outline).dropdown-toggle {color: #fff;background-color: #e12330;border-color: #dc1e2b;}
.btn.dark:not(.btn-outline) {color: #FFF;background-color: #2f353b;border-color: #2f353b;}
.btn.dark:not(.btn-outline).active, .btn.dark:not(.btn-outline):active, .btn.dark:not(.btn-outline):hover, .open>.btn.dark:not(.btn-outline).dropdown-toggle {color: #FFF;background-color: #181c1f;border-color: #141619;}
.btn.yellow:not(.btn-outline) {color: #fff;background-color: #c49f47;border-color: #c49f47;}
.btn.yellow:not(.btn-outline).active, .btn.yellow:not(.btn-outline):active, .btn.yellow:not(.btn-outline):hover, .open>.btn.yellow:not(.btn-outline).dropdown-toggle {color: #fff;background-color: #a48334;border-color: #9c7c32;}
.btn.blue:not(.btn-outline) {color: #FFF;background-color: #3598dc;border-color: #3598dc;}
.btn.blue:not(.btn-outline).active, .btn.blue:not(.btn-outline):active, .btn.blue:not(.btn-outline):hover, .open>.btn.blue:not(.btn-outline).dropdown-toggle {color: #FFF;background-color: #217ebd;border-color: #1f78b5;}
</style>
<script type="text/javascript" src="<?php echo JS_PATH?>layer/layer.js"></script>
<script type="text/javascript">
var syncing = 0;
function sync_web(id) {
	if (syncing == 1) {
		layer.msg('<i class="fa fa-times-circle"></i>&nbsp;&nbsp;<?php echo L('sync_server')?>', {time: 3000});
		return;
	}
	syncing = 1;
	$('#sync_html_'+id).html('<font color="blue"><?php echo L('sync_server_data')?></font>');
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "<?php echo APP_PATH?>index.php?m=fclient&c=fclient&a=sync_web&id="+id+"&pc_hash="+pc_hash,
		success: function(json) {
			if (json.code) {
				$('#sync_html_'+id).html('<font color="green">'+json.msg+'</font>');
			} else {
				layer.open({
					type: 1,
					title: '<?php echo L('sync_fail')?>',
					closeBtn: 0, //不显示关闭按钮
					shadeClose : true,
					scrollbar: false,
					content: '<div style="padding: 30px;">'+json.msg+'</div>'
				});
				$('#sync_html_'+id).html('<font color="red"><?php echo L('sync_fail')?></font>');
			}
			syncing = 0;
		},
		error: function(HttpRequest, ajaxOptions, thrownError) {
			//alert(HttpRequest.responseText);
			$('#sync_html_'+id).html('<font color="red"><?php echo L('sync_server_not')?></font>');
			syncing = 0;
		}
	});
}
</script>
<div class="pad-lr-10">
<div class="table-list">
<form name="searchform" action="" method="get" >
<input type="hidden" value="fclient" name="m">
<input type="hidden" value="fclient" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<div class="explain-col search-form">
<select name="field" class="form-control">
	<option value="uid"<?php if ($_GET['field']=='uid') echo ' selected'?>>UID</option>
	<option value="username"<?php if ($_GET['field']=='username') echo ' selected'?>><?php echo L('username')?></option>
	<option value="name"<?php if ($_GET['field']=='name') echo ' selected'?>><?php echo L('name')?></option>
	<option value="domain"<?php if ($_GET['field']=='domain') echo ' selected'?>><?php echo L('domain')?></option>
	<option value="sn"<?php if ($_GET['field']=='sn') echo ' selected'?>><?php echo L('sn')?></option>
	<option value="money"<?php if ($_GET['field']=='money') echo ' selected'?>><?php echo L('money')?></option>
	<option value="status"<?php if ($_GET['field']=='status') echo ' selected'?>><?php echo L('status')?></option>
	<option value="id"<?php if ($_GET['field']=='id') echo ' selected'?>> Id </option>
</select>
<input type="text" value="<?php echo $keyword?>" class="input-text" name="keyword">
<input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit">
</div>
</form>
<form name="myform" id="myform" action="?m=fclient&c=fclient" method="post">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="35" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('id[]');" />
                        <span></span>
                    </label></th>
			<th width="120"><?php echo L('uid')?></th>
			<th width="180"><?php echo L('name')?></th>
			<th width="120"><?php echo L('money')?></th>
			<th width="110"><?php echo L('model')?></th>
			<th width="90"><?php echo L('status')?></th>
			<th width='210'><?php echo L('notice_time')?></th>
			<th><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="id[]" value="<?php echo $info['id']?>" />
                        <span></span>
                    </label></td>
		<td align="center"><?php echo $user_arr[$info['uid']];?></td>
		<td><?php echo new_html_special_chars($info['name'])?></td>
		<td align="center"><?php echo $info['money'];?></td>
		<td align="center"><?php if(dr_string2array($info['setting'])['mode']){echo L('local_site');}else{echo L('remote_web_site');}?></td>
		<td align="center"><?php if($info['status']==1){echo L('no_check');}elseif($info['status']==2){echo L('check_2');}elseif($info['status']==3){echo L('check_3');}elseif($info['status']==4){echo L('check_4');}?></td>
		<td align="center"><?php if ($info['inputtime']) echo date('Y-m-d',$info['inputtime']);?> ~ <?php if ($info['endtime']) echo date('Y-m-d',$info['endtime']);?></td>
		<td><a href="javascript:;"
			onclick="edit(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['name']))?>')"
			title="<?php echo L('edit')?>" class="btn btn-xs green"> <i class="fa fa-edit"></i> <?php echo L('edit')?></a>
			<a target="_blank" href="<?php echo $info['domain']?>" class="btn btn-xs red"> <i class="fa fa-search"></i> <?php echo L('web_site')?></a>
			<a href="?m=fclient&c=fclient&a=sync_admin&id=<?php echo $info['id']?>" target="_blank" class="btn btn-xs dark"> <i class="fa fa-user"></i> <?php echo L('web_site_admin')?></a>
			<?php if(dr_string2array($info['setting'])['mode']){?>
			<a href="?m=fclient&c=fclient&a=update&id=<?php echo $info['id']?>" class="btn btn-xs yellow"> <i class="fa fa-download"></i> <?php echo L('update')?></a>
			<a href="javascript:sync_web('<?php echo $info['id']?>');" class="btn btn-xs blue"> <i class="fa fa-send"></i> <?php echo L('data_detection')?></a>
			<?php }else{?>
			<a href="?m=fclient&c=fclient&a=down&id=<?php echo $info['id']?>" class="btn btn-xs yellow"> <i class="fa fa-download"></i> <?php echo L('download')?></a>
			<a href="javascript:sync_web('<?php echo $info['id']?>');" class="btn btn-xs blue"> <i class="fa fa-send"></i> <?php echo L('send_data')?></a>
			<?php }?>
			<label id="sync_html_<?php echo $info['id']?>"></label>
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
<div class="btn"> 
<input type="button" class="button" name="dosubmit" onClick="document.myform.action='?m=fclient&c=fclient&a=delete';return confirm_delete()" value="<?php echo L('delete')?>"/></div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">
function edit(id, name) {
	artdialog('edit','?m=fclient&c=fclient&a=edit&id='+id,'<?php echo L('edit')?> '+name+' ',700,450);
}
function confirm_delete(){
	var str = 0;
	var id = tag = '';
	$("input[name='id[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1;
			id += tag+$(this).val();
			tag = '|';
		}
	});
	if(str==0) {
		Dialog.alert('<?php echo L('checked_the_info')?>');
		return false;
	}
	Dialog.confirm('<?php echo L('confirm')?>',function() {
		$('#myform').submit();
	});
}
</script>
</body>
</html>
