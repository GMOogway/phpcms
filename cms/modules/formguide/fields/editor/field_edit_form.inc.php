<?php defined('IN_CMS') or exit('No permission resources.');$siteinfo = getcache('sitelist', 'commons');$config = string2array($siteinfo[$this->siteid]['setting']);?>
    <div class="form-group">
      <label class="col-md-2 control-label">编辑器默认宽度</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="20" class="input-text"></label>
            <span class="help-block"><?php echo L('[整数]表示固定宽度；[整数%]表示百分比')?></span>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">编辑器默认高度</label>
        <div class="col-md-9">
            <label><input type="text" name="setting[height]" value="<?php echo $setting['height'];?>" size="20" class="input-text"></label>
            <span class="help-block"><?php echo L('px')?></span>
        </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">编辑器样式</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[toolbar]" value="basic" onclick="$('#bjqms').hide()" <?php if($setting['toolbar']=='basic') echo 'checked';?>>简洁型 <span></span></label>
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[toolbar]" value="standard" onclick="$('#bjqms').hide()" <?php if($setting['toolbar']=='standard') echo 'checked';?>> 标准型 <span></span></label>
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[toolbar]" value="full" onclick="$('#bjqms').hide()" <?php if($setting['toolbar']=='full') echo 'checked';?>> 完整型 <span></span></label>
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[toolbar]" value="modetool" onclick="$('#bjqms').show()" <?php if($setting['toolbar']=='modetool') echo 'checked';?>> 自定义 <span></span></label>
            </div>
        </div>
    </div>
    <div class="form-group" id="bjqms"<?php if($setting['toolbar']!='modetool') echo ' style="display:none;"';?>>
      <label class="col-md-2 control-label">工具栏</label>
        <div class="col-md-9">
            <textarea name="setting[toolvalue]" id="toolvalue" style="height:90px;" class="form-control"><?php echo $setting['toolvalue'];?></textarea>
            <span class="help-block"><?php if (SYS_EDITOR) {?><?php } else {?>必须严格按照Ueditor工具栏格式：'Fullscreen', 'Source', '|', 'Undo', 'Redo'<?php }?></span>
        </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">默认值</label>
        <div class="col-md-9">
        <div class="col-md-9">
            <textarea name="setting[defaultvalue]" id="defaultvalue" style="height:90px;" class="form-control"><?php echo $setting['defaultvalue'];?></textarea>
        </div>
    </div>
    <div class="form-group"> 
      <label class="col-md-2 control-label">是否启用关联链接</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablekeylink]" value="1" <?php if($setting['enablekeylink']) echo 'checked';?>>是 <span></span></label>
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablekeylink]" value="0" <?php if(!$setting['enablekeylink']) echo 'checked';?>> 否 <span></span></label>
            </div>
        </div>
    </div>
    <div class="form-group"> 
      <label class="col-md-2 control-label">替换次数</label>
        <div class="col-md-9">
            <label><input type="text" name="setting[replacenum]" value="<?php echo $setting['replacenum'];?>" size="4" class="input-text"></label>
            <span class="help-block"><?php echo L('（留空则为替换全部）')?></span>
        </div>
    </div>
    <div class="form-group"> 
      <label class="col-md-2 control-label">关联链接方式</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[link_mode]" value="1" <?php if($setting['link_mode']) echo 'checked';?>> 关键字链接 <span></span></label>
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[link_mode]" value="0" <?php if(!$setting['link_mode']) echo 'checked';?>> 网址链接 <span></span></label>
            </div>
        </div>
    </div>
    <div class="form-group"<?php if (!SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <label class="col-md-2 control-label">编辑器颜色</label>
        <div class="col-md-9">
            <label><?php echo color_select('setting[color]', $setting['color']);?></label>
        </div>
    </div>
    <div class="form-group"<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <label class="col-md-2 control-label">编辑器样式</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[theme]" value="default" <?php if($setting['theme']=='default') echo 'checked';?>> 默认 <span></span></label>
                <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[theme]" value="notadd" <?php if($setting['theme']=='notadd') echo 'checked';?>> 样式1 <span></span></label>
            </div>
        </div>
    </div>
    <div class="form-group"<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
        <label class="col-md-2 control-label">固定编辑器图标栏</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[autofloat]" value="1" <?php if($setting['autofloat']) echo 'checked';?>> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[autofloat]" value="0" <?php if(!$setting['autofloat']) echo 'checked';?>> 否 <span></span></label>
        </div>
        </div>
    </div>
    <div class="form-group"<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <label class="col-md-2 control-label">将div标签转换为p标签</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[div2p]" value="1" <?php if($setting['div2p']) echo 'checked';?>> 开启 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[div2p]" value="0" <?php if(!$setting['div2p']) echo 'checked';?>> 关闭 <span></span></label>
        </div>
        </div>
    </div>
    <div class="form-group"<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <label class="col-md-2 control-label">自动伸长高度</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[autoheight]" value="1" <?php if($setting['autoheight']) echo 'checked';?>> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[autoheight]" value="0" <?php if(!$setting['autoheight']) echo 'checked';?>> 否 <span></span></label>
        </div>
        </div>
    </div>
    <div class="form-group"<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <label class="col-md-2 control-label">回车换行符号</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enter]" value="1" <?php if($setting['enter']) echo 'checked';?>> br标签 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enter]" value="0" <?php if(!$setting['enter']) echo 'checked';?>> p标签 <span></span></label>
        </div>
            <span class="help-block"><?php echo L('选择回车换行的符号，默认是p标签换行')?></span>
        </div>
    </div>
    <div class="form-group"<?php if (SYS_EDITOR) {?> style="display: none;"<?php }?>> 
      <label class="col-md-2 control-label">是否取消单图上传按钮</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[simpleupload]" value="1" <?php if($setting['simpleupload']) echo 'checked';?>> 开启 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[simpleupload]" value="0" <?php if(!$setting['simpleupload']) echo 'checked';?>> 关闭 <span></span></label>
        </div>
            <span class="help-block"><?php echo L('单图上传按钮对某些浏览器不被支持，兼容性较差')?></span>
        </div>
    </div>
    <?php if ($config['ueditor']) {?>
    <div class="form-group">
      <label class="col-md-2 control-label">图片水印</label>
        <div class="col-md-9">
            <div class="form-control-static">系统强制开启水印</div>
        </div>
    </div>
    <?php } else {?>
    <div class="form-group">
      <label class="col-md-2 control-label">图片水印</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="1" <?php if($setting['watermark']) echo 'checked';?>> 开启 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="0" <?php if(!$setting['watermark']) echo 'checked';?>> 关闭 <span></span></label>
        </div>
        </div>
    </div>
    <?php }?>
    <?php echo attachment($setting);?>
    <div class="form-group">
      <label class="col-md-2 control-label">是否保存远程图片</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablesaveimage]" value="1" <?php if($setting['enablesaveimage']) echo 'checked';?>> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[enablesaveimage]" value="0" <?php if(!$setting['enablesaveimage']) echo 'checked';?>> 否 <span></span></label>
        </div>
        </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">本地图片自动上传</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[local_img]" value="1" <?php if($setting['local_img']) echo 'checked';?>> 是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[local_img]" value="0" <?php if(!$setting['local_img']) echo 'checked';?>> 否 <span></span></label>
        </div>
        </div>
    </div>
    <?php if ($config['ueditor']) {?>
    <div class="form-group">
      <label class="col-md-2 control-label">本地图片上传水印</label>
        <div class="col-md-9">
            <div class="form-control-static">系统强制开启水印</div>
        </div>
    </div>
    <?php } else {?>
    <div class="form-group">
      <label class="col-md-2 control-label">本地图片上传水印</label>
        <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[local_watermark]" value="1" <?php if($setting['local_watermark']) echo 'checked';?>> 开启 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[local_watermark]" value="0" <?php if(!$setting['local_watermark']) echo 'checked';?>> 关闭 <span></span></label>
        </div>
        </div>
    </div>
    <?php }?>
    <?php echo local_attachment($setting);?>