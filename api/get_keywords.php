<?php
/**
 * 获取关键字接口
 */
defined('IN_CMS') or exit('No permission resources.');

exit(dr_get_keywords(dr_safe_replace($input->post('data'))));
?>