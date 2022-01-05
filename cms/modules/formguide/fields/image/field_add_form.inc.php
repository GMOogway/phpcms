
	<div class="form-group">
      <label class="col-md-2 control-label">文本框长度</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[size]"  size="10" class="form-control"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">默认值</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[defaultvalue]"  size="40" class="form-control"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">表单显示模式</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[show_type]" value="1" /> 图片模式 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio"  name="setting[show_type]" value="0" checked/> 文本框模式 <span></span></label>
        </div></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">文件大小</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_maxsize]" value="0" size="40" class="form-control"></label>
            <span class="help-block">单位MB</span>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">允许上传的图片类型</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_allowext]" value="gif|jpg|jpeg|png|bmp" size="40" class="form-control"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">是否在图片上添加水印</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="1">是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="0" checked> 否 <span></span></label>
        </div></label>
      </div>
    </div>
    <?php echo attachment(array());?>
	<div class="form-group">
      <label class="col-md-2 control-label">是否从已上传中选择</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="1" checked>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="0"> 否 <span></span></label>
        </div></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">图像大小</label>
      <div class="col-md-9">
          <div class="input-inline input-medium">
              <label><div class="input-group">
                  <span class="input-group-addon">宽</span>
                  <input type="text" name="setting[images_width]" value="" class="form-control">
                  <span class="input-group-addon">px</span>
              </div></label>
              <label><div class="input-group">
                  <span class="input-group-addon">高</span>
                  <input type="text" name="setting[images_height]" value="" class="form-control">
                  <span class="input-group-addon">px</span>
              </div></label>
          </div>
      </div>
    </div>
