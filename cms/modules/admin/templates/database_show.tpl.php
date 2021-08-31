<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<style type="text/css">
body {color: #333;padding: 0!important;margin: 0!important;font-size: 14px;}
th {text-align: left;}
.page-container {margin: 0;padding: 0;position: relative;}
.page-container:after, .page-container:before {content: " ";display: table;}
.page-content-wrapper {float: left;width: 100%;}
.page-content-wrapper .page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.page-content3 {margin-left: 0px !important;border-left: 0 !important;}
.main-content2 {background: #fff!important;}
.main-content {background: #f5f6f8;}
.main-content {background: #fff;}
.page-content {margin-top: 0;padding: 0;}
</style>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content   main-content2">
                            <div class="page-body" style="padding-top:17px;margin-bottom:30px;">
                <div style="margin-top: -20px"><span style="padding-left: 10px"><?php echo $tables;?></span></div>
    <div class="table-list">
        <table class="table table-striped table-bordered table-hover table-checkable dataTable">
            <thead>
            <tr class="heading">
                <th width="140" style="text-align: left;padding-left:9px"><?php echo L('字段');?></th>
                <th width="150"><?php echo L('描述');?></th>
                <th><?php echo L('类型');?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($structure as $i=>$t) {?>
            <tr class="odd gradeX">
                <td style="text-align: left;padding-left:9px"><?php echo $t['Field'];?></td>
                <td><?php echo ($t['Comment'] ? $t['Comment'] : $t['Field']);?></td>
                <td><?php echo $t['Type'];?></td>
            </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>
</body>
</html>