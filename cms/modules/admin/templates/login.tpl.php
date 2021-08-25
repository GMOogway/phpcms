<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo L('logon')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<meta name="author" content="zhaoxunzhiyin" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link href="<?php echo CSS_PATH?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo JS_PATH?>layui/css/layui.css" media="all" />
<link href="<?php echo CSS_PATH?>admin/css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH?>jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<script src="<?php echo JS_PATH?>jquery.backstretch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>layer/layer.js"></script>
<script src="<?php echo JS_PATH?>jquery.md5.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH?>jquery.particleground.min.js" type="text/javascript"></script>
</head>
<body>
<div class="container login">
    <form class="layui-form layui-form-pane" action="?m=admin&c=index&a=<?php echo SYS_ADMIN_PATH;?>" method="post" id="myform" name="myform" onsubmit="return login()">
        <input name="dosubmit" type="hidden" value="1">
        <?php echo dr_form_hidden();?>
        <div id="content" class="content">
            <div id="large-header" class="large-header">
                <div id="canvas"></div>
                <div class="main-title">
                    <div class="beg-login-box">
                        <header>
                            <h1>站点后台管理系统</h1>
                            <em>Management System</em>
                        </header>
                        <div class="beg-login-main">
                            <form class="layui-form layui-form-pane" method="post">
                                <div class="layui-form-item">
                                    <label class="beg-login-icon fs1">
                                        <span class="layui-icon layui-icon-username"></span>
                                    </label>
                                    <input type="text" id="username" name="username" placeholder="账号" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-item">
                                    <label class="beg-login-icon fs1">
                                        <i class="layui-icon layui-icon-password"></i>
                                    </label>
                                    <input type="password" id="password" name="password" placeholder="密码" autocomplete="off" class="layui-input">
                                    <span class="bind-password icon"><svg focusable="false" data-icon="eye-invisible" width="1em" height="1em" fill="currentColor" aria-hidden="true" viewBox="64 64 896 896"><path d="M942.2 486.2Q889.47 375.11 816.7 305l-50.88 50.88C807.31 395.53 843.45 447.4 874.7 512 791.5 684.2 673.4 766 512 766q-72.67 0-133.87-22.38L323 798.75Q408 838 512 838q288.3 0 430.2-300.3a60.29 60.29 0 000-51.5zm-63.57-320.64L836 122.88a8 8 0 00-11.32 0L715.31 232.2Q624.86 186 512 186q-288.3 0-430.2 300.3a60.3 60.3 0 000 51.5q56.69 119.4 136.5 191.41L112.48 835a8 8 0 000 11.31L155.17 889a8 8 0 0011.31 0l712.15-712.12a8 8 0 000-11.32zM149.3 512C232.6 339.8 350.7 258 512 258c54.54 0 104.13 9.36 149.12 28.39l-70.3 70.3a176 176 0 00-238.13 238.13l-83.42 83.42C223.1 637.49 183.3 582.28 149.3 512zm246.7 0a112.11 112.11 0 01146.2-106.69L401.31 546.2A112 112 0 01396 512z"></path><path d="M508 624c-3.46 0-6.87-.16-10.25-.47l-52.82 52.82a176.09 176.09 0 00227.42-227.42l-52.82 52.82c.31 3.38.47 6.79.47 10.25a111.94 111.94 0 01-112 112z"></path></svg></span>
                                </div>
                                <?php if (!$sysadmincode) {?>
                                <div class="layui-form-item">
                                    <label class="beg-login-icon fs1">
                                        <span class="layui-icon layui-icon-vercode"></span>
                                    </label>
                                    <input type="text" id="captcha" name="code" placeholder="验证码" autocomplete="off" maxlength="4" class="layui-input">
                                    <div class="captcha">
                                        <?php echo form::checkcode('code_img')?>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="layui-form-item">
                                    <button type="submit" class="layui-btn btn-submit btn-blog">立即登陆</button>
                                </div>
                            </form>
                        </div>
                        <footer>
                            <p>&copy;&nbsp;2006-<script language="javaScript">document.write(new Date().getFullYear());</script>&nbsp;Kaixin100&nbsp;<span>www.kaixin100.cn</span>&nbsp;<?php echo pc_base::load_config('version','cms_version');?></p>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function() {
    if(self.parent.frames.length!=0){
        self.parent.location=document.location.href;
    }
    if(document.myform.username.value == '') {
        document.myform.username.focus();
    } else {
        document.myform.username.select();
    }
    $('#canvas').particleground({
        dotColor: 'rgba(255,255,255,0.2)',
        lineColor: 'rgba(255,255,255,0.2)'
    });
    $('#large-header').backstretch([
        "<?php echo IMG_PATH?>admin_img/bg-screen1.jpg","<?php echo IMG_PATH?>admin_img/bg-screen2.jpg","<?php echo IMG_PATH?>admin_img/bg-screen3.jpg","<?php echo IMG_PATH?>admin_img/bg-screen4.jpg","<?php echo IMG_PATH?>admin_img/bg-screen5.jpg","<?php echo IMG_PATH?>admin_img/bg-screen6.jpg","<?php echo IMG_PATH?>admin_img/bg-screen7.jpg"], {
        fade: 1000,
        duration: 8000
    });
    $('.bind-password').on('click', function () {
        if ($("input[name='password']").attr('type')=='text') {
            $(this).html('<svg focusable="false" data-icon="eye-invisible" width="1em" height="1em" fill="currentColor" aria-hidden="true" viewBox="64 64 896 896"><path d="M942.2 486.2Q889.47 375.11 816.7 305l-50.88 50.88C807.31 395.53 843.45 447.4 874.7 512 791.5 684.2 673.4 766 512 766q-72.67 0-133.87-22.38L323 798.75Q408 838 512 838q288.3 0 430.2-300.3a60.29 60.29 0 000-51.5zm-63.57-320.64L836 122.88a8 8 0 00-11.32 0L715.31 232.2Q624.86 186 512 186q-288.3 0-430.2 300.3a60.3 60.3 0 000 51.5q56.69 119.4 136.5 191.41L112.48 835a8 8 0 000 11.31L155.17 889a8 8 0 0011.31 0l712.15-712.12a8 8 0 000-11.32zM149.3 512C232.6 339.8 350.7 258 512 258c54.54 0 104.13 9.36 149.12 28.39l-70.3 70.3a176 176 0 00-238.13 238.13l-83.42 83.42C223.1 637.49 183.3 582.28 149.3 512zm246.7 0a112.11 112.11 0 01146.2-106.69L401.31 546.2A112 112 0 01396 512z"></path><path d="M508 624c-3.46 0-6.87-.16-10.25-.47l-52.82 52.82a176.09 176.09 0 00227.42-227.42l-52.82 52.82c.31 3.38.47 6.79.47 10.25a111.94 111.94 0 01-112 112z"></path></svg>');
            $("input[name='password']").attr('type', 'password');
        } else {
			var icon = 1;
            $(this).html('<svg focusable="false" data-icon="eye" width="1em" height="1em" fill="currentColor" aria-hidden="true" viewBox="64 64 896 896"><path d="M942.2 486.2C847.4 286.5 704.1 186 512 186c-192.2 0-335.4 100.5-430.2 300.3a60.3 60.3 0 000 51.5C176.6 737.5 319.9 838 512 838c192.2 0 335.4-100.5 430.2-300.3 7.7-16.2 7.7-35 0-51.5zM512 766c-161.3 0-279.4-81.8-362.7-254C232.6 339.8 350.7 258 512 258c161.3 0 279.4 81.8 362.7 254C791.5 684.2 673.4 766 512 766zm-4-430c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm0 288c-61.9 0-112-50.1-112-112s50.1-112 112-112 112 50.1 112 112-50.1 112-112 112z"></path></svg>');
            $("input[name='password']").attr('type', 'text');
        }
    });
});
</script>
<script>
//监听提交
function login() {
    if (!$('#username').val()){
        layer.msg('账号不能为空！', {icon: 5, anim: 6, time: 1000});
        $('#username').focus();
        return false;
    }
    if (!$('#password').val()){
        layer.msg('密码不能为空！', {icon: 5, anim: 6, time: 1000});
        $('#password').focus();
        return false;
    }
    <?php if (!$sysadmincode) {?>
    if (!$('#captcha').val()){
        layer.msg('验证码不能为空！', {icon: 5, anim: 6, time: 1000});
        $('#captcha').focus();
        return false;
    }
    <?php }?>
    loading = layer.load(1, {shade: [0.1,'#fff'] });//0.1透明度的白色背景
    // 这里进行md5加密存储
    var pwd = $('#password').val();
    pwd = $.md5(pwd); // 进行md5加密
    $('#password').val(pwd);
    $.ajax({
        type: 'post',
        url: '?m=admin&c=index&a=<?php echo SYS_ADMIN_PATH;?>',
        data: $("#myform").serialize(),
        dataType: 'json',
        success: function(res) {
            layer.close(loading);
            if(res.code == 1){
                layer.msg(res.msg, {icon: 1, time: 1000}, function(){
                    location.href = res.data.url;
                });
            /*}else if(res.code == 2){
                $('#username').val('');
                $('#username').focus();
                layer.msg(res.msg, {icon: 2, anim: 6, time: 1000});
                <?php if (!$sysadmincode) {?>
                $('#captcha').val('');
                $('#code_img').trigger('click');
                <?php }?>
            }else if(res.code == 3){
                $('#password').val('');
                $('#password').focus();
                layer.msg(res.msg, {icon: 2, anim: 6, time: 1000});
                <?php if (!$sysadmincode) {?>
                $('#captcha').val('');
                $('#code_img').trigger('click');
                <?php }?>*/
            <?php if (!$sysadmincode) {?>
            /*}else if(res.code == 4){
                $('#captcha').focus();
                $('#captcha').val('');
                layer.msg(res.msg, {icon: 2, anim: 6, time: 1000});
                $('#code_img').trigger('click');*/
            <?php }?>
            }else{
                layer.msg(res.msg, {icon: 2, anim: 6, time: 1000});
                <?php if (!$sysadmincode) {?>
                $('#captcha').val('');
                $('#code_img').trigger('click');
                <?php }?>
            }
        }
    });
    return false;
}
</script>
</body>
</html>