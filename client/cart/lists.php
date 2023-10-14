<?php
$data = [
    'page_title' => 'XSHOP - Giỏ hàng'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

// Truy vấn cơ sở dữ liệu bảng cart
if (isLogin()) {
    $clientId = isLogin()['client_id'];
    if (!empty($clientId)) {
        $listAllCart = getRaw("SELECT * FROM cart WHERE client_id=$clientId AND status=0 ORDER BY id DESC");
    }
}
$msg = getFlashData("msg");
$msg_type = getFlashData("msg_type");
?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>
        <div class="my-5">
            <?php
            getMsg($msg, $msg_type);
            ?>
            <div class="box_title" id="tablecart"><b>GIỎ HÀNG CỦA BẠN</b></div>
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
                        <th>Xóa</th>
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
                            <a href="?module=cart&action=minus&id=<?php echo $item['id'] ?>">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-minus"></i></button>
                            </a>
                            <?php echo '<button class="px-3 btn btn-success btn-sm">' . $item['quantity'] . '</button>' ?>

                            <a href="?module=cart&action=plus&id=<?php echo $item['id'] ?>">
                                <button class="btn btn-primary btn-sm plus-<?php echo $count; ?>"><i
                                        class="fa fa-plus"></i></button>
                            </a>
                        </td>
                        <td><?php echo $totalPrice ?></td>
                        <td width="5%"><a href="?module=cart&action=delete&id=<?php echo $item['id'] ?>"><button
                                    class="btn btn-danger btn-sm">Xóa</button></a></td>
                    </tr>
                    <?php endforeach;
                        endif;  ?>
                </tbody>
            </table>
            <p>Tổng tiền: <b><?php echo !empty($total) ? $total : false ?> VNĐ</b></p>
            <a href="?module=cart&action=formcart"><button class="btn btn-primary btn-sm">Tiếp tục đặt hàng</button></a>
            <?php else : ?>
            <div class="alert alert-warning">
                <p class="text-center">Giỏ hàng của bạn hiện không có sản phẩm nào được thêm vào!</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';