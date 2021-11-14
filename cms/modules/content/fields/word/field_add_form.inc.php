<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>是否在图片上添加水印</td>
      <td><div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="1">是 <span></span></label>
          <label class="mt-radio mt-radio-outline"><input type="radio" name="setting[watermark]" value="0" checked> 否 <span></span></label>
        </div></td>
    </tr>
    <?php echo attachment(array(), 1);?>
</table>