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
		$("#modelid").formValidator({onshow:"<?php echo L('select_model');?>",onfocus:"<?php echo L('select_model');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('select_model');?>"});
		$("#url").formValidator({onshow:" ",onfocus:"<?php echo L('domain_name_format');?>",tipcss:{width:'300px'},empty:true}).inputValidator({onerror:"<?php echo L('domain_name_format');?>"}).regexValidator({regexp:"^http(s?):\/\/(.+)\/$",onerror:"<?php echo L('domain_end_string');?>"});
		$("#template_list").formValidator({onshow:"<?php echo L('template_setting');?>",onfocus:"<?php echo L('template_setting');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('template_setting');?>"});
		<?php echo $formValidator;?>
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
<form action="?m=admin&c=category&a=add" class="form-horizontal" method="post" name="myform" id="myform" onsubmit="return checkall()">
<input name="dosubmit" type="hidden" value="1">
<input name="catid" type="hidden" value="<?php echo isset($catid) && $catid ? $catid : 0;?>">
<input name="page" id="dr_page" type="hidden" value="<?php echo $page;?>">
<div class="portlet light bordered">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float:left;">
            <li<?php if ($page==0) {?> class="active"<?php }?>>
                <a data-toggle="tab_0" onclick="$('#dr_page').val('0')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('catgory_basic').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-cog"></i> <?php if (!is_mobile(0)) {echo L('catgory_basic');}?> </a>
            </li>
            <li<?php if ($page==1) {?> class="active"<?php }?>>
                <a data-toggle="tab_1" onclick="$('#dr_page').val('1')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('catgory_createhtml').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-file-code-o"></i> <?php if (!is_mobile(0)) {echo L('catgory_createhtml');}?> </a>
            </li>
            <li<?php if ($page==2) {?> class="active"<?php }?>>
                <a data-toggle="tab_2" onclick="$('#dr_page').val('2')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('catgory_template').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-html5"></i> <?php if (!is_mobile(0)) {echo L('catgory_template');}?> </a>
            </li>
            <li<?php if ($page==3) {?> class="active"<?php }?>>
                <a data-toggle="tab_3" onclick="$('#dr_page').val('3')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('catgory_seo').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-internet-explorer"></i> <?php if (!is_mobile(0)) {echo L('catgory_seo');}?> </a>
            </li>
            <li<?php if ($page==4) {?> class="active"<?php }?>>
                <a data-toggle="tab_4" onclick="$('#dr_page').val('4')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('catgory_private').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-user-circle"></i> <?php if (!is_mobile(0)) {echo L('catgory_private');}?> </a>
            </li>
            <li<?php if ($page==5) {?> class="active"<?php }?>>
                <a data-toggle="tab_5" onclick="$('#dr_page').val('5')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('catgory_readpoint').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-rmb"></i> <?php if (!is_mobile(0)) {echo L('catgory_readpoint');}?> </a>
            </li>
            <li<?php if ($page==6) {?> class="active"<?php }?>>
                <a data-toggle="tab_6" onclick="$('#dr_page').val('6')"<?php if (is_mobile(0)) {echo ' onmouseover="layer.tips(\''.L('field_manage').'\',this,{tips: [1, \'#fff\']});" onmouseout="layer.closeAll();"';}?>> <i class="fa fa-code"></i> <?php if (!is_mobile(0)) {echo L('field_manage');}?> </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body form">
        <div class="tab-content">
            <div class="tab-pane<?php if ($page==0) {?> active<?php }?>" id="tab_0">

                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('add_category_types')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="addtype" value="0" checked onclick="$('#catdir_tr').show();$('#normal_add').show();$('#normal_add').show();$('#batch_add').hide();"> <?php echo L('normal_add');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type="radio" name="addtype" value="1" onclick="$('#catdir_tr').hide();$('#normal_add').hide();$('#normal_add').hide();$('#batch_add').show();"> <?php echo L('batch_add');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="dr_row_modelid">
                        <label class="col-md-2 control-label"><?php echo L('select_model')?></label>
                        <div class="col-md-9">
                            <label><?php
                            $model_datas = array();
                            foreach($models as $_k=>$_v) {
                                if($_v['siteid']!=$this->siteid) continue;
                                $model_datas[$_v['modelid']] = $_v['name'];
                            }
                            echo form::select($model_datas,isset($modelid) && $modelid ? $modelid : '','name="info[modelid]" id="modelid" onchange="change_tpl(this.value)"',L('select_model'));
                            ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('parent_category')?></label>
                        <div class="col-md-9">
                            <label><?php echo form::select_category('category_content_'.$this->siteid,$parentid,'name="info[parentid]" id="parentid"',L('please_select_parent_category'),0,-1);?></label>
                        </div>
                    </div>
                    <div class="form-group" id="dr_row_catname">
                        <label class="col-md-2 control-label"><?php echo L('catname')?></label>
                        <div class="col-md-9">
                            <label id="normal_add"><input class="form-control input-large" type="text" name="info[catname]" id="catname" value="" onblur="topinyin('catdir','catname','?m=admin&c=category&a=public_ajax_pinyin');"></label>
                            <span id="batch_add" style="display:none"><textarea class="form-control" name="batch_add" id="batch" maxlength="255" style="height:90px;"></textarea>
                            <span class="help-block" id="dr_catname_tips"><?php echo L('batch_add_tips')?></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('catdir')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="catdir" name="info[catdir]" value=""></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('catgory_img')?></label>
                        <div class="col-md-9">
                            <label><?php echo form::images('info[image]', 'image', $image, 'content');?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('description')?></label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="info[description]" maxlength="255" style="height:90px;"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('workflow')?></label>
                        <div class="col-md-9">
                            <label><?php
        $workflows = getcache('workflow_'.$this->siteid,'commons');
        if($workflows) {
            $workflows_datas = array();
            foreach($workflows as $_k=>$_v) {
                $workflows_datas[$_v['workflowid']] = $_v['workname'];
            }
            echo form::select($workflows_datas,'','name="setting[workflowid]"',L('catgory_not_need_check'));
        } else {
            echo '<input type="hidden" name="setting[workflowid]" value="">';
            echo L('add_workflow_tips');
        }
    ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('ismenu')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='info[ismenu]' value='1' checked> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='info[ismenu]' value='0'  > <?php echo L('no');?> <span></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('可用')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[disabled]' value='0' checked> <?php echo L('可用');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[disabled]' value='1'  > <?php echo L('禁用');?> <span></span></label>
                            </div>
                            <span class="help-block"><?php echo L('禁用状态下此栏目不能正常访问')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('您现在的位置')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[iscatpos]' value='1' checked> <?php echo L('display');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[iscatpos]' value='0'  > <?php echo L('hidden');?> <span></span></label>
                            </div>
                            <span class="help-block"><?php echo L('前端栏目面包屑导航调用不会显示，但可以正常访问，您现在的位置不显示')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('左侧')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[isleft]' value='1' checked> <?php echo L('display');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[isleft]' value='0'> <?php echo L('hidden');?> <span></span></label>
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
                        <label class="col-md-2 control-label"><?php echo L('html_show')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[content_ishtml]' value='1' <?php if($setting['content_ishtml']) echo 'checked';?> onClick="$('#show_php_ruleid').css('display','none');$('#show_html_ruleid').css('display','')"> <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[content_ishtml]' value='0' <?php if(!$setting['content_ishtml']) echo 'checked';?>  onClick="$('#show_php_ruleid').css('display','');$('#show_html_ruleid').css('display','none')"> <?php echo L('no');?> <span></span></label>
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
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('show_urlrules')?></label>
                        <div class="col-md-9">
                            <label id="show_php_ruleid" style="display:<?php if($setting['content_ishtml']) echo 'none';?>">
                                <?php echo form::urlrule('content','show',0,$setting['category_ruleid'],'name="show_php_ruleid"');?>
                            </label>
                            <label id="show_html_ruleid" style="display:<?php if(!$setting['content_ishtml']) echo 'none';?>">
                                <?php echo form::urlrule('content','show',1,$setting['category_ruleid'],'name="show_html_ruleid"');?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('create_to_rootdir')?></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[create_to_html_root]' value='1' <?php if($setting['create_to_html_root']) echo 'checked';?> > <?php echo L('yes');?> <span></span></label>
                                <label class="mt-radio mt-radio-outline"><input type='radio' name='setting[create_to_html_root]' value='0' <?php if(!$setting['create_to_html_root']) echo 'checked';?> > <?php echo L('no');?> <span></span></label>
                            </div>
                            <span class="help-block"><?php echo L('create_to_rootdir_tips');?></span>
                        </div>
                    </div>
                    <div class="form-group" id="tr_domain" style="display:<?php if(!$setting['ishtml']) echo 'none';?>">
                        <label class="col-md-2 control-label"><?php echo L('domain')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" id="url" name="info[url]" value=""></label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==2) {?> active<?php }?>" id="tab_2">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label">列表信息数</label>
                        <div class="col-md-9">
                            <label><input class="form-control" type="text" value="10" name="setting[pagesize]"></label>
                            <span class="help-block">列表页面每页显示的信息数量，静态生成时调用此参数</span>
                        </div>
                    </div>
                    <div class="form-group" id="dr_row_template_list">
                        <label class="col-md-2 control-label"><?php echo L('available_styles')?></label>
                        <div class="col-md-9">
                            <label><?php echo form::select($template_list, $setting['template_list'], 'name="setting[template_list]" id="template_list" onchange="load_file_list(this.value)"', L('please_select'))?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('category_index_tpl')?></label>
                        <div class="col-md-9">
                            <label id="category_template"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('category_list_tpl')?></label>
                        <div class="col-md-9">
                            <label id="list_template"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('content_tpl')?></label>
                        <div class="col-md-9">
                            <label id="show_template"></label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==3) {?> active<?php }?>" id="tab_3">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('SEO标题')?></label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="setting[meta_title]" maxlength="255" style="height:90px;"></textarea>
                            <span class="help-block"><?php echo L('针对搜索引擎设置的标题')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('SEO关键字')?></label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="setting[meta_keywords]" maxlength="255" style="height:90px;"></textarea>
                            <span class="help-block"><?php echo L('关键字中间用半角逗号隔开')?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('SEO描述信息')?></label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="setting[meta_description]" maxlength="255" style="height:90px;"></textarea>
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
                            <div class="user_group J_check_wrap">
                                <dl>
                                    <?php
                                    $roles = getcache('role','commons');
                                    foreach($roles as $roleid=> $rolrname) {
                                    $disabled = $roleid==1 ? 'disabled' : '';
                                    ?>
                                    <dt>
                                        <label class="mt-checkbox mt-checkbox-outline"><input type="checkbox" data-direction="y" data-checklist="J_check_priv_roleid<?php echo $roleid;?>" class="checkbox J_check_all" <?php echo $disabled;?>/><?php echo $rolrname?><span></span></label>
                                    </dt>
                                    <dd>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="init,<?php echo $roleid;?>" ><?php echo L('view');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="add,<?php echo $roleid;?>" ><?php echo L('add');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="edit,<?php echo $roleid;?>" ><?php echo L('edit');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="delete,<?php echo $roleid;?>" ><?php echo L('delete');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="listorder,<?php echo $roleid;?>" ><?php echo L('listorder');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="push,<?php echo $roleid;?>" ><?php echo L('push');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="remove,<?php echo $roleid;?>" ><?php echo L('move');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="copy,<?php echo $roleid;?>" ><?php echo L('copy');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="recycle_init,<?php echo $roleid;?>" ><?php echo L('recycle');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="recycle,<?php echo $roleid;?>" ><?php echo L('restore');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_roleid<?php echo $roleid;?>" name="priv_roleid[]" <?php echo $disabled;?> value="update,<?php echo $roleid;?>" ><?php echo L('update');?><span></span></label>
                                    </dd>
                                    <?php }?>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('group_private')?></label>
                        <div class="col-md-9">
                            <div class="user_group J_check_wrap">
                                <dl>
                                    <?php
                                    $group_cache = getcache('grouplist','member');
                                    foreach($group_cache as $_key=>$_value) {
                                    if($_value['groupid']==1) continue;
                                    ?>
                                    <dt>
                                        <label class="mt-checkbox mt-checkbox-outline"><input type="checkbox" data-direction="y" data-checklist="J_check_priv_groupid<?php echo $_value['groupid'];?>" class="checkbox J_check_all"/><?php echo $_value['name'];?><span></span></label>
                                    </dt>
                                    <dd>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_groupid<?php echo $_value['groupid'];?>" name="priv_groupid[]" value="visit,<?php echo $_value['groupid'];?>" ><?php echo L('allow_vistor');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_groupid<?php echo $_value['groupid'];?>" name="priv_groupid[]" value="add,<?php echo $_value['groupid'];?>" ><?php echo L('allow_contribute');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_groupid<?php echo $_value['groupid'];?>" name="priv_groupid[]" value="edit,<?php echo $_value['groupid'];?>" ><?php echo L('edit');?><span></span></label>
                                        <label class="mt-checkbox mt-checkbox-outline"><input class="J_check" type="checkbox" data-yid="J_check_priv_groupid<?php echo $_value['groupid'];?>" name="priv_groupid[]" value="delete,<?php echo $_value['groupid'];?>" ><?php echo L('delete');?><span></span></label>
                                    </dd>
                                    <?php }?>
                                </dl>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==5) {?> active<?php }?>" id="tab_5">
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('contribute_add_point')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" name="setting[presentpoint]" id="presentpoint" value=""></label>
                            <span class="help-block"><?php echo L('contribute_add_point_tips');?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('default_readpoint')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" name="setting[defaultchargepoint]" id="defaultchargepoint" value=""></label>
                            <label><select name="setting[paytype]"><option value="0"><?php echo L('readpoint');?></option><option value="1"><?php echo L('money');?></option></select> <?php echo L('readpoint_tips');?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><?php echo L('repeatchargedays')?></label>
                        <div class="col-md-9">
                            <label><input class="form-control input-large" type="text" name="setting[repeatchargedays]" id="repeatchargedays" value=""></label>
                            <span class="help-block"><font color="red"><?php echo L('repeat_tips2');?></font></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane<?php if ($page==6) {?> active<?php }?>" id="tab_6">
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
window.top.$('#display_center_id').css('display','none');
$('.nav-tabs a').click(function (e) {
    $('.nav-tabs').find('li').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(this).parent().addClass('active');
    $('#'+$(this).attr("data-toggle")).addClass('active');
})
function change_tpl(modelid) {
    if(modelid) {
        $.getJSON('?m=admin&c=category&a=public_change_tpl&modelid='+modelid, function(data){$('#template_list').val(data.template_list);$('#category_template').html(data.category_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
    }
}
function load_file_list(id) {
    if(id=='') return false;
    $.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&catid=<?php echo $parentid?>', function(data){$('#category_template').html(data.category_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
}
<?php if(isset($modelid) && $modelid) echo "change_tpl($modelid)";?>
</script>
</body>
</html>