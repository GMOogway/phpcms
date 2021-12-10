<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<div class="container">
        <h2>后台显示字段回调</h2>
        <div class="content-text">
    <p>回调是用于在列表显示时对其值进行格式化，如果不填写回调函数，那么就会原样显示数据库储存内容。<br/></p><p>CMS默认的回调函数有：</p><pre class="brush:html;toolbar:false">标题:&nbsp;title</pre></div>


    <p> &nbsp;&nbsp;</p>
</div>
<style>
img {max-width: 80%}
h2 {
    padding-bottom: 10px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e7e7eb;
}
img,video {
    border: 2px solid #f1f3f4;
    padding: 10px;
    border-radius: 5px;
    margin: 5px;
}
.content-text table {
    border: 1px solid #000000;
    border-collapse: collapse;
    border-spacing: 0;
    width: 100% !important;
    word-break: break-all;
}
.content-text table th {
    padding: 8px !important;
    line-height: 30px !important;
    border: 1px solid #000000;
    background-color: rgb(191, 191, 191);
}
.content-text table td {
    word-wrap: break-word;
    border: 1px solid #000000;
    padding: 4px 8px !important;
    font-size: 12px;
    line-height: 30px !important;
    vertical-align: middle;
}
</style>
</body>
</html>