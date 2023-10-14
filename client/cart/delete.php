<?php
if (!empty($_GET['id'])) {

    $id = $_GET['id'];
    if (!empty($id)) {
        // xóa sản phẩm
        $condition = "id='$id'";

        $deleteStatus = delete('cart', $condition);
        if (!empty($deleteStatus)) {
            setFlashData('msg', 'Loại bỏ sản phẩm khỏi giỏ hàng thành công!');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Lỗi hệ thống, vui lòng thử lại sau!');
            setFlashData("msg_type", 'danger');
        }
    } else {
        setFlashData("msg", 'Lỗi dữ liệu vui lòng thử lại sau!');
        setFlashData("msg_type", 'danger');
    }
} else {
    setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn!');
    setFlashData('msg_type', 'danger');
}

redirect('?module=cart&action=lists');