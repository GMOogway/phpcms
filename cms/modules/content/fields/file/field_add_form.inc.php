
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
      <label class="col-md-2 control-label">文件大小</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_maxsize]" value="0" size="40" class="form-control"></label>
            <span class="help-block">单位MB</span>
      </div>
    </div>
	<div class="form-group">
      <label class="col-md-2 control-label">扩展名</label>
      <div class="col-md-9">
            <label><input type="text" name="setting[upload_allowext]" value="pdf|doc|docx|xls|wps|rar|zip|7z|jpg|jpeg|png|bmp" size="60" class="form-control"></label>
            <span class="help-block">格式：jpg|gif|png|exe|html|php|rar|zip</span>
      </div>
    </div>
    <?php echo attachment(array());?>
	<div class="form-group">
      <label class="col-md-2 control-label">显示浏览附件</label>
      <div class="col-md-9">
            <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="1" checked>是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[isselectimage]" value="0"> 否 <span></span></label>
        </div></label>
        <span class="help-block">允许用户选取自己已经上传的附件</span>
      </div>
    </div>
