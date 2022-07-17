<?php
defined('IS_ADMIN') or exit('No permission resources.');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo L('website_manage');?></title>
<meta name="author" content="zhaoxunzhiyin" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<link rel="stylesheet" href="<?php echo CSS_PATH?>font-awesome/css/font-awesome.min.css" media="all">
<link rel="stylesheet" href="<?php echo JS_PATH?>layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo CSS_PATH?>layuimini/css/public.css" media="all">
<?php if(!$this->get_siteid()) dr_admin_msg(0,L('admin_login'),'?m=admin&c=index&a='.SYS_ADMIN_PATH);?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>Dialog/main.js"></script>
<script src='<?php echo JS_PATH?>bootstrap-tagsinput.min.js' type='text/javascript'></script>
<script type="text/javascript">
var is_admin = 0;
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
$(function () {
    handlegotop();
    <?php $sitelist_ccache = getcache('sitelist', 'commons');
    $ccache = getcache('category_content_1','commons');
    if(!module_exists('member') && (!is_array($sitelist_ccache) || !is_array($ccache))) { ?>
    $.ajax({type: "GET",dataType:"json", url: "?m=admin&c=cache_all&a=init&pc_hash=<?php echo dr_get_csrf_token();?>&is_ajax=1",
        success: function(json) {
            if (json.code) {
                dr_tips(json.code, json.msg)
            }
        }
    });
    <?php }?>
});
</script>
</head>
<body>
<div class="layuimini-container">
    <div class="layuimini-main">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8">
                <div class="layui-row layui-col-space15">
                    <div class="layui-col-md6">
                        <div class="layui-card">
                            <div class="layui-card-header"><i class="fa fa-user icon"></i><?php echo L('personal_information')?></div>
                            <div class="layui-card-body">
                                <div class="welcome-module">
                                    <div class="layui-row layui-col-space10">
                                        <p><span id="nowTime"></span></p>
                                        <p><?php echo L('main_dear')?><span style="color:#ff0000;"><?php echo $admin_username?></span><span id="main_hello"></span></p>
                                        <p><?php echo L('main_role')?><?php echo $rolename?></p>
                                        <p><?php echo L('main_last_logintime')?><?php echo dr_date($logintime,null,'red')?></p>
                                        <p><?php echo L('main_last_loginip')?><?php echo $loginip?><a class="label layui-bg-green ml10" href="javascript:dr_show_ip('<?php echo WEB_PATH;?>api.php?op=ip_address', '<?php echo $loginip;?>');"><i class="fa fa-eye" /></i> 查看</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <div class="layui-card">
                            <div class="layui-card-header"><i class="fa fa-warning icon"></i><?php echo L('main_safety_tips')?></div>
                            <div class="layui-card-body">
                                <div class="welcome-module">
                                    <div class="layui-row layui-col-space10 layuimini-qiuck" style="color:#ff0000;">
                                        <?php if(is_file(CACHE_PATH.'caches_error/caches_data/log-'.date('Y-m-d',SYS_TIME).'.php')) {
                                        $menu_data = $this->menu_db->get_one(array('name' => 'public_error_log', 'm' => 'admin', 'c' => 'index', 'a' => 'public_error_log'));?>
                                        <p><?php echo L('※ 错误日志，<a href="javascript:;" layuimini-content-href="?m=admin&c=index&a=public_error_log&menuid='.$menu_data['id'].'&pc_hash='.dr_get_csrf_token().'" data-title="错误日志" data-icon="fa fa-shield"><i class="fa fa-shield"></i><cite>点击查看</cite></a>')?></p>
                                        <?php } ?>
                                        <?php if(is_file(CACHE_PATH.'error_log.php')) {
                                        $menu_data = $this->menu_db->get_one(array('name' => 'public_error', 'm' => 'admin', 'c' => 'index', 'a' => 'public_error'));?>
                                        <p><?php echo L('※ 系统错误，<a href="javascript:;" layuimini-content-href="?m=admin&c=index&a=public_error&menuid='.$menu_data['id'].'&pc_hash='.dr_get_csrf_token().'" data-title="系统错误" data-icon="fa fa-shield"><i class="fa fa-shield"></i><cite>点击查看</cite></a>')?></p>
                                        <?php } ?>
                                        <?php if(SELF == 'admin.php') {?>
                                        <p><?php echo L('※ 为了系统安全，请修改根目录admin.php的文件名')?></p>
                                        <?php } ?>
                                        <?php if(IS_DEV) {?>
                                        <p><?php echo L('※ 当前环境参数已经开启开发者模式，网站上线后建议关闭开发者模式')?></p>
                                        <?php } ?>
                                        <?php if($pc_writeable) {?>
                                        <p><?php echo L('main_safety_permissions')?></p>
                                        <?php } ?>
                                        <?php if(!SYS_ERRORLOG) {?>
                                        <p><?php echo L('main_safety_errlog')?></p>
                                        <?php } ?>
                                        <?php if(SYS_EXECUTION_SQL) {?>
                                        <p><?php echo L('main_safety_sql')?></p>
                                        <?php } ?>
                                        <?php if($logsize_warning) {?>
                                        <p><?php echo L('main_safety_log',array('size'=>$common_cache['errorlog_size'].'MB'))?></p>
                                        <?php } ?>
                                        <?php if(IS_EDIT_TPL) {?>
                                        <p><?php echo L('main_safety_tpledit')?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md12">
                        <div class="layui-card">
                            <div class="layui-card-header"><i class="fa fa-credit-card icon icon-blue"></i>快捷入口</div>
                            <div class="layui-card-body">
                                <div class="welcome-module">
                                    <div class="layui-row layui-col-space10 layuimini-qiuck">
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="?m=admin&c=index&a=public_icon" data-title="图标管理" data-icon="fa fa-cog">
                                                <i class="fa fa-cog"></i>
                                                <cite>图标管理</cite>
                                            </a>
                                        </div>
                                        <?php foreach($adminpanel as $v) {?>
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="<?php echo $v['url'].'&menuid='.$v['menuid'];?>&pc_hash=<?php echo dr_get_csrf_token();?>" data-title="<?php echo L($v['name'])?>" data-icon="<?php echo $v['icon']?>">
                                                <i class="<?php echo $v['icon']?>"></i>
                                                <cite><?php echo L($v['name'])?></cite>
                                            </a>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">

                <div class="layui-card">
                    <div class="layui-card-header"><i class="fa fa-fire icon"></i>版本信息</div>
                    <div class="layui-card-body layui-text">
                        <table class="layui-table">
                            <colgroup>
                                <col width="120">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <td>系统版本</td>
                                <?php $menu_data = $this->menu_db->get_one(array('name' => 'my_website', 'm' => 'admin', 'c' => 'cloud', 'a' => 'init'));?>
                                <td><a href="javascript:;" layuimini-content-href="?m=admin&c=cloud&a=init&menuid=<?php echo $menu_data['id']?>&pc_hash=<?php echo dr_get_csrf_token();?>" data-title="我的网站" data-icon="fa fa-cog"><i class="fa fa-cog"></i> Cms <?php echo CMS_VERSION?> [<?php echo CMS_RELEASE?>]</a><a id="dr_cms_update" href="javascript:;" layuimini-content-href="?m=admin&c=cloud&a=upgrade&menuid=277&pc_hash=<?php echo dr_get_csrf_token()?>" data-title="版本升级" data-icon="fa fa-refresh" style="display: none" class="badge badge-danger badge-roundless ml10">  </a></td>
                            </tr>
                            <script>
                            $(function () {
                                $.ajax({type: "GET",dataType:"json", url: "?m=admin&c=index&a=public_version_cms",
                                    success: function(json) {
                                        if (json.code) {
                                            $('#dr_cms_update').show();
                                            $('#dr_cms_update').html('<i class="fa fa-refresh"></i> '+json.msg);
                                        }
                                    }
                                });
                            });
                            </script>
                            <tr>
                                <td><?php echo L('main_os')?></td>
                                <td><?php echo $sysinfo['os']?></td>
                            </tr>
                            <tr>
                                <td><?php echo L('main_web_server')?></td>
                                <td><?php echo $sysinfo['web_server']?></td>
                            </tr>
                            <tr>
                                <td><?php echo L('MySQL')?></td>
                                <td><?php echo $sysinfo['mysqlv']?></td>
                            </tr>
                            <tr>
                                <td><?php echo L('main_upload_limit')?></td>
                                <td><?php echo $sysinfo['fileupload']?></td>
                            </tr>
                            <tr>
                                <td>下载地址</td>
                                <td>
                                    修改版：<a href="https://gitee.com/zhaoxunzhiyin/phpcms/" target="_blank">gitee</a> / <a href="https://github.com/zhaoxunzhiyin/phpcms/" target="_blank">github</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Gitee</td>
                                <td style="padding-bottom: 0;">
                                    <div class="layui-btn-container">
                                        <a href="https://gitee.com/zhaoxunzhiyin/phpcms/" target="_blank" style="margin-right: 15px"><img src="https://gitee.com/zhaoxunzhiyin/phpcms/badge/star.svg?theme=dark" alt="star"></a>
                                        <a href="https://gitee.com/zhaoxunzhiyin/phpcms/" target="_blank"><img src="https://gitee.com/zhaoxunzhiyin/phpcms/badge/fork.svg?theme=dark" alt="fork"></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Github</td>
                                <td style="padding-bottom: 0;">
                                    <div class="layui-btn-container">
                                        <iframe src="https://ghbtns.com/github-btn.html?user=zhaoxunzhiyin&repo=phpcms&type=star&count=true" frameborder="0" scrolling="0" width="100px" height="20px"></iframe>
                                        <iframe src="https://ghbtns.com/github-btn.html?user=zhaoxunzhiyin&repo=phpcms&type=fork&count=true" frameborder="0" scrolling="0" width="100px" height="20px"></iframe>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="layui-card">
                    <div class="layui-card-header"><i class="fa fa-paper-plane-o icon"></i>作者心语</div>
                    <div class="layui-card-body layui-text layadmin-text">
                        <p><?php echo L('main_product_planning')?><?php echo $designer;?><?php echo $programmer;?></p>
                        <p><?php echo L('main_product_qq')?>（<?php echo $qq;?>）<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $qq;?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $qq;?>:51" onmouseover="layer.tips('点击这里给我发消息',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></a></p>
                        <p><?php echo L('main_product_tel')?><?php echo $tel;?></p>
                        <p><?php echo L('main_support')?><?php echo $designer;?><?php echo $programmer;?></p>
                        <p>技术交流QQ群（<?php echo $qqgroup;?>）：<a target="_blank" href="https://jq.qq.com/?_wv=1027&k=NdLwEXcR"><img border="0" src="https://pub.idqqimg.com/wpa/images/group.png" onmouseover="layer.tips('点击这里加入群聊<br>【PHPCMS二次开发】',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></a></p>
                        <p>（加群请备注来源：如gitee官网等）</p>
                        <p>喜欢此后台模板的可以给我的Gitee加个Star支持一下</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="scroll-to-top">
    <i class="bi bi-arrow-up-circle-fill"></i>
</div>
<script src="<?php echo JS_PATH?>layui/layui.js" charset="utf-8"></script>
<script src="<?php echo CSS_PATH?>layuimini/js/lay-config.js?v=2.0.0" charset="utf-8"></script>
<script src="<?php echo JS_PATH?>main.js" charset="utf-8"></script>
<script>
layui.use(['layer', 'miniTab','echarts'], function () {
    var $ = layui.jquery,
        layer = layui.layer,
        miniTab = layui.miniTab,
        echarts = layui.echarts;
    miniTab.listen();
});
</script>
</body>
</html>