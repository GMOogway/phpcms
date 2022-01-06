<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="subnav">
<div class="content-menu ib-a blue">
<?php if($super_admin) {?>
<a href='?m=content&c=content&a=public_checkall&menuid=<?php echo $this->input->get('menuid');?>' class="on"><i class="fa fa-check"></i> <?php echo L('all_check_list');?></a>
<?php } else {
	echo '<a class="on"><i class="fa fa-check"></i> '.L('check_status').'</a>';
}
for ($j=0;$j<5;$j++) {
?>
<i class="fa fa-circle"></i><a href='?m=content&c=content&a=public_checkall&menuid=<?php echo $this->input->get('menuid');?>&status=<?php echo $j;?>' class="<?php if($status==$j) echo 'on';?>"><i class="fa fa-check"></i> <?php echo L('workflow_'.$j);?></a>
<?php }?>
</div>
</div>
<div class="content-header"></div>
<div class="pad-10">

<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
            <th width="60">ID</th>
			<th><?php echo L('title');?></th>
            <th><?php echo L('select_model_name');?></th>
            <th width="110"><?php echo L('current_steps');?></th>
            <th width="80"><?php echo L('steps');?></th>
            <th width="100"><?php echo L('belong_category');?></th>
            <th width="180"><?php echo L('contribute_time');?></th>
            <th><?php echo L('username');?></th>
			<th><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
<tbody>
    <?php
	$model_cache = getcache('model','commons');
	foreach ($datas as $r) {
		$arr_checkid = explode('-',$r['checkid']);

		$workflowid = $this->categorys[$r['catid']]['workflowid'];
		if($stepid = $workflows[$workflowid]['steps']) {
			$stepname = L('steps_'.$stepid);
		} else {
			$stepname = '';
		}
		$modelname = $model_cache[$arr_checkid[2]]['name'];
		$flowname = L('workflow_'.$r['status']);
	?>
        <tr>
		<td align='center' ><?php echo $arr_checkid[1];?></td>
		<td align='left' ><a href="javascript:;" onclick='change_color(this);window.open("?m=content&c=content&a=public_preview&steps=<?php echo $r['status']?>&catid=<?php echo $r['catid'];?>&id=<?php echo $arr_checkid[1];?>&pc_hash=<?php echo dr_get_csrf_token();?>","manage")'><?php echo $r['title'];?></a></td>
		<td align='center' ><?php echo $modelname;?></td>
		<td align='center' ><?php echo $flowname;?></td>
		<td align='center' ><?php echo $stepname;?></td>
		<td align='center' ><a href="?m=content&c=content&a=init&menuid=<?php echo $this->input->get('menuid');?>&catid=<?php echo $r['catid'];?>"><?php echo $this->categorys[$r['catid']]['catname'];?></a></td>
		<td align='center' ><?php echo dr_date($r['inputtime'], null, 'red');?></td>
		<td align='center'>
		<?php
		if($r['sysadd']==0) {
			echo "<a href='?m=member&c=member&a=memberinfo&username=".urlencode($r['username'])."' >".$r['username']."</a>"; 
			echo '<img src="'.IMG_PATH.'icon/contribute.png" title="'.L('member_contribute').'">';
		} else {
			echo $r['username'];
		}
		?></td>
		<td align='center'><a href="javascript:;" onclick='change_color(this);window.open("?m=content&c=content&a=public_preview&steps=<?php echo $r['status']?>&catid=<?php echo $r['catid'];?>&id=<?php echo $arr_checkid[1];?>&pc_hash=<?php echo dr_get_csrf_token();?>","manage")'><?php echo L('c_check');?></a></td>
	</tr>
     <?php }?>
</tbody>
     </table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-5 col-sm-5 table-footer-button"></div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript"> 
<!--
window.top.$("#current_pos_attr").html('<?php echo L('checkall_content');?>');
function change_color(obj) {
	$(obj).css('color','red');
}
//-->
</script>
</body>
</html>