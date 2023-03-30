<!DOCTYPE html>
<head>
<meta charset="<?php echo CHARSET;?>">
<title><?php echo L('website_manage');?></title>
<meta name="author" content="zhaoxunzhiyin" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<?php echo load_css(CSS_PATH.'bootstrap/css/bootstrap.min.css');?>
<?php echo load_css(CSS_PATH.'font-awesome/css/font-awesome.min.css');?>
<?php echo load_css(CSS_PATH.'admin/css/style.css');?>
<?php echo load_css(CSS_PATH.'table_form.css');?>
<?php echo load_css(CSS_PATH.'admin/css/my.css');?>
<?php echo load_js(JS_PATH.'Dialog/main.js');?>
<?php echo load_js(JS_PATH.'bootstrap/js/bootstrap.min.js');?>
<script type="text/javascript">
var is_admin = 0;
var web_dir = '<?php echo WEB_PATH;?>';
var pc_hash = '<?php echo dr_get_csrf_token();?>';
var csrf_hash = '<?php echo csrf_hash();?>';
</script>
<?php echo load_js(JS_PATH.'admin_common.js');?>
<?php echo load_js(JS_PATH.'my.js');?>
<?php echo load_js(JS_PATH.'styleswitch.js');?>
<?php echo load_js(JS_PATH.'layer/layer.js');?>
<?php if(isset($show_validator)) { ?>
<?php echo load_js(JS_PATH.'formvalidator.js');?>
<?php echo load_js(JS_PATH.'formvalidatorregex.js');?>
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
</style>
<div class="scroll-to-top">
    <i class="bi bi-arrow-up-circle-fill"></i>
</div>