<?php

require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

if (isPost()) {
    $body = getBody();

    $errors = [];

    if (empty(trim($body['fullname']))) {
        $errors['fullname'] = 'Họ và tên quản trị viên không được để trống!';
    }

    if (empty(trim($body['email']))) {
        $errors['email'] = 'Email không được để trống';
    } else {
        if (!filter_var(trim($body['email']), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Định dạng email không hợp lệ';
        } else {
            // Truy van co so du lieu bang client
            $email = trim($body['email']);
            $listClient = clientEmail($email);
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

    if (empty($errors)) {
        // Không có lỗi xảy ra

        // Tạo token

        $dataInsert = [
            'fullname' => trim($body['fullname']),
            'email' => trim($body['email']),
            'password' => password_hash(trim($body['password']), PASSWORD_DEFAULT),
            'status' => 1,
            'position' => 1,
            'create_at' => date('Y/m/d H:i:s')
        ];

        $insertStatus = insert('client', $dataInsert);
        if (!empty($insertStatus)) {
            setFlashData('msg', 'Thêm quản trị viên thành công!');
            setFlashData('msg_type', 'success');
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
    redirect('?module=manager&action=add');
}

// Truy van du lieu type
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$old = getFlashData('old');
$error = getFlashData('errors');
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>THÊM QUẢN TRỊ VIÊN MỚI</h1>
    </div>
    <div class="row2 form_content ">
        <br>
        <?php getMsg($msg, $msg_type) ?>
        <form action="#" method="POST" style="text-align: left;" enctype="multipart/form-data">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label> Mã QTV </label>
                        <input type="text" name="id" placeholder="nhập vào mã loại" class="form-control" value="<?php echo oldData('id', $old) ?>" disabled>
                        <p></p>
                    </div>

                    <div class="form-group">
                        <label for="">Tên QTV</label>
                        <input type="text" name="fullname" class="form-control" placeholder="Tên quản trị viên..." value="<?php echo oldData('fullname', $old) ?>">
                        <p class="error"><?php echo errorData('fullname', $error) ?></p>
                    </div>

                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label>Email quản trị viên </label>
                        <input type="text" name="email" placeholder="nhập vào email..." class="form-control" value="<?php echo oldData('email', $old) ?>">
                        <p class="error"><?php echo errorData('email', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label>Mật khẩu </label>
                        <input type="password" name="password" placeholder="nhập vào mật khẩu..." class="form-control" value="<?php echo oldData('password', $old) ?>">
                        <p class="error"><?php echo errorData('password', $error) ?></p>
                    </div>

                </div>

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <!-- <a href="?module=products"><button type="button" class="btn btn-success">Danh sách</button></a> -->
            </div>
        </form>
    </div>
</div>