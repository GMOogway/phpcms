<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<style type="text/css">
body {background-color: #f5f6f8;}
.progress {border: 0;background-image: none;filter: none;-webkit-box-shadow: none;-moz-box-shadow: none;box-shadow: none;}
.progress {height: 20px;background-color: #fff;border-radius: 4px;}
.progress-bar-success {background-color: #3ea9e2;}
</style>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.slimscroll.min.js"></script>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content  ">
                            <div class="page-body" style="padding-top:0px;margin-bottom:30px;">
<div class="text-center">
    <button type="button" id="dr_check_button" onclick="dr_checking();" class="btn blue"> <i class="fa fa-refresh"></i> 开始执行</button>
</div>
<div class="note note-danger margin-top-30">
    <p>技巧提示：模板代码写法是否合理，对生成速度有着极大的影响</p>
    <p>在生成静态的时候出错，最大可能性是模板的问题</p>
    <p style="color: red">如果网站没有上线，请不要生成静态；开发中的网站使用动态地址才能方便开发调试；开发完毕后上线之前再开启和生成静态功能。</p>
</div>
<div id="dr_check_result" class="margin-top-20" style="display: none">
    <div class="progress progress-striped">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">

        </div>
    </div>
</div>
<div id="dr_check_div" class="well margin-top-20" style="display: none">
    <div class="scroller" style="height:300px" data-rail-visible="1"  id="dr_check_html"></div>
</div>
<input id="dr_check_status" type="hidden" value="1">
<script>
function dr_checking() {
    $('#dr_check_button').attr('disabled', true);
    $('#dr_check_button').html('正在初始化');
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
                //$('#dr_check_button').attr('disabled', false);
                //$('#dr_check_button').html('<i class="fa fa-refresh"></i> 重新执行');
                //dr_tips(0, '发现异常');
            } else {
                $('#dr_check_div').show();
                //$('#dr_check_result').show();
                //$('#dr_check_result .progress-bar-success').attr('style', 'width:'+json.code+'%');
                if (json.code == 100) {
                    $('#dr_check_status').val('0');
                    $('#dr_check_button').attr('disabled', false);
                    $('#dr_check_button').html('<i class="fa fa-refresh"></i> 执行完毕');
                    var isxs = 0;
                    $("#dr_check_html .rbf").each(function(){
                        $('#dr_check_bf').append('<p>'+$(this).html()+'</p>');
                        isxs = 1;
                    });
                } else {
                    $('#dr_check_button').html('<i class="fa fa-refresh"></i> 执行中 '+json.code+'%');
                    dr_ajax2ajax(json.code);
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
        height: '300px',
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