<?php
$data = [
    'page_title' => 'XSHOP - Đơn hàng chi tiết'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

// Truy vấn cơ sở dữ liệu bảng cart va nguoi dung
if (!empty($_GET['code'])) {
    $codeId = $_GET['code'];
    if (!empty($codeId)) {
        $listAllCartDetail = getRaw("SELECT * FROM cart WHERE code_id=$codeId");
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
            </div>

            <div class="my-5">
                <div class="box_title" id="tablecart"><b>Thông chi tiết sản phẩm</b></div>

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
                        <?php if (!empty($listAllCartDetail)) :
                            $count = 0;
                            $total = 0;
                            foreach ($listAllCartDetail as $item) :
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
                <a href="?module=bill&action=lists" class="btn btn-success btn-sm">Quay lại</a>
            </div>
        </form>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';