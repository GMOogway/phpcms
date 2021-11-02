<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>
<style type="text/css">
body .table-list table tr>td:first-child, body .table-list table tr>th:first-child {text-align: left;padding: 8px;}
</style>
<div class="subnav">
  <h1 class="title-2 line-x"><?php echo $this->style_info['name'].' - '.L('detail')?></h1>
</div>
<div class="pad-lr-10">
<form action="?m=template&c=file&a=updatefilename&style=<?php echo $this->style?>" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th align="left" ><?php echo L("dir")?></th>
		<th align="left" ><?php echo L('desc')?></th>
		<th align="left" ><?php echo L('operation')?></th>
		</tr>
        </thead>
<tbody>
<tr>
<td align="left" colspan="3"><?php echo L("local_dir")?>：<?php echo $local?></td>
</tr>
<?php if ($dir !='' && $dir != '.'):?>
<tr>
<td align="left" colspan="3"><a href="<?php echo '?m=template&c=file&a=init&style='.$this->style.'&dir='.stripslashes(dirname($dir))?>"><img src="<?php echo IMG_PATH?>folder-closed.gif" /><?php echo L("parent_directory")?></a></td>
</tr>
<?php endif;?>
<?php 
if(is_array($list)):
	foreach($list as $v):
	$filename = basename($v);
?>
<tr>
<?php if (is_dir($v)) {
	echo '<td align="left"><img src="'.IMG_PATH.'folder-closed.gif" /> <a href="?m=template&c=file&a=init&style='.$this->style.'&dir='.(isset($_GET['dir']) && !empty($_GET['dir']) ? stripslashes($_GET['dir']).DIRECTORY_SEPARATOR : '').$filename.'"><b>'.$filename.'</b></a></td><td align="left"><input type="text" name="file_explan['.$encode_local.']['.$filename.']" value="'.(isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "").'"></td><td></td>';
} else {
 	if (substr($filename,-4,4) == 'html') {
 		echo '<td align="left"><img src="'.IMG_PATH.'file.gif" /> '.$filename.'</td><td align="left"><input type="text" name="file_explan['.$encode_local.']['.$filename.']" value="'.(isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "").'"></td>';
		if($tpl_edit=='1'){
			echo '<td> <a class="btn btn-xs green" href="?m=template&c=file&a=edit_file&style='.$this->style.'&dir='.urlencode(stripslashes($dir)).'&file='.$filename.'">'.L('edit').'</a> <a class="btn btn-xs blue" href="?m=template&c=file&a=visualization&style='.$this->style.'&dir='.urlencode(stripslashes($dir)).'&file='.$filename.'" target="_blank">'.L('visualization').'</a> <a class="btn btn-xs dark" href="javascript:history_file(\''.$filename.'\')">'.L('histroy').'</a></td>';
		}else{
			echo '<td></td>';
		}
 	}
}?>
</tr>
<?php 
	endforeach;
endif;
?></tbody>
</table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label><button type="button" onclick="location.href='?m=template&c=style&a=init&pc_hash=<?php echo dr_get_csrf_token();?>'" class="btn yellow btn-sm"> <i class="fa fa-mail-reply-all"></i> <?php echo L('returns_list_style')?></button></label>
        <label><button type="button" onclick="add_file()" class="btn blue btn-sm"> <i class="fa fa-plus"></i> <?php echo L('new')?></button></label>
        <label><button type="submit" class="btn green btn-sm"> <i class="fa fa-refresh"></i> <?php echo L('update')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--

function history_file(name) {
	var w = 700;
	var h = 520;
	if (is_mobile()) {
		w = h = '100%';
	}
	var diag = new Dialog({
		id:'history',
		title:'《'+name+'》<?php echo L("histroy")?>',
		url:'<?php echo SELF;?>?m=template&c=template_bak&a=init&style=<?php echo $this->style;?>&dir=<?php echo urlencode(stripslashes($dir))?>&filename='+name+'&pc_hash='+pc_hash,
		width:w,
		height:h,
		modal:true
	});
	diag.onOk = function(){
		diag.close();
	};
	diag.onCancel=function() {
		$DW.close();
	};
	diag.show();
}

function add_file() {
	artdialog('add_file','?m=template&c=file&a=add_file&style=<?php echo $this->style;?>&dir=<?php echo urlencode(stripslashes($dir))?>','<?php echo L("new")?>',500,300);
}
//-->
</script>
</body>
</html>