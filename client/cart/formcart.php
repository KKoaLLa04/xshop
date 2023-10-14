<?php
$data = [
    'page_title' => 'XSHOP - Thanh toán'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

// Truy vấn cơ sở dữ liệu bảng cart va nguoi dung
if (isLogin()) {
    $clientId = isLogin()['client_id'];
    if (!empty($clientId)) {
        $listAllCart = getRaw("SELECT * FROM cart WHERE client_id=$clientId AND status=0 ORDER BY id DESC");
    }

    // truy van co so du lieu nguoi dung
    $clientInfo = firstRaw("SELECT * FROM client WHERE id=$clientId");
    if (isPost()) {
        $body = getBody();

        $errors = [];
        if (empty(trim($body['name']))) {
            $errors['name'] = 'Tên người đặt hàng bắt buộc phải nhập';
        }

        if (empty(trim($body['email']))) {
            $errors['email'] = 'Email người đặt hàng bắt buộc phải nhập';
        }

        if (empty(trim($body['phone']))) {
            $errors['phone'] = 'Số điện thoại người đặt hàng bắt buộc phải nhập';
        }

        if (empty(trim($body['address']))) {
            $errors['address'] = 'Địa chỉ người đặt hàng bắt buộc phải nhập';
        }

        if (empty($errors)) {
            // insert vao trong database
            $code = time();
            $dataInsert = [
                'name' => trim($body['name']),
                'email' => trim($body['email']),
                'address' => trim($body['address']),
                'phone' => trim($body['phone']),
                'pay' => trim($body['pay']),
                'total' => trim($body['total']),
                'status' => 0,
                'client_id' => $clientId,
                'code' => $code,
                'create_at' => date('Y/m/d H:i:s')
            ];

            $insertStatus = insert('bill', $dataInsert);
            if (!empty($insertStatus)) {
                setFlashData("msg", 'Bạn đã đặt đơn hàng thành công!');
                setFlashData('msg_type', 'success');
                redirect('?module=cart&action=bill');
            } else {
                setFlashData("msg", 'Lỗi hệ thống, vui lòng thử lại sau!');
                setFlashData('msg_type', 'danger');
                redirect('?module=cart&action=formcart');
            }
        } else {
            setFlashData("msg", 'Có lỗi xảy ra vui lòng kiểm tra dữ liệu nhập vào');
            setFlashData('msg_type', 'danger');
            setFlashData('error', $errors);
            redirect('?module=cart&action=formcart');
        }
    }
}

$msg = getFlashData("msg");
$msg_type = getFlashData("msg_type");
$error = getFlashData('error');
?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>
        <form action="" method="POST" style="text-align: left;">
            <div class="my-5">
                <?php getMsg($msg, $msg_type) ?>
                <div class="box_title"><b>Thông tin đặt hàng</b></div>
                <div style="padding: 5px 2px;">
                    <hr>
                    <input type="text" class="form-control" placeholder="Người đặt hàng..." name="name"
                        value="<?php echo !empty($clientInfo['fullname']) ? $clientInfo['fullname'] : '' ?>">
                    <p class="error"><?php echo errorData('name', $error) ?></p>
                    <input type="text" class="form-control" placeholder="Email..." name="email"
                        value="<?php echo !empty($clientInfo['email']) ? $clientInfo['email'] : '' ?>">
                    <p class="error"><?php echo errorData('email', $error) ?></p>
                    <input type="text" class="form-control" placeholder="Địa chỉ...." name="address"
                        value="<?php echo !empty($clientInfo['address']) ? $clientInfo['address'] : '' ?>">
                    <p class="error"><?php echo errorData('address', $error) ?></p>
                    <input type="text" class="form-control" placeholder="Số điện thoại..." name="phone"
                        value="<?php echo !empty($clientInfo['phone']) ? $clientInfo['phone'] : '' ?>">
                    <p class="error"><?php echo errorData('phone', $error) ?></p>
                </div>
            </div>

            <div class="my-5">
                <div class="box_title"><b>Phương thức thanh toán</b></div>
                <div style="padding: 5px 2px;">
                    <hr>
                    <input type="radio" value="0" name="pay" checked="checked"> Thanh toán khi nhận hàng
                    <input type="radio" value="1" name="pay" style="margin-left: 150px;"> Thanh toán online
                </div>
            </div>
            <div class="my-5">
                <div class="box_title" id="tablecart"><b>Thông tin giỏ hàng</b></div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th width="10%">Ảnh</th>
                            <th>tên sản phẩm</th>
                            <th>giá sản phẩm</th>
                            <th>số lượng</th>
                            <th>thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($listAllCart)) :
                            $count = 0;
                            $total = 0;
                            foreach ($listAllCart as $item) :
                                $count++;
                                $total += $item['price'] * $item['quantity'];
                                $totalPrice = $item['price'] * $item['quantity'];
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><img src="<?php echo _WEB_HOST_ROOT . '/uploads/' . $item['images']; ?>" width="100%">
                            </td>
                            <td><?php echo $item['name'] ?></td>
                            <td><?php echo $item['price'] ?></td>
                            <td class="text-center">
                                <?php echo '<button class="px-3 btn btn-success btn-sm" type="button" >' . $item['quantity'] . '</button>' ?>
                            </td>
                            <td><?php echo $totalPrice ?></td>
                        </tr>
                        <?php endforeach;
                        endif;  ?>
                    </tbody>
                </table>
                <p>Tổng tiền: <b><?php echo !empty($total) ? $total : '0' ?> VNĐ</b></p>
                <input type="hidden" name="total" value="<?php echo !empty($total) ? $total : '0' ?>">
                <a href="#"><button class="btn btn-primary btn-sm" name="agree" value="1">Đồng ý đặt hàng</button></a>
            </div>
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';