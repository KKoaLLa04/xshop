<?php

require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

// Truy vấn cơ sở dữ liệu cũ
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $listProducts = firstRaw("SELECT * FROM products WHERE id=$id");
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

    if (empty($body['price'])) {
        $errors['price'] = 'Giá hàng hóa không được để trống';
    } else {
        if ($body['price'] <= 0) {
            $errors['price'] = 'Giá hàng hóa không được nhỏ hơn hoặc bằng 0';
        }
    }

    if (empty($body['type_id'])) {
        $errors['type_id'] = 'Danh mục hàng hóa bắt buộc phải chọn';
    }

    if (empty($errors)) {
        // khong co loi xay ra
        if (empty($_FILES['image']['name'])) {
            $dataUpdate = [
                'name' => trim($body['name']),
                'price' => trim($body['price']),
                'view' => 0,
                'status' => trim($body['status']),
                'type_id' => trim($body['type_id']),
                'create_at' => date('Y-m-d H:i:s')
            ];
        } else {
            // Xu ly anh
            $from = $_FILES['image']['tmp_name'];
            $to = _WEB_PATH_ROOT . '/uploads/' . $_FILES['image']['name'];
            move_uploaded_file($from, $to);
            $image = $_FILES['image']['name'];
            $dataUpdate = [
                'name' => trim($body['name']),
                'price' => trim($body['price']),
                'image' => trim($image),
                'view' => 0,
                'status' => trim($body['status']),
                'type_id' => trim($body['type_id']),
                'create_at' => date('Y-m-d H:i:s')
            ];
        }


        $condition = "id=" . $id;

        $updateStatus = update('products', $dataUpdate, $condition);
        if (!empty($updateStatus)) {
            setFlashData('msg', 'Cập nhật hàng hóa thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Có lỗi xảy ra , vui lòng kiểm tra dữ liệu');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=products&action=update&id=' . $id);
    } else {
        setFlashData('msg', 'Có lỗi xảy ra , vui lòng kiểm tra dữ liệu');
        setFlashData('msg_type', 'danger');
        setFlashData('old', $body);
        setFlashData('error', $errors);
        redirect('?module=products&action=update&id=' . $id);
    }
}
// Truy van du lieu type
$listAllType = getRaw("SELECT * FROM type ORDER BY id DESC");
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('error');
$old = getFlashData('old');
if (empty($old) && !empty($listProducts)) {
    $old = $listProducts;
}
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>THÊM MỚI LOẠI HÀNG HÓA</h1>
    </div>
    <div class="row2 form_content ">
        <br>
        <?php getMsg($msg, $msg_type) ?>
        <form action="#" method="POST" style="text-align: left;" enctype="multipart/form-data">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label> Mã loại </label> <br>
                        <input type="text" name="id" placeholder="nhập vào mã loại" class="form-control"
                            value="<?php echo oldData('id', $old) ?>" disabled>
                        <p></p>
                    </div>

                    <div class="form-group">
                        <label for="">Giá</label>
                        <input type="text" name="price" class="form-control" placeholder="Giá hàng hóa..."
                            value="<?php echo oldData('price', $old) ?>">
                        <p class="error"><?php echo errorData('price', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label for="">Tên danh mục</label>
                        <select name="type_id" class="form-control">
                            <option value="0">Chọn danh mục</option>
                            <?php if (!empty($listAllType)) :
                                foreach ($listAllType as $item) : ?>
                            <option value="<?php echo $item['id'] ?>"
                                <?php echo (!empty($old['type_id']) && $item['id'] == $old['type_id']) ? 'selected' : false ?>>
                                <?php echo $item['name'] ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                        <p class="error"><?php echo errorData('type_id', $error) ?></p>
                    </div>

                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label>Tên Hàng hóa </label> <br>
                        <input type="text" name="name" placeholder="nhập vào tên hàng hóa" class="form-control"
                            value="<?php echo oldData('name', $old) ?>">
                        <p class="error"><?php echo errorData('name', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label for="">Tình trạng</label>
                        <select name="status" class="form-control">
                            <option value="0"
                                <?php echo !empty($old['status'] && $old['status'] == 0) ? 'selected' : false ?>>Hết
                                hàng
                            </option>
                            <option value="1"
                                <?php echo !empty($old['status'] && $old['status'] == 1) ? 'selected' : false ?>>Còn
                                hàng
                            </option>
                        </select>
                        <p></p>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Ảnh minh họa (không bắt buộc)</label>
                                <input type="file" name="image" class="form-control">
                                <p></p>
                            </div>
                            <div class="col-6">
                                <label for="">Ảnh Gốc</label>
                                <img src="<?php echo _WEB_HOST_ROOT . '/uploads/' . oldData('image', $old) ?>" alt=""
                                    width="150px">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="?module=products"><button type="button" class="btn btn-success">Danh sách</button></a>
            </div>
        </form>
    </div>
</div>