<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<title><?php echo L('website_manage');?></title>
<meta name="author" content="zhaoxunzhiyin" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link href="<?php echo CSS_PATH?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>table_form.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>Dialog/main.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>admin_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>layer/layer.js"></script>
<?php if(isset($show_validator)) { ?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<?php } ?>
<?php if(!$this->get_siteid()) exit('error');?>
<script type="text/javascript">
handlegotop = function() {
	navigator.userAgent.match(/iPhone|iPad|iPod/i) ? $(window).bind("touchend touchcancel touchleave", function(a) {
		100 < $(this).scrollTop() ? $(".scroll-to-top").fadeIn(500) : $(".scroll-to-top").fadeOut(500)
	}) : $(window).scroll(function() {
		100 < $(this).scrollTop() ? $(".scroll-to-top").fadeIn(500) : $(".scroll-to-top").fadeOut(500)
	});
	$(".scroll-to-top").click(function(a) {
		a.preventDefault();
		$("html, body").animate({
			scrollTop: 0
		}, 500);
		return !1
	})
};
$(function(){
	handlegotop();
});
</script>
</head>
<body>
<style type="text/css">
html{_overflow-y:scroll}
.scroll-to-top{padding:1px;text-align:center;position:fixed;bottom:32px;z-index:10002;display:none;right:20px}
.scroll-to-top>i{display:inline-block;color:#687991;font-size:30px;opacity:.6;filter:alpha(opacity=60)}
.scroll-to-top:hover{cursor:pointer}
.scroll-to-top:hover>i{opacity:1;filter:alpha(opacity=100)}
</style>
<div class="scroll-to-top">
    <i class="bi bi-arrow-up-circle-fill"></i>
</div>