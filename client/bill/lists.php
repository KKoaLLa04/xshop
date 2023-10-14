<?php
$data = [
    'page_title' => 'XSHOP - Đơn hàng'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

if (isLogin()) {
    $clientId = isLogin()['client_id'];
    if (!empty($clientId)) {
        $listAllCart = getRaw("SELECT * FROM cart WHERE client_id=$clientId AND status=1 ORDER BY id DESC");
    }
}

if (isLogin()) {
    $clientId = isLogin()['client_id'];
    $listAllBill = getRaw("SELECT * FROM bill WHERE client_id=$clientId ORDER BY id DESC");
}
?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>
        <h4 class="my-3">Thông tin các đơn hàng bạn đã đặt:</h4>
        <p><b>Tình trạng:</b> đơn hàng mới -> xử lý -> giao -> đã giao</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Tên</th>
                    <th>Địa chỉ</th>
                    <th>email</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                    <th>Tình trạng</th>
                    <th>Xem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listAllBill)) :
                    $count = 0;
                    foreach ($listAllBill as $item) :
                        $count++;
                        $dateObj = date_create($item['create_at']);
                        $dateFormat = date_format($dateObj, 'd/m/Y');
                ?>

                <tr>
                    <td><?php echo $count ?></td>
                    <td>CART - <?php echo $item['code'] ?></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['address'] ?></td>
                    <td><?php echo $item['email'] ?></td>
                    <td><?php echo $item['total'] ?></td>
                    <td><?php echo $dateFormat ?></td>
                    <td><?php if ((!$item['status'] && $item['status'] == 0)) {
                                    echo '<button class="btn btn-danger btn-sm">Đơn hàng mới</button>';
                                } elseif ($item['status'] == 1) {
                                    echo '<button class="btn btn-warning btn-sm">Đang xử lý</button>';
                                } elseif ($item['status'] == 2) {
                                    echo  '<button class="btn btn-primary btn-sm">Đang giao</button>';
                                } elseif ($item['status'] == 3) {
                                    echo  '<button class="btn btn-success btn-sm">Đã giao</button>';
                                }   ?>
                    </td>
                    <td><a href="?module=bill&action=detail&code=<?php echo $item['code'] ?>"
                            class="btn btn-primary btn-sm">Chi Tiết</a></td>
                </tr>
                <?php endforeach;
                endif ?>
            </tbody>
        </table>

        <h4 class="my-4">Chi Tiết sản phẩm bạn đã đặt</h4>
        <?php if (!empty($listAllCart)) : ?>
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
                    <td><img src="<?php echo _WEB_HOST_ROOT . '/uploads/' . $item['images']; ?>" width="100%"></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['price'] ?></td>
                    <td class="text-center">
                        <?php echo '<button class="px-3 btn btn-success btn-sm">' . $item['quantity'] . '</button>' ?>
                    </td>
                    <td><?php echo $totalPrice ?></td>
                </tr>
                <?php endforeach;
                    endif;  ?>
            </tbody>
        </table>
        <p>Tổng tiền: <b><?php echo !empty($total) ? $total : false ?> VNĐ</b></p>
        <?php else : ?>
        <div class="alert alert-warning">
            <p class="text-center">Giỏ hàng của bạn hiện không có sản phẩm nào được thêm vào!</p>
        </div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-success btn-sm">Quay lại trang chủ</a>
    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';