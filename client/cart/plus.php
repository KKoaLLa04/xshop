<?php

if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn cơ sở dữ liệu
    $cartDetail = firstRaw("SELECT * FROM cart WHERE id=$id");
    if (!empty($cartDetail)) {
        // update count
        $quantity = $cartDetail['quantity'];
        $quantity++;
        $dataUpdate = [
            'quantity' => $quantity
        ];

        $condition = 'id=' . $id;

        update('cart', $dataUpdate, $condition);
    }
} else {
    setFlashData("msg", 'Liên kết không tồn tại hoặc đã hết hạn!');
    setFlashData("msg_type", 'danger');
}

redirect('?module=cart&action=lists#tablecart');
