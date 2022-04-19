<?php
defined('IN_CMS') or exit('No permission resources.');

$db = '';
$db = pc_base::load_model('content_model');
$hits_db = pc_base::load_model('hits_model');
$pagelength = $input->get('pagelength') ? $input->get('pagelength') : 30;
if($input->get('modelid') && $input->get('catid')) {
	$modelid = intval($input->get('modelid'));
	$db->set_model($modelid);
	$where = 'catid='.$input->get('catid').' AND status=99';
	if($input->get('dis')) {
		$where .= ' AND suoshucs="'.$input->get('dis').'"';
	}
	if($input->get('spc')) {
		$where .= ' AND zhuanye="'.$input->get('spc').'"';
	}
	if($input->get('score')) {
		$where .= ' AND fenshu="'.$input->get('score').'"';
	}
	if($input->get('my_city')) {
		$where .= ' AND suoshucs="'.$input->get('my_city').'"';
	}
	if($input->get('my_kaodian')) {
		$where .= ' AND suoshucs="'.$input->get('my_kaodian').'"';
	}
	if($input->get('my_chengji')) {
		$where .= ' AND chengji="'.$input->get('my_chengji').'"';
	}
	if($input->get('my_fav')) {
		$where .= ' AND fax="'.$input->get('my_fav').'"';
	}
	if(!empty($input->get('key'))) {
		$where .= " AND `title` like '%".$input->get('key')."%'";
	}
	$datas = $db->listinfo($where,'id desc',$input->get('page'),$pagelength);
	$countr = $db->get_one($where, "COUNT(*) AS num");
	$pages = $db->pages;
	echo '[';
	foreach ($datas as $r) {
		if($r['islink']) {
			$url=$r['url'];
		} elseif(strpos($r['url'],'http://')!==false) {
			$url=$r['url'];
		} else {
			$url=$release_siteurl.$r['url'];
		}
		if($r['thumb']) {
			$thumb=$r['thumb'];
		} else {
			$thumb=IMG_PATH.'nopic.gif';
		}
		$db->set_model($modelid);
		$where = 'catid='.$input->get('catid').' AND `inputtime` > "'.strtotime(date("Y")-1 . '-' . date("m") . '-' . date("d")).'" AND `inputtime` < "'.strtotime(date("Y")+1 . '-' . date("m") . '-' . date("d")).'" AND status=99';
		$zsjzr = $db->listinfo($where,'id desc',$input->get('page'),$pagelength);
		if(dr_count($zsjzr)>0) {
			$subscript=3;
		} else {
			$subscript=2;
		}
		$hitsid = 'c-'.$modelid.'-'.intval($r['id']);
		$hitsr = $hits_db->get_one(array('hitsid'=>$hitsid));
		echo '{"id":"'.$r['id'].'","url":"'.$url.'","name":"'.$r['title'].'","logo":"'.$thumb.'","tag":"","score_type":"400,500","browse_number":"'.$hitsr['views'].'","focus_number":"824","subscript":"'.$subscript.'"},';
	}
	echo '{"max":"'.$countr['num'].'"}]';
	exit;
}
?>