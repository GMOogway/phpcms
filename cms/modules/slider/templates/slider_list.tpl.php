<?php
defined('IS_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
<div class="right-card-box">
    <div class="row table-search-tool">
	<div class="col-md-12 col-sm-12">
		<label>位置</label>
        <label><i class="fa fa-caret-right"></i></label>
		<?php
	if(is_array($type_arr)){
	foreach($type_arr as $typeid => $type){
		?><label><a href="?m=slider&c=slider&typeid=<?php echo $typeid;?>"><?php echo $type;?></a></label>
		<?php }}?></label>
</div>
</div>
<form name="myform" id="myform" action="?m=slider&c=slider&a=listorder" method="post">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('id[]');" />
                        <span></span>
                    </label></th>
			<th width="80"><?php echo L('listorder')?></th>
			<th><?php echo L('slider_name')?></th>
			<th width="100"><?php echo L('image')?></th>
			<th width="100"><?php echo L('url')?></th>
			<th width='100'><?php echo L('typeid')?></th>
			<th width="100"><?php echo L('status')?></th>
			<th width="160"><?php echo L('slider_adddate')?></th>
			<th><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="id[]" value="<?php echo $info['id']?>" />
                        <span></span>
                    </label></td>
		<td><input name='listorders[<?php echo $info['id']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c"></td>
		<td><?php if ($info['url']!="#" && $info['url']){?><a href="<?php echo $info['url'];?>" title="<?php echo $info['name']?>" target="_blank"><?php }?><?php echo $info['name']?><?php if ($info['url']!="#" && $info['url']){?></a><?php }?></td>
		<td><a href="javascript:preview('<?php echo $info['image']?>')" title="<?php echo $info['description'];?>"><img src="<?php echo $info['image'];?>" height=60></a></td>
		<td align="center"><?php if ($info['url']!="#" && $info['url']){?><a class="btn btn-xs yellow" href="<?php echo $info['url'];?>" target="_blank">点击查看</a><?php }else{?>无<?php }?></td>
		<td align="center"><?php echo $type_arr[$info['typeid']];?></td>
		<td align="center"><?php if($info['isshow']=='0'){ echo "不显示";}else{echo "显示";}?></td>
		<td align="center"><?php echo dr_date($info['addtime'], null, 'red');?></td>
		<td><a class="btn btn-xs green" href="###"
			onclick="edit(<?php echo $info['id']?>, '<?php echo new_addslashes($info['name'])?>')"
			title="<?php echo L('edit')?>"><?php echo L('edit')?></a> <a class="btn btn-xs red"
			href='###'
			onClick="Dialog.confirm('<?php echo L('confirm', array('message' => new_addslashes($info['name'])))?>',function(){redirect('?m=slider&c=slider&a=delete&id=<?php echo $info['id']?>&pc_hash='+pc_hash);});"><?php echo L('delete')?></a> 
		</td>
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
        <label><button type="submit" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('listorder')?></button></label>
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('confirm', array('message' => L('selected')))?>',function(){document.myform.action='?m=slider&c=slider&a=delete';$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('delete')?></button></label>
    </div>
    <div class="col-md-7 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function edit(id, name) {
	artdialog('edit','?m=slider&c=slider&a=edit&id='+id,'<?php echo L('edit')?> '+name+' ',700,450);
}
function checkuid() {
	var ids='';
	$("input[name='id[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		Dialog.alert("<?php echo L('before_select_operations')?>");
		return false;
	} else {
		myform.submit();
	}
}
//向下移动
function listorder_up(id) {
	$.get('?m=slider&c=slider&a=listorder_up&id='+id,null,function (msg) { 
	if (msg==1) { 
	//$("div [id=\'option"+id+"\']").remove(); 
		Dialog.alert('<?php echo L('move_success')?>');
	} else {
	Dialog.alert(msg); 
	} 
	}); 
} 
function preview(file) {
	if(IsImg(file)) {
        var width = 400;
        var height = 300;
        var att = 'width: 350px;height: 260px;';
        if (is_mobile()) {
            width = height = '90%';
            var att = 'height: 90%;';
        }
        var diag = new Dialog({
            title:'<?php echo L('预览')?>',
            html:'<style type="text/css">a{text-shadow: none; color: #337ab7; text-decoration:none;}a:hover{cursor: pointer; color: #23527c; text-decoration: underline;}</style><div style="'+att+'line-height: 24px;word-break: break-all;overflow: hidden auto;"><p style="word-break: break-all;text-align: center;margin-bottom: 20px;"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center;"><a href="'+file+'" target="_blank"><img style="max-width:100%" src="'+file+'"></a></p></div>',
            width:width,
            height:height,
            modal:true
        });
		diag.show();
	} else {
        var diag = new Dialog({
            title:'<?php echo L('预览')?>',
            html:'<style type="text/css">a{text-shadow: none; color: #337ab7; text-decoration:none;}a:hover{cursor: pointer; color: #23527c; text-decoration: underline;}</style><p style="text-align: center;word-break: break-all;margin-bottom: 20px;"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center;"><a href="'+file+'" target="_blank"><i class="fa fa-download"></i> <?php echo L('click_open')?></a></p>',
            modal:true
        });
		diag.show();
	}
}
function IsImg(url){
	  var sTemp;
	  var b=false;
	  var opt="jpg|gif|png|bmp|jpeg|webp";
	  var s=opt.toUpperCase().split("|");
	  for (var i=0;i<s.length ;i++ ){
	    sTemp=url.substr(url.length-s[i].length-1);
	    sTemp=sTemp.toUpperCase();
	    s[i]="."+s[i];
	    if (s[i]==sTemp){
	      b=true;
	      break;
	    }
	  }
	  return b;
}
</script>
</body>
</html>