<?php
$data = [
    'page_title' => 'XSHOP - Đổi mật khẩu'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

if (isLogin()) {
    $clientId = isLogin()['client_id'];
    $clientDetail = clientDetailAccount($clientId);
    if (!empty($clientDetail)) {

        if (!empty($_POST['changepassword'])) {
            $body = getBody();

            $password_old = $body['password_old'];
            $passwordHash = $clientDetail['password'];

            $errors = [];

            if (empty(trim($body['password_old']))) {
                $errors['password_old'] = 'Mật khẩu cũ không được để trống';
            } else {
                if (strlen(trim($body['password_old']) <= 5)) {
                    $errors['password_old'] = 'Mật khẩu cũ phải lớn hơn 5 ký tự';
                } else {
                    if (!password_verify($password_old, $passwordHash)) {
                        $errors['password_old'] = 'mật khẩu cũ không chính xác, vui lòng thử lại';
                    }
                }
            }

            if (empty(trim($body['password']))) {
                $errors['password'] = 'Mật khẩu mới không được để trống';
            } else {
                if (strlen(trim($body['password']) <= 5)) {
                    $errors['password'] = 'Mật khẩu mới phải lớn hơn 5 ký tự';
                }
            }

            if (empty(trim($body['confirm_password']))) {
                $errors['confirm_password'] = 'Nhập lại mật khẩu mới không được để trống';
            } else {
                if (trim($body['confirm_password']) !== trim($body['password'])) {
                    $errors['confirm_password'] = 'Mật khẩu nhập lại không trùng khớp';
                }
            }


            if (empty($errors)) {
                // khong co loi xay ra
                $dataUpdate = [
                    'password' => password_hash(trim($body['password']), PASSWORD_DEFAULT),
                    'update_at' => date('Y/m/d H:i:s')
                ];

                $condition = 'id=' . $clientId;

                $updateStatus = update('client', $dataUpdate, $condition);

                if (!empty($updateStatus)) {
                    setFlashData('msg', 'Đổi mật khẩu thành công!');
                    setFlashData('msg_type', 'success');
                    redirect('?module=login&action=logout');
                } else {
                    setFlashData("msg", 'Lỗi hệ thống, vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu nhập vào');
                setFlashData('msg_type', 'danger');
                setFlashData('errors', $errors);
                setFlashData('old', $body);
            }
            redirect('?module=account&action=changepassword');
        }
    } else {
        setFlashData("msg", 'Lỗi hệ thống, vui lòng liên hệ quản trị viên!');
        setFlashData('msg_type', 'danger');
        redirect('?module=account&action=changepassword');
    }
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('errors');
$old = getFlashData('old');
if (!empty($clientDetail) && empty($old)) {
    $old = $clientDetail;
}
?>
<main class="catalog  mb ">

    <div class="boxleft">
        <h2>Thay đổi mật khẩu</h2>
        <?php getMsg($msg, $msg_type) ?>
        <form action="" method="post" style="text-align: left;">
            <div class="form-group">
                <label for="">Mật khẩu cũ</label>
                <input type="password" class="form-control" name="password_old" placeholder="Mật khẩu cũ...">
                <p class="error"><?php echo errorData('password_old', $error) ?></p>
            </div>

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


            <button type="submit" name="changepassword" value="1" class="btn btn-success">Xác nhận</button>
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';
