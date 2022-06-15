<?php
defined('IN_CMS') or exit('No permission resources.');
define('ROUTE_M', '');
$field = remove_xss(safe_replace(trim($input->get('field'))));
$modelid = intval($input->get('modelid'));
$data = getcache('model_field_'.$modelid,'model');
$setting = string2array($data[$field]['setting']);
$value = $input->get('value');
$key = SYS_BDMAP_API;
$key = str_replace(array('/','(',')','&',';'),'',$key);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php if(isset($addbg)) { ?> class="addbg"<?php } ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET ?>">
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $key?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH ?>Dialog/main.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH ?>layer/layer.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH ?>member_common.js"></script>
<style type="text/css">
*{ padding:0; margin:0}
body{font-size: 12px;}
#toolbar{ background-color:#E5ECF9;zoom:1; height:24px; line-height:24px; padding:0 12px; margin-top:3px; position:relative}
#toolbar a{display:inline-block;zoom:1;*display:inline; color:#4673CC}
#toolbar a.mark,#toolbar a.map{ background: url(<?php echo IMG_PATH ?>icon/map_mark.png) no-repeat left 50%; padding:0 0 0 20px}
#toolbar a.map{ background-image:url(<?php echo IMG_PATH ?>icon/map.png); margin-left:12px}
#toolbar .right{ float:right;}
#mapObj{width:699px;height:388px; padding-top:1px}
#citywd,.input-text,.measure-input,textarea,input.date,input.endDate,.input-focus{border:1px solid #A7A6AA;height:18px;margin:0 5px 0 0;padding:2px 0 2px 5px;border: 1px solid #d0d0d0;background: #FFF url(<?php echo IMG_PATH ?>admin_img/input.png) repeat-x; font-family: Verdana, Geneva, sans-serif,"宋体";font-size:12px;}
#citywd{width:120px !important;}
textarea,textarea.input-text,textarea.input-focus{font-size:12px;height:auto; padding:5px; margin:0;}
.city_submit,.button{background: #19aa8d;color: #fff;padding: 0px 10px;border-radius: 2px;border: none;height: 22px;font-size: 12px;cursor: pointer;margin-right:10px;}
.city_submit{margin-right:0px;}
</style>
</head>
<body>
<input type="hidden" value="<?php echo $value?>" id="<?php echo $field?>" >
<div id="toolbar">
    <div class="selCity">
        <div class="right"><input type="text" value="" id="localsearch" class="input-text" /><input type="button" class="button" value="<?php echo L('search');?>" onclick="localsearch();" /><a href="javascript:;" class="mark" onClick="addMarker();"><?php echo L('api_addmark','','map')?></a><a href="javascript:;" onClick="removeMarker();" class="map"><?php echo L('api_resetmap','','map')?></a></div>
    </div>
</div>
<div id="mapObj" class="view"></div>
<script type="text/javascript">
var mapObj = new BMap.Map("mapObj");          // 创建地图实例  
//向地图中添加缩放控件
var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
mapObj.addControl(ctrl_nav);
mapObj.enableDragging();//启用地图拖拽事件，默认启用(可不写)
mapObj.enableScrollWheelZoom();//启用地图滚轮放大缩小
mapObj.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
mapObj.enableKeyboard();//启用键盘上下左右键移动地图
//mapObj.centerAndZoom("<?php echo $defaultcity?>");
if($('#<?php echo $field?>').val()) {
    drawPoints();
}
$(function(){
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(r){
        if(this.getStatus() == BMAP_STATUS_SUCCESS){
            baiduSearchAddress(''+r.point.lng+','+r.point.lat+'');
        } else {
            dr_tips(0, '定位失败：'+this.getStatus());
        }
    },{enableHighAccuracy: true});
});
//本地搜索
function localsearch(){
    if($("#localsearch").val()!=""){
        var local = new BMap.LocalSearch(mapObj, {
            renderOptions:{map: mapObj}
        });
        local.search($("#localsearch").val());
    }
}
function drawPoints(){
    var data = $('#<?php echo $field?>').val();
    var data = data.split('|');
    var lngX = data[0];
    var latY = data[1];
    var zoom = data[2] ? data[2] : 10;
    mapObj.centerAndZoom(new BMap.Point(lngX,latY),zoom);
    // 创建图标对象
    var myIcon = new BMap.Icon('<?php echo IMG_PATH ?>icon/mak.png', new BMap.Size(27, 45));
    // 创建标注对象并添加到地图
    var center = mapObj.getCenter();
    var point = new BMap.Point(lngX,latY);
    var marker = new BMap.Marker(point, {icon: myIcon});
    marker.enableDragging();
    mapObj.addOverlay(marker);
    var ZoomLevel = mapObj.getZoom();
    marker.addEventListener("dragend", function(e){
        $('#<?php echo $field?>').val(e.point.lng+'|'+e.point.lat+'|'+ZoomLevel); 
    });
}
// 搜索地址
function baiduSearchAddress(point){
    if (point) {
        var address = point;
    } else {
        var address = $('#localsearch').val();
    }
    if ( address.indexOf(",") != -1 && address.indexOf(".") != -1) {
        // 表示坐标
        var data = address.split(',');
        var lngX = data[0];
        var latY = data[1];
        var zoom = 17;
        mapObj.centerAndZoom(new BMap.Point(lngX,latY),zoom);
        // 创建图标对象
        var myIcon = new BMap.Icon('<?php echo IMG_PATH ?>icon/mak.png', new BMap.Size(27, 45));
        // 创建标注对象并添加到地图
        var center = mapObj.getCenter();
        var point = new BMap.Point(lngX,latY);
        var marker = new BMap.Marker(point, {icon: myIcon});
        marker.enableDragging();
        mapObj.addOverlay(marker);
        var ZoomLevel = mapObj.getZoom();
        $('#<?php echo $field?>').val(address);
        marker.addEventListener("dragend", function(e){
            $('#<?php echo $field?>').val(e.point.lng+'|'+e.point.lat+'|'+ZoomLevel); 
        });
    } else {
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint(address, function(point){
            if (point) {
                mapObj.centerAndZoom(point, 13);
                mapObj.addOverlay(new BMap.Marker(point));
            }else{
                dr_tips(0, "没有找到这个地址");
            }
        });
        //mapObj.setCenter(address);
    }
}
function addMarker(){ 
      mapObj.clearOverlays();
      // 创建图标对象
      var myIcon = new BMap.Icon('<?php echo IMG_PATH ?>icon/mak.png', new BMap.Size(27, 45));
    
      // 创建标注对象并添加到地图
      var center = mapObj.getCenter();
      var point = new BMap.Point(center.lng,center.lat);
      var marker = new BMap.Marker(point, {icon: myIcon});
      marker.enableDragging();
      mapObj.addOverlay(marker);
      var ZoomLevel = mapObj.getZoom();
      $('#<?php echo $field?>').val(center.lng+'|'+center.lat+'|'+ZoomLevel);
      marker.addEventListener("dragend", function(e){  
        $('#<?php echo $field?>').val(e.point.lng+'|'+e.point.lat+'|'+ZoomLevel); 
    }) 
}
function removeMarker() {
    mapObj.clearOverlays();
    mapObj.centerAndZoom("<?php echo $defaultcity?>");
    $("#curCity").html('<?php echo $defaultcity?>');
    $('#<?php echo $field?>').val('');
}
</script>
</body>
</html>