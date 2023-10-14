<?php
require_once _WEB_PATH_TEMPLATE . '/client/header.php';

// Xử lý dữ liệu
if (!empty($_POST['registerButton'])) {
    $body = getBody();

    $errors = [];

    if (empty(trim($body['fullname']))) {
        $errors['fullname'] = 'Họ và tên không được để trống';
    } else {
        if (strlen(trim($body['fullname']) <= 5)) {
            $errors['fullname'] = 'Họ và tên phải lớn hơn 5 ký tự';
        }
    }

    if (empty(trim($body['email']))) {
        $errors['email'] = 'Email không được để trống';
    } else {
        if (!filter_var(trim($body['email']), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Định dạng email không hợp lệ';
        } else {
            // Truy van co so du lieu bang client
            $email = trim($body['email']);
            $listClient = getRows("SELECT * FROM client WHERE email='$email'");
            if ($listClient > 0) {
                $errors['email'] = 'Email đã tồn tại, vui lòng thử lại email khác';
            }
        }
    }

    if (empty(trim($body['password']))) {
        $errors['password'] = 'Mật khẩu không được để trống';
    } else {
        if (strlen(trim($body['password'])) < 6) {
            $errors['password'] = 'Mật khẩu phải lớn hơn hoặc bằng 6 ký tự';
        }
    }

    if (empty(trim($body['confirm_password']))) {
        $errors['confirm_password'] = 'Nhập lại mật khẩu không được để trống';
    } else {
        if (trim($body['confirm_password']) !== trim($body['password'])) {
            $errors['confirm_password'] = 'Nhập lại mật khẩu không trùng khớp';
        }
    }

    if (empty($errors)) {
        // Không có lỗi xảy ra

        // Tạo token
        $token = sha1(uniqid() . time());

        $dataInsert = [
            'fullname' => trim($body['fullname']),
            'email' => trim($body['email']),
            'password' => password_hash(trim($body['password']), PASSWORD_DEFAULT),
            'status' => 0,
            'position' => 0,
            'token' => $token,
            'create_at' => date('Y/m/d H:i:s')
        ];

        $insertStatus = insert('client', $dataInsert);
        if (!empty($insertStatus)) {

            // Tạo link token
            $linkToken = _WEB_HOST_ROOT . '?module=login&action=active&token=' . $token;

            // Gửi email

            $subject = 'Chúc mừng bạn vừa tạo tài khoản thành công, vui lòng xem hướng dẫn kích hoạt tài khoản';
            $content = 'Chúc mừng bạn ' . trim($body['fullname']) . ' Đăng ký tài khoản thành công <br/>';
            $content .= 'Vui lòng click vào link dưới đây để kích hoạt tài khoản: <br/>';
            $content .= 'Link: ' . $linkToken . '<br/>';
            $content .= 'Trân trọng!';

            $sendMailStatus = sendMail(trim($body['email']), $subject, $content);

            if (!empty($sendMailStatus)) {
                setFlashData('msg', 'Bạn vừa đăng ký tài khoản thành công, vui lòng vào mail để xem hướng dẫn kích hoạt tài khoản');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Lỗi hệ thống, vui lòng thử lại sau!');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Lỗi hệ thống, Vui lòng thử lại sau!');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
    }
    redirect('?module=login&action=register');
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('errors');
$old = getFlashData('old');
?>
<main class="catalog  mb ">

    <div class="boxleft">
        <h2>Đăng ký thành viên</h2>
        <?php getMsg($msg, $msg_type) ?>
        <form action="" method="post" style="text-align: left;">
            <div class="form-group">
                <label for="">Họ và tên</label>
                <input type="text" class="form-control" name="fullname" placeholder="Họ và tên..." value="<?php echo oldData('fullname', $old) ?>">
                <p class="error"><?php echo errorData('fullname', $error) ?></p>
            </div>

            <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Email..." value="<?php echo oldData('email', $old) ?>">
                <p class="error"><?php echo errorData('email', $error) ?></p>
            </div>

            <div class="form-group">
                <label for="">Mật khẩu</label>
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu...">
                <p class="error"><?php echo errorData('password', $error) ?></p>
            </div>

            <div class="form-group">
                <label for="">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu...">
                <p class="error"><?php echo errorData('confirm_password', $error) ?></p>
            </div>

            <button type="submit" name="registerButton" value="1" class="btn btn-success">Đăng ký</button>
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';
