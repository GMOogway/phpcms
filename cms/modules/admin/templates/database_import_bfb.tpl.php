<!DOCTYPE html>
<html>
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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>Dialog/main.js"></script>
<script type="text/javascript" src="<?php echo CSS_PATH?>bootstrap/js/bootstrap.min.js"></script>
<script src='<?php echo JS_PATH?>bootstrap-tagsinput.min.js' type='text/javascript'></script>
<script type="text/javascript">
var web_dir = '<?php echo WEB_PATH;?>';
var pc_hash = '<?php echo dr_get_csrf_token();?>';
var csrf_hash = '<?php echo csrf_hash();?>';
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>admin_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>layer/layer.js"></script>
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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.slimscroll.min.js"></script>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
                            <div class="page-body" style="padding-top:0px;margin-bottom:30px;">
<div id="dr_check_div" class="well margin-top-20" style="display: none">
    <div class="scroller" style="height:<?php if(is_mobile(0)) {?>300<?php } else {?>430<?php }?>px" data-rail-visible="1"  id="dr_check_html"></div>
</div>
<input id="dr_check_status" type="hidden" value="1">
<script>
function dr_checking() {
    $('#dr_check_bf').html("");
    $('#dr_check_html').html("正在准备中");
    dr_ajax2ajax(1);
}
dr_checking();
function dr_ajax2ajax(page) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "<?php echo $todo_url;?>&page="+page,
        success: function (json) {

            $('#dr_check_html').append(json.msg);
            document.getElementById('dr_check_html').scrollTop = document.getElementById('dr_check_html').scrollHeight;

            if (json.code == 0) {
                $('#dr_check_div').show();
                $('#dr_check_html').html('<font color="red">'+json.msg+'</font>');
                dr_tips(0, '发现异常');
            } else {
                $('#dr_check_div').show();
                if (json.data.page == 0) {
                    $('#dr_check_status').val('0');
                    var isxs = 0;
                    $("#dr_check_html .rbf").each(function(){
                        $('#dr_check_bf').append('<p>'+$(this).html()+'</p>');
                        isxs = 1;
                    });
                } else {
                    dr_ajax2ajax(json.data.page);
                }
            }
        },
        error: function(HttpRequest, ajaxOptions, thrownError) {
            dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
        }
    });
}
$(function() {
    $(".scroller").slimScroll({
        allowPageScroll: !0,
        size: "7px",
        color: "#bbb",
        wrapperClass: "slimScrollDiv",
        railColor: "#eaeaea",
        position: "right",
        height: '<?php if(is_mobile(0)) {?>300<?php } else {?>430<?php }?>px',
        alwaysVisible: false,
        railVisible: false,
        disableFadeOut: !0
    });
});
</script>
</div>
</div>
</div>
</div>
</body>
</html>