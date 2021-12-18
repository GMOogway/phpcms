<?php defined('IS_ADMIN') or exit('No permission resources.');
if (IS_DEV) {?>
<html>
<head>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<link href="<?php echo CSS_PATH;?>admin/css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo CSS_PATH;?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body class="page-content-white">
<div style="<?php if(is_mobile(0)) {?>padding:100px 10px 10px 10px; <?php } else {?>padding:220px;<?php }?>text-align: center">
    <a href="<?php echo $url;?>" class="btn default btn-block">{dr_lang('单击下方链接进行访问该页面')}</a>
    <p><?php echo $url;?></p>
</div>
</body>
</html>
<?php } else {?>
<html>
<head>
<meta http-equiv="refresh" content="0;url=<?php echo $url;?>">
</head>
<body style="background: url(<?php echo JS_PATH;?>layer/theme/default/loading-0.gif);background-position: center;background-color: #fff;background-repeat: no-repeat;"> </body>
</html>
<?php }?>