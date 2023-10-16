<?php

// Check đăng nhập
if (!empty($_POST['loginButton'])) {
    $body = getBody();

    if (!empty($body['email'] && !empty($body['password']))) {
        $email = trim($body['email']);
        // Truy vấn cơ sở dữ liệu
        $clientDetail = checkAccountExit($email);
        if (!empty($clientDetail) && $clientDetail['status'] == 1) {
            $passwordHash = $clientDetail['password'];
            $passwordCheck = $body['password'];
            if (password_verify($passwordCheck, $passwordHash)) {

                // Tạo token login
                $token = sha1(uniqid() . time());
                // Đăng nhập thành công

                setSession('login_token', $token);
                setSession('client_login', $clientDetail);
                $dataInsert = [
                    'token' => $token,
                    'client_id' => $clientDetail['id'],
                    'create_at' => date('Y/m/d H:i:s'),
                ];

                $insertStatus = insert('login_token', $dataInsert);
            } else {
                setFlashData('msg', 'Mật khẩu không chính xác');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Email không tồn tại hoặc chưa được kích hoạt');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
    }

    redirect('index.php');
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<?php if (isLogin()) :
    $client = getSession('client_login');
?>
    <div class="mb">
        <div class="box_title">TÀI KHOẢN</div>
        <div class="box_content form_account">
            <form action="#" method="POST" style="text-align: left;">
                <?php getMsg($msg, $msg_type) ?>
                <h4><?php echo $client['fullname'] ?></h4>
                <ul>
                    <li>Họ tên: <?php echo $client['fullname'] ?></li>
                    <li>Email: <?php echo $client['email'] ?></li>
                    <li>Vị trí: <?php echo ($client['position'] == 0) ? 'khách hàng' : 'admin' ?></li>
                    <li>Xshop</li>
                    <li>Siêu thị trực tuyến</li>
                    <li><a href="?module=account&action=edit" style="text-decoration: none;">Cập nhật tài khoản</a></li>
                    <li><a href="?module=account&action=changepassword" style="text-decoration: none;">Đổi mật khẩu</a></li>
                </ul>
                <br>
                <a href="?module=login&action=logout"><button class="btn btn-danger btn-sm" type="button">Đăng
                        xuất</button></a>
                <?php if ($client['position'] != 0) : ?>
                    <button class="btn btn-warning btn-sm"><a href="<?php echo _WEB_HOST_ROOT . '/admin' ?>" style="text-decoration: none; color: black" target="_blank">Trang quản
                            trị</a></button>
                <?php endif; ?>
                <button class="btn btn-success btn-sm"><a href="?module=cart&action=lists" style="text-decoration: none; color: white">GIỎ HÀNG <i class="fa fa-shopping-cart"></i></a></button>
            </form>
        </div>
    </div>
<?php
else : ?>
    <div class="mb">
        <div class="box_title">TÀI KHOẢN</div>
        <div class="box_content form_account">
            <form action="#" method="POST" style="text-align: left;">
                <?php getMsg($msg, $msg_type) ?>
                <h4>Tên đăng nhập</h4><br>
                <input type="text" name="email" id="" placeholder="Tên tài khoản(email)...">
                <h4>Mật khẩu</h4><br>
                <input type="password" name="password" id="" placeholder="Mật khẩu..."><br>
                <br>
                <a href=""><button type="submit" name="loginButton" value="1" class="btn btn-primary btn-sm">Đăng
                        nhập</button></a>
                <li class="form_li"><a href="?module=login&action=forgot">Quên mật khẩu</a></li>
                <li class="form_li"><a href="?module=login&action=register">Đăng kí thành viên</a></li>
            </form>
        </div>
    </div>

<?php endif; ?>