<?php
require_once _WEB_PATH_TEMPLATE . '/client/header.php';

// Xử lý dữ liệu
if (!empty($_POST['fotgotButton'])) {
    $body = getBody();

    $errors = [];

    if (empty(trim($body['email']))) {
        $errors['email'] = 'Email trông được để trống';
    } else {
        if (!isEmail(trim($body['email']))) {
            $errors['email'] = 'Email không đúng định dạng';
        } else {
            // Truy van co so du lieu bang client
            $email = trim($body['email']);
            $listClient = getRows("SELECT * FROM client WHERE email='$email'");
            if ($listClient < 1) {
                $errors['email'] = 'Email không tồn tại trong hệ thống, vui lòng kiểm tra lại';
            }
        }
    }

    if (empty($errors)) {
        // Tạo token forgot
        $forgotToken = sha1(uniqid() . time());

        $dataUpdate = [
            'forgot' => $forgotToken,
            'update_at' => date('Y/m/d H:i:s')
        ];

        $condition = "email='$email'";

        $updateStatus = update('client', $dataUpdate, $condition);

        if (!empty($updateStatus)) {
            // Tạo link reset password
            $resetPassword = _WEB_HOST_ROOT . '?module=login&action=reset&token=' . $forgotToken;
            // Tiến hành gửi email
            $subject = 'Yêu cầu khôi phục mật khẩu';
            $content = 'Chào bạn. <br/>';
            $content .= 'Chúng tôi nhận được yêu cầu khôi phục mật khẩu từ bạn. <br/>';
            $content .= 'Vui lòng click vào link dưới đây để lấy lại mật khẩu <br/>';
            $content .= 'Link: ' . $resetPassword . ' <br/>';
            $content .= 'Trân trọng!';

            $sendMailStatus = sendMail(trim($body['email']), $subject, $content);
            if (!empty($sendMailStatus)) {
                setFlashData('msg', 'Kiểm tra mail để xem hướng dẫn đổi mật khẩu mới');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Lỗi hệ thống, vui lòng thử lại sau!');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Có lỗi xảy ra, vui lòng thử lại sau!');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Có lỗi xảy ra, vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
    }

    redirect('?module=login&action=forgot');
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('errors');
$old = getFlashData('old');
?>
<main class="catalog  mb ">

    <div class="boxleft">
        <h2>Quên mật khẩu</h2>
        <?php getMsg($msg, $msg_type) ?>
        <form action="" method="post" style="text-align: left;">
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Email..." value="<?php echo oldData('email', $old) ?>">
                <p class="error"><?php echo errorData('email', $error) ?></p>
            </div>

            <button type="submit" name="fotgotButton" value="1" class="btn btn-success">Xác nhận</button>
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';
