<?php 
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<style type="text/css">
body {background-color: #fff;overflow-y: hidden;overflow-x: hidden;}
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content   main-content2">
                            <div class="page-body" style="margin-top:20px;margin-bottom:30px;">
<form class="form-horizontal" method="post" role="form" id="myform">
    <div class="form-body">
        <div class="form-group">
            <label class="col-xs-12 control-label "><?php echo L('原来的储存策略');?></label>
            <div class="col-xs-12">
                <label>
                    <select name="data[o]" class="form-control">
                        <option value="0"> <?php echo L('默认');?> </option>
                        <?php 
                        if (is_array($remote)) {
                        foreach ($remote as $t) {
                        ?>
                        <option value="<?php echo $t['id'];?>"><?php echo $t['name'];?></option>
                        <?php }} ?>
                    </select>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 control-label "><?php echo L('变更后的储存策略');?></label>
            <div class="col-xs-12">
                <label>
                    <select name="data[n]" class="form-control">
                        <option value="0"> <?php echo L('默认');?> </option>
                        <?php 
                        if (is_array($remote)) {
                        foreach ($remote as $t) {
                        ?>
                        <option value="<?php echo $t['id'];?>"><?php echo $t['name'];?></option>
                        <?php }} ?>
                    </select>
                </label>
                <p class="help-block"><?php echo L('需要手动将原来的储存附件复制到新的储存策略的目录中');?></p>
            </div>
        </div>

    </div>
</form>
</div>
</div>
</div>
</div>
</body>
</html>