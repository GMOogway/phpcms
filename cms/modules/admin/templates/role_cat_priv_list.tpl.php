<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<form action="?m=admin&c=role&a=setting_cat_priv&roleid=<?php echo $roleid?>&siteid=<?php echo $siteid?>&op=2" method="post">
<div class="table-list" id="load_priv">
<table width="100%">
			  <thead>
				<tr>
				  <th width="60"><label class='mt-table mt-checkbox mt-checkbox-single mt-checkbox-outline'><input type='checkbox' class='group-checkable' value='' onclick='select_all(0, this)'><span></span></label></th><th align="left"><?php echo L('title_varchar')?></th><th width="60"><?php echo L('view')?></th><th width="60"><?php echo L('add')?></th><th width="60"><?php echo L('edit')?></th><th width="60"><?php echo L('delete')?></th><th width="60"><?php echo L('sort')?></th><th width="60"><?php echo L('push')?></th><th width="60"><?php echo L('move')?></th><th width="60"><?php echo L('copy')?></th><th width="60"><?php echo L('recycle')?></th><th width="60"><?php echo L('restore')?></th><th width="60"><?php echo L('update')?></th>
			  </tr>
			    </thead>
				 <tbody>
				<?php echo $categorys?>
			 </tbody>
			</table>
</div>
<div class="btn"><input type="submit" value="<?php echo L('submit')?>" class="button"></div>
</form>
<script type="text/javascript">
function select_all(name, obj) {
    if (obj.checked) {
        if (name == 0) {
			$.each($("input[type='checkbox']"),function(i,rs){
				if($(this).attr('disabled') != 'disabled'){
					$(this).attr('checked', 'checked');
				}
			});
            //$("input[type='checkbox']").attr('checked', 'checked');
        } else {
			$.each($("input[type='checkbox'][name='priv[" + name + "][]']"),function(i,rs){
				if($(this).attr('disabled') != 'disabled'){
					$(this).attr('checked', 'checked');
				}
			});
            //$("input[type='checkbox'][name='priv[" + name + "][]']").attr('checked', 'checked');
        }
    } else {
        if (name == 0) {
            $("input[type='checkbox']").attr('checked', null);
        } else {
            $("input[type='checkbox'][name='priv["+name+"][]']").removeAttr('checked');
        }
    }
}
</script>
</body>
</html>
