<?php
/**
 * 分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $pageurls 链接地址
 * @return 分页
 */
function content_pages($num, $curr_page, $pageurls) {
	$input = pc_base::load_sys_class('input');
	$multipage = '';
	$first_url = $pageurls[1][1];
	$multipage = $input->page($pageurls[2][1], $num, 1, $curr_page, $first_url);
	return $multipage;
}
?>