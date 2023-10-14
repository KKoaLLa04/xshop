<?php
$data = [
    'page_title' => 'XSHOP - bình luận'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);
// truy van lay tất cả dữ liệu trong bảng comment
$listAllComments = getRaw("SELECT comments.*,fullname,name, products.id as product_detail FROM comments INNER JOIN client ON client.id=comments.client_id INNER JOIN products ON products.id=comments.product_id ORDER BY comments.id DESC");

// Truy van lay tat ca du lieu của người dùng
if (isLogin()) {
    $clientId = getSession('client_login')['id'];

    if (!empty($clientId)) {
        $listClientComments = getRaw("SELECT comments.*,fullname,name, products.id as product_detail FROM comments INNER JOIN client ON client.id=comments.client_id INNER JOIN products ON products.id=comments.product_id WHERE client_id=$clientId ORDER BY comments.id DESC");
    }
}
?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>

        <?php if (isLogin()) {
        ?>
        <br>
        <h4>Danh sách bình luận của bạn:</h4>
        <ul>
            <?php if (!empty($listClientComments)) :
                    foreach ($listClientComments as $comment) :
                        $dateObj = date_create($comment['create_at']);
                        $dateFormat = date_format($dateObj, 'd/m/Y');
                ?>
            <li>
                <div class="row">
                    <div class="col-9">
                        <p><b><?php echo $comment['fullname'] ?></b>: <?php echo $comment['content'] ?> </p>
                    </div>

                    <div class="col-3">
                        <p><a href="?module=products&action=detail&id=<?php echo $comment['product_detail'] ?>"
                                style="text-decoration: none;"><?php echo $comment['name'] ?></a> -
                            <?php echo $dateFormat ?></p>
                    </div>
                </div>
            </li>
            <?php endforeach;
                endif; ?>
        </ul>
        <hr>
        <?php
        } ?>
        <h4 class="my-5">Danh sách bình luận của tất cả sản phẩm:</h4>
        <ul>
            <?php if (!empty($listAllComments)) :
                foreach ($listAllComments as $comment) :
                    $dateObj = date_create($comment['create_at']);
                    $dateFormat = date_format($dateObj, 'd/m/Y');
            ?>
            <li>
                <div class="row">
                    <div class="col-9">
                        <p><b><?php echo $comment['fullname'] ?></b>: <?php echo $comment['content'] ?> </p>
                    </div>

                    <div class="col-3">
                        <p><a href="?module=products&action=detail&id=<?php echo $comment['product_detail'] ?>"
                                style="text-decoration: none;"><?php echo $comment['name'] ?></a> -
                            <?php echo $dateFormat ?></p>
                    </div>
                </div>
            </li>
            <?php endforeach;
            endif; ?>
        </ul>


    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';