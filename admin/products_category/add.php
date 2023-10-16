<?php

require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

if (isPost()) {

    $body = getBody();

    $errors = [];

    if (empty($body['name'])) {
        $errors['name'] = 'Loại hàng hóa không được để trống!';
    } else {
        if (strlen($body['name']) < 6) {
            $errors['name'] = 'Tên loại hàng hóa không được nhỏ hơn 6 ký tự';
        }
    }

    if (empty($errors)) {
        // khong co loi xay ra
        $data = [
            'name' => trim($body['name']),
            'create_at' => date('Y-m-d H:i:s')
        ];

        $insertStatus = insert('type', $data);
        if (!empty($insertStatus)) {
            setFlashData('msg', 'Thêm loại hàng hóa thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Có lỗi xảy ra , vui lòng kiểm tra dữ liệu');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=products_category&action=add');
    } else {
        setFlashData('msg', 'Có lỗi xảy ra , vui lòng kiểm tra dữ liệu');
        setFlashData('msg_type', 'danger');
        setFlashData('old', $body);
        setFlashData('error', $errors);
        redirect('?module=products_category&action=add');
    }
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$old = getFlashData('old');
$error = getFlashData('error');
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>THÊM MỚI LOẠI HÀNG HÓA</h1>
    </div>
    <div class="row2 form_content ">
        <br>
        <?php getMsg($msg, $msg_type) ?>
        <form action="#" method="POST" style="text-align: left;">
            <div class="row2 mb10 form_content_container">
                <label> Mã loại </label> <br>
                <input type="text" name="id" placeholder="nhập vào mã loại" disabled>
            </div>
            <div class="row2 mb10">
                <label>Tên loại </label> <br>
                <input type="text" name="name" placeholder="nhập vào tên loại hàng hóa">
                <p class="error"><?php echo errorData('name', $error) ?></p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <a href="?module=products_category"><button type="button" class="btn btn-success">Danh sách</button></a>
            </div>
        </form>
    </div>
</div>