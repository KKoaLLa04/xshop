<?php

require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

// Truy vấn cơ sở dữ liệu cũ
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $listBillDetail = firstRaw("SELECT * FROM bill WHERE id=$id");
}

if (isPost()) {

    $body = getBody();

    $status = $body['status'];
    if (isset($status)) {
        $dataUpdate = [
            'name' => trim($body['name']),
            'address' => trim($body['address']),
            'email' => trim($body['email']),
            'phone' => trim($body['phone']),
            'total' => trim($body['total']),
            'pay' => trim($body['pay']),
            'status' => $status,
        ];

        $condition = 'id=' . $id;

        $updateStatus = update('bill', $dataUpdate, $condition);
        if (!empty($updateStatus)) {
            setFlashData('msg', 'Cập nhật hóa đơn khách hàng thành công!');
            setFlashData("msg_type", 'success');
        } else {
            setFlashData("msg", 'có lỗi xảy ra, vui lòng thử lại!');
            setFlashData('msg_type', 'danger');
        }

        redirect("?module=bill&action=update&id=$id");
    }
}
// Truy van du lieu type
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('error');
$old = getFlashData('old');
if (empty($old) && !empty($listBillDetail)) {
    $old = $listBillDetail;
}
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>Sửa hóa đơn khách hàng</h1>
    </div>
    <div class="row2 form_content ">
        <br>
        <?php getMsg($msg, $msg_type) ?>
        <form action="#" method="POST" style="text-align: left;" enctype="multipart/form-data">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label> Mã Đơn hàng </label>
                        <input type="text" name="id" placeholder="nhập vào mã đơn hàng" class="form-control"
                            value="<?php echo oldData('code', $old) ?>" disabled>
                        <p></p>
                    </div>

                    <div class="form-group">
                        <label for="">Tên khách hàng</label>
                        <input type="text" name="name" class="form-control" placeholder="Tên khách hàng..."
                            value="<?php echo oldData('name', $old) ?>">
                        <p class="error"><?php echo errorData('name', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email..."
                            value="<?php echo oldData('email', $old) ?>">
                        <p class="error"><?php echo errorData('email', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label for="">Tổng</label>
                        <input type="text" name="total" class="form-control" placeholder="Tổng tiền thanh toan..."
                            value="<?php echo oldData('total', $old) ?>">
                        <p class="error"><?php echo errorData('total', $error) ?></p>
                    </div>

                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label>Địa chỉ </label>
                        <input type="text" name="address" placeholder="nhập vào địa chỉ...." class="form-control"
                            value="<?php echo oldData('address', $old) ?>">
                        <p class="error"><?php echo errorData('address', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label>Điện thoại </label>
                        <input type="text" name="phone" placeholder="nhập vào số điện thoại...." class="form-control"
                            value="<?php echo oldData('phone', $old) ?>">
                        <p class="error"><?php echo errorData('phone', $error) ?></p>
                    </div>

                    <div class="form-group">
                        <label for="">Tình trạng</label>
                        <select name="status" class="form-control">
                            <option value="0"
                                <?php echo (!empty($old['status']) && $old['status'] == 0) ? 'selected' : false ?>>Đơn
                                hàng mới
                            </option>
                            <option value="1"
                                <?php echo (!empty($old['status']) && $old['status'] == 1) ? 'selected' : false ?>>Đang
                                xử
                                lý
                            </option>
                            <option value="2"
                                <?php echo (!empty($old['status']) && $old['status'] == 2) ? 'selected' : false ?>>Đang
                                giao
                            </option>
                            <option value="3"
                                <?php echo (!empty($old['status']) && $old['status'] == 3) ? 'selected' : false ?>>Đã
                                giao
                            </option>
                        </select>
                        <p></p>

                        <div class="form-group">
                            <label for="">Hình thức thanh toán</label>
                            <select name="pay" class="form-control">
                                <option value="0"
                                    <?php echo (isset($old['pay']) && $old['pay'] == 0) ? 'selected' : false ?>>Thanh
                                    toán khi nhận hàng
                                </option>
                                <option value="1"
                                    <?php echo (isset($old['pay']) && $old['pay'] == 1) ? 'selected' : false ?>>Thanh
                                    toán online
                                </option>
                            </select>
                            <p></p>
                        </div>

                    </div>

                </div>

                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo !empty($id) ? $id : false ?>">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="?module=bill"><button type="button" class="btn btn-success">Danh sách</button></a>
                </div>
        </form>
    </div>
</div>