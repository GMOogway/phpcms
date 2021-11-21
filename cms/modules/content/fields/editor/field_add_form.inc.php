<?php $siteinfo = getcache('sitelist', 'commons');$config = string2array($siteinfo[$this->siteid]['setting']);?>
<table cellpadding="2" cellspacing="1" width="98%">
    <tr> 
      <td>编辑器默认宽度：</td>
      <td><input type="text" name="setting[width]" value="" size="20" class="input-text"> [整数]表示固定宽度；[整数%]表示百分比</td>
    </tr>
	<tr> 
      <td>编辑器默认高度：</td>
      <td><input type="text" name="setting[height]" value="" size="20" class="input-text"> px</td>
    </tr>
    <tr> 
      <td width="140">编辑器样式：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[toolbar]" value="basic" onclick="$('#bjqms').hide()" checked> 简洁型 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[toolbar]" value="standard" onclick="$('#bjqms').hide()"> 标准型 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[toolbar]" value="full" onclick="$('#bjqms').hide()"> 完整型 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[toolbar]" value="modetool" onclick="$('#bjqms').show()"> 自定义 <span></span></label>
        </div></td>
    </tr>
    <tr id="bjqms" style="display:none;">
      <td>工具栏：</td>
      <td><textarea name="setting[toolvalue]" rows="2" cols="20" id="toolvalue" style="height:100px;width:250px;">'Bold', 'Italic', 'Underline'</textarea><br><?php if (SYS_EDITOR) {?>必须严格按照CKEditor工具栏格式：'Maximize', 'Source', '-', 'Undo', 'Redo'<?php } else {?>必须严格按照Ueditor工具栏格式：'Fullscreen', 'Source', '|', 'Undo', 'Redo'<?php }?></td>
    </tr>
    <tr>
      <td>默认值：</td>
      <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:100px;width:250px;"></textarea></td>
    </tr>
    <tr<?php if(!$this->input->get('modelid') || $this->input->get('modelid')==-1 || $this->input->get('modelid')==-2) {echo ' style="display: none;"';}?>> 
      <td>是否启用关联链接：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablekeylink]" value="1">是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablekeylink]" value="0" checked> 否 <span></span></label><input type="text" name="setting[replacenum]" value="1" size="4" class="input-text"> 替换次数 （留空则为替换全部）
          </div></td>
    </tr>
    <tr<?php if(!$this->input->get('modelid') || $this->input->get('modelid')==-1 || $this->input->get('modelid')==-2) {echo ' style="display: none;"';}?>> 
      <td>关联链接方式：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[link_mode]" value="1" checked> 关键字链接 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[link_mode]" value="0"> 网址链接 <span></span></label>
        </div></td>
    </tr>
    <tr<?php if (!SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <td>编辑器颜色：</td>
      <td><?php echo color_select('setting[color]', '');?></td>
    </tr>
    <tr<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <td>编辑器样式：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[theme]" value="default" checked> 默认 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[theme]" value="notadd"> 样式1 <span></span></label>
        </div></td>
    </tr>
    <tr<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <td>固定编辑器图标栏：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[autofloat]" value="1"> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[autofloat]" value="0" checked> 否 <span></span></label>
        </div></td>
    </tr>
    <tr<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <td>将div标签转换为p标签：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[div2p]" value="1" checked> 开启 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[div2p]" value="0"> 关闭 <span></span></label>
        </div></td>
    </tr>
    <tr<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <td>自动伸长高度：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[autoheight]" value="1"> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[autoheight]" value="0" checked> 否 <span></span></label>
        </div></td>
    </tr>
    <tr<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <td>回车换行符号：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enter]" value="1"> br标签 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enter]" value="0" checked> p标签 <span></span></label>
        </div> 选择回车换行的符号，默认是p标签换行</td>
    </tr>
    <tr<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <td>是否取消单图上传按钮：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[simpleupload]" value="1"> 开启 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[simpleupload]" value="0" checked> 关闭 <span></span></label>
        </div> 单图上传按钮对某些浏览器不被支持，兼容性较差</td>
    </tr>
    <?php if ($config['ueditor']) {?>
    <tr> 
      <td>图片水印：</td>
      <td>系统强制开启水印</td>
    </tr>
    <?php } else {?>
    <tr> 
      <td>图片水印：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="1" checked> 开启 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="0"> 关闭 <span></span></label>
        </div></td>
    </tr>
    <?php }?>
    <?php echo attachment(array(), 1);?>
    <tr> 
      <td>是否保存远程图片：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablesaveimage]" value="1" checked> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablesaveimage]" value="0"> 否 <span></span></label>
        </div></td>
    </tr>
    <tr> 
      <td>本地图片自动上传：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[local_img]" value="1" checked> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[local_img]" value="0" > 否 <span></span></label>
        </div></td>
    </tr>
    <?php if ($config['ueditor']) {?>
    <tr> 
      <td>本地图片上传水印：</td>
      <td>系统强制开启水印</td>
    </tr>
    <?php } else {?>
    <tr> 
      <td>本地图片上传水印：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[local_watermark]" value="1" checked> 开启 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[local_watermark]" value="0" > 关闭 <span></span></label>
        </div></td>
    </tr>
    <?php }?>
    <?php echo local_attachment(array(), 1);?>
    <?php if(!$this->input->get('modelid') || $this->input->get('modelid')==-1 || $this->input->get('modelid')==-2) {?>
    <tr style="display: none;">
      <td>显示分页符与子标题：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[disabled_page]" value="1" checked> 禁止<span></span></label>
        </div></td>
    </tr>
    <?php } else {?>
    <tr>
      <td>显示分页符与子标题：</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[disabled_page]" value="1"> 禁止 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[disabled_page]" value="0" checked> 显示 <span></span></label>
        </div></td>
    </tr>
    <?php }?>
</table>