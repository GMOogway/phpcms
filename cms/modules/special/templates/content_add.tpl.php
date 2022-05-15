<?php 
defined('IS_ADMIN') or exit('No permission resources.'); 
$show_dialog = $show_validator = $show_header = true; 
include $this->admin_tpl('header','admin');
$authkey = upload_key('1,jpg|jpeg|gif|bmp|png,0,,300,300,,,');
$p = dr_authcode(array(
	'file_upload_limit' => 1,
	'file_types_post' => 'jpg|jpeg|gif|bmp|png',
	'size' => 0,
	'allowupload' => '',
	'thumb_width' => 300,
	'thumb_height' => 300,
	'watermark_enable' => '',
	'attachment' => '',
	'image_reduce' => '',
), 'ENCODE');
?>
<?php echo load_css(JS_PATH.'layui/css/layui.css');?>
<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET?>';
	var uploadurl = '<?php echo SYS_UPLOAD_URL;?>';
//-->
</script>
<?php echo load_js(JS_PATH.'content_addtop.js');?>
<?php echo load_css(JS_PATH.'jquery-minicolors/jquery.minicolors.css');?>
<?php echo load_js(JS_PATH.'jquery-minicolors/jquery.minicolors.min.js');?>
<?php echo load_js(JS_PATH.'cookie.js');?>
<div class="page-container" style="margin-bottom: 0px !important;">
    <div class="page-content-wrapper">
        <div class="page-content page-content3 mybody-nheader main-content">
                <div class="page-body">
<form name="myform" id="myform" action="?m=special&c=content&a=add&specialid=<?php echo $_GET['specialid']?>" class="form-horizontal" onsubmit="return checkall()" method="post" enctype="multipart/form-data">
<input value="1" type="hidden" name="dosubmit">
    <div class="">
        <div class="row ">
            <div class="<?php if (is_mobile(0)){?>col-md-12<?php }else{?>col-md-9<?php }?>">

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-blue sbold"></span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="form-body">
                            <div class="form-group" id="dr_row_typeid">
                                <label class="control-label col-md-2"><font color="red">*</font> <?php echo L('for_type')?></label>
                                <div class="col-md-10">
                                    <?php echo form::select($types, '', 'name="info[typeid]" id="typeid" class="input-text"', L('please_choose_type'))?>
                                </div>
                            </div>
                            <div class="form-group" id="dr_row_title">
                                <label class="control-label col-md-2"><font color="red">*</font> <?php echo L('content_title')?></label>
                                <div class="col-md-10">
                                    <input type="text" style="width:350px;" name="info[title]" id="title" class="measure-input" onBlur="check_title('?m=special&c=content&a=public_check_title&specialid=<?php echo intval($_GET['specialid'])?>&id=<?php echo intval($_GET['id'])?>','title');$.post('<?php echo WEB_PATH;?>api.php?op=get_keywords&sid='+Math.random()*5, {data:$('#title').val()}, function(data){if(data && $('#keywords').val()=='') {$('#keywords').val(data); $('#keywords').tagsinput('add', data);}});"/>
		<input type="hidden" name="style_font_weight" id="style_font_weight" value="">
		<input type="button" class="button" id="check_title_alt" value="<?php echo L('check_exist')?>" onclick="$.get('?m=special&c=content&a=public_check_title&sid='+Math.random()*5, {data:$('#title').val(), specialid:'<?php echo $_GET['specialid']?>'}, function(data){ if(data=='1') {$('#check_title_alt').val('<?php echo L('title_exist')?>');$('#check_title_alt').css('background-color','#E7505A');} else if(data=='0') {$('#check_title_alt').val('<?php echo L('title_no_exist')?>');$('#check_title_alt').css('background-color','#1E9FFF')}})"/> <input type="hidden" name="style_color" id="style_color" value=""> <script type="text/javascript">$(function(){$("#style_color").minicolors({control:$("#style_color").attr("data-control")||"hue",defaultValue:$("#style_color").attr("data-defaultValue")||"",inline:"true"===$("#style_color").attr("data-inline"),letterCase:$("#style_color").attr("data-letterCase")||"lowercase",opacity:$("#style_color").attr("data-opacity"),position:$("#style_color").attr("data-position")||"bottom left",change:function(t,o){t&&(o&&(t+=", "+o),"object"==typeof console&&console.log(t));$("#title").css("color",$("#style_color").val())},theme:"bootstrap"})});</script>
		<a href="javascript:;" onclick="set_title_color('');$('.minicolors-swatch-color').css('background','');"><?php echo L('清空');?></a>
		<i class="fa fa-bold" onclick="input_font_bold()" style="cursor:pointer"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('keywords')?></label>
                                <div class="col-md-10">
                                    <input type='text' name='info[keywords]' id='keywords' value='' style='width:400px' data-role='tagsinput'>
                                    <span class="help-block"><?php echo L('more_keywords_with_blanks')?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('description')?></label>
                                <div class="col-md-10">
                                    <textarea name="info[description]" id="description" style='width:98%;height:46px;' onkeyup="strlen_verify(this, 'description_len', 255)"></textarea> 还可输入<B><span id="description_len">255</span></B> 个字符
                                </div>
                            </div>
                            <div class="form-group" id="dr_row_content">
                                <label class="control-label col-md-2"><font color="red">*</font> <?php echo L('content')?></label>
                                <div class="col-md-10">
                                    <div id='content_tip'></div><textarea class="dr_ueditor" name="data[content]" id="content"></textarea><?php echo form::editor('content', 'full', '', 'content', '', '', 1, '', '')?><span class="help-block"><div class="mt-checkbox-inline" style="margin-top: 10px;"><label style="margin-bottom: 5px;" class="mt-checkbox mt-checkbox-outline"><input name="add_introduce" type="checkbox"  value="1" checked><?php echo L('iscutcontent')?><span></span></label><label style="width: 80px;margin-right: 15px;"><input type="text" name="introcude_length" value="200" size="3"></label><label style="margin-right: 15px;"><?php echo L('characters_to_contents')?></label><label style="margin-bottom: 5px;" class="mt-checkbox mt-checkbox-outline"><input type='checkbox' name='auto_thumb' value="1" checked><?php echo L('iscutcotent_pic')?><span></span></label><label style="width: 80px;margin-right: 15px;"><input type="text" name="auto_thumb_no" value="1" size="2" class=""></label><label style="margin-right: 15px;"><?php echo L('picture2thumb')?></label></div></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('paginationtype')?></label>
                                <div class="col-md-10">
                                    <select name="data[paginationtype]" id="paginationtype" onchange="if(this.value==1)$('#paginationtype1').css('display','');else $('#paginationtype1').css('display','none');">
                <option value="0"><?php echo L('no_page')?></option>
                <option value="1"><?php echo L('collate_copies')?></option>
                <option value="2"><?php echo L('manual_page')?></option>
            </select>
			<span id="paginationtype1" style="display:none"><input name="data[maxcharperpage]" type="text" id="maxcharperpage" value="10000" size="8" maxlength="8"><?php echo L('number_of_characters')?></span>
                                </div>
                            </div>
                   </div>
                    </div>
                </div>

                
            </div>
            <div class="<?php if (is_mobile(0)){?>col-md-12<?php }else{?>col-md-3<?php }?> my-sysfield" >
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div class="form-body">
                          <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('content_thumb')?></label>
                                <div class="col-md-10">
                                    <div class="upload-pic img-wrap"><div class="bk10"></div><input type="hidden" name="info[thumb]" id="thumb">
						<p><a href="javascript:;" onclick="h5upload('<?php echo SELF;?>', 'thumb_images', '<?php echo L('file_upload')?>','thumb','thumb_images','<?php echo $p?>','content','39','<?php echo $authkey?>',<?php echo SYS_EDITOR;?>);return false;"><img src="<?php echo IMG_PATH;?>icon/upload-pic.png" id="thumb_preview" width="135" height="113" style="cursor:hand" /></a></p><label><button type="button" onclick="crop_cut($('#thumb').val());return false;" class="btn blue btn-sm"> <i class="fa fa-cut"></i> <?php echo L('crop_thumb')?></button></label><script type="text/javascript">function crop_cut(id){
	if (id=='') { Dialog.alert('<?php echo L('please_upload_thumb')?>');return false;}
	var w = 770;
	var h = 510;
	if (is_mobile()) {w = h = '100%';}
	var diag = new Dialog({id:'crop',title:'<?php echo L('crop_thumb')?>',url:'<?php echo SELF;?>?m=content&c=content&a=public_crop&module=cms&spec=2&picurl='+window.btoa(unescape(encodeURIComponent(id)))+'&input=thumb&preview=thumb_preview',width:w,height:h,modal:true});diag.onOk = function(){$DW.dosbumit();return false;};diag.onCancel=function() {$DW.close();};diag.show();
};</script> <label><button type="button" onclick="$('#thumb_preview').attr('src','<?php echo IMG_PATH;?>icon/upload-pic.png');$('#thumb').val('');return false;" class="btn red btn-sm"> <i class="fa fa-trash"></i> <?php echo L('cancel_thumb')?></button></label></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('author')?></label>
                                <div class="col-md-10">
                                    <input type="text" name="data[author]" value="" size="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('islink')?></label>
                                <div class="col-md-10">
                                    <input type="text" name="linkurl" id="linkurl" value="" size="30" maxlength="255" disabled> <div class="mt-checkbox-inline"><label class="mt-checkbox mt-checkbox-outline"><input name="info[islink]" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" > <font color="red"><?php echo L('islink')?></font><span></span></label></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('inputtime')?></label>
                                <div class="col-md-10">
                                    <?php echo form::date('info[inputtime]', format::date(SYS_TIME, 1) , 1);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('template_style')?></label>
                                <div class="col-md-10">
                                    <?php echo form::select($template_list, $style, 'name="data[style]" id="style" onchange="load_file_list(this.value)"', L('please_select'))?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo L('show_template')?></label>
                                <div class="col-md-10">
                                    <span id="show_template"><script type="text/javascript">$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style=<?php echo $style?>&module=special&templates=show&id=<?php echo $show_template?>&name=data', function(data){$('#show_template').html(data.show_template);});</script></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
    </div>
</form>
</div>
</div>
</div>
</div>
<script type="text/javascript"> 
function load_file_list(id) {
	$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&module=special&templates=show&name=data', function(data){$('#show_template').html(data.show_template);});
}
//只能放到最下面
$(function(){
/*
 * 加载禁用外边链接
 */
	$('#linkurl').attr('disabled',true);
	$('#islink').attr('checked',false);
	$('.edit_content').hide();
});
</script>
</body>
</html>