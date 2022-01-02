<?php 
defined('IS_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = true; 
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php if(isset($big_menu)) echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';?>
    <?php echo admin::submenu($_GET['menuid'],$big_menu); ?><span>|</span><a href="javascript:artdialog('setting','?m=poster&c=space&a=setting','<?php echo L('module_setting')?>',540,320);void(0);"><em><?php echo L('module_setting')?></em></a>
    </div>
</div>
<div class="pad-lr-10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="200" align="center"><?php echo L('template_name')?></th>
			<th align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($templates)){
	foreach($templates as $info){
?>   
	<tr>
	<td><?php if ($poster_template[$info]['name']) { echo $poster_template[$info]['name'].' ('.$info.')'; } else { echo $info; }?></td>
	<td align="center">
	<a class="btn btn-xs green" href="javascript:<?php if ($poster_template[$info]['iscore']) {?>check<?php } else {?>edit<?php }?>('<?php echo addslashes(new_html_special_chars($info))?>', '<?php echo addslashes(new_html_special_chars($poster_template[$info]['name']))?>');void(0);"><?php if ($poster_template[$info]['iscore']) { echo L('check_template'); } else { echo L('setting_template'); }?></a> <a class="btn btn-xs red" href="?m=poster&c=space&a=public_tempate_del&id=<?php echo $info?>"><?php echo L('delete')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>  </div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select"></div>
    <div class="col-md-5 list-page"><?php echo $this->pages?></div>
</div>
</div>
<script type="text/javascript">
<!--
function edit(id, name) {
	artdialog('testIframe','?m=poster&c=space&a=public_tempate_setting&template='+id,name,540,360);
};

function check(id, name) {
	omnipotent('testIframe',name,'<?php echo SELF;?>?m=poster&c=space&a=public_tempate_setting&template='+id+'&pc_hash='+pc_hash,1,540,360);
}
//-->
</script>
</body>
</html>