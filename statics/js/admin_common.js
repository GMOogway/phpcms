if(typeof jQuery == 'undefined'){
	window.alert("没有引用jquery库");
}
// 是否有隐藏区域
function dr_isEllipsis(dom) {
	var checkDom = dom.cloneNode(),parent, flag;
	checkDom.style.width = dom.offsetWidth + 'px';
	checkDom.style.height = dom.offsetHeight + 'px';
	checkDom.style.overflow = 'auto';
	checkDom.style.position = 'absolute';
	checkDom.style.zIndex = -1;
	checkDom.style.opacity = 0;
	checkDom.style.whiteSpace = "nowrap";
	checkDom.innerHTML = dom.innerHTML;
	parent = dom.parentNode;
	parent.appendChild(checkDom);
	flag = checkDom.scrollWidth > checkDom.offsetWidth;
	parent.removeChild(checkDom);
	return flag;
};
$(function(){
	/*if ($(document).width() < 600) {
		$('.table-list table').attr('style', 'table-layout: inherit!important;');
	}*/
	// 排序操作
	$('.table-list table .heading th').click(function(e) {
		var _class = $(this).attr("class");
		if (_class == '' || _class == undefined) {
			return;
		}
		var _name = $(this).attr("name");
		if (_name == '' || _name == undefined) {
			return;
		}
		var _order = '';
		if (_class == "order_sorting") {
			_order = 'desc';
		} else if (_class == "order_sorting_desc") {
			_order = 'asc';
		} else {
			_order = 'desc';
		}
		var url = decodeURI(window.location.href);
		url = url.replace("&order=", "&");
		url+= "&order="+_name+"+"+_order;
		window.location.href=url;
	});
	// tabl
	if ($('.table-checkable')) {
		var table = $('.table-checkable');
		table.find('.group-checkable').change(function () {
			var set = jQuery(this).attr("data-set");
			var checked = jQuery(this).is(":checked");
			jQuery(set).each(function () {
				if (checked) {
					$(this).prop("checked", true);
					$(this).parents('tr').addClass("active");
				} else {
					$(this).prop("checked", false);
					$(this).parents('tr').removeClass("active");
				}
			});
		});
	}
	// 当存在隐藏时单击显示区域
	$(".table-list table td,.table-list table th").click(function() {
		var e = $(this);
		if (1 == dr_isEllipsis(e[0])) {
			var t = e.html();
			if (t.indexOf("checkbox") != -1) return;
			if (t.indexOf("<input") != -1) return;
			if (t.indexOf('class="btn') != -1);
			else if (t.indexOf('href="') != -1) return;
			layer.tips(t, e, {
				tips: [1, "#fff"],
				time: 5e3
			})
		}
	});
	/*复选框全选(支持多个，纵横双控全选)。
	 *实例：版块编辑-权限相关（双控），验证机制-验证策略（单控）
	 *说明：
	 *	"J_check"的"data-xid"对应其左侧"J_check_all"的"data-checklist"；
	 *	"J_check"的"data-yid"对应其上方"J_check_all"的"data-checklist"；
	 *	全选框的"data-direction"代表其控制的全选方向(x或y)；
	 *	"J_check_wrap"同一块全选操作区域的父标签class，多个调用考虑
	 */
	if ($('.J_check_wrap').length) {
		var total_check_all = $('input.J_check_all');
		//遍历所有全选框
		$.each(total_check_all, function () {
			var check_all = $(this), check_items;
			//分组各纵横项
			var check_all_direction = check_all.data('direction');
			check_items = $('input.J_check[data-' + check_all_direction + 'id="' + check_all.data('checklist') + '"]');
			//点击全选框
			check_all.change(function (e) {
				var check_wrap = check_all.parents('.J_check_wrap'); //当前操作区域所有复选框的父标签（重用考虑）
				if ($(this).attr('checked')) {
					//全选状态
					check_items.attr('checked', true);
					//所有项都被选中
					if (check_wrap.find('input.J_check').length === check_wrap.find('input.J_check:checked').length) {
						check_wrap.find(total_check_all).attr('checked', true);
					}
				} else {
					//非全选状态
					check_items.removeAttr('checked');
					//另一方向的全选框取消全选状态
					var direction_invert = check_all_direction === 'x' ? 'y' : 'x';
					check_wrap.find($('input.J_check_all[data-direction="' + direction_invert + '"]')).removeAttr('checked');
				}
			});
			//点击非全选时判断是否全部勾选
			check_items.change(function () {
				if ($(this).attr('checked')) {
					if (check_items.filter(':checked').length === check_items.length) {
						//已选择和未选择的复选框数相等
						check_all.attr('checked', true);
					}
				} else {
					check_all.removeAttr('checked');
				}
			});
		});
	}
});
function geturlpathname() {
	var url = document.location.toString();
	var arrUrl = url.split("//");
	var start = arrUrl[1].indexOf("/");
	var relUrl = arrUrl[1].substring(start);
	if(relUrl.indexOf("?") != -1){
		relUrl = relUrl.split("?")[0];
	}
	return relUrl;
}
// 时间戳转换
function dr_strtotime(datetime) {
	if (datetime.indexOf(" ") == -1) {
		datetime+= ' 00:00:00';
	}
	var tmp_datetime = datetime.replace(/:/g,'-');
	tmp_datetime = tmp_datetime.replace(/ /g,'-');
	var arr = tmp_datetime.split("-");
	var now = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
	return parseInt(now.getTime()/1000);
}
// 判断当前终端是否是移动设备
function is_mobile() {
	var ua = navigator.userAgent,
	isWindowsPhone = /(?:Windows Phone)/.test(ua),
	isSymbian = /(?:SymbianOS)/.test(ua) || isWindowsPhone, 
	isAndroid = /(?:Android)/.test(ua), 
	isFireFox = /(?:Firefox)/.test(ua), 
	isChrome = /(?:Chrome|CriOS)/.test(ua),
	isTablet = /(?:iPad|PlayBook)/.test(ua) || (isAndroid && !/(?:Mobile)/.test(ua)) || (isFireFox && /(?:Tablet)/.test(ua)),
	isPhone = /(?:iPhone)/.test(ua) && !isTablet,
	isPc = !isPhone && !isAndroid && !isSymbian;
	if (isPc) {
		// pc
		return false;
	} else {
		return true;
	}
}
function confirmurl(url,message) {
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	Dialog.confirm(message,function() {
		redirect(url);
	});
}
function redirect(url) {
	location.href = url;
}
function dr_content_go(url) {
	window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.location = url;
}
function topinyin(name, from, url) {
	var val = $("#" + from).val();
	if ($("#" + name).val()) {
		return false
	}
	$.get(url+'&name='+val+'&rand='+Math.random(), function(data){
		$('#'+name).val(data);
	});
}
//text
$(function(){
	$(":text").addClass('input-text');
})
/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	if ($("#check_box").is(":checked")) {
		$("input[name='"+name+"']").each(function() {
			$(this).attr("checked","checked");
			$(this).parents('tr').addClass("active");
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			$(this).removeAttr("checked");
			$(this).parents('tr').removeClass("active");
		});
	}
}
// 显示ip信息
function dr_show_ip(url, value) {
	$.get(url+'&value='+value, function(html){
		layer.alert(html, {
			shade: 0,
			title: "",
			icon: 1
		})
	}, 'text');
}
// 显示视频
function dr_preview_video(file) {
	var width = '450px';
	var height = '330px';
	var att = 'width="350" height="280"';
	if (is_mobile()) {
		width = height = '90%';
		var att = 'width="90%" height="200"';
	}
	layer.alert('<p style="text-align: center"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center"> <video class="video-js vjs-default-skin" controls="" preload="auto" '+att+'><source src="'+file+'" type="video/mp4"/></video>\n</p>', {
		shade: 0,
		//scrollbar: false,
		shadeClose: true,
		title: '',
		area: [width, width],
		btn: []
	});
}

// 显示图片
function dr_preview_image(file) {
	var width = '400px';
	var height = '300px';
	if (is_mobile()) {
		width = height = '90%';
	}
	layer.alert('<p style="text-align: center"><a href="'+file+'" target="_blank">'+file+'</a></p><p style="text-align: center"><a href="'+file+'" target="_blank"><img style="max-width:100%" src="'+file+'"></a></p>', {
		shade: 0,
		//scrollbar: false,
		shadeClose: true,
		title: '',
		area: [width, width],
		btn: []
	});
}
// 显示url
function dr_preview_url(url) {
	var width = '400px';
	var height = '200px';
	if (is_mobile()) {
		width = height = '90%';
	}
	layer.alert('<div style="text-align: center;"><a href="'+url+'" target="_blank">'+url+'</a></div>', {
		shade: 0,
		title: '',
		area: [width, width],
		btn: []
	});
}
function openwinx(url,name,w,h) {
	if(!w) w='100%';
	if(!h) h='100%';
	if (is_mobile()) {
		w = h = '100%';
	}
	if (w=='100%' && h=='100%') {
		var drag = false;
	} else {
		var drag = true;
	}
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (url.toLowerCase().indexOf("http://") != -1 || url.toLowerCase().indexOf("https://") != -1) {
	} else {
		url = geturlpathname()+url;
	}
	var diag = new Dialog({
		id:'content_id',
		title:name,
		url:url,
		width:w,
		height:h,
		modal:true,
		draggable:drag
	});
	diag.cancelText = '关闭(X)';
	diag.onCancel=function() {
		$DW.close();
	};
	diag.show();
}
function dr_content_submit(url,type,w,h) {
	if(!w) w='100%';
	if(!h) h='100%';
	if (is_mobile()) {
		w = h = '100%';
	}
	if (w=='100%' && h=='100%') {
		var drag = false;
	} else {
		var drag = true;
	}
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (url.toLowerCase().indexOf("http://") != -1 || url.toLowerCase().indexOf("https://") != -1) {
	} else {
		url = geturlpathname()+url;
	}
	var title = '';
	if (type == 'add') {
		title = '<i class="fa fa-plus"></i> '+'添加';
	} else if (type == 'edit') {
		title = '<i class="fa fa-edit"></i> '+'修改';
	} else if (type == 'send') {
		title = '<i class="fa fa-send"></i> '+'推送';
	} else if (type == 'save') {
		title = '<i class="fa fa-save"></i> '+'保存';
	} else {
		title = type;
	}
	var diag = new Dialog({
		id:'content_id',
		title:title,
		url:url,
		width:w,
		height:h,
		modal:true,
		draggable:drag
	});
	diag.addButton('dosubmit','保存后自动关闭',function(){
		var body = diag.innerFrame.contentWindow.document;
		$.ajax({type: "POST",dataType:"json", url: url, data: $(body).find('#myform').serialize(),
			success: function(json) {
				if (json.code) {
					if (json.data.tourl) {
						setTimeout("window.location.href = '"+json.data.tourl+"'", 2000);
					} else {
						setTimeout("window.location.reload(true)", 2000);
					}
					dr_tips(1, json.msg);
					diag.close()
				} else {
					if (json.data.field) {
						$(body).find('#dr_row_'+json.data.field).addClass('has-error');
						Dialog.warn(json.msg, function(){$(body).find('#'+json.data.field).focus();});
					} else {
						Dialog.warn(json.msg);
					}
				}
				return false;
			},
			error: function(HttpRequest, ajaxOptions, thrownError) {
				dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
			}
		});
		return false;
	},0,1);
	if (type == 'edit') {
		diag.okText = '保存并继续修改';
	} else {
		diag.okText = '保存并继续发表';
	}
	diag.onOk = function(){
		var body = diag.innerFrame.contentWindow.document;
		$.ajax({type: "POST",dataType:"json", url: url, data: $(body).find('#myform').serialize(),
			success: function(json) {
				if (json.code) {
					body.location.reload(true);
					Dialog.tips(json.msg);
				} else {
					if (json.data.field) {
						$(body).find('#dr_row_'+json.data.field).addClass('has-error');
						Dialog.warn(json.msg, function(){$(body).find('#'+json.data.field).focus();});
					} else {
						Dialog.warn(json.msg);
					}
				}
				return false;
			},
			error: function(HttpRequest, ajaxOptions, thrownError) {
				dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
			}
		});
		return false;
	};
	diag.cancelText = '关闭(X)';
	diag.onCancel=function(){
		if($DW.$V('#title') !='') {
			Dialog.confirm('内容已经录入，确定离开将不保存数据？', function(){
				if (parent.right) {
					parent.right.location.reload(true);
				} else {
					window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.location.reload(true);
				}
				diag.close();
			}, function(){});
		} else {
			if (parent.right) {
				parent.right.location.reload(true);
			} else {
				window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.location.reload(true);
			}
			diag.close();
		}
		return false;
	};
	diag.onClose=function(){
		if (parent.right) {
			parent.right.location.reload(true);
		} else {
			window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.location.reload(true);
		}
		$DW.close();
	};
	diag.show();
}
//弹出对话框
function artdialog(id,url,title,w,h) {
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (url.toLowerCase().indexOf("http://") != -1 || url.toLowerCase().indexOf("https://") != -1) {
	} else {
		url = geturlpathname()+url;
	}
	if(!w) w=700;
	if(!h) h=500;
	if (is_mobile()) {
		w = h = '100%';
	}
	if (w=='100%' && h=='100%') {
		var drag = false;
	} else {
		var drag = true;
	}
	var diag = new Dialog({
		id:id,
		title:title,
		url:url,
		width:w,
		height:h,
		modal:true,
		draggable:drag
	});
	diag.onOk = function(){
		var form = $DW.$('#dosubmit');
		form.click();
		return false;
	};
	diag.onCancel=function() {
		$DW.close();
	};
	diag.show();
}
//选择图标
function menuicon(id,linkurl,title,w,h) {
	if (typeof pc_hash == 'string') linkurl += (linkurl.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (linkurl.toLowerCase().indexOf("http://") != -1 || linkurl.toLowerCase().indexOf("https://") != -1) {
	} else {
		linkurl = geturlpathname()+linkurl;
	}
	if(!w) w=700;
	if(!h) h=500;
	if (is_mobile()) {
		w = h = '100%';
	}
	if (w=='100%' && h=='100%') {
		var drag = false;
	} else {
		var drag = true;
	}
	var diag = new Dialog({
		id:id,
		title:title,
		url:linkurl,
		width:w,
		height:h,
		modal:true,
		draggable:drag
	});
	diag.onCancel=function() {
		$DW.close();
	};
	diag.show();
}
//弹出对话框
function omnipotent(id,linkurl,title,close_type,w,h) {
	if (typeof pc_hash == 'string') linkurl += (linkurl.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (linkurl.toLowerCase().indexOf("http://") != -1 || linkurl.toLowerCase().indexOf("https://") != -1) {
	} else {
		linkurl = geturlpathname()+linkurl;
	}
	if(!w) w=700;
	if(!h) h=500;
	if (is_mobile()) {
		w = h = '100%';
	}
	if (w=='100%' && h=='100%') {
		var drag = false;
	} else {
		var drag = true;
	}
	var diag = new Dialog({
		id:id,
		title:title,
		url:linkurl,
		width:w,
		height:h,
		modal:true,
		draggable:drag
	});
	if(!close_type) {
		diag.onOk = function(){
			var form = $DW.$('#dosubmit');
			form.click();
			return false;
		};
	} else {
		diag.cancelText = '关闭(X)';
	}
	diag.onCancel=function() {
		$DW.close();
	};
	diag.show();
}
function map(id,linkurl,title,tcstr,w,h) {
	if (typeof pc_hash == 'string') linkurl += (linkurl.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (linkurl.toLowerCase().indexOf("http://") != -1 || linkurl.toLowerCase().indexOf("https://") != -1) {
	} else {
		linkurl = geturlpathname()+linkurl;
	}
	if(!w) w=700;
	if(!h) h=500;
	if (is_mobile()) {
		w = h = '100%';
	}
	if (w=='100%' && h=='100%') {
		var drag = false;
	} else {
		var drag = true;
	}
	var diag = new Dialog({
		id:id,
		title:title,
		url:linkurl,
		width:w,
		height:h,
		modal:true,
		draggable:drag
	});
	diag.onOk = function(){
		$S(tcstr).value = $DW.$V('#'+tcstr);
		diag.close();
	};
	diag.onCancel=function() {
		$DW.close();
	};
	diag.show();
}
// 窗口提交
function dr_iframe(type, url, width, height, rt) {
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (url.toLowerCase().indexOf("http://") != -1 || url.toLowerCase().indexOf("https://") != -1) {
	} else {
		url = geturlpathname()+url;
	}
	var title = '';
	if (type == 'add') {
		title = '<i class="fa fa-plus"></i> '+'添加';
	} else if (type == 'edit') {
		title = '<i class="fa fa-edit"></i> '+'修改';
	} else if (type == 'send') {
		title = '<i class="fa fa-send"></i> '+'推送';
	} else if (type == 'save') {
		title = '<i class="fa fa-save"></i> '+'保存';
	} else {
		title = type;
	}
	if (!width) {
		width = '500px';
	}
	if (!height) {
		height = '70%';
	}
	if (is_mobile()) {
		width = '100%';
		height = '100%';
	}
	if (width=='100%' && height=='100%') {
		var drag = false;
	} else {
		var drag = true;
	}
	var diag = new Dialog({
		id:'iframe',
		title:title,
		url:url,
		width:width,
		height:height,
		modal:true,
		draggable:drag
	});
	diag.onOk = function(){
		var body = diag.innerFrame.contentWindow.document;
		$.ajax({type: "POST",dataType:"json", url: url, data: $(body).find('#myform').serialize(),
			success: function(json) {
				if (json.code) {
					if (json.data.tourl) {
						setTimeout("window.location.href = '"+json.data.tourl+"'", 2000);
					} else {
						if (rt == 'nogo') {
						} else {
							setTimeout("window.location.reload(true)", 2000);
						}
					}
					dr_tips(1, json.msg);
					diag.close()
				} else {
					if (json.data.field) {
						$(body).find('#dr_row_'+json.data.field).addClass('has-error');
						Dialog.warn(json.msg, function(){if(json.data.batch){$(body).find('#'+json.data.batch).focus();}else{$(body).find('#'+json.data.field).focus();}});
					} else {
						Dialog.warn(json.msg);
					}
				}
				return false;
			},
			error: function(HttpRequest, ajaxOptions, thrownError) {
				dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
			}
		});
		return false;
	};
	diag.onCancel=function(){
		$DW.close();
	};
	diag.show();
}
// ajax 显示内容
function dr_iframe_show(type, url, width, height) {
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (url.toLowerCase().indexOf("http://") != -1 || url.toLowerCase().indexOf("https://") != -1) {
	} else {
		url = geturlpathname()+url;
	}
	var title = '';
	if (type == 'show') {
		title = '<i class="fa fa-search"></i> 查看';
	} else if (type == 'edit') {
		title = '<i class="fa fa-edit"></i> 修改';
	} else if (type == 'code') {
		title = '<i class="fa fa-code"></i> 代码';
	} else if (type == 'cart') {
		title = '<i class="fa fa-shopping-cart"></i> 交易记录';
	} else {
		title = type;
	}
	if (!width) {
		width = '60%';
	}
	if (!height) {
		height = '70%';
	}
	if (is_mobile()) {
		width = '95%';
		height = '90%';
	}
	var diag = new Dialog({
		id:'iframe_show',
		title:title,
		url:url,
		width:width,
		height:height,
		modal:true,
		draggable:true
	});
	diag.cancelText = '关闭(X)';
	diag.onCancel=function(){
		$DW.close();
	};
	diag.show();
}
// ajax 显示内容
function iframe_show(type, url, width, height) {
	var title = '';
	if (type == 'show') {
		title = '<i class="fa fa-search"></i> 查看';
	} else if (type == 'edit') {
		title = '<i class="fa fa-edit"></i> 修改';
	} else if (type == 'code') {
		title = '<i class="fa fa-code"></i> 代码';
	} else if (type == 'cart') {
		title = '<i class="fa fa-shopping-cart"></i> 交易记录';
	} else {
		title = type;
	}
	if (!width) {
		width = '60%';
	}
	if (!height) {
		height = '75%';
	}
	if (is_mobile()) {
		width = '95%';
		height = '90%';
	}
	layer.open({
		type: 2,
		title: title,
		fix:true,
		scrollbar: false,
		shadeClose: true,
		shade: 0,
		area: [width, height],
		success: function(layero, index){
			// 主要用于后台权限验证
			var body = layer.getChildFrame('body', index);
			var json = $(body).html();
			if (json.indexOf('"code":0') > 0 && json.length < 500){
				var obj = JSON.parse(json);
				layer.close(index);
				dr_tips(0, obj.msg);
			}
		},
		content: url+'&is_ajax=1'
	});
}
// ajax保存数据
function dr_ajax_save(value, url, name) {
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (url.toLowerCase().indexOf("http://") != -1 || url.toLowerCase().indexOf("https://") != -1) {
	} else {
		url = geturlpathname()+url;
	}
	var index = layer.load(2, {
		shade: [0.3,'#fff'], //0.1透明度的白色背景
		time: 5000
	});
	$.ajax({
		type: "GET",
		url: url+'&name='+name+'&value='+value,
		dataType: "json",
		success: function (json) {
			layer.close(index);
			dr_tips(json.code, json.msg, json.data.time);
		},
		error: function(HttpRequest, ajaxOptions, thrownError) {
			dr_ajax_admin_alert_error(HttpRequest, ajaxOptions, thrownError);
		}
	});
}
// ajax关闭或启用
function dr_ajax_open_close(e, url, fan) {
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (url.toLowerCase().indexOf("http://") != -1 || url.toLowerCase().indexOf("https://") != -1) {
	} else {
		url = geturlpathname()+url;
	}
	var index = layer.load(2, {
		shade: [0.3,'#fff'], //0.1透明度的白色背景
		time: 10000
	});
	$.ajax({
		type: "GET",
		cache: false,
		url: url,
		dataType: "json",
		success: function (json) {
			layer.close(index);
			if (json.code == 1) {
				if (json.data.value == fan) {
					$(e).attr('class', 'badge badge-no');
					$(e).html('<i class="fa fa-times"></i>');
				} else {
					$(e).attr('class', 'badge badge-yes');
					$(e).html('<i class="fa fa-check"></i>');
				}
				dr_tips(1, json.msg);
			} else {
				dr_tips(0, json.msg);
			}
		},
		error: function(HttpRequest, ajaxOptions, thrownError) {
			dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError);
		}
	});
}
function dr_ajax_list_open_close(e, url) {
	if (typeof pc_hash == 'string') url += (url.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (url.toLowerCase().indexOf("http://") != -1 || url.toLowerCase().indexOf("https://") != -1) {
	} else {
		url = geturlpathname()+url;
	}
	var obj = $(e);
	var val = 0;
	if (obj.attr("value") == 1) {
		val = 0;
	} else {
		val = 1;
	}
	url+="&value="+val;
	$.ajax({
		type: "GET",
		url: url,
		dataType: "json",
		success: function (json) {
			if (json.code == 1) {
				if (val == 0) {
					obj.attr('class', 'badge badge-no');
					obj.html('<i class="fa fa-times"></i>');
				} else {
					obj.attr('class', 'badge badge-yes');
					obj.html('<i class="fa fa-check"></i>');
				}
				obj.attr("value", val);
			}
			dr_tips(json.code, json.msg);
		},
		error: function(HttpRequest, ajaxOptions, thrownError) {
			dr_ajax_admin_alert_error(HttpRequest, ajaxOptions, thrownError);
		}
	});
}
// ajax 批量操作确认
function dr_ajax_option(url, msg, remove) {
	layer.confirm(msg,{
			icon: 3,
			shade: 0,
			title: '提示',
			btn: ['确定', '取消']
	}, function(index){
		layer.close(index);
		var loading = layer.load(2, {
			shade: [0.3,'#fff'], //0.1透明度的白色背景
			time: 100000000
		});
		$.ajax({
			type: "POST",
			dataType: "json",
			url: url,
			data: $("#myform").serialize(),
			success: function(json) {
				layer.close(loading);
				if (json.code) {
					if (remove) {
						// 批量移出去
						var ids = json.data.ids;
						if (typeof ids != "undefined" ) {
							console.log(ids);
							for ( var i = 0; i < ids.length; i++){
								$("#dr_row_"+ids[i]).remove();
							}
						}
					}
					if (json.data.url) {
						setTimeout("window.location.href = '"+json.data.url+"'", 2000);
					} else {
						setTimeout("window.location.reload(true)", 3000)
					}
				}
				dr_tips(json.code, json.msg, json.data.time);
			},
			error: function(HttpRequest, ajaxOptions, thrownError) {
				dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
			}
		});
	});
}
// ajax提交
function dr_ajax_submit(url, form, time, go) {
	var flen = $('[id='+form+']').length;
	// 验证id是否存在
	if (flen == 0) {
		dr_tips(0, '表单id属性不存在' + ' ('+form+')');
		return;
	}
	// 验证重复
	if (flen > 1) {
		dr_tips(0, '表单id属性已重复定义' + ' ('+form+')');
		return;
	}

	// 验证必填项管理员
	var tips_obj = $('#'+form).find('[name=is_tips]');
	if (tips_obj.val() == 'required') {
		tips_obj.val('');
	}
	if ($('#'+form).find('[name=is_admin]').val() == 1) {
		$('#'+form).find('.dr_required').each(function () {
			if (!$(this).val()) {
				tips_obj.val('required');
			}
		});
	}

	var tips = tips_obj.val();
	if (tips) {
		if (tips == 'required') {
			tips = '有必填字段未填写，确认提交吗？';
		}
		layer.confirm(
		tips,
		{
			icon: 3,
			shade: 0,
			title: '提示',
			btn: ['确定', '取消']
		}, function(index){
			dr_post_submit(url, form, time, go);
		});
	} else {
		dr_post_submit(url, form, time, go);
	}
}
// 处理post提交
function dr_post_submit(url, form, time, go) {
	var p = url.split('/');
	if ((p[0] == 'http:' || p[0] == 'https:') && document.location.protocol != p[0]) {
		alert('当前提交的URL是'+p[0]+'模式，请使用'+document.location.protocol+'模式访问再提交');
		return;
	}

	url = url.replace(/&page=\d+&page/g, '&page');

	var loading = layer.load(2, {
		shade: [0.3,'#fff'], //0.1透明度的白色背景
		time: 100000000
	});

	$("#"+form+' .form-group').removeClass('has-error');

	$('.dr_ueditor').each(function () {
		var uev = $(this).attr('id');
		if(UE.getEditor(uev).queryCommandState('source')!=0){
			UE.getEditor(uev).execCommand('source');
		}
	});

	$.ajax({
		type: "POST",
		dataType: "json",
		url: url,
		data: $("#"+form).serialize(),
		success: function(json) {
			layer.close(loading);
			if (json.code) {
				dr_tips(1, json.msg, json.data.time);
				if (time) {
					var gourl = url;
					if (go != '' && go != undefined && go != 'undefined') {
						gourl = go;
					} else if (json.data.url) {
						gourl = json.data.url;
					}
					setTimeout("window.location.href = '"+gourl+"'", time);
				}
			} else {
				dr_tips(0, json.msg, json.data.time);
				$('.captcha img').click();
				if (json.data.field) {
					$('#dr_row_'+json.data.field).addClass('has-error');
					$('#dr_'+json.data.field).focus();
				}
			}
		},
		error: function(HttpRequest, ajaxOptions, thrownError) {
			dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError)
		}
	});
}
function dr_admin_menu_ajax(e, t) {
	var a = layer.load(2, {
		shade: [.3, "#fff"],
		time: 1e4
	});
	$.ajax({
		type: "GET",
		dataType: "json",
		url: e,
		success: function(e) {
			if (layer.close(a), dr_tips(e.code, e.msg), 1 == e.code) {
				if (t) return;
				setTimeout("location.reload(true)", 2e3)
			}
		},
		error: function(e, t, a) {
			dr_ajax_admin_alert_error(e, t, a)
		}
	})
}
function dr_submit_sql_todo(e, t) {
	var a = layer.load(2, {
		shade: [.3, "#fff"],
		time: 1e3
	});
	$("#sql_result").html(" ... "), $.ajax({
		type: "POST",
		dataType: "json",
		url: t,
		data: $("#" + e).serialize(),
		success: function(e) {
			return layer.close(a), 1 == e.code ? $("#sql_result").html("<pre>" + e.msg + "</pre>") : $("#sql_result").html('<div class="alert alert-danger">' + e.msg + "</div>"), !1
		},
		error: function(e, t, a) {
			dr_ajax_admin_alert_error(e, t, a)
		}
	})
}
function dr_install_uninstall(id,msg,title,linkurl,module,w,h) {
	if (typeof pc_hash == 'string') linkurl += (linkurl.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (linkurl.toLowerCase().indexOf("http://") != -1 || linkurl.toLowerCase().indexOf("https://") != -1) {
	} else {
		linkurl = geturlpathname()+linkurl;
	}
	if(!w) w=500;
	if(!h) h=260;
	if (is_mobile()) {
		w = h = '100%';
	}
	Dialog.confirm(msg, function() {
		var t = layer.load(2, {
			shade: [.3, "#fff"],
			time: 5e3
		});
		$.ajax({
			type: "POST",
			dataType: "json",
			url: linkurl,
			data: {module:module,csrf_test_name:csrf_hash},
			success: function(e) {
				layer.close(t), dr_tips(e.code, e.msg), 1 == e.code && setTimeout("dr_install_confirm()", 2e3)
			},
			error: function(e, t, a) {
				dr_ajax_admin_alert_error(e, t, a)
			}
		})
	}, function() {})
}
function dr_install_confirm() {
	Dialog.confirm("确定要刷新整个后台吗？", function() {
		parent.location.reload(!0);
	}, function() {
		window.top.$(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.location.reload(!0);
	})
}
function dr_bfb(e, t, a) {
	layer.load(2, {
		shade: [.3, "#fff"],
		time: 1e3
	}), layer.open({
		type: 2,
		title: e,
		scrollbar: !1,
		resize: !0,
		maxmin: !0,
		shade: 0,
		area: ["80%", "80%"],
		success: function(e, t) {
			var a = layer.getChildFrame("body", t),
				r = $(a).html();
			if (r.indexOf('"code":0') > 0 && r.length < 150) {
				var i = JSON.parse(r);
				layer.closeAll(), dr_tips(0, i.msg)
			}
		},
		content: a + "&" + $("#" + t).serialize(),
		cancel: function(e, t) {
			var a = layer.getChildFrame("body", e);
			if ($(a).find("#dr_check_status").val() == "1") return layer.confirm('关闭后将中断操作，是否确认关闭呢？', {
				icon: 3,
				shade: 0,
				title: "提示",
				btn: ["确定", "取消"]
			}, function(e) {
				layer.closeAll()
			}), !1
		}
	})
}
function dr_bfb_submit(e, t, a) {
	layer.load(2, {
		shade: [.3, "#fff"],
		time: 1e3
	}), $.ajax({
		type: "POST",
		dataType: "json",
		url: a,
		data: $("#" + t).serialize(),
		success: function(t) {
			return layer.closeAll("loading"), 1 == t.code ? layer.open({
				type: 2,
				title: e,
				scrollbar: !1,
				resize: !0,
				maxmin: !0,
				shade: 0,
				area: ["80%", "80%"],
				success: function(e, t) {
					var a = layer.getChildFrame("body", t),
						r = $(a).html();
					if (r.indexOf('"code":0') > 0 && r.length < 150) {
						var i = JSON.parse(r);
						layer.closeAll("loading"), dr_tips(0, i.msg)
					}
				},
				content: t.data.url,
				cancel: function(e, t) {
					var a = layer.getChildFrame("body", e);
					if ($(a).find("#dr_check_status").val() == "1") return layer.confirm('关闭后将中断操作，是否确认关闭呢？', {
						icon: 3,
						shade: 0,
						title: "提示",
						btn: ["确定", "取消"]
					}, function(e) {
						layer.closeAll()
					}), !1
				}
			}) : dr_tips(0, t.msg, 9e4), !1
		},
		error: function(e, t, a) {
			dr_ajax_admin_alert_error(e, t, a)
		}
	})
}
function dr_submit_todo(e, t) {
	var w = '30%';
	var h = '30%';
	if (is_mobile()) {
		w = '95%';
		h = '50%';
	}
	layer.load(2, {
		shade: [.3, "#fff"],
		time: 1e3
	}), layer.open({
		type: 2,
		title: '执行结果',
		shadeClose: !0,
		shade: 0,
		area: [w, h],
		success: function(e, t) {
			var a = layer.getChildFrame("body", t),
				r = $(a).html();
			if (r.indexOf('"code":0') > 0 && r.length < 150) {
				var i = JSON.parse(r);
				layer.closeAll(t), dr_tips(0, i.msg)
			}
		},
		content: t + "&" + $("#" + e).serialize()
	})
}
function dr_submit_post_todo(e, t) {
	var a = layer.load(2, {
		shade: [.3, "#fff"],
		time: 1e3
	});
	$.ajax({
		type: "POST",
		dataType: "json",
		url: t,
		data: $("#" + e).serialize(),
		success: function(e) {
			return layer.close(a), 1 == e.code ? dr_tips(1, e.msg) : dr_tips(0, e.msg, 9e4), !1
		},
		error: function(e, t, a) {
			dr_ajax_admin_alert_error(e, t, a)
		}
	})
}
function dr_tips(code, msg, time) {
	if (!time || time == "undefined") {
		time = 3000;
	} else {
		time = time * 1000;
	}
	var is_tip = 0;
	if (time < 0) {
		is_tip = 1;
	} else if (code == 0 && msg.length > 15) {
		is_tip = 1;
	}

	if (is_tip) {
		if (code == 0) {
			layer.alert(msg, {
				shade: 0,
				title: "",
				icon: 2
			})
		} else {
			layer.alert(msg, {
				shade: 0,
				title: "",
				icon: 1
			})
		}
	} else {
		var tip = '<i class="fa fa-info-circle"></i>';
		//var theme = 'teal';
		if (code >= 1) {
			tip = '<i class="fa fa-check-circle"></i>';
			//theme = 'lime';
		} else if (code == 0) {
			tip = '<i class="fa fa-times-circle"></i>';
			//theme = 'ruby';
		}
		layer.msg(tip+'&nbsp;&nbsp;'+msg, {time: time});
	}
}
function dr_ajax_admin_alert_error(HttpRequest, ajaxOptions, thrownError) {
	layer.closeAll("loading");
	var msg = HttpRequest.responseText;
	if (!msg) {
		dr_tips(0, "系统错误");
	} else {
		layer.open({
			type:1,
			title:"系统错误",
			fix:true,
			shadeClose:true,
			shade:0,
			area:[ "50%", "50%" ],
			content:'<div style="padding:10px;">' + msg + '</div>'
		});
	}
}
function dr_ajax_alert_error(HttpRequest, ajaxOptions, thrownError) {
	layer.closeAll('loading');
	var msg = HttpRequest.responseText;
	//console.log(HttpRequest, ajaxOptions, thrownError);
	if (!msg) {
		dr_tips(0, '系统崩溃，请检查错误日志');
	} else {
		layer.open({
			type: 1,
			title: '系统崩溃，请检查错误日志',
			fix:true,
			shadeClose: true,
			shade: 0,
			area: ['50%', '50%'],
			content: "<div style=\"padding:10px;\">"+msg+"</div>"
		});
	}
}
function check_title(linkurl,title) {
	if (typeof pc_hash == 'string') linkurl += (linkurl.indexOf('?') > -1 ? '&': '?') + 'pc_hash=' + pc_hash;
	if (linkurl.toLowerCase().indexOf("http://") != -1 || linkurl.toLowerCase().indexOf("https://") != -1) {
	} else {
		linkurl = geturlpathname()+linkurl;
	}
	var val = $('#'+title).val();
	$.get(linkurl+"&data=" + val + "&is_ajax=1",
	function(data) {
		if (data) {
			dr_tips(0, data);
		}
	});
}
function get_wxurl(syseditor, field, linkurl, formname, titlename, keywordname, contentname) {
	var index = layer.load(2, {
		shade: [0.3,'#fff'], //0.1透明度的白色背景
		time: 5000
	});
	$.ajax({type: "POST",dataType:"json", url: linkurl+'&field='+field, data: $('#'+formname).serialize(),
		success: function(json) {
			layer.close(index);
			dr_tips(json.code, json.msg);
			if (json.code > 0) {
				var arr = json.data;
				$('#'+titlename).val(arr.title);
				if ($('#'+keywordname).length > 0) {
					$('#'+keywordname).val(arr.keyword);
					$('#'+keywordname).tagsinput('add', arr.keyword);
				}
				if (syseditor==1) {
					CKEDITOR.instances[contentname].setData(arr.content);
				} else {
					UE.getEditor(contentname).setContent(arr.content);
				}
			}
		},
		error: function(HttpRequest, ajaxOptions, thrownError) {
			dr_ajax_admin_alert_error(HttpRequest, ajaxOptions, thrownError);
		}
	});
}