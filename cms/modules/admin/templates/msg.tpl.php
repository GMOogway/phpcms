<?php defined('IS_ADMIN') or exit('No permission resources.');?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<title><?php echo $meta_title ? $meta_title : L('message_tips');?></title>
<meta name="author" content="zhaoxunzhiyin" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<link href="<?php echo CSS_PATH?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>admin/css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>Dialog/main.js"></script>
<script type="text/javascript">
var is_admin = 0;
var web_dir = '<?php echo WEB_PATH;?>';
var pc_hash = '<?php echo dr_get_csrf_token();?>';
var csrf_hash = '<?php echo csrf_hash();?>';
</script>
<script language="JavaScript" src="<?php echo JS_PATH?>admin_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>layer/layer.js"></script>
</head>
<body style="background: #ffffff">
<div class="page-404-full-page" style="padding-top:10px">
<div class="row">
    <div class="col-xs-12 page-404">
        <?php if ($mark==1) {?>
        <div class="admin_msg number font-green"> <i class="fa fa-check-circle-o"></i> </div>
        <?php } else if ($mark==2) {?>
        <div class="admin_msg number font-blue"> <i class="fa fa-info-circle"></i> </div>
        <?php } else {?>
        <div class="admin_msg number font-red"> <i class="fa fa-times-circle-o"></i> </div>
        <?php }?>
        <div class="details">
            <h4><?php echo $msg;?></h4>
            <p class="alert_btnleft">
                <?php if ($url) {if(strpos($url,'&pc_hash')===false) $url .= '&pc_hash='.dr_get_csrf_token();?>
                <a href="<?php echo $url;?>"><?php echo L('如果您的浏览器没有自动跳转，请点击这里');?></a>
                <meta http-equiv="refresh" content="<?php echo $time;?>; url=<?php echo $url;?>">
                <?php } else {if($backurl!='javascript:history.back();' && strpos($backurl,'&pc_hash')===false) $backurl .= '&pc_hash='.dr_get_csrf_token();?>
                <a href="<?php echo $backurl;?>" >[<?php echo L('点击返回上一页');?>]</a>
                <?php }?>
            </p>

        </div>
    </div>
</div>
</div>
<?php if ($dialog) {?>
<script style="text/javascript">
$(function(){
    if (window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.right) {
        window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.right.location.reload(true);
    } else {
        window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.location.reload(true);
    }
    ownerDialog.close();
})
</script>
<?php }?>
</body>
</html>