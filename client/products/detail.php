<?php
$data = [
    'page_title' => 'XSHOP - Chi tiết sản phẩm'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

// Lay dữ liệu sản phẩm
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $productDetail = productClientDetail($id);

    // update view
    $view = $productDetail['view'];
    $view++;
    $dataUpdate = [
        'view' => $view,
    ];
    $condition = 'id=' . $id;
    update('products', $dataUpdate, $condition);

    // lấy dữ liệu comments
    $listAllComments = productCommentDetail($id);

    // Lấy dữ liệu sản phẩm cùng loại
    if (!empty($productDetail['type_id'])) {
        $typeId = $productDetail['type_id'];
        if (!empty($typeId)) {
            $listAllProducts = clientProductLimit($typeId, $id);
        }
    }

    // Lay du lieu nguoi dung
    if (isLogin()) {
        $clientDetail = getSession('client_login');

        if (!empty($_POST['sendComment'])) {

            $body = getBody();

            $errors = [];
            if (empty(trim($body['content']))) {
                $errors['content'] = 'Nội dung bình luận bắt buộc phải nhập';
            }

            if (empty($errors)) {
                // Xu ly insert vao comment
                $dataInsert = [
                    'content' => trim($body['content']),
                    'product_id' => $id,
                    'client_id' => $clientDetail['id'],
                    'create_at' => date('Y/m/d H:i:s')
                ];

                $insertStatus = insert('comments', $dataInsert);
                if (!empty($insertStatus)) {
                    setFlashData('msg', 'Bạn đã gửi bình luận thành công');
                    setFlashData('msg_type', 'success');
                } else {
                    setFlashData('msg', 'Lỗi Hệ thống, bạn không thể gửi bình luạn vào lúc này!');
                    setFlashData('msg_type', 'danger');
                }
                redirect('?module=products&action=detail&id=' . $id . '#comments');
            } else {
                setFlashData('error', $errors);
                redirect('?module=products&action=detail&id=' . $id . '#comments');
            }
        }
    }

    if (empty($productDetail)) {
        redirect('index.php');
    }
} else {
    redirect('index.php');
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('error');
?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>
        <h4 class="my-5">Sản phẩm: <b><?php echo $productDetail['name'] ?></b> </h4>


        <div class="  mb">
            <?php getMsg($msg, $msg_type) ?>
            <div class="box_title">CHI TIẾT SẢN PHẨM</div>
            <div class="row">
                <div class="col-6">
                    <img src="<?php echo _WEB_HOST_ROOT . '/uploads/' . $productDetail['image'] ?>" width="100%" height="100%">
                </div>
                <div class="col-6">
                    <h4><?php echo $productDetail['name'] ?></h4>
                    <p><b>Giá: <span class="span-price">$<?php echo $productDetail['price'] ?></span></b></p>
                    <p><?php echo $productDetail['description'] ?></p>
                    <p>Lượt xem: <?php echo $productDetail['view'] ?></p>
                    <p>Loại: <b><?php echo $productDetail['type_name'] ?></b></p>
                    <a href="?module=cart&action=buynow&id=<?php echo $productDetail['id'] ?>"><button class="btn btn-primary">Đặt Mua</button></a>
                    <a href="?module=cart&action=add&id=<?php echo $productDetail['id'] ?>"><button class="btn btn-success">Thêm vào giỏ hàng <i class="fa fa-shopping-cart"></i></button></a>
                </div>
            </div>
        </div>

        <div class="mb" id="comments">
            <div class="box_title">BÌNH LUẬN</div>
            <div class="box_content2  product_portfolio binhluan ">
                <?php if (!empty($listAllComments)) :
                    foreach ($listAllComments as $item) :
                        $dateObj = date_create($item['create_at']);
                        $dateFormat = date_format($dateObj, 'd/m/Y H:i:s')
                ?>
                        <div class="comment-list" style="display: flex; justify-content: space-between;">
                            <p><b><?php echo $item['fullname'] ?></b>: <?php echo $item['content'] ?> </p>
                            <p class="error" style="text-align: left;"><?php echo errorData('content', $error) ?></p>
                        </div>
                    <?php endforeach;
                else :
                    ?>
                    <div class="comment-list alert alert-warning">
                        <p class="text-center">Hiện chưa có bình luận nào tại sản phẩm này, hãy là người bình luận đầu tiên
                        </p>
                    </div>
                <?php
                endif ?>
            </div>
            <div class="box_search">
                <br>
                <?php echo getMsg($msg, $msg_type) ?>
                <form action="" method="POST">
                    <!-- <input type="hidden" name="idpro" value=""> -->
                    <?php if (isLogin()) : ?>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" name="content" class="form-control" placeholder="Viết bình luận của bạn...">
                                <p class="error"><?php echo oldData('content', $error) ?></p>
                            </div>
                            <div class="col-2">
                                <!-- <input type="submit" name="guibinhluan" value="Gửi bình luận" class="form-control"> -->
                                <button type="submit" name="sendComment" value="1" class="form-control">Gửi bình
                                    luận</button>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" name="content" class="form-control" placeholder="Viết bình luận của bạn (Đăng nhập để bình luận)..." disabled>
                            </div>
                            <div class="col-2">
                                <input type="submit" name="guibinhluan" value="Gửi bình luận" class="form-control" disabled>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>

        </div>

        <div class=" mb">
            <div class="box_title">SẢN PHẨM CÙNG LOẠI</div>
            <div class="box_content">
                <div class="row">
                    <?php if (!empty($listAllProducts)) :
                        foreach ($listAllProducts as $item) : ?>
                            <div class="col-3">
                                <a href="?module=products&action=detail&id=<?php echo $item['id'] ?>"><img src="<?php echo _WEB_HOST_ROOT . '/uploads/' . $item['image'] ?>" alt="" width="100%" height="100%"></a>
                                <p class="text-center"><a href="?module=products&action=detail&id=<?php echo $item['id'] ?>" style="color: black; text-decoration: none;"><b><?php echo $item['name'] ?></b></a>
                                </p>
                            </div>
                    <?php endforeach;
                    endif ?>
                </div>
                <p class="my-4"></p>
            </div>
        </div>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';
