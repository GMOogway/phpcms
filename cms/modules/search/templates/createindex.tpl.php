<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-10">
<div class="explain-col">
<form action="" method="get">
<input type="hidden" name="m" value="search">
<input type="hidden" name="c" value="search_admin">
<input type="hidden" name="a" value="createindex">
<input type="hidden" name="menuid" value="63">
<input type="hidden" name="dosubmit" value="1">
    <?php echo L('re_index_note');?> 
    <label><input type="text" name="pagesize" value="100" size="5"></label>
    <label><?php echo L('tiao');?></label>
    <label><button type="submit" class="btn green btn-sm onloading" name="submit"> <i class="fa fa-refresh"></i> <?php echo L('confirm_reindex')?></button></label>
</form>
</div>
</body>
</html>