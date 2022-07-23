<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<script type="text/javascript">
<!--
    var charset = '<?php echo CHARSET;?>';
    var uploadurl = '<?php echo SYS_UPLOAD_URL;?>';
//-->
</script>
<link href="<?php echo JS_PATH?>layui/css/layui.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>layui/layui.js"></script>
<script type="text/javascript">var catid=0</script>
<div class="pad-10">
<form action="?m=admin&c=site&a=add" method="post" id="myform">
<input name="dosubmit" type="hidden" value="1">
<div>
<fieldset>
    <legend><?php echo L('basic_configuration')?></legend>
    <table width="100%"  class="table_form">
  <tr id="dr_row_name">
    <th width="100"><?php echo L('site_name')?>：</th>
    <td class="y-bg"><label><input type="text" class="input-text" name="info[name]" id="name" size="70" /></label></td>
  </tr>
  <tr id="dr_row_dirname">
    <th><?php echo L('site_dirname')?>：</th>
    <td class="y-bg"><label><input type="text" class="input-text" name="info[dirname]" id="dirname" size="70" /></label></td>
  </tr>
    <tr id="dr_row_domain">
    <th><?php echo L('site_domain')?>：</th>
    <td class="y-bg"><label><input type="text" class="input-text" name="info[domain]" id="domain"  size="70"/></label></td>
  </tr>
  <tr>
    <th><?php echo L('html_home')?>：</th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[ishtml]" value="1"> <?php echo L('open');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[ishtml]" value="0" checked> <?php echo L('close');?> <span></span></label>
      </div>
    </td>
  </tr>
</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
    <legend><?php echo L('mobile_configuration')?></legend>
    <table width="100%"  class="table_form">
  <tr>
    <th width="120"><?php echo L('access_mode')?>：</th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobilemode]" value="-1" onclick="$('.dr_zsy').hide();$('.dr_mode_0').hide();$('.dr_mode_1').hide();" checked> <?php echo L('close_mode');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobilemode]" value="0" onclick="$('.dr_zsy').show();$('.dr_mode_0').show();$('.dr_mode_1').hide();"> <?php echo L('directory_mode');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobilemode]" value="1" onclick="$('.dr_zsy').show();$('.dr_mode_0').hide();$('.dr_mode_1').show();"> <?php echo L('domain_mode');?> <span></span></label>
      </div>
    </td>
  </tr>
  <tr id="dr_row_mobile_dirname" class="dr_mode_0" style="display: none">
    <th><?php echo L('mobile_dirname')?>：</th>
    <td class="y-bg"><label><input type="text" class="input-text" name="info[mobile_dirname]" id="mobile_dirname" size="70" value="mobile"/></label></td>
  </tr>
  <tr id="dr_row_mobile_domain" class="dr_mode_1" style="display: none">
    <th><?php echo L('mobile_domain')?>：</th>
    <td class="y-bg"><label><input type="text" class="input-text" name="info[mobile_domain]" id="mobile_domain" size="70"/></label></td>
  </tr>
  <tr>
    <th><?php echo L('mobile_auto')?>：</th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobileauto]" value="1"> <?php echo L('open');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobileauto]" value="0" checked> <?php echo L('close');?> <span></span></label><br><?php echo L('mobile_auto_desc')?>
      </div>
    </td>
  </tr>
  <tr class="dr_zsy" style="display: none">
    <th><?php echo L('html_mobile')?>：</th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobilehtml]" value="1"> <?php echo L('html_mobile_url');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[mobilehtml]" value="0" checked> <?php echo L('dynamic_address');?> <span></span></label><br><?php echo L('html_mobile_desc')?>
      </div>
    </td>
  </tr>
  <tr class="dr_zsy" style="display: none">
    <th><?php echo L('mobile_not_pad')?>：</th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[not_pad]" value="1"> <?php echo L('open');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="info[not_pad]" value="0" checked> <?php echo L('close');?> <span></span></label><br><?php echo L('mobile_not_pad_desc')?>
      </div>
    </td>
  </tr>
  <tr class="dr_zsy" style="display: none">
    <th><?php echo L('mobile_template')?>：</th>
    <td class="y-bg"><?php echo L('mobile_template_style')?></td>
  </tr>
</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
    <legend><?php echo L('seo_configuration')?></legend>
    <table width="100%"  class="table_form">
  <tr>
    <th width="100"><?php echo L('site_title')?>：</th>
    <td class="y-bg"><label><input type="text" class="input-text" name="info[site_title]" id="site_title" size="80" /></label></td>
  </tr>
  <tr>
    <th><?php echo L('keyword_name')?>：</th>
    <td class="y-bg"><label><input type="text" class="input-text" name="info[keywords]" id="keywords" size="80" /></label></td>
  </tr>
    <tr>
    <th><?php echo L('description')?>：</th>
    <td class="y-bg"><label><input type="text" class="input-text" name="info[description]" id="description" size="80" /></label></td>
  </tr>
</table>
</fieldset>
<div class="bk15"></div>
<?php if($forminfos && is_array($forminfos['base'])) {?>
<fieldset>
    <legend><?php echo L('field_manage')?></legend>
    <table width="100%"  class="table_form">
<?php
 foreach($forminfos['base'] as $field=>$info) {
     if($info['isomnipotent']) continue;
     if($info['formtype']=='omnipotent') {
        foreach($forminfos['base'] as $_fm=>$_fm_value) {
            if($_fm_value['isomnipotent']) {
                $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
            }
        }
        foreach($forminfos['senior'] as $_fm=>$_fm_value) {
            if($_fm_value['isomnipotent']) {
                $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
            }
        }
    }
 ?>
    <tr id="dr_row_<?php echo $field?>">
      <th width="100"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?>
      </th>
      <td class="y-bg"><?php echo $info['form']?>  <?php echo $info['tips']?></td>
    </tr>
<?php }?>
</table>
</fieldset>
<div class="bk15"></div>
<?php }?>
<fieldset>
    <legend><?php echo L('release_point_configuration')?></legend>
    <table width="100%"  class="table_form">
  <tr id="dr_row_release_point">
    <th width="80" valign="top"><?php echo L('release_point')?>：</th>
    <td> <select name="info[release_point][]" size="3" id="release_point" multiple title="<?php echo L('ctrl_more_selected')?>">
            <option value='' selected><?php echo L('not_use_the_publishers_some')?></option>
    <?php if(is_array($release_point_list) && !empty($release_point_list)): foreach($release_point_list as $v):?>
          <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
    <?php endforeach;endif;?>
        </select> </td>
        
  </tr>
</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
    <legend><?php echo L('template_style_configuration')?></legend>
    <table width="100%"  class="table_form">
  <tr id="dr_row_template">
    <th width="100" valign="top"><?php echo L('style_name')?>：</th>
    <td class="y-bg"> <select name="template[]" size="3" id="template" multiple title="<?php echo L('ctrl_more_selected')?>" onchange="default_list()" ondblclick="default_list()">
        <?php if(is_array($template_list)):
            foreach ($template_list as $key=>$val):
        ?>
          <option value="<?php echo $val['dirname']?>"><?php echo $val['name']?></option>
          <?php endforeach;endif;?>
        </select></td>
  </tr>
   </tr>
    <tr id="dr_row_default_style">
    <th width="100" valign="top"><?php echo L('default_style')?>：<input type="hidden" name="info[default_style]" id="default_style_input" value="0"></th>
    <td class="y-bg"><span id="default_style"><div class="mt-radio-inline"><label class="mt-radio mt-radio-outline"><input type="radio" name="default_style_radio" disabled> <span></span></label></div></span><span id="default_style_msg"></span></td>
  </tr>
</table>
<script type="text/javascript">
function default_list() {
    var html = '';
    var old = $('#default_style_input').val();
    var checked = '';
    $('#template option:selected').each(function(i,n){
        if (old == $(n).val()) {
            checked = 'checked';
        }
         html += '<div class="mt-radio-inline"><label class="mt-radio mt-radio-outline"><input type="radio" name="default_style_radio" value="'+$(n).val()+'" onclick="$(\'#default_style_input\').val(this.value);" '+checked+'> '+$(n).text()+' <span></span></label></div>';
    });
    if(!checked)  $('#default_style_input').val('0');
    $('#default_style').html(html);
}
</script>
</fieldset>
<div class="bk15"></div>
<fieldset>
    <legend><?php echo L('site_att_config')?></legend>
    <table width="100%"  class="table_form">
  <tr>
    <th width="130" valign="top"><?php echo L('site_att_upload_maxsize')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[upload_maxsize]" id="upload_maxsize" size="10" value="2"/></label> MB </td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('site_att_allow_ext')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[upload_allowext]" id="upload_allowext" size="80" value="jpg|jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf"/></label></td>
  </tr>
  <tr<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>>
    <td valign="top" colspan="2"><fieldset>
    <legend><?php echo L('att_ueditor')?></legend>
    <table width="100%" class="radio-label">
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_filename')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[filename]" id="filename" size="50" value="{yyyy}/{mm}{dd}/{time}{rand:6}"/></label><br><?php echo L('ueditor_filename_desc')?></td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_image_max_size')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[imageMaxSize]" id="imageMaxSize" size="10" value="2"/></label> MB </td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_image_allow_ext')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[imageAllowFiles]" id="imageAllowFiles" size="80" value="png|jpg|jpeg|gif|bmp"/></label></td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_catcher_max_size')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[catcherMaxSize]" id="catcherMaxSize" size="10" value="2"/></label> MB </td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_catcher_allow_ext')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[catcherAllowFiles]" id="catcherAllowFiles" size="80" value="png|jpg|jpeg|gif|bmp"/></label></td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_video_max_size')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[videoMaxSize]" id="videoMaxSize" size="10" value="100"/></label> MB </td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_video_allow_ext')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[videoAllowFiles]" id="videoAllowFiles" size="80" value="flv|swf|mkv|avi|rm|rmvb|mpeg|mpg|ogg|ogv|mov|wmv|mp4|webm|mp3|wav|mid"/></label></td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_file_max_size')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[fileMaxSize]" id="fileMaxSize" size="10" value="50"/></label> MB </td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_file_allow_ext')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[fileAllowFiles]" id="fileAllowFiles" size="80" value="png|jpg|jpeg|gif|bmp|flv|swf|mkv|avi|rm|rmvb|mpeg|mpg|ogg|ogv|mov|wmv|mp4|webm|mp3|wav|mid|rar|zip|tar|gz|7z|bz2|cab|iso|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|md|xml"/></label></td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_imagemanager_max_size')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[imageManagerListSize]" id="imageManagerListSize" size="10" value="20"/></label></td>
  </tr>
  <tr style="display: none;">
    <th width="130" valign="top"><?php echo L('ueditor_imagemanager_allow_ext')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[imageManagerAllowFiles]" id="imageManagerAllowFiles" size="80" value="png|jpg|jpeg|gif|bmp"/></label></td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_filemanager_max_size')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[fileManagerListSize]" id="fileManagerListSize" size="10" value="20"/></label></td>
  </tr>
  <tr style="display: none;">
    <th width="130" valign="top"><?php echo L('ueditor_filemanager_allow_ext')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[fileManagerAllowFiles]" id="fileManagerAllowFiles" size="80" value="png|jpg|jpeg|gif|bmp|flv|swf|mkv|avi|rm|rmvb|mpeg|mpg|ogg|ogv|mov|wmv|mp4|webm|mp3|wav|mid|rar|zip|tar|gz|7z|bz2|cab|iso|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|md|xml"/></label></td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('ueditor_videomanager_max_size')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[videoManagerListSize]" id="videoManagerListSize" size="10" value="20"/></label></td>
  </tr>
  <tr style="display: none;">
    <th width="130" valign="top"><?php echo L('ueditor_videomanager_allow_ext')?></th>
    <td class="y-bg"><label><input type="text" class="input-text" name="setting[videoManagerAllowFiles]" id="videoManagerAllowFiles" size="80" value="flv|swf|mkv|avi|rm|rmvb|mpeg|mpg|ogg|ogv|mov|wmv|mp4|webm|mp3|wav|mid"/></label></td>
  </tr>
</table>
</fieldset></td>
  </tr>
  <tr>
    <th><?php echo L('site_att_upload_maxsize')?> </th>
    <td class="y-bg"><?php echo $this->check_gd()?></td>
  </tr>
  <tr>
    <th><?php echo L('site_att_watermark_enable')?></th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark_enable]" value="1" checked="checked"> <?php echo L('site_att_watermark_open');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark_enable]" value="0"> <?php echo L('site_att_watermark_close');?> <span></span></label>
      </div>
    </td>
  </tr>
  <tr>
    <th><?php echo L('site_att_watermark_type')?></th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[type]" value="0" onclick="dr_type(0)" checked="checked"> <?php echo L('site_att_photo');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[type]" value="1" onclick="dr_type(1)"> <?php echo L('site_att_text');?> <span></span></label>
      </div>
    </td>
  </tr>
  <tr class="dr_sy dr_sy_1">
    <th><?php echo L('site_att_text_font')?></th>
    <td class="y-bg">
      <?php if ($waterfont) {?>
        <select style="height: 34px;background-color: rgb(255, 255, 255);box-shadow: rgba(0, 0, 0, 0.075) 0px 1px 1px inset;padding: 6px 12px;border-width: 1px;border-style: solid;border-color: rgb(194, 202, 216);border-image: initial;border-radius: 4px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" name="setting[wm_font_path]" id="wm_font_path">
            <?php foreach($waterfont as $t) {?>
            <option<?php if ($t=='1.ttf') {?> selected=""<?php }?> value="<?php echo $t;?>"><?php echo $t;?></option>
            <?php }?>
        </select>
      <?php }?><button type="button" class="layui-btn layui-btn-sm" id="fileupload-font"><i class="layui-icon">&#xe67c;</i><?php echo L('upload');?></button><br><?php echo L('site_att_text_font_desc')?>
     </td>
  </tr>
  <tr class="dr_sy dr_sy_1">
    <th><?php echo L('site_att_watermark_text')?></th>
    <td class="y-bg">
      <input type="text" class="input-text" name="setting[wm_text]" id="wm_text" size="10" value="cms" /><br><?php echo L('site_att_text_desc')?>
     </td>
  </tr>
  <tr class="dr_sy dr_sy_1">
    <th><?php echo L('site_att_text_size')?></th>
    <td class="y-bg">
      <input type="text" class="input-text" name="setting[wm_font_size]" id="wm_font_size" size="10" value="" /><br><?php echo L('site_att_text_size_desc')?>
     </td>
  </tr>
  <tr class="dr_sy dr_sy_1">
    <th><?php echo L('site_att_text_color')?></th>
    <td class="y-bg">
      <input type="text" class="input-text" name="setting[wm_font_color]" id="wm_font_color" size="10" value="" />
     </td>
  </tr>
  <tr class="dr_sy dr_sy_0">
    <th><?php echo L('site_att_watermark_img')?></th>
    <td class="y-bg">
      <?php if ($waterfile) {?>
        <select style="height: 34px;background-color: rgb(255, 255, 255);box-shadow: rgba(0, 0, 0, 0.075) 0px 1px 1px inset;padding: 6px 12px;border-width: 1px;border-style: solid;border-color: rgb(194, 202, 216);border-image: initial;border-radius: 4px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;" name="setting[wm_overlay_path]" id="wm_overlay_path">
            <?php foreach($waterfile as $t) {?>
            <option<?php if ($t=='logo.png') {?> selected=""<?php }?> value="<?php echo $t;?>"><?php echo $t;?></option>
            <?php }?>
        </select>
      <?php }?><button type="button" class="layui-btn layui-btn-sm" id="fileupload-img"><i class="layui-icon">&#xe67c;</i><?php echo L('upload');?></button><br><?php echo L('site_att_watermark_img_desc')?>
     </td>
  </tr>
   <tr>
    <th width="130" valign="top"><?php echo L('site_att_watermark_pct')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[wm_opacity]" id="wm_opacity" size="10" value="100" /><br><?php echo L('site_att_watermark_pct_desc')?></td>
  </tr> 
   <tr>
    <th width="130" valign="top"><?php echo L('site_att_watermark_quality')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[quality]" id="quality" size="10" value="80" /><br><?php echo L('site_att_watermark_quality_desc')?></td>
  </tr>
  <tr>
    <th><?php echo L('site_att_watermark_padding')?></th>
    <td class="y-bg">
      <label><input type="text" class="input-text" name="setting[wm_padding]" id="wm_padding" size="10" value="0" placeholder="px" /></label><br><?php echo L('site_att_watermark_padding_desc')?>
     </td>
  </tr>
  <tr>
    <th><?php echo L('site_att_watermark_offset')?></th>
    <td class="y-bg">
      <?php echo L('site_att_watermark_hor_offset')?>
<label><input type="text" class="input-text" name="setting[wm_hor_offset]" id="wm_hor_offset" size="10" value="0" placeholder="px" /></label> PX <?php echo L('site_att_watermark_vrt_offset')?><label><input type="text" class="input-text" name="setting[wm_vrt_offset]" id="wm_vrt_offset" size="10" value="0" placeholder="px" /></label> PX
     </td>
  </tr>
  <tr>
    <th><?php echo L('site_att_watermark_photo')?></th>
    <td class="y-bg"><?php echo L('site_att_watermark_minwidth')?>
<label><input type="text" class="input-text" name="setting[width]" id="width" size="10" value="0" placeholder="px" /></label> PX <?php echo L('site_att_watermark_minheight')?><label><input type="text" class="input-text" name="setting[height]" id="height" size="10" value="0" placeholder="px" /></label> PX<br><?php echo L('site_att_watermark_photo_desc')?>
     </td>
  </tr>
  <tr>
    <th width="130" valign="top"><?php echo L('site_att_watermark_pos')?></th>
    <td>
      <div class="btn-group c-3x3" data-toggle="buttons">
        <?php foreach ($locate as $i=>$t) {?>
        <label class="btn btn-default<?php if ($i == 'right-bottom') {?> active<?php }?><?php if (strpos($i, 'bottom')!==false) {?> btn2<?php }?>"><input type="radio" name="setting[locate]" value="<?php echo $i?>"<?php if ($i == 'right-bottom') {?> checked<?php }?> class="toggle"><?php echo L($t)?></label>
        <?php }?>
      </div>
    </td>
  </tr>
  <tr>
    <th><?php echo L('site_att_ueditor')?></th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[ueditor]" value="0" checked> <?php echo L('site_att_watermark_ueditor');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[ueditor]" value="1"> <?php echo L('site_att_watermark_all');?> <span></span></label><br><?php echo L('site_att_ueditor_desc')?>
      </div>
    </td>
  </tr>
  <tr>
    <th><?php echo L('缩略图水印')?></th>
    <td class="y-bg">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[thumb]" value="0" checked> <?php echo L('按调用参数');?> <span></span></label>
        <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[thumb]" value="1"> <?php echo L('site_att_watermark_all');?> <span></span></label><br><?php echo L('是否对缩略图函数thumb的图片进行强制水印')?>
      </div>
    </td>
  </tr>
   <tr>
    <th width="130" valign="top"></th>
    <td class="y-bg"><button type="button" onclick="dr_preview()" class="layui-btn layui-btn-danger layui-btn-sm"> <i class="fa fa-photo"></i> <?php echo L('site_att_watermark_review');?></button></td>
  </tr>
</table>
</fieldset>
</div>
</div>
</div>
</form>
<link rel="stylesheet" href="<?php echo JS_PATH?>ion-rangeslider/ion.rangeSlider.min.css">
<script src="<?php echo JS_PATH?>ion-rangeslider/ion.rangeSlider.min.js"></script>
<link href="<?php echo JS_PATH?>jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH?>jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
<script type="text/javascript">
function dr_type(v) {
    $('.dr_sy').hide();
    $('.dr_sy_'+v).show();
}
function dr_preview() {
    var linkurl = '?m=admin&c=site&a=public_preview&setting[type]='+$('input[name="setting[type]"]:checked').val()+'&setting[wm_font_path]='+$('#wm_font_path').val()+'&setting[wm_text]='+$('#wm_text').val()+'&setting[wm_font_size]='+$('#wm_font_size').val()+'&setting[wm_font_color]='+$('#wm_font_color').val()+'&setting[wm_overlay_path]='+$('#wm_overlay_path').val()+'&setting[wm_opacity]='+$('#wm_opacity').val()+'&setting[quality]='+$('#quality').val()+'&setting[wm_padding]='+$('#wm_padding').val()+'&setting[wm_hor_offset]='+$('#wm_hor_offset').val()+'&setting[wm_vrt_offset]='+$('#wm_vrt_offset').val()+'&setting[width]='+$('#width').val()+'&setting[height]='+$('#height').val()+'&setting[locate]='+$('input[name="setting[locate]"]:checked').val();
    if (typeof pc_hash == 'string') linkurl += (linkurl.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
    if (linkurl.toLowerCase().indexOf("http://") != -1 || linkurl.toLowerCase().indexOf("https://") != -1) {
    } else {
        linkurl = geturlpathname()+linkurl;
    }
    var diag = new Dialog({
        id:'preview',
        title:'水印预览',
        html:'<div style="text-align:center"><img style="max-width: 400px;width: 100%;-webkit-user-select: none;" src="'+linkurl+'"></div>',
        width:'50%',
        height:'60%',
        modal:true,
        draggable:true
    });
    diag.onOk = function(){
        diag.close();
    };
    diag.show();
}
$(function(){
    $("#wm_font_color").minicolors({
        control: $(this).attr('data-control') || 'hue',
        defaultValue: $(this).attr('data-defaultValue') || '',
        inline: $(this).attr('data-inline') === 'true',
        letterCase: $(this).attr('data-letterCase') || 'lowercase',
        opacity: $(this).attr('data-opacity'),
        position: $(this).attr('data-position') || 'bottom left',
        change: function(hex, opacity) {
            if (!hex) return;
            if (opacity) hex += ', ' + opacity;
            if (typeof console === 'object') {
                console.log(hex);
            }
        },
        theme: 'bootstrap'
    });
    dr_type(0);
    $("#wm_opacity").ionRangeSlider({
        grid: true,
        min: 1,
        max: 100,
        from: 100
    });
    $("#quality").ionRangeSlider({
        grid: true,
        min: 1,
        max: 100,
        from: 80
    });
    layui.use('upload', function () {
        var upload = layui.upload;
        upload.render({
            elem:'#fileupload-font',
            accept:'file',
            field:'file_data',
            url: '?m=admin&c=site&a=public_upload_index&at=font&pc_hash='+pc_hash,
            exts: 'ttf',
            done: function(data){
                dr_tips(data.code, data.msg);
                if(data.code == 1){
                    setTimeout("location.reload(true)", 2000);
                }
            }
        });
        upload.render({
            elem:'#fileupload-img',
            accept:'file',
            field:'file_data',
            url: '?m=admin&c=site&a=public_upload_index&at=img&pc_hash='+pc_hash,
            exts: 'png',
            done: function(data){
                dr_tips(data.code, data.msg);
                if(data.code == 1){
                    setTimeout("location.reload(true)", 2000);
                }
            }
        });
    });
});
</script>
</body>
</html>