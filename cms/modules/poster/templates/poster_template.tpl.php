<?php 
defined('IS_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = true; 
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
    <?php if(is_mobile(0)) {?>
    <div class="content-menu btn-group dropdown-btn-group"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-th-large"></i> 菜单 <i class="fa fa-angle-down"></i></a>
        <ul class="dropdown-menu">
            <?php if(isset($big_menu)) { echo '<li><a class="add fb" href="'.$big_menu[0].'"><i class="fa fa-plus"></i> '.$big_menu[1].'</a></li><div class="dropdown-line"></div>';} else {$big_menu = '';} ?>
            <?php echo admin::submenu($this->input->get('menuid'),$big_menu); ?>
            <div class="dropdown-line"></div>
            <li><a href="javascript:artdialog('setting','?m=poster&c=space&a=setting','<?php echo L('module_setting')?>',540,320);void(0);"><i class="iconm fa fa-cog"></i> <?php echo L('module_setting')?></a></li>
        </ul>
    </div>
    <?php } else {?>
    <div class="content-menu ib-a">
    <?php if(isset($big_menu)) { echo '<a class="add fb" href="'.$big_menu[0].'"><i class="fa fa-plus"></i> '.$big_menu[1].'</a><i class="fa fa-circle"></i>';} else {$big_menu = '';} ?>
    <?php echo admin::submenu($this->input->get('menuid'),$big_menu); ?><i class="fa fa-circle"></i><a href="javascript:artdialog('setting','?m=poster&c=space&a=setting','<?php echo L('module_setting')?>',540,320);void(0);"><i class="iconm fa fa-cog"></i> <?php echo L('module_setting')?></a>
    </div>
    <?php }?>
</div>
<div class="content-header"></div>
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
	<a class="btn btn-xs green" href="javascript:<?php if ($poster_template[$info]['iscore']) {?>check<?php } else {?>edit<?php }?>('<?php echo new_addslashes(new_html_special_chars($info))?>', '<?php echo new_addslashes(new_html_special_chars($poster_template[$info]['name']))?>');void(0);"><?php if ($poster_template[$info]['iscore']) { echo L('check_template'); } else { echo L('setting_template'); }?></a> <a class="btn btn-xs red" href="?m=poster&c=space&a=public_tempate_del&id=<?php echo $info?>"><?php echo L('delete')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>  </div>
<div class="list-footer table-checkable clear">
    <div class="col-md-5 col-sm-5 table-footer-button"></div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $this->pages?></div>
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