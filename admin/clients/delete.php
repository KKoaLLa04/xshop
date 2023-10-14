<?php

if (!empty($_GET['id'])) {

    $id = $_GET['id'];

    $condition = 'id=' . $id;

    delete('comments', 'client_id=' . $id);
    delete('bill', 'client_id=' . $id);
    delete('cart', 'client_id=' . $id);
    $deleteStatus = delete('client', $condition);
    if (!empty($deleteStatus)) {
        setFlashData('msg', 'Xóa khách hàng thành công');
        setFlashData('msg_type', 'success');
    } else {
        setFlashData('msg', 'Xóa khách hàng không thành công, vui lòng thực hiện lại sau!');
        setFlashData('msg_type', 'danger');
    }
} else {
    setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn');
    setFlashData('msg_type', 'danger');
}

redirect('?module=clients');