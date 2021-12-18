<?php defined('IS_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<title><?php echo L('website_manage');?></title>
<meta name="author" content="zhaoxunzhiyin" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<link href="<?php echo CSS_PATH?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>admin/css/style.css" rel="stylesheet" type="text/css" />
<link href='<?php echo CSS_PATH?>bootstrap-tagsinput.css' rel='stylesheet' type='text/css' />
<link href="<?php echo CSS_PATH?>table_form.css" rel="stylesheet" type="text/css" />
<?php
if(!$this->get_siteid()) dr_admin_msg(0,L('admin_login'),'?m=admin&c=index&a='.SYS_ADMIN_PATH);
if(isset($show_dialog)) {?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>
<?php } ?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>Dialog/main.js"></script>
<script src='<?php echo JS_PATH?>bootstrap-tagsinput.min.js' type='text/javascript'></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>admin_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>layer/layer.js"></script>
<?php if(isset($show_validator)) { ?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<?php } ?>
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
	}
	window.focus();
	var pc_hash = '<?php echo dr_get_csrf_token();?>';
	var csrf_hash = '<?php echo csrf_hash();?>';
	<?php if(!isset($show_pc_hash)) { ?>
		window.onload = function(){
		var html_a = document.getElementsByTagName('a');
		var num = html_a.length;
		for(var i=0;i<num;i++) {
			var href = html_a[i].href;
			if(href && href.indexOf('javascript:') == -1) {
				if(href.indexOf('?') != -1) {
					html_a[i].href = href+'&pc_hash='+pc_hash;
				} else {
					html_a[i].href = href+'?pc_hash='+pc_hash;
				}
			}
		}

		var html_form = document.forms;
		var num = html_form.length;
		for(var i=0;i<num;i++) {
			var newNode = document.createElement("input");
			newNode.name = 'pc_hash';
			newNode.type = 'hidden';
			newNode.value = pc_hash;
			html_form[i].appendChild(newNode);
		}
	}
<?php } ?>
$(function(){
	handlegotop();
	var html_form2 = document.forms;
	var num2 = html_form2.length;
	for(var i=0;i<num2;i++) {
		var csrfNode = document.createElement("input");
		csrfNode.name = 'csrf_test_name';
		csrfNode.type = 'hidden';
		csrfNode.value = csrf_hash;
		html_form2[i].appendChild(csrfNode);
	}
});
</script>
</head>
<body>
<?php if(!isset($show_header)) { ?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php if(isset($big_menu)) { echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';} else {$big_menu = '';} ?>
    <?php echo admin::submenu($this->input->get('menuid'),$big_menu); ?>
    </div>
</div>
<?php } ?>
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