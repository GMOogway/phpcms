<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo JS_PATH;?>layui/css/layui.css" media="all" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>admin/css/global.css" media="all" />
<link href="<?php echo JS_PATH;?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            format: "yyyy-mm-dd",
            orientation: "left",
            autoclose: true
        });
    }
});
</script>
<style type="text/css">
.list_order {text-align: left;}
</style>
<script type="text/javascript" src="<?php echo JS_PATH;?>layui/layui.js"></script>
<div class="admin-main layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo L('list');?></legend>
    </fieldset>
    <blockquote class="layui-elem-quote">
        <?php 
        foreach($datas2 as $r) {
            echo "<a href=\"?m=content&c=content&a=initall&modelid=".$r['modelid']."&menuid=".$this->input->get('menuid')."&pc_hash=".dr_get_csrf_token()."\" class=\"layui-btn layui-btn-sm";
            if($r['modelid']==$modelid) echo " layui-btn-danger";
            if ($r['modelid']==2) {
                echo "\"><i class=\"fa fa-download\"></i> ".$r['name']."(".$r['items'].")</a>";
            } else if ($r['modelid']==3) {
                echo "\"><i class=\"fa fa-image\"></i> ".$r['name']."(".$r['items'].")</a>";
            } else {
                echo "\"><i class=\"fa fa-list\"></i> ".$r['name']."(".$r['items'].")</a>";
            }
        }
        ?>
        <a href="javascript:;" onclick="javascript:$('#searchid').toggle();" class="layui-btn layui-btn-sm layui-btn-normal">
            <i class="fa fa-search"></i> <?php echo L('search');?>
        </a>
<?php
echo "<br>";
echo "<br>";
if(is_array($infos)){
    foreach($infos as $info){
        $total = $this->db->count(array('status'=>99,'username'=>$info['username']));
        echo "<a href=\"?m=content&c=content&a=initall&modelid=".$modelid."&menuid=".$this->input->get('menuid')."&start_time=&end_time=&posids=&searchtype=2&keyword=".$info['username']."&pc_hash=".dr_get_csrf_token()."\" class=\"layui-btn layui-btn-sm";
        if($info['username']==$this->input->get('keyword') && !$this->input->get('start_time') && !$this->input->get('end_time')) echo ' layui-btn-danger';
        echo "\">";
        echo $info['realname'] ? $info['realname'] : $info['username'];
        echo "(总".$total.")</a>";
    }
}
echo "<br>";
echo "<br>";
if(is_array($infos)){
    foreach($infos as $info){
        $total2 = $this->db->count("status=99 and username='".$info['username']."' and `inputtime` > '".strtotime(date("Ymd", time()))."' and `inputtime` < '".strtotime(date("Ymd", strtotime('+1 day',time())))."'");
        echo "<a href=\"?m=content&c=content&a=initall&modelid=".$modelid."&menuid=".$this->input->get('menuid')."&start_time=".dr_date(SYS_TIME,'Y-m-d')."&end_time=".dr_date(SYS_TIME,'Y-m-d')."&posids=&searchtype=2&keyword=".$info['username']."&pc_hash=".dr_get_csrf_token()."\" class=\"layui-btn layui-btn-sm";
        if($info['username']==$this->input->get('keyword') && dr_date(SYS_TIME,'Y-m-d')==$this->input->get('start_time') && dr_date(SYS_TIME,'Y-m-d')==$this->input->get('end_time')) echo ' layui-btn-danger';
        echo "\">";
        echo $info['realname'] ? $info['realname'] : $info['username'];
        echo "(今".$total2.")</a>";
    }
}
?>
    </blockquote>
    <div class="demoTable" id="searchid"<?php if (!$this->input->get('search')) {?> style="display:none;"<?php }?>>
        <form name="searchform" action="" method="get" >
        <input type="hidden" value="content" name="m">
        <input type="hidden" value="content" name="c">
        <input type="hidden" value="initall" name="a">
        <input type="hidden" value="<?php echo $modelid;?>" name="modelid">
        <input type="hidden" value="1" name="search">
        <input type="hidden" value="<?php echo dr_get_csrf_token();?>" name="pc_hash">
        <?php echo L('addtime');?>：
        <label><div class="formdate">
            <div class="input-group input-medium date-picker input-daterange">
                <input type="text" class="form-control" value="<?php echo $this->input->get('start_time');?>" name="start_time" id="start_time">
                <span class="input-group-addon"> - </span>
                <input type="text" class="form-control" value="<?php echo $this->input->get('end_time');?>" name="end_time" id="end_time">
            </div>
        </div></label>
        <label><select id="posids" name="posids"><option value='' <?php if($this->input->get('posids')=='') echo 'selected';?>><?php echo L('all');?></option>
        <option value="1" <?php if($this->input->get('posids')==1) echo 'selected';?>><?php echo L('elite');?></option>
        <option value="2" <?php if($this->input->get('posids')==2) echo 'selected';?>><?php echo L('no_elite');?></option>
        </select></label>
        <label><select id="searchtype" name="searchtype">
            <option value='0' <?php if($this->input->get('searchtype')==0) echo 'selected';?>><?php echo L('title');?></option>
            <option value='1' <?php if($this->input->get('searchtype')==1) echo 'selected';?>><?php echo L('intro');?></option>
            <option value='2' <?php if($this->input->get('searchtype')==2) echo 'selected';?>><?php echo L('username');?></option>
            <option value='3' <?php if($this->input->get('searchtype')==3) echo 'selected';?>>ID</option>
        </select></label>
        <label>
            <input class="input-text" name="keyword" id="keyword" value="<?php if($this->input->get('keyword')) echo $this->input->get('keyword');?>" placeholder="请输入关键字">
        </label>
        <label><button type="submit" class="btn green btn-sm"><i class="fa fa-search"></i> <?php echo L('search');?></button></label>
        <div style="clear: both;"></div>
        </form>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<script type="text/html" id="attribute">
    {{# if(d.thumb){ }}
    <img src="<?php echo IMG_PATH;?>icon/small_img.gif" onmouseover="layer.tips('<img src={{d.thumb}}>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();">
    {{# } }}
    {{# if(d.posids==1){ }}
    <img src="<?php echo IMG_PATH;?>icon/small_elite.png" onmouseover="layer.tips('<?php echo L('elite');?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();">
    {{# } }}
    {{# if(d.islink==1){ }}
    <img src="<?php echo IMG_PATH;?>icon/link.png" onmouseover="layer.tips('<?php echo L('islink_url');?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();">
    {{# } }}
</script>
<script type="text/html" id="hits">
    <span style="display: block;" onmouseover="layer.tips('<?php echo L('today_hits');?>：{{d.dayviews}}<br><?php echo L('yestoday_hits');?>：{{d.yesterdayviews}}<br><?php echo L('week_hits');?>：{{d.weekviews}}<br><?php echo L('month_hits');?>：{{d.monthviews}}',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();">{{d.views}}</span>
</script>
<script type="text/html" id="username">
    {{# if(d.sysadd==0){ }}
    <a href='javascript:;' onclick="omnipotent('member','?m=member&c=member&a=memberinfo&username={{d.deusername}}&pc_hash=<?php echo $this->input->get('pc_hash');?>','<?php echo L('view_memberlinfo');?>',1,700,500);">{{d.username}}</a><img src="<?php echo IMG_PATH;?>icon/contribute.png" onmouseover="layer.tips('<?php echo L('member_contribute');?>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();">
    {{# } else { }}
    {{d.username}}
    {{# } }}
</script>
<script type="text/html" id="action">
    <a href="{{d.url}}" target="_blank" class="layui-btn layui-btn-xs layui-btn-normal"><i class="fa fa-eye"></i> <?php echo L('preview');?></a>
    <a href="javascript:;" onclick="javascript:dr_content_submit('?m=content&c=content&a=edit&catid={{d.catid}}&id={{d.id}}','edit')" class="layui-btn layui-btn-xs"><i class="fa fa-edit"></i> <?php echo L('edit');?></a>
    <a href="javascript:view_comment('{{d.idencode}}','{{d.safetitle}}')" class="layui-btn layui-btn-xs layui-btn-danger"><i class="fa fa-comment"></i> <?php echo L('comment');?></a>
</script>
<script>
layui.use(['table'], function(){
    var table = layui.table, $ = layui.jquery;
    var tableIn = table.render({
        id: 'content',
        elem: '#list',
        url:'?m=content&c=content&a=initall&modelid=<?php echo $modelid;?>&pc_hash='+pc_hash,
        method: 'post',
        where: {keyword: '<?php echo $this->input->get('keyword');?>',start_time: '<?php echo $this->input->get('start_time');?>',end_time: '<?php echo $this->input->get('end_time');?>',posids: '<?php echo $this->input->get('posids');?>',searchtype: '<?php echo $this->input->get('searchtype');?>',csrf_test_name: csrf_hash},
        cellMinWidth: 80,
        page: true,
        cols: [[
            {field: 'id', title: '<?php echo L('number');?>', width: 80, sort: true, fixed: 'left'},
            {field: 'title', title: '<?php echo L('title');?>', minWidth:340, sort: true, edit: 'text'},
            {field: 'attribute', title: '<?php echo L('attribute');?>', templet: '#attribute', width:100},
            {field: 'hits', title: '<?php echo L('hits');?>', width:100, templet: '#hits', sort: true},
            {field: 'publish_user', title: '<?php echo L('publish_user');?>', width:100, templet: '#username', sort: true},
            {field: 'updatetime', title: '<?php echo L('updatetime');?>', width:180, sort: true},
            {width: 240, align: 'center', toolbar: '#action',title:'<?php echo L('operations_manage');?>'<?php if(!is_mobile(0)) {?>, fixed: 'right'<?php }?>}
        ]],
        limit: <?php echo SYS_ADMIN_PAGESIZE;?>
    });
    //搜索
    /*$('#search').on('click', function () {
        var keyword = $('#keyword').val();
        var start_time = $('#start_time').val();
        var end_time = $('#end_time').val();
        var posids = $('#posids').val();
        var searchtype = $('#searchtype').val();
        if ($.trim(keyword) === '') {
            dr_tips(0, '<?php echo L('请输入关键字！')?>');
            return;
        }
        tableIn.reload({ page: {page: 1}, where: {keyword: keyword,start_time: start_time,end_time: end_time,posids: posids,searchtype: searchtype} });
    });*/
    //监听单元格编辑
    table.on('edit(list)',function(obj) {
        var value = obj.value, data = obj.data, field = obj.field;
        if (field=='title' && value=='') {
            layer.tips('标题不能为空',this,{tips: [1, '#fff']});
            return false;
        }else{
            $.ajax({
                type: 'post',
                url: '?m=content&c=content&a=update&modelid=<?php echo $modelid;?>&pc_hash='+pc_hash,
                data: {id:data.id,field:field,value:value,dosubmit:1},
                dataType: 'json',
                success: function(res) {
                    if (res.code == 1) {
                        layer.msg(res.msg, {time: 1000, icon: 1}, function () {
                            tableIn.reload();
                        });
                    }else{
                        dr_tips(0, res.msg);
                    }
                }
            });
        }
    });
});
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
<!--
function view_comment(id, name) {
	var w = 800;
	var h = 500;
	if (is_mobile()) {
		w = h = '100%';
	}
    var diag = new Dialog({
        id:'view_comment',
        title:'<?php echo L('view_comment');?>：'+name,
        url:'<?php echo SELF;?>?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid='+id+'&pc_hash='+pc_hash,
        width:w,
        height:h,
        modal:true
    });
    diag.onCancel=function() {
        $DW.close();
    };
    diag.show();
}
setcookie('refersh_time', 0);
function refersh_window() {
    var refersh_time = getcookie('refersh_time');
    if(refersh_time==1) {
        location.reload(true);
    }
}
setInterval("refersh_window()", 3000);
//-->
</script>
</body>
</html>