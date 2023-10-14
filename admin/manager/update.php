<?php

require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

// Truy vấn cơ sở dữ liệu cũ
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $clientDetail = firstRaw("SELECT * FROM client WHERE id=$id");
}

if (isPost()) {

    $body = getBody();

    $errors = [];

    // validate
    if (empty(trim($body['fullname']))) {
        $errors['fullname'] = 'Họ và ten không được để trống!';
    } else {
        if (strlen(trim($body['fullname'])) <= 6) {
            $errors['fullname'] = 'Họ và tên phải lớn hơn 6 ký tự!';
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
            $listClient = getRows("SELECT * FROM client WHERE email='$email' AND id<>$id");
            if ($listClient > 0) {
                $errors['email'] = 'Email đã tồn tại, vui lòng thử lại email khác';
            }
        }
    }

    if (empty($errors)) {
        $dataUpdate = [
            'fullname' => trim($body['fullname']),
            'address' => trim($body['address']),
            'email' => trim($body['email']),
            'phone' => trim($body['phone']),
            'status' => trim($body['status']),
            'position' => trim($body['position']),
            'update_at' => date('Y/m/d H:i:s'),
        ];

        $condition = "id=" . $id;

        $updateStatus = update('client', $dataUpdate, $condition);
        if (!empty($updateStatus)) {
            setFlashData('msg', 'Cập nhật thông tin của khách hàng thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Có lỗi xảy ra , vui lòng kiểm tra dữ liệu');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=manager&action=update&id=' . $id);
    } else {
        setFlashData('msg', 'Có lỗi xảy ra, Vui lòng kiểm tra dữ liệu nhập vào!');
        setFlashData('msg_type', 'danger');
        setFlashData('error', $errors);
        setFlashData('old', $body);
        redirect('?module=manager&action=update&id=' . $id);
    }
}
// danh sach toan bo san pham

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('error');
$old = getFlashData('old');
if (empty($old) && !empty($clientDetail)) {
    $old = $clientDetail;
}
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>Cập nhật thông tin account khách hàng</h1>
    </div>
    <div class="row2 form_content ">
        <br>
        <?php getMsg($msg, $msg_type) ?>
        <form action="#" method="POST" style="text-align: left;" enctype="multipart/form-data">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label> Tên quản trị viên </label>
                        <input type="text" name="fullname" placeholder="Tên quản trị viên..." class="form-control"
                            value="<?php echo oldData('fullname', $old) ?>">
                        <p class="error"><?php echo errorData('fullname', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label> Email </label>
                        <input type="text" name="email" placeholder="Email..." class="form-control"
                            value="<?php echo oldData('email', $old) ?>">
                        <p class="error"><?php echo errorData('email', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label> Phone </label>
                        <input type="text" name="phone" placeholder="Số điện thoại..." class="form-control"
                            value="<?php echo oldData('phone', $old) ?>">
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label> Địa chỉ </label>
                        <input type="text" name="address" placeholder="Địa chỉ..." class="form-control"
                            value="<?php echo oldData('address', $old) ?>">
                        <p></p>
                    </div>

                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="0" <?php echo !empty(oldData('status', $old) == 0) ? 'selected' : false ?>>
                                Chưa kích
                                hoạt</option>
                            <option value="1" <?php echo !empty(oldData('status', $old) == 1) ? 'selected' : false ?>>Đã
                                kích
                                hoạt</option>
                        </select>
                        <p></p>
                    </div>

                    <div class="form-group">
                        <label for="">Chức vụ</label>
                        <select name="position" class="form-control">
                            <option value="0" <?php echo !empty(oldData('position', $old) == 0) ? 'selected' : false ?>>
                                Khách hàng</option>
                            <option value="1" <?php echo !empty(oldData('position', $old) == 1) ? 'selected' : false ?>>
                                Quản trị viên</option>
                            <option value="2" <?php echo !empty(oldData('position', $old) == 2) ? 'selected' : false ?>>
                                Admin</option>
                            <option value="3" <?php echo !empty(oldData('position', $old) == 3) ? 'selected' : false ?>>
                                Super Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="?module=manager"><button type="button" class="btn btn-success">Danh sách</button></a>
            </div>
        </form>
    </div>
</div>