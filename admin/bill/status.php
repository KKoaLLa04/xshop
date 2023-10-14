<?php

if (!empty($_GET['code'])) {
    $status = $_GET['status'];
    $code = $_GET['code'];

    $status++;
    if ($status >= 3) {
        $status = 3;
    }
    $dataUpdate = [
        'status' => $status,
    ];
    $condition = 'code = ' . $code;

    $updateStatus = update('bill', $dataUpdate, $condition);
    if (!empty($updateStatus)) {
        setFlashData('msg', 'Cập nhật tình trạng đơn hàng thành công');
        setFlashData('msg_type', 'success');
    } else {
        setFlashData('msg', 'Có sự cố xảy ra, tình trạng không thê thay đổi');
        setFlashData("msg_type", 'danger');
    }

    redirect('?module=bill');
}