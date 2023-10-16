<?php
require_once _WEB_PATH_TEMPLATE . '/client/header.php';

// Truy vấn cơ sở dữ liệu bảng cart va nguoi dung
if (isLogin()) {
    $clientId = isLogin()['client_id'];
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 1;
    }
    if (!empty($clientId)) {
        // $listAllCart = getRaw("SELECT * FROM cart WHERE client_id=$clientId AND status=0 ORDER BY id DESC");
        $productDetail = cartFirstDetail($id);
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
        } else {
            setFlashData("msg", 'Có lỗi xảy ra vui lòng kiểm tra dữ liệu nhập vào');
            setFlashData('msg_type', 'danger');
            setFlashData('error', $errors);
            redirect('?module=cart&action=formcart');
        }
    }
} else {
    setFlashData('msg', 'Vui lòng đăng nhập để đặt mua hàng');
    setFlashData('msg_type', 'danger');
    redirect('index.php');
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
                    <input type="text" class="form-control" placeholder="Người đặt hàng..." name="name" value="<?php echo !empty($clientInfo['fullname']) ? $clientInfo['fullname'] : '' ?>">
                    <p class="error"><?php echo errorData('name', $error) ?></p>
                    <input type="text" class="form-control" placeholder="Email..." name="email" value="<?php echo !empty($clientInfo['email']) ? $clientInfo['email'] : '' ?>">
                    <p class="error"><?php echo errorData('email', $error) ?></p>
                    <input type="text" class="form-control" placeholder="Địa chỉ...." name="address" value="<?php echo !empty($clientInfo['address']) ? $clientInfo['address'] : '' ?>">
                    <p class="error"><?php echo errorData('address', $error) ?></p>
                    <input type="text" class="form-control" placeholder="Số điện thoại..." name="phone" value="<?php echo !empty($clientInfo['phone']) ? $clientInfo['phone'] : '' ?>">
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
                <div class="box_title" id="tablecart"><b>Thông tin mặt hàng</b></div>

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
                        <?php if (!empty($productDetail)) :
                            $count = 1;
                        ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><img src="<?php echo _WEB_HOST_ROOT . '/uploads/' . $productDetail['image']; ?>" width="100%">
                                </td>
                                <td><?php echo $productDetail['name'] ?></td>
                                <td><?php echo $productDetail['price'] ?></td>
                                <td class="text-center">
                                    <!-- <a href="?module=cart&action=minus&id=<?php echo $productDetail['id'] ?>">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-minus"></i></button>
                                </a> -->
                                    <?php echo '<button class="px-3 btn btn-success btn-sm">1</button>' ?>

                                    <!-- <a href="?module=cart&action=plus&id=<?php echo $productDetail['id'] ?>">
                                    <button class="btn btn-primary btn-sm plus-<?php echo $count; ?>"><i
                                            class="fa fa-plus"></i></button>
                                </a> -->
                                </td>
                                <td><?php echo $productDetail['price'] ?></td>
                            </tr>
                        <?php
                        endif;  ?>
                    </tbody>
                </table>
                <p>Tổng tiền: <b><?php echo !empty($productDetail['price']) ? $productDetail['price'] : '0' ?> VNĐ</b>
                </p>
                <!-- <input type="hidden" name="total" value="<?php echo !empty($total) ? $total : '0' ?>"> -->
                <button class="btn btn-primary btn-sm" name="agree" value="1"><a href="?module=cart&action=billnow&id=<?php echo $productDetail['id'] ?>" style="color: white; text-decoration: none;">Đồng ý đặt
                        hàng</a></button>
            </div>
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';
