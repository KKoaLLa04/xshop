<?php

require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

$id = '';
$categoryDetail = [];
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn cơ sở dữ liệu 
    $categoryDetail = firstRaw("SELECT * FROM type WHERE id=$id");
} else {
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('msg_type', 'danger');
}

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
        $dataUpdate = [
            'name' => trim($body['name']),
            'update_at' => date('Y-m-d H:i:s')
        ];

        $condition = 'id=' . $id;

        $updateStatus = update('type', $dataUpdate, $condition);
        if (!empty($updateStatus)) {
            setFlashData('msg', 'Cập nhật loại hàng hóa thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Có lỗi xảy ra , vui lòng kiểm tra dữ liệu');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=products_category&action=update&id=' . $id);
    } else {
        setFlashData('msg', 'Có lỗi xảy ra , vui lòng kiểm tra dữ liệu');
        setFlashData('msg_type', 'danger');
        setFlashData('old', $body);
        setFlashData('error', $errors);
        redirect('?module=products_category&action=update&id=' . $id);
    }
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$old = getFlashData('old');
$error = getFlashData('error');
if (empty($old) && !empty($categoryDetail)) {
    $old = $categoryDetail;
}
echo '<pre>';
print_r($old);
echo '</pre>';
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>Cập nhật LOẠI HÀNG HÓA</h1>
    </div>
    <div class="row2 form_content ">
        <br>
        <?php getMsg($msg, $msg_type) ?>
        <form action="#" method="POST" style="text-align: left;">
            <div class="row2 mb10 form_content_container">
                <label> Mã loại </label> <br>
                <input type="text" name="id" placeholder="nhập vào mã loại" value="<?php echo oldData('id', $old) ?>" disabled>
            </div>
            <div class="row2 mb10">
                <label>Tên loại </label> <br>
                <input type="text" name="name" placeholder="nhập vào tên loại hàng hóa" value="<?php echo oldData('name', $old) ?>">
                <p class="error"><?php echo errorData('name', $error) ?></p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <button type="button" class="btn btn-warning">Nhập lại</button>
                <a href="?module=products_category"><button type="button" class="btn btn-success">Danh sách</button></a>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        </form>
    </div>
</div>