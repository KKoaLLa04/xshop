<?php
$data = [
    'page_title' => 'XSHOP - Cập nhật thông tin cá nhân'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

if (isLogin()) {
    $clientId = isLogin()['client_id'];
    $clientDetail = firstRaw("SELECT * FROM client WHERE id=$clientId");

    if (!empty($clientDetail)) {

        if (!empty($_POST['editbutton'])) {
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
                    $listClient = getRows("SELECT * FROM client WHERE email='$email' AND id <> $clientId");
                    if ($listClient > 0) {
                        $errors['email'] = 'Email đã tồn tại, vui lòng thử lại email khác';
                    }
                }
            }

            if (empty($errors)) {
                // khong co loi xay ra
                $dataUpdate = [
                    'fullname' => trim($body['fullname']),
                    'email' => trim($body['email']),
                    'address' => trim($body['address']),
                    'phone' => trim($body['phone']),
                    'update_at' => date('Y/m/d H:i:s')
                ];

                $condition = 'id=' . $clientId;

                $updateStatus = update('client', $dataUpdate, $condition);

                if (!empty($updateStatus)) {
                    setFlashData('msg', 'Cập nhật thông tin cá nhân thành công!');
                    setFlashData('msg_type', 'success');
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
            redirect('?module=account&action=edit');
        }
    } else {
        setFlashData("msg", 'Lỗi hệ thống, vui lòng liên hệ quản trị viên!');
        setFlashData('msg_type', 'danger');
        redirect('?module=account&action=edit');
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
        <h2>Cập nhật thông tin cá nhân</h2>
        <?php getMsg($msg, $msg_type) ?>
        <form action="" method="post" style="text-align: left;">
            <div class="form-group">
                <label for="">Họ và tên</label>
                <input type="text" class="form-control" name="fullname" placeholder="Họ và tên..."
                    value="<?php echo oldData('fullname', $old) ?>">
                <p class="error"><?php echo errorData('fullname', $error) ?></p>
            </div>

            <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Email..."
                    value="<?php echo oldData('email', $old) ?>">
                <p class="error"><?php echo errorData('email', $error) ?></p>
            </div>

            <div class="form-group">
                <label for="">Số điện thoại</label>
                <input type="text" class="form-control" name="phone" placeholder="số điện thoại..."
                    value="<?php echo oldData('phone', $old) ?>">
                <p class="error"><?php echo errorData('phone', $error) ?></p>
            </div>

            <div class="form-group">
                <label for="">Địa chỉ</label>
                <input type="text" class="form-control" name="address" placeholder="Địa chỉ..."
                    value="<?php echo oldData('address', $old) ?>">
                <p class="error"><?php echo errorData('address', $error) ?></p>
            </div>

            <button type="submit" name="editbutton" value="1" class="btn btn-success">Cập nhật</button>
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';