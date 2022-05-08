<?php
/**
 * 输出xml头部信息
 */
function wmlHeader() {
	echo "<?xml version=\"1.0\" encoding=\"".CHARSET."\"?>\n";
}
/**
 * 生成Tag URL
 */
function mobile_tag_url($keyword, $siteid){
	$sitelist = getcache('sitelist','commons');
	!$siteid && $siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
	return $sitelist[$siteid]['mobile_domain'].'index.php?m=mobile&c=tag&a=lists&tag='.urlencode($keyword).'&siteid='.$siteid;
}
/**
 * 解析手机分类url路径
 */
function list_url($url, $catid = '') {
	$sitelist = getcache('sitelist','commons');
	$siteids = getcache('category_content','commons');
	$catid && $siteid = $siteids[$catid];
	!$catid && $siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
	return str_replace(array($sitelist[$siteid]['domain'], 'm=content'), array($sitelist[$siteid]['mobile_domain'], 'm=mobile'), $url);
}

/**
 * 解析手机内容url路径
 */
function show_url($url, $catid = '') {
	$sitelist = getcache('sitelist','commons');
	$siteids = getcache('category_content','commons');
	$catid && $siteid = $siteids[$catid];
	!$catid && $siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
	if (strstr($url, 'javascript:alert')) {
		return $url;
	}
	return str_replace(array($sitelist[$siteid]['domain'], 'm=content'), array($sitelist[$siteid]['mobile_domain'], 'm=mobile'), $url);
}

/**
 * 过滤内容为wml格式
 */
function wml_strip($string) {
    $string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;', '&'), array(' ', '&', '"', "'", '“', '”', '—', '{<}', '{>}', '·', '…', '&amp;'), $string);
	return str_replace(array('{<}', '{>}'), array('&lt;', '&gt;'), $string);
}

function strip_selected_tags($text) {
    $tags = array('em','font','h1','h2','h3','h4','h5','h6','hr','i','ins','li','ol','p','pre','small','span','strike','strong','sub','sup','table','tbody','td','tfoot','th','thead','tr','tt','u','div','span');
    $args = func_get_args();
    $text = array_shift($args);
    $tags = func_num_args() > 2 ? array_diff($args,array($text)) : (array)$tags;
    foreach ($tags as $tag){
        if( preg_match_all( '/<'.$tag.'[^>]*>([^<]*)<\/'.$tag.'>/iu', $text, $found) ){
            $text = str_replace($found[0],$found[1],$text);
        }
    }
    return $text;
}

/**
 * 生成文章分页方法
 */

function mobile_content_pages($num, $curr_page, $pageurls, $showurls) {
	$input = pc_base::load_sys_class('input');
	$multipage = '';
	$first_url = $showurls[1][1];
	$multipage = $input->page($showurls[2][1], $num, 1, $curr_page, $first_url);
	if(strstr($first_url, '.php')) $multipage .="| <a href='".$showurls[1][1]."&remains=true'>剩余全文</a>";
	return $multipage;
}
?>