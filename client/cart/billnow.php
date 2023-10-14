<?php
require_once _WEB_PATH_TEMPLATE . '/client/header.php';

// Truy vấn cơ sở dữ liệu bảng cart va nguoi dung
if (isLogin()) {
    $clientId = isLogin()['client_id'];
    $clientInfor = firstRaw("SELECT * FROM client WHERE id=$clientId");
    // Truy vấn cơ sở dữ liệu bảng bill
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 1;
    }
    $productDetail = firstRaw("SELECT * FROM products WHERE id=$id");
    $code = time();
    $dataInsert = [
        'name' => $clientInfor['fullname'],
        'email' => $clientInfor['email'],
        'phone' => $clientInfor['phone'],
        'address' => $clientInfor['address'],
        'pay' => 0,
        'total' => $productDetail['price'],
        'status' => 0,
        'client_id' => $clientId,
        'code' => $code,
        'create_at' => date('Y/m/d H:i:s'),
    ];

    $insertStatus = insert('bill', $dataInsert);
    if (!empty($insertStatus)) {
        setFlashData("msg", 'Chúc mừng bạn đã đặt hàng thành công!');
        setFlashData("msg_type", 'success');
    } else {
        setFlashData("msg", 'Có lỗi xảy ra, hãy thử lại sau!');
        setFlashData("msg_type", 'danger');
    }
    redirect('index.php');
} else {
    setFlashData("msg", 'Vui lòng đăng nhập để thực hiện chức năng');
    setFlashData("msg_type", 'danger');
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
                <div class="box_title"><b>Cảm ơn</b></div>
                <br>
                <div style="padding: 5px 2px;" class="alert alert-success">
                    <p class="text-center">Cảm ơn bạn đã đặt hàng!</p>
                </div>
            </div>

            <div class="my-5">
                <div class="box_title"><b>Thông tin đơn hàng</b></div>
                <div style="padding: 5px 2px;">
                    <ul>
                        <li>Mã Đơn hàng: CART-<?php echo $listBillDetail['code'] ?><?php ?></li>
                        <li>Ngày đặt hàng: <?php echo $listBillDetail['create_at'] ?></li>
                        <li>Họ Tên: <?php echo $listBillDetail['name'] ?></li>
                        <li>Email: <?php echo $listBillDetail['email'] ?></li>
                        <li>Số điện thoại: <?php echo $listBillDetail['phone'] ?></li>
                        <li>Địa chỉ: <?php echo $listBillDetail['address'] ?></li>
                        <li>Tổng tiền thanh toán: <?php echo $listBillDetail['total'] ?> VNĐ</li>
                        <li>Phương thức thanh toán:
                            <?php echo ($listBillDetail['pay'] == 0) ? 'Thanh toán khi nhận hàng' : 'Thanh toán online' ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="my-5">
                <div class="box_title" id="tablecart"><b>Thông tin người nhận</b></div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>tên khách hàng</th>
                            <th>email</th>
                            <th>Địa chỉ</th>
                            <th>số điện thoại</th>
                            <th>Tổng hóa đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($listBillDetail)) :
                        ?>
                        <tr>
                            <td>1</td>
                            <td>CART - <?php echo $listBillDetail['code'] ?></td>
                            <td><?php echo $listBillDetail['name'] ?></td>
                            <td><?php echo $listBillDetail['email'] ?></td>
                            <td><?php echo $listBillDetail['address'] ?></td>
                            <td><?php echo $listBillDetail['phone'] ?></td>
                            <td><?php echo $listBillDetail['total'] ?></td>
                        </tr>
                        <?php endif;  ?>
                    </tbody>
                </table>
                <p>Tổng tiền: <b><?php echo !empty($total) ? $total : '0' ?> VNĐ</b></p>
                <input type="hidden" name="total" value="<?php echo !empty($total) ? $total : '0' ?>">
                <button class="btn btn-success btn-sm" name="agree" value="1"><a href="index.php"
                        style="text-decoration: none; color: white;">Quay lại trang
                        chủ</a></button>
            </div>
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';