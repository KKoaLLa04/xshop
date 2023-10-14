<?php

if (!empty($_GET['id'])) {

    $id = $_GET['id'];

    $condition = 'id=' . $id;

    // Check
    $categoryForeign = getRows("SELECT id FROM products WHERE type_id=$id");
    if ($categoryForeign > 0) {
        setFlashData('msg', 'Hiện trong danh mục còn ' . $categoryForeign . ' Hàng hóa. Vui lòng xóa hết hàng hóa trước khi xóa danh mục');
        setFlashData('msg_type', 'danger');
        redirect('?module=products_category');
    } else {
        $deleteStatus = delete('type', $condition);
    }
    if (!empty($deleteStatus)) {
        setFlashData('msg', 'Xóa loại hàng hóa thành công');
        setFlashData('msg_type', 'success');
    } else {
        setFlashData('msg', 'Xóa hàng hóa không thành công, vui lòng thực hiện lại sau!');
        setFlashData('msg_type', 'danger');
    }
} else {
    setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn');
    setFlashData('msg_type', 'danger');
}

redirect('?module=products_category');
