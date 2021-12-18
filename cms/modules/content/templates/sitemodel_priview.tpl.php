<?php
defined('IS_ADMIN') or exit('No permission resources.');$addbg=1;
include $this->admin_tpl('header','admin');?>
<link rel="stylesheet" href="<?php echo JS_PATH?>layui/css/layui.css" media="all" />
<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo SYS_UPLOAD_URL;?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<link href="<?php echo JS_PATH?>jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH?>jquery-minicolors/jquery.minicolors.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript">var catid=<?php echo $catid;?></script>
<div class="page-content main-content">
<div class="form-horizontal">
<div class="myfbody">
        <div class="row ">
            <div class="col-md-9">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-blue sbold"></span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="form-body clear">
                           <?php
if(is_array($forminfos['base'])) {
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
<div class="form-group">
    <label class="control-label col-md-2"><?php if($info['star']){ ?><span class="required" aria-required="true"> * </span><?php } ?><?php echo $info['name']?></label>
    <div class="col-md-10">
		<?php echo $info['form']?>
		<span class="help-block"><?php echo $info['tips']?></span>
	</div>
</div>
<?php
} }
?>
                        </div>
                    </div>
                </div>

                
            </div>
            <div class="col-md-3 my-sysfield">
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div class="form-body clear">
<?php
if(is_array($forminfos['senior'])) {
 foreach($forminfos['senior'] as $field=>$info) {
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
<div class="form-group">
    <label class="control-label col-md-2"><?php if($info['star']){ ?><span class="required" aria-required="true"> * </span><?php } ?><?php echo $info['name']?></label>
    <div class="col-md-10">
		<?php echo $info['form']?>
		<span class="help-block"><?php echo $info['tips']?></span>
	</div>
</div>
<?php
} }
?>
<?php if($_SESSION['roleid']==1 || $priv_status) {?>
<div class="form-group">
    <label class="control-label col-md-2"><?php echo L('c_status');?></label>
    <div class="col-md-10">
		<div class="mt-radio-inline"><label class="mt-radio mt-radio-outline"><input type="radio" name="status" value="99" checked/> <?php echo L('c_publish');?> <span></span></label>
<?php if(isset($workflowid) && $workflowid) { ?><label class="mt-radio mt-radio-outline"><input type="radio" name="status" value="1" > <?php echo L('c_check');?> <span></span></label><?php }?>
</div>
	</div>
</div>
<?php }?>

                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
<script type="text/javascript"> 
<!--
//只能放到最下面
$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){Dialog.alert(msg,function(){$(obj).focus();
	boxid = $(obj).attr('id');
	if($('#'+boxid).attr('boxid')!=undefined) {
		check_content(boxid);
	}
	})}});
	<?php echo isset($formValidator) && $formValidator ? $formValidator : '';?>
	
/*
 * 加载禁用外边链接
 */

	$('#linkurl').attr('disabled',true);
	$('#islink').attr('checked',false);
	$('.edit_content').hide();
})
document.title='<?php echo L('priview_modelfield');?>';
//-->
</script>