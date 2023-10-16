<?php
if (isGet()) {
    $body = getBody();
    $token = $body['token'];
}
if (!empty($token)) {
    $clientToken = clientToken($token);

    if (!empty($clientToken)) {
        $dataUpdate = [
            'token' => '',
            'status' => 1,
            'update_at' => date('Y/m/d H:i:s'),
        ];

        $condition = "token = '$token'";

        $updateStatus = update('client', $dataUpdate, $condition);
        if (!empty($updateStatus)) {

            // Link login 
            $linkLogin = _WEB_HOST_ROOT . '?module=login&action=login';

            // Gửi email kích hoạt tài khoản thành công
            $subject = 'Chúc mừng bạn ' . $clientToken['fullname'] . ' Đã kích hoạt tài khoản thành công';
            $content = 'Bạn có thể đăng nhập ngay bây giờ bằng link dưới đây: <br/>';
            $content .= 'Link: ' . $linkLogin . ' <br/>';
            $content .= 'Trân trọng!';

            $sendMailStatus = sendMail($clientToken['email'], $subject, $content);

            if (!empty($sendMailStatus)) {
                setFlashData('msg', 'Bạn đã kích hoạt tài khoản thành công, có thể đăng nhập ngay lúc này!');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Lỗi hệ thống, vui lòng thử lại sau!');
                setFlashData('msg_type', 'danger');
            }

            redirect('?module=login&action=register');
        } else {
            setFlashData('msg', 'Lỗi hệ thống, vui lòng liên hệ quản trị viên để được kích hoạt tài khoản!');
            setFlashData('msg_type', 'danger');
            redirect('?module=login&action=register');
        }
    } else {
        setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn');
    }
} else {
    setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn');
}

$msg = getFlashData('msg');
if (!empty($msg)) :
?>
    <div class="" style="margin: 30px auto; text-align: center; background-color: red; color: white">
        <h1 class="text-center"><?php echo !empty($msg) ? $msg : false ?></h1>
    </div>
<?php endif ?>