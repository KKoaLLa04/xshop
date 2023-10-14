<?php

if (!empty($_GET['id'])) {

    $id = $_GET['id'];

    $condition = 'id=' . $id;

    $conditionCm = "product_id=$id";
    delete('comments', $conditionCm);

    $deleteStatus = delete('products', $condition);
    if (!empty($deleteStatus)) {
        setFlashData('msg', 'Xóa hàng hóa thành công');
        setFlashData('msg_type', 'success');
    } else {
        setFlashData('msg', 'Xóa hàng hóa không thành công, vui lòng thực hiện lại sau!');
        setFlashData('msg_type', 'danger');
    }
} else {
    setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn');
    setFlashData('msg_type', 'danger');
}

redirect('?module=products');