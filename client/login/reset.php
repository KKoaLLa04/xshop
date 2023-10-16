<?php
require_once _WEB_PATH_TEMPLATE . '/client/header.php';

// Xử lý dữ liệu
$body = getBody();
if (!empty(trim($body['token']))) {
    $token = trim($body['token']);

    if (!empty($_POST['resetButton'])) {
        $clientQuery = forgotToken($token);

        if (!empty($clientQuery)) {
            if (isPost()) {
                $body = getBody();

                $errors = [];



                if (empty(trim($body['password']))) {
                    $errors['password'] = 'Mật khẩu mới không được để trống';
                } else {
                    if (strlen(trim($body['password'])) < 6) {
                        $errors['password'] = 'Mật khẩu mới phải lớn hơn hoặc bằng 6 ký tự';
                    }
                }

                if (empty(trim($body['confirm_password']))) {
                    $errors['confirm_password'] = 'Nhập lại mật khẩu mới không được để trống';
                } else {
                    if (trim($body['confirm_password']) !== trim($body['password'])) {
                        $errors['confirm_password'] = 'Nhập lại mật khẩu mới không trùng khớp';
                    }
                }

                if (empty($errors)) {
                    // Tạo token forgot
                    $dataUpdate = [
                        'forgot' => '',
                        'password' => password_hash(trim($body['password']), PASSWORD_DEFAULT),
                        'update_at' => date('Y/m/d H:i:s')
                    ];

                    $condition = "forgot='$token'";

                    $updateStatus = update('client', $dataUpdate, $condition);

                    if (!empty($updateStatus)) {
                        // Tiến hành gửi email
                        setFlashData('msg', 'Bạn đã đổi mật khẩu thành công');
                        setFlashData('msg_type', 'success');
                        redirect('index.php');
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

                // redirect('index.php');
            }
        } else {
            setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn');
            setFlashData('msg_type', 'danger');
            // redirect('index.php');
        }
    }
} else {
    setFlashData('msg', 'Liên kết không tồn tại hoặc đã hết hạn');
    setFlashData('msg_type', 'danger');
    redirect('index.php');
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
                <label for="">Mật khẩu mới</label>
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu mới...">
                <p class="error"><?php echo errorData('password', $error) ?></p>
            </div>

            <div class="form-group">
                <label for="">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu mới...">
                <p class="error"><?php echo errorData('confirm_password', $error) ?></p>
            </div>


            <button type="submit" name="resetButton" value="1" class="btn btn-success">Xác nhận</button>
            <input type="hidden" name="token" value="<?php echo $token ?>">
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';
