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
<div class="table-list">
<form name="searchform" action="" method="get" >
<input type="hidden" value="pay" name="m">
<input type="hidden" value="payment" name="c">
<input type="hidden" value="pay_stat" name="a">
<input type="hidden" name="dosubmit" value="1">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">

<div class="explain-col search-form">
    <?php echo L('username')?> <label><input type="text" value="<?php echo $username?>" class="input-text" name="info[username]"></label>
    <?php echo form::select($trade_status,$status,'name="info[status]"', L('all_status'))?>
    <label><div class="formdate">
        <div class="input-group input-medium date-picker input-daterange">
            <input type="text" class="form-control" value="<?php echo $start_addtime;?>" name="info[start_addtime]">
            <span class="input-group-addon"> <?php echo L('to')?> </span>
            <input type="text" class="form-control" value="<?php echo $end_addtime;?>" name="info[end_addtime]">
        </div>
    </div></label>
    <label><button type="submit" class="btn blue btn-sm onloading" name="submit"> <i class="fa fa-search"></i> <?php echo L('search')?></button></label>
</div>

</form>
<fieldset>
	<legend><?php echo L('finance').L('totalize')?></legend>
	<table width="100%" class="table_form">
  <tbody>
  <tr>
    <th width="80"><?php echo L('total').L('transactions')?></th>
    <td class="y-bg"><?php echo L('money')?>&nbsp;&nbsp;<span class="font-fixh green"><?php echo $total_amount_num?></span> <?php echo L('bi')?>（<?php echo L('trade_succ').L('trade')?>&nbsp;&nbsp;<span class="font-fixh"><?php echo $total_amount_num_succ?></span> <?php echo L('bi')?>）<br/><?php echo L('point')?>&nbsp;&nbsp;<span class="font-fixh green"><?php echo $total_point_num?></span> <?php echo L('bi')?>（<?php echo L('trade_succ').L('trade')?>&nbsp;&nbsp;<span class="font-fixh"><?php echo $total_point_num_succ?></span> <?php echo L('bi')?>）</td>
  </tr>   
  <tr>
    <th width="80"><?php echo L('total').L('amount')?></th>
    <td class="y-bg"><span class="font-fixh green"><?php echo $total_amount?></span> <?php echo L('yuan')?>（<?php echo L('trade_succ').L('trade')?>&nbsp;&nbsp;<span class="font-fixh"><?php echo $total_amount_succ?></span><?php echo L('yuan')?>）<br/><span class="font-fixh green"><?php echo $total_point?></span><?php echo L('dian')?>（<?php echo L('trade_succ').L('trade')?>&nbsp;&nbsp;<span class="font-fixh"><?php echo $total_point_succ?></span><?php echo L('dian')?>）</td>
  </tr>
</table>
</fieldset>
<div class="bk10"></div>
<fieldset>
	<legend><?php echo L('query_stat')?></legend>
	<table width="100%" class="table_form">
  <tbody>
  <?php if($num) {?>
  <tr>
    <th width="80"><?php echo L('total_transactions')?>：</th>
    <td class="y-bg"><?php echo L('money')?>：<span class="font-fixh green"><?php echo $amount_num?></span> <?php echo L('bi')?>（<?php echo L('transactions_success')?>：<span class="font-fixh"><?php echo $amount_num_succ?></span> <?php echo L('bi')?>）<br/><?php echo L('point')?>：<span class="font-fixh green"><?php echo $point_num?></span> <?php echo L('bi')?>（<?php echo L('transactions_success')?>：<span class="font-fixh"><?php echo $point_num_succ?></span> <?php echo L('bi')?>）</td>
  </tr>   
  <tr>
    <th width="80"><?php echo L('total').L('amount')?>：</th>
    <td class="y-bg"><span class="font-fixh green"><?php echo $amount?></span><?php echo L('yuan')?>（<?php echo L('transactions_success')?>：<span class="font-fixh"><?php echo $amount_succ?></span><?php echo L('yuan')?>）<br/><span class="font-fixh green"><?php echo $point?></span><?php echo L('dian')?>（<?php echo L('transactions_success')?>：<span class="font-fixh"><?php echo $point_succ?></span><?php echo L('dian')?>）</td>
  </tr>
  <?php }?>
</table>
</fieldset>
</div>
</div>
</form>
</body>
</html>
<script type="text/javascript">
<!--
function discount(id, name) {
	artdialog('discount','?m=pay&c=payment&a=public_discount&id='+id,'<?php echo L('discount')?>--'+name,500,200);
}
function detail(id, name) {
	omnipotent('discount','?m=pay&c=payment&a=public_pay_detail&id='+id,'<?php echo L('discount')?>--'+name,1,500,550);
}
//-->
</script>