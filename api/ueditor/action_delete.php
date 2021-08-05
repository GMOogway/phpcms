<?php
defined('IN_CMS') or exit('No permission resources.');

/**
 * 删除文件
 */
if ($userid) {
    /* 获取路径 */
    $aid = $input->post('id');

    if ($aid) {
        /* 删除数据 */
        $upload = pc_base::load_sys_class('upload');
        $thisdb= pc_base::load_model('attachment_model');
        $attachment_index = pc_base::load_model('attachment_index_model');
        if($upload->delete(array('aid'=>$aid))) {
            $attachment_index->delete(array('aid'=>$aid));
            $result = json_encode(array(
                'code'=> '1',
                'state'=> '删除成功。'
            ), JSON_UNESCAPED_UNICODE);
        } else {
            $result = json_encode(array(
                'code'=> '0',
                'state'=> '文件数据不存在。'
            ), JSON_UNESCAPED_UNICODE);
        }
    } else {
        $result = json_encode(array(
            'code'=> '0',
            'state'=> '所选附件不存在。'
        ), JSON_UNESCAPED_UNICODE);
    }
} else {
    $result = json_encode(array(
        'code'=> '0',
        'state'=> '请登录在操作'
    ), JSON_UNESCAPED_UNICODE);
}

return $result;