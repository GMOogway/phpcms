<?php
defined('IS_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap/css/bootstrap.min.css" media="all" />
<style type="text/css">
.page-content {margin-left: 0px;margin-top: 0;padding: 25px 20px 10px;}
.main-content {background: #f5f6f8;}
.portlet.light {padding: 12px 20px 15px;background-color: #fff;}
.portlet.light>.portlet-title {padding: 0;color: #181C32;font-weight: 500;}
.portlet.bordered>.portlet-title {border-bottom: 0;}
.portlet>.portlet-title {padding: 0;margin-bottom: 2px;-webkit-border-radius: 4px 4px 0 0;-moz-border-radius: 4px 4px 0 0;-ms-border-radius: 4px 4px 0 0;-o-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;}
.portlet>.portlet-title>.caption {float: left;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;}
.portlet.light>.portlet-title>.caption.caption-md>.caption-subject, .portlet.light>.portlet-title>.caption>.caption-subject {font-size: 15px;}
.font-dark {color: #2f353b!important;}
.portlet>.portlet-title:after,.portlet>.portlet-title:before {content: " ";display: table;}
.portlet>.portlet-title:after {clear: both;}
.portlet>.portlet-title>.nav-tabs {background: 0 0;margin: 1px 0 0;float: right;display: inline-block;border: 0;}
.portlet>.portlet-title>.nav-tabs>li {background: 0 0;margin: 0;border: 0;}
.portlet>.portlet-title>.nav-tabs>li>a {background: 0 0;margin: 5px 0 0 1px;border: 0;padding: 8px 10px;color: #fff;}
.portlet>.portlet-title>.nav-tabs>li.active>a,.portlet>.portlet-title>.nav-tabs>li:hover>a {color: #333;background: #fff;border: 0;}
.portlet.light>.portlet-title>.nav-tabs>li {margin: 0;padding: 0;}
.portlet.light>.portlet-title>.nav-tabs>li>a {margin: 0;padding: 12px 13px 13px;color: #666;}
.portlet.light>.portlet-title>.nav-tabs>li>a {font-size: 14px!important;}
.tabbable-line>.nav-tabs {border: none;margin: 0;}
.tabbable-line>.nav-tabs>li {margin: 0;border-bottom: 4px solid transparent;}
.tabbable-line>.nav-tabs>li>a {background: 0 0!important;border: 0;margin: 0;padding-left: 15px;padding-right: 15px;color: #737373;cursor: pointer;}
.tabbable-line>.nav-tabs>li>a>i {color: #a6a6a6;}
.tabbable-line>.nav-tabs>li.active {background: 0 0;border-bottom: 4px solid #3ea9e2;position: relative;}
.tabbable-line>.nav-tabs>li.active>a {border: 0;color: #333;}
.tabbable-line>.nav-tabs>li.active>a>i {color: #404040;}
.tabbable-line>.nav-tabs>li.open,.tabbable-line>.nav-tabs>li:hover {background: 0 0;border-bottom: 4px solid #dadbde;}
.tabbable-line>.nav-tabs>li.open>a,.tabbable-line>.nav-tabs>li:hover>a {border: 0;background: 0 0!important;color: #333;}
.tabbable-line>.nav-tabs>li.open>a>i,.tabbable-line>.nav-tabs>li:hover>a>i {color: #a6a6a6;}
.tabbable-line>.nav-tabs>li.active {border-bottom: 4px solid #40aae3;}
.form .form-body,.portlet-form .form-body {padding: 20px;}
.form-group .input-inline {margin-right: 5px;}
.input-inline, .radio-list>label.radio-inline {display: inline-block;}
.badge, .input-inline {vertical-align: middle;}
.input-large {width: 320px!important;}
@media (max-width:768px) {
.input-large {width: 250px!important;}
.input-xlarge {width: 300px!important;}
}
</style>
<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo SYS_UPLOAD_URL;?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript">var catid=0</script>
<script type="text/javascript"> 
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){Dialog.alert(msg,function(){$(obj).focus();})}});
		$("#catname").formValidator({onshow:"<?php echo L('input_catname');?>",onfocus:"<?php echo L('input_catname');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_catname');?>"})<?php if(ROUTE_A=='edit') echo '.defaultPassed()';?>;
		$("#url").formValidator({onshow:"<?php echo L('input_linkurl');?>",onfocus:"<?php echo L('input_linkurl');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_linkurl');?>"})<?php if(ROUTE_A=='edit') echo '.defaultPassed()';?>;
	})
	function checkall(){
		<?php echo $checkall;?>
	}
//-->
</script>
<div class="page-content main-content">
<div class="note note-danger my-content-top-tool">
    <p><?php echo L('最多支持创建'.MAX_CATEGORY.'个栏目，请合理的规划网站栏目');?></p>
</div>
<form action="?m=admin&c=category&a=<?php echo ROUTE_A;?>" class="form-horizontal" method="post" name="myform" id="myform" onsubmit="return checkall()">
<input name="dosubmit" type="hidden" value="1">
<input name="catid" type="hidden" value="<?php echo $catid;?>">
<input name="type" type="hidden" value="<?php echo $type;?>">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('catgory_basic').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('catgory_basic');}?> </a>
            </li>
            <li<?php if ($page==1) {?> class="active"<?php }?>>
                <a data-toggle="tab_1" onclick="$('#dr_page').val('1')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('field_manage').'\',this,{tips: [1, \'#000\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-code"></i> <?php if (!is_mobile(0)) {echo L('field_manage');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('parent_category')?></label>
                        <div class="col-md-9">
                            <label><?php echo form::select_category('category_content_'.$this->siteid,$parentid,'name="info[parentid]" id="parentid"',L('please_select_parent_category'),0,-1);?></label>
                        </div>
                    </div>
                    <div class="form-group" id="dr_row_catname">
                        <label class="col-md-2 control-label"><?php echo L('catname')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" name="info[catname]" id="catname" value="<?php echo $catname;?>"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('catgory_img')?></label>
                        <div class="col-md-9">
                            <label><?php echo form::images('info[image]', 'image', $image, 'content');?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('link_url')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="url" name="info[url]" value="<?php echo $url;?>"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('ismenu')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='info[ismenu]' value='1' <?php if($ismenu) echo 'checked';?>> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='info[ismenu]' value='0' <?php if(!$ismenu) echo 'checked';?>> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('可用')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[disabled]' value='0' <?php if(!$setting['disabled']) echo 'checked';?>> <?php echo L('可用');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[disabled]' value='1' <?php if($setting['disabled']) echo 'checked';?>> <?php echo L('禁用');?> <span></span></label>
                            </div>
                            <span class="help-block"><?php echo L('禁用状态下此栏目不能正常访问')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('您现在的位置')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[iscatpos]' value='1' <?php if($setting['iscatpos']) echo 'checked';?>> <?php echo L('display');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[iscatpos]' value='0' <?php if(!$setting['iscatpos']) echo 'checked';?>> <?php echo L('hidden');?> <span></span></label>
                            </div>
                            <span class="help-block"><?php echo L('前端栏目面包屑导航调用不会显示，但可以正常访问，您现在的位置不显示')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('左侧')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[isleft]' value='1' <?php if($setting['isleft']) echo 'checked';?>> <?php echo L('display');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[isleft]' value='0' <?php if(!$setting['isleft']) echo 'checked';?>> <?php echo L('hidden');?> <span></span></label>
                            </div>
                            <span class="help-block"><?php echo L('前端栏目调用左侧不会显示，但可以正常访问')?></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==1) {?> active<?php }?>" id="tab_1">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('html_category')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[ishtml]' value='1' <?php if($setting['ishtml']) echo 'checked';?> onClick="$('#category_php_ruleid').css('display','none');$('#category_html_ruleid').css('display','');$('#tr_domain').css('display','');"> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[ishtml]' value='0' <?php if(!$setting['ishtml']) echo 'checked';?>  onClick="$('#category_php_ruleid').css('display','');$('#category_html_ruleid').css('display','none');$('#tr_domain').css('display','none');"> <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('category_urlrules')?></label>
                        <div class="col-md-9">
                            <label id="category_php_ruleid" style="display:<?php if($setting['ishtml']) echo 'none';?>">
                            <?php echo form::urlrule('content','category',0,$setting['category_ruleid'],'name="category_php_ruleid"');?>
                            </label>
                            <label id="category_html_ruleid" style="display:<?php if(!$setting['ishtml']) echo 'none';?>">
                            <?php echo form::urlrule('content','category',1,$setting['category_ruleid'],'name="category_html_ruleid"');?>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==2) {?> active<?php }?>" id="tab_2">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('available_styles')?></label>
                        <div class="col-md-9">
                            <label><?php echo form::select($template_list, $setting['template_list'], 'name="setting[template_list]" id="template_list" onchange="load_file_list(this.value)"', L('please_select'))?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('page_templates')?></label>
                        <div class="col-md-9">
                            <label id="page_template"></label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==3) {?> active<?php }?>" id="tab_3">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('SEO标题')?></label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="setting[meta_title]" maxlength="255" style="height:90px;"><?php echo $setting['meta_title'];?></textarea>
                            <span class="help-block"><?php echo L('针对搜索引擎设置的标题')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('SEO关键字')?></label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="setting[meta_keywords]" maxlength="255" style="height:90px;"><?php echo $setting['meta_keywords'];?></textarea>
                            <span class="help-block"><?php echo L('关键字中间用半角逗号隔开')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('SEO描述信息')?></label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="setting[meta_description]" maxlength="255" style="height:90px;"><?php echo $setting['meta_description'];?></textarea>
                            <span class="help-block"><?php echo L('针对搜索引擎设置的网页描述')?></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==4) {?> active<?php }?>" id="tab_4">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('role_private')?></label>
                        <div class="col-md-9">
                            <div class="table-list"><table width="100%">
			  <thead>
				<tr>
				  <th align="left" width="200"><?php echo L('role_name');?></th><th><?php echo L('edit');?></th>
			  </tr>
			    </thead>
				 <tbody>
				<?php
				$roles = getcache('role','commons');
				foreach($roles as $roleid=> $rolrname) {
				$disabled = $roleid==1 ? 'disabled' : '';
				?>
		  		<tr>
				  <td><?php echo $rolrname?></td>
				  <td align="center"><label class="mt-checkbox mt-checkbox-outline"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> <?php echo $this->check_category_priv('init',$roleid);?> value="init,<?php echo $roleid;?>" ><span></span></label></td>
			  </tr>
			  <?php }?>
	
			 </tbody>
			</table></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('group_private')?></label>
                        <div class="col-md-9">
                            <div class="table-list"><table width="100%">
			  <thead>
				<tr>
				  <th align="left" width="200"><?php echo L('group_name');?></th><th><?php echo L('allow_vistor');?></th>
			  </tr>
			    </thead>
				 <tbody>
			<?php
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
			if($_value['groupid']==1) continue;
			?>
		  		<tr>
				  <td><?php echo $_value['name'];?></td>
				  <td align="center"><label class="mt-checkbox mt-checkbox-outline"><input type="checkbox" name="priv_groupid[]" <?php echo $this->check_category_priv('visit',$_value['groupid'],0);?>  value="visit,<?php echo $_value['groupid'];?>" ><span></span></label></td>
			  </tr>
			<?php }?>
			 </tbody>
			</table></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==5) {?> active<?php }?>" id="tab_5">
                <div class="form-body">

<?php
if($forminfos && is_array($forminfos['base'])) {
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
                    <div class="form-group" id="dr_row_<?php echo $field?>">
                        <label class="col-md-2 control-label"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?></label>
                        <div class="col-md-9">
                            <label><?php echo $info['form']?></label>
                            <span class="help-block" id="dr_<?php echo $field?>_tips"><?php echo $info['tips']?></span>
                        </div>
                    </div>
<?php
} }
?>

                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>
<script type="text/javascript">
$('.nav-tabs a').click(function (e) {
    $('.nav-tabs').find('li').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(this).parent().addClass('active');
    $('#'+$(this).attr("data-toggle")).addClass('active');
})
window.top.$('#display_center_id').css('display','none');
function load_file_list(id) {
    if(id=='') return false;
    $.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&catid=<?php echo $catid?>&type=1', function(data){$('#page_template').html(data.page_template);});
}
<?php if(isset($setting['template_list']) && !empty($setting['template_list'])) echo "load_file_list('".$setting['template_list']."')"?>
</script>
</body>
</html>