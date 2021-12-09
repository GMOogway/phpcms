<?php
defined('IS_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form name="searchform" id="searchform" action="?m=admin&c=ipbanned&a=search_ip&menuid=<?php echo $this->input->get('menuid');?>" method="get"  >
<input type="hidden" value="admin" name="m">
<input type="hidden" value="ipbanned" name="c">
<input type="hidden" value="search_ip" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col">IP:  <input type="text" value="" class="input-text" id="ip" name="search[ip]">    <input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit">
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<form name="myform" id="myform" action="?m=admin&c=ipbanned&a=delete" method="post" onsubmit="checkuid();return false;">
<input name="dosubmit" type="hidden" value="1">
<div class="table-list">
 <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th align="center" class="myselect">
                    <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="group-checkable" value="" id="check_box" onclick="selectall('ipbannedid[]');" />
                        <span></span>
                    </label></th>
            <th width="200">IP</th>
            <th><?php echo L('deblocking_time')?></th> 
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
                        <input type="checkbox" class="checkboxes" name="ipbannedid[]" value="<?php echo $info['ipbannedid']?>" />
                        <span></span>
                    </label></td>
        <td align="left"><span  class="<?php echo $info['style']?>"><?php echo $info['ip']?></span> </td>
        <td align="center"><?php echo dr_date($info['expires'], 'Y-m-d', 'red');?></td>
         <td align="center"><a class="btn btn-xs red" href="javascript:confirmurl('?m=admin&c=ipbanned&a=delete&ipbannedid=<?php echo $info['ipbannedid']?>', '<?php echo L('confirm', array('message' => L('selected')))?>')"><?php echo L('delete')?></a> </td>
    </tr>
<?php
	}
}
?></tbody>
 </table>
</div>
<div class="list-footer table-checkable clear">
    <div class="col-md-7 list-select">
        <label class="mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline">
            <input type="checkbox" class="group-checkable" data-set=".checkboxes">
            <span></span>
        </label>
        <label><button type="button" onClick="Dialog.confirm('<?php echo L('confirm', array('message' => L('selected')))?>',function(){$('#myform').submit();});" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('remove_all_selected')?></button></label>
    </div>
    <div class="col-md-5 list-page"><?php echo $pages?></div>
</div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function checkuid() {
	var ids='';
	$("input[name='ipbannedid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		Dialog.alert("<?php echo L('before_select_operation')?>");
		return false;
	} else {
		myform.submit();
	}
}

function checkSubmit()
{
	if (searchform.ip.value=="")
	{
		searchform.ip.focus();
		Dialog.alert("<?php echo L('parameters_error')?>");
		return false;
	}
	else
	{
		if(searchform.ip.value.split(".").length!=4)
		{
			searchform.ip.focus();
			Dialog.alert("<?php echo L('ip_type_error')?>");
			return false;
		}
		else
		{
			for(i=0;i<searchform.ip.value.split(".").length;i++)

			{

				var ipPart;

				ipPart=searchform.ip.value.split(".")[i];

				if(isNaN(ipPart) || ipPart=="" || ipPart==null)

				{

					searchform.ip.focus();

					Dialog.alert("<?php echo L('ip_type_error')?>");

					return false;

				}

				else

				{

					if(ipPart/1>255 || ipPart/1<0)
					{
						searchform.ip.focus();
						Dialog.alert("<?php echo L('ip_type_error')?>");
						return false;
					}
				}
			}
		}
	}
}
</script>