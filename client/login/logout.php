<?php

if (!empty($_SESSION['login_token'])) {

    // Xoa co so du lieu trong bang token
    $token = $_SESSION['login_token'];
    $condition = "token = '$token'";
    $deleteStatus = delete('login_token', $condition);
    if (!empty($deleteStatus)) {
        unset($_SESSION['login_token']);
        unset($_SESSION['client_login']);
        redirect('index.php');
        setFlashData('msg', 'Đăng xuất thành công');
        setFlashData('msg_type', 'success');
    }
} else {
    unset($_SESSION);
    redirect('index.php');
}
