<?php

if (!empty($_GET['id'])) {

    $id = $_GET['id'];

    $condition = 'id=' . $id;

    $deleteStatus = delete('comments', $condition);
    if (!empty($deleteStatus)) {
        setFlashData('msg', 'Xóa bình luận thành công');
        setFlashData('msg_type', 'success');
    } else {
        setFlashData('msg', 'Xóa bình luận không thành công, vui lòng thực hiện lại sau!');
        setFlashData('msg_type', 'danger');
    }
} else {
    setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn');
    setFlashData('msg_type', 'danger');
}

redirect('?module=comments');
