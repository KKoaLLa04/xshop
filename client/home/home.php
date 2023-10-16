<?php

$data = [
    'page_title' => 'Trang chủ - XSHOP'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

// truy van lay tất cả dữ liệu trong bảng products
$listAllProducts = productLimit();
?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>
        <div class="items my-5">
            <?php if (!empty($listAllProducts)) :
                foreach ($listAllProducts as $item) : ?>
                    <div class="box_items">
                        <div class="box_items_img">
                            <img src="<?php echo 'uploads/' . $item['image'] ?> ">
                            <div class="add"><a href="?module=cart&action=add&product_id=<?php echo $item['id'] ?>">ADD
                                    TO CART</a>
                            </div>
                        </div>
                        <a class="item_name" href="?module=products&action=detail&id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a>
                        <p class="price">$<?php echo $item['price'] ?></p>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';
