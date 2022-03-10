<?php defined('IS_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="subnav">
    <?php if(is_mobile(0)) {?>
    <div class="content-menu ib-a">
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle on" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-th-large"></i> 菜单 <i class="fa fa-angle-double-down"></i></a>
            <ul class="dropdown-menu">
                <?php echo admin::submenu(115); ?>
            </ul>
        </li>
    </div>
    <?php } else {?>
    <div class="content-menu ib-a">
    <?php echo admin::submenu(115); ?>
    </div>
    <?php }?>
</div>
<div class="content-header"></div>
<div class="pad-lr-10">
<fieldset>
	<legend><?php echo L('the_new_publication_solutions')?></legend>
	<form name="myform" action="?" method="get" id="myform">
	
		<table width="100%" class="table_form">
			<tr>
			<td width="120"><?php echo L('category')?>：</td> 
			<td>
			<?php echo form::select_category('', '', 'name="catid"', L('please_choose'), 0, 0, 1)?>
			</td>
		</tr>
	</table>
	<input type="hidden" name="m" value="collection">
	<input type="hidden" name="c" value="node">
	<input type="hidden" name="a" value="import_program_add">
	<input type="hidden" name="nodeid" value="<?php if(isset($nodeid)) echo $nodeid?>">
	<input type="hidden" name="type" value="<?php echo $type?>">
	<input type="hidden" name="ids" value="<?php echo $ids?>">
	<input type="hidden" name="dosubmit" value="1">
	<label><button type="submit" class="btn blue btn-sm onloading" name="submit"> <i class="fa fa-save"></i> <?php echo L('submit')?></button></label>
	</form>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('publish_the_list')?></legend>
<form name="myform" action="?" method="get" >
<div class="bk15"></div>
<?php
	foreach($program_list as $k=>$v) {
		echo form::radio(array($v['id']=>$cat[$v['catid']]['catname']), '', 'name="programid"', 150);
?>
<span style="margin-right:10px;"><a href="?m=collection&c=node&a=import_program_del&id=<?php echo $v['id']?>" style="color:#ccc"><?php echo L('delete')?></a></span>
<?php
	}

?>
</fieldset>
	<input type="hidden" name="m" value="collection">
	<input type="hidden" name="c" value="node">
	<input type="hidden" name="a" value="import_content">
	<input type="hidden" name="nodeid" value="<?php if(isset($nodeid)) echo $nodeid?>">
	<input type="hidden" name="type" value="<?php echo $type?>">
	<input type="hidden" name="ids" value="<?php echo $ids?>">
	<input type="hidden" name="dosubmit" value="1">
	<label><button type="submit" class="btn green btn-sm onloading" name="submit"> <i class="fa fa-save"></i> <?php echo L('submit')?></button></label>
</div>
</form>
</div>
</body>
</html>