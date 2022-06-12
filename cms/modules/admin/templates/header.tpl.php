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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>Dialog/main.js"></script>
<script type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
<script src='<?php echo JS_PATH?>bootstrap-tagsinput.min.js' type='text/javascript'></script>
<script type="text/javascript">
<?php
if(in_array(ROUTE_M, array('admin', 'content', 'special')) && in_array(ROUTE_C, array('category', 'content', 'sitemodel_field')) && in_array(ROUTE_A, array('add', 'edit', 'public_priview'))) {?>
var is_admin = 0;
<?php } else { ?>
var is_admin = 1;
<?php } ?>
var pc_hash = '<?php echo dr_get_csrf_token();?>';
var csrf_hash = '<?php echo csrf_hash();?>';
</script>
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
$(function(){
    handlegotop();
<?php if(!isset($show_pc_hash)) { ?>
    var html_a = document.getElementsByTagName('a');
    var num = html_a.length;
    for(var i=0;i<num;i++) {
        var href = html_a[i].href;
        if(href && href.indexOf('javascript:') == -1) {
            if(href.indexOf('pc_hash') == -1) {
                if(href.indexOf('?') != -1) {
                    html_a[i].href = href+'&pc_hash='+pc_hash;
                } else {
                    html_a[i].href = href+'?pc_hash='+pc_hash;
                }
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
<?php } ?>
<?php if(SYS_CSRF) { ?>
    var html_form2 = document.forms;
    var num2 = html_form2.length;
    for(var i=0;i<num2;i++) {
        var csrfNode = document.createElement("input");
        csrfNode.name = 'csrf_test_name';
        csrfNode.type = 'hidden';
        csrfNode.value = csrf_hash;
        html_form2[i].appendChild(csrfNode);
    }
<?php } ?>
});
</script>
</head>
<body>
<?php if(!isset($show_header)) {?>
<div class="subnav">
    <?php if(is_mobile(0)) {?>
    <div class="content-menu ib-a">
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle on" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-th-large"></i> 菜单 <i class="fa fa-angle-double-down"></i></a>
            <ul class="dropdown-menu">
                <?php if(isset($big_menu)) { echo '<li><a class="add fb" href="'.$big_menu[0].'"><i class="fa fa-plus"></i> '.$big_menu[1].'</a></li><div class="dropdown-line"></div>';} else {$big_menu = '';} ?>
                <?php echo admin::submenu($this->input->get('menuid'),$big_menu); ?>
            </ul>
        </li>
    </div>
    <?php } else {?>
    <div class="content-menu ib-a">
    <?php if(isset($big_menu)) { echo '<a class="add fb" href="'.$big_menu[0].'"><i class="fa fa-plus"></i> '.$big_menu[1].'</a><i class="fa fa-circle"></i>';} else {$big_menu = '';} ?>
    <?php echo admin::submenu($this->input->get('menuid'),$big_menu); ?>
    </div>
    <?php }?>
</div>
<div class="content-header"></div>
<?php }?>
<style type="text/css">
html{_overflow-y:scroll}
</style>
<div class="scroll-to-top">
    <i class="bi bi-arrow-up-circle-fill"></i>
</div>