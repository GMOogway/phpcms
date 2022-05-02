
	<div class="form-group">
      <label class="col-md-2 control-label">文件大小</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_maxsize]" value="0" size="40" class="form-control"></label>
            <span class="help-block">单位MB</span>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">扩展名</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_allowext]" value="gif|jpg|jpeg|png|bmp" size="40" class="form-control"></label>
            <span class="help-block">格式：jpg|gif|png|exe|html|php|rar|zip</span>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">显示浏览附件</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="1">是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="0" checked> 否 <span></span></label>
        </div></label>
        <span class="help-block">允许用户选取自己已经上传的附件</span>
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
      <label class="col-md-2 control-label">上传数量</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_number]" value="10" class="form-control"></label>
      </div>
    </div>
    <?php echo attachment(array());?>
