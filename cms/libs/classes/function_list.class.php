<?php
/**
 * 列表格式化函数库
 */

class function_list {

    protected $uid_data = array();
    protected $cid_data = array();

    // 用于列表显示标题
    public function title($value, $param = array(), $data = array()) {

        $value = htmlspecialchars(clearhtml($value));
        $title = ($data['thumb'] ? '<i class="fa fa-photo"></i> ' : '').dr_keyword_highlight(str_cut($value, 30), $param['keyword']);
        !$title && $title = '...';

        return isset($data['url']) && $data['url'] ? ('<a href="'.$data['url'].'" target="_blank" class="tooltips" data-container="body" data-placement="top" data-original-title="'.$value.'" title="'.$value.'">'.$title.'</a>') : $title;
    }
}