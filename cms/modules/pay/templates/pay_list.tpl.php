<?php 
	defined('IS_ADMIN') or exit('No permission resources.');
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
<div class="pad_10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="pay" name="m">
<input type="hidden" value="payment" name="c">
<input type="hidden" value="pay_list" name="a">
<input type="hidden" name="dosubmit" value="1">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<div class="explain-col search-form">
<?php echo L('order_sn')?> <label><input type="text" value="<?php echo $trade_sn?>" class="input-text" name="info[trade_sn]"></label> 
<?php echo L('username')?> <label><input type="text" value="<?php echo $username?>" class="input-text" name="info[username]"></label>
<?php echo L('addtime')?> <label><div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $start_addtime;?>" name="info[start_addtime]">
                <span class="input-group-addon"> <?php echo L('to')?> </span>
                <input type="text" class="form-control" value="<?php echo $end_addtime;?>" name="info[end_addtime]">
            </div>
        </div></label>
<?php echo form::select($trade_status,$status,'name="info[status]"', L('all_status'))?>
<label><button type="submit" class="btn blue btn-sm onloading" name="submit"> <i class="fa fa-search"></i> <?php echo L('search')?></button></label>
</div>
</form>
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%"><?php echo L('username')?></th>
            <th width="20%"><?php echo L('order_sn')?></th>
            <th width="15%"><?php echo L('order_time')?></th>
            <th width="9%"><?php echo L('business_mode')?></th>
            <th width="8%"><?php echo L('payment_mode')?></th>
            <th width="8%"><?php echo L('deposit_amount')?></th>
            <th width="10%"><?php echo L('pay_status')?></th>
            <th width="20%"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	$sum_amount = $sum_amount_succ = $sum_point_succ = $sum_point = '0';
	foreach($infos as $info){
		if($info['type'] == 1) {
			$num_amount++;
			$sum_amount += $info['money']; 
			if($info['status'] =='succ') $sum_amount_succ += $info['money'];
		}  elseif ($info['type'] == 2) {
			$num_point++;
			$sum_point += $info['money']; 
			if($info['status'] =='succ') $sum_point_succ += $info['money'];
		}
		
?>   
	<tr>
	<td width="10%" align="center"><?php echo $info['username']?></td>
	<td width="20%" align="center"><?php echo $info['trade_sn']?> <a href="javascript:void(0);" onclick="detail('<?php echo $info['id']?>', '<?php echo $info['trade_sn']?>')"><img src="<?php echo IMG_PATH?>admin_img/detail.png"></a></td>
	<td  width="15%" align="center"><?php echo date('Y-m-d H:i:s',$info['addtime'])?></td>
	<td width="9%" align="center"><?php echo L($info['pay_type'])?></td>
	<td width="8%" align="center"><?php echo $info['payment']?></td>
	<td width="8%" align="center"><?php echo $info['money']?> <?php echo ($info['type']==1) ? L('yuan') : L('dian')?></td>
	<td width="10%" align="center"><?php echo L($info['status'])?> </a>
	<td width="20%" align="center">
	<?php if($info['status'] =='succ' || $info['status'] =='error' || $info['status'] =='failed' ||$info['status'] =='timeout' || $info['status'] =='cancel') {?>
	<font color="#cccccc"><?php echo L('change_price')?>  | <?php echo L('closed')?>  |</font> <a href="javascript:confirmurl('?m=pay&c=payment&a=pay_del&id=<?php echo $info['id']?>&menuid=<?php echo $_GET['menuid']?>', '<?php echo L('trade_record_del')?>')"><?php echo L('delete')?></a>
	<?php } elseif($info['status'] =='waitting' ) {?>
	<a href="javascript:confirmurl('?m=pay&c=payment&a=public_check&id=<?php echo $info['id']?>', '<?php echo L('check_confirm',array('sn'=>$info['trade_sn']))?>')"><?php echo L('check')?></a> | <a href="?m=pay&c=payment&a=pay_cancel&id=<?php echo $info['id']?>"><?php echo L('closed')?></a>  | <a href="javascript:confirmurl('?m=pay&c=payment&a=pay_del&id=<?php echo $info['id']?>&menuid=<?php echo $_GET['menuid']?>', '<?php echo L('trade_record_del')?>')"><?php echo L('delete')?></a>
	<?php } else {?>
	<a href="javascript:void(0);" onclick="discount('<?php echo $info['id']?>', '<?php echo $info['trade_sn']?>')"><?php echo L('change_price')?></a> | <a href="?m=pay&c=payment&a=pay_cancel&id=<?php echo $info['id']?>"><?php echo L('closed')?></a>  | <a href="javascript:confirmurl('?m=pay&c=payment&a=pay_del&id=<?php echo $info['id']?>&menuid=<?php echo $_GET['menuid']?>', '<?php echo L('trade_record_del')?>')"><?php echo L('delete')?></a>
	

	<?php }?>
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
    <div class="col-md-5 col-sm-5 table-footer-button"><?php echo L('thispage').L('totalize')?>  <span class="font-fixh green"><?php echo $number?></span> <?php echo L('bi').L('trade')?>(<?php echo L('money')?>：<span class="font-fixh"><?php echo $num_amount?></span><?php echo L('bi')?>，<?php echo L('point')?>：<span class="font-fixh"><?php echo $num_point?></span><?php echo L('bi')?>)，<?php echo L('total').L('amount')?>：<span class="font-fixh green"><?php echo $sum_amount?></span><?php echo L('yuan')?> ,<?php echo L('trade_succ').L('trade')?>：<span class="font-fixh green"><?php echo $sum_amount_succ?></span><?php echo L('yuan')?> ，总点数：<span class="font-fixh green"><?php echo $sum_point?></span><?php echo L('dian')?> ,<?php echo L('trade_succ').L('trade')?>：<span class="font-fixh green"><?php echo $sum_point_succ?></span><?php echo L('dian')?></div>
    <div class="col-md-7 col-sm-7 text-right"><?php echo $pages?></div>
</div>
</div>
</form>
</body>
</html>
<script type="text/javascript">
<!--
function discount(id, name) {
	artdialog('discount','?m=pay&c=payment&a=discount&id='+id,'<?php echo L('discount')?>--'+name,500,200);
}
function detail(id, name) {
	omnipotent('discount','?m=pay&c=payment&a=public_pay_detail&id='+id,'<?php echo L('discount')?>--'+name,1,500,550);
}
//-->
</script>