
	<div class="form-group">
      <label class="col-md-2 control-label">允许上传的图片类型</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_allowext]" value="gif|jpg|jpeg|png|bmp" size="40" class="input-text"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">是否从已上传中选择</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="1">是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="0" checked> 否 <span></span></label>
        </div></label>
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
	<div class="form-group">
      <label class="col-md-2 control-label">允许同时上传的个数</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_number]" value="10" size=3 class="input-text"></label>
      </div>
    </div>
    <?php echo attachment(array());?>
