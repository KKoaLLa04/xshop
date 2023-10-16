<?php

require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

// Truy vấn cơ sở dữ liệu cũ
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $listComment = commentDetail($id);
}

if (isPost()) {

    $body = getBody();

    $errors = [];

    if (empty($body['product_id'])) {
        $errors['product_id'] = 'Sản phẩm bình luận bắt buộc phải chọn';
    }
    if (empty($body['content'])) {
        $errors['content'] = 'Nội dung bình luận không được để trống!';
    }

    if (empty($errors)) {
        $dataUpdate = [
            'content' => trim($body['content']),
            'product_id' => trim($body['product_id']),
            'update_at' => date('Y-m-d H:i:s')
        ];

        $condition = "id=" . $id;

        $updateStatus = update('comments', $dataUpdate, $condition);
        if (!empty($updateStatus)) {
            setFlashData('msg', 'Cập nhật bình luận của khách hàng thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Có lỗi xảy ra , vui lòng kiểm tra dữ liệu');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=comments&action=update&id=' . $id);
    } else {
        setFlashData('msg', 'Có lỗi xảy ra, Vui lòng kiểm tra dữ liệu nhập vào!');
        setFlashData('msg_type', 'danger');
        setFlashData('error', $errors);
        setFlashData('old', $body);
        redirect('?module=comments&action=update&id=' . $id);
    }
}
// danh sach toan bo san pham
$listAllProducts = listProduct();

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('error');
$old = getFlashData('old');
if (empty($old) && !empty($listComment)) {
    $old = $listComment;
}
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>Cập nhật bình luận khách hàng</h1>
    </div>
    <div class="row2 form_content ">
        <br>
        <?php getMsg($msg, $msg_type) ?>
        <form action="#" method="POST" style="text-align: left;" enctype="multipart/form-data">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label> Tên khách hàng </label> <br>
                        <input type="text" name="fullname" placeholder="Tên khách hàng..." class="form-control" value="<?php echo oldData('fullname', $old) ?>" disabled>
                    </div>

                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label> Sản phẩm bình luận </label> <br>
                        <select name="product_id" class="form-control">
                            <?php if (!empty($listAllProducts)) :
                                foreach ($listAllProducts as $item) :  ?>
                                    <option value="<?php echo $item['id'] ?>" <?php echo ($item['id'] == $listComment['product_id']) ? 'selected' : false ?>>
                                        <?php echo $item['name'] ?></option>
                            <?php endforeach;
                            endif ?>
                        </select>
                        <p class="error"><?php echo errorData('product_id', $error) ?></p>
                    </div>
                </div>

                <div class="col-12">
                    <label for="">Nội dung bình luận</label>
                    <textarea name="content" class="form-control" rows="10"><?php echo $listComment['content'] ?></textarea>
                    <p class="error"><?php echo errorData('content', $error) ?></p>
                </div>

            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="?module=comments"><button type="button" class="btn btn-success">Danh sách</button></a>
            </div>
        </form>
    </div>
</div>