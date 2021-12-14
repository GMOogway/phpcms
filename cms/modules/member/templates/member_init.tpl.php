<?php defined('IS_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
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
<div class="pad-10">
<div class="common-form">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form contentWrap">
		<tr>
			<td width="120"><?php echo L('member_statistics')?></td> 
			<td>
				<?php echo L('member_totalnum')?>：<?php echo $memberinfo['totalnum']?>
				<?php echo L('member_todaynum')?>：<?php echo $memberinfo['today_member']?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('member_verify_totalnum')?></td> 
			<td>
				<?php echo $memberinfo['verifynum']?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('member_vip_totalnum')?></td> 
			<td>
				<?php echo $memberinfo['vipnum']?>
			</td>
		</tr>
	</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('member_search')?></legend>
<div class="bk10"></div>
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="m">
<input type="hidden" value="member" name="c">
<input type="hidden" value="manage" name="a">
<input type="hidden" value="<?php echo $this->input->get('menuid');?>" name="menuid">
<table width="100%" class="table_form contentWrap">
		<tr>
			<td width="120"><?php echo L('regtime')?></td> 
			<td><div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $start_time;?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $end_time;?>" name="end_time" id="end_time">
            </div>
        </div>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('member_group')?></td> 
			<td>
				<?php echo form::select($grouplist, $_GET['groupid'], 'name="groupid"', L('nolimit'))?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('status')?></td> 
			<td>
				<select name="status">
					<option value='0' <?php if(isset($_GET['status']) && $_GET['status']==0){?>selected<?php }?>><?php echo L('nolimit')?></option>
					<option value='1' <?php if(isset($_GET['status']) && $_GET['status']==1){?>selected<?php }?>><?php echo L('lock')?></option>
					<option value='2' <?php if(isset($_GET['status']) && $_GET['status']==2){?>selected<?php }?>><?php echo L('normal')?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('type')?></td> 
			<td>
				<select name="type">
					<option value='1' <?php if(isset($_GET['type']) && $_GET['type']==1){?>selected<?php }?>><?php echo L('username')?></option>
					<option value='2' <?php if(isset($_GET['type']) && $_GET['type']==2){?>selected<?php }?>><?php echo L('uid')?></option>
					<option value='3' <?php if(isset($_GET['type']) && $_GET['type']==3){?>selected<?php }?>><?php echo L('email')?></option>
					<option value='4' <?php if(isset($_GET['type']) && $_GET['type']==4){?>selected<?php }?>><?php echo L('regip')?></option>
				</select>
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('amount')?></td> 
			<td>
				<input name="amount_from" type="text" value="" class="input-text" size="4"/>-
				<input name="amount_to" type="text" value="" class="input-text" size="4"/>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('point')?></td> 
			<td>
				<input name="point_from" type="text" value="" class="input-text" size="4"/>-
				<input name="point_to" type="text" value="" class="input-text" size="4"/>
			</td>
		</tr>

</table>
<div class="bk15"></div>
<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
</form>
</fieldset>
</div>
</div>
</body>
</html>