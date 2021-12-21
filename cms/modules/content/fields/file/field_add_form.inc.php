
	<div class="form-group">
      <label class="col-md-2 control-label">文本框长度</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[size]"  size="10" class="input-text"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">默认值</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[defaultvalue]"  size="40" class="input-text"></label>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">允许上传的文件类型</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_allowext]" value="pdf|doc|docx|xls|wps|rar|zip|7z|jpg|jpeg|png|bmp" size="60" class="input-text"></label>
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
