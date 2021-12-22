<?php 
defined('IN_CMS') or exit('No permission resources.');
$server_list = getcache('downservers','commons');
if (is_array($server_list)) {
foreach($server_list as $_r) if (in_array($_r['siteid'],array(0,$this->siteid))) $str .='<span class="ib" style="width:25%">'.$_r['sitename'].'</span>';
}
?>
    <div class="form-group">
      <label class="col-md-2 control-label">镜像服务器列表</label>
        <div class="col-md-9">
            <div class="form-control-static"><?php echo $str?></div>
        </div>
    </div>
	<div class="form-group">
	<label class="col-md-2 control-label">文件链接方式</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input name="setting[downloadlink]" value="0" type="radio" <?php if(!$setting['downloadlink']) echo 'checked';?>>链接到真实软件地址 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input name="setting[downloadlink]" value="1" type="radio" <?php if($setting['downloadlink']) echo 'checked';?>> 链接到跳转页面 <span></span></label>
        </div>
	</div>
	</div>
	<label class="col-md-2 control-label">文件下载方式</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input name="setting[downloadtype]" value="0" type="radio" <?php if(!$setting['downloadtype']) echo 'checked';?>>链接文件地址 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input name="setting[downloadtype]" value="1" type="radio" <?php if($setting['downloadtype']) echo 'checked';?>>通过PHP读取<span></span></label>
        </div>
	</div>
	<div class="form-group">
      <label class="col-md-2 control-label">文件大小</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_maxsize]" value="<?php echo $setting['upload_maxsize'];?>" size="40" class="input-text"></label>
            <span class="help-block">单位MB</span>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">允许上传的文件类型</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_allowext]" value="<?php echo $setting['upload_allowext'];?>" size="40" class="input-text"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">是否从已上传中选择</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="1" <?php if($setting['isselectimage']) echo 'checked';?>>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="0" <?php if(!$setting['isselectimage']) echo 'checked';?>> 否 <span></span></label>
        </div></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">允许同时上传的个数</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_number]" value="<?php echo $setting['upload_number'];?>" class="input-text"></label>
      </div>
    </div>
    <?php echo attachment($setting);?>

<SCRIPT LANGUAGE="JavaScript">
<!--
	function add_mirrorsite(obj)
	{
		var name = $(obj).siblings("#addname").val();
		var url = $(obj).siblings("#addurl").val();
		var servers = $("#servers").text()+name+" | "+url+"\r\n";
		$("#servers").text(servers);
	}
//-->
</SCRIPT>