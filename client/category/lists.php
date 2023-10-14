<?php
$data = [
    'page_title' => 'XSHOP - Danh mục'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

// truy van lay tất cả dữ liệu trong bảng type
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $firstCategory = firstRaw("SELECT * FROM type WHERE id = $id ORDER BY id DESC");
    if (!empty($firstCategory)) {
        // Truy van lay tat ca san pham cua danh muc 
        $listAllProductCate = getRaw("SELECT * FROM products WHERE type_id=$id");
    } else {
        redirect('index.php');
    }
} else {
    redirect('index.php');
}

?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>
        <h4 class="my-5">Danh mục: <?php echo $firstCategory['name'] ?></h4>
        <div class="items my-5">
            <?php if (!empty($listAllProductCate)) :
                foreach ($listAllProductCate as $item) :
            ?>
            <div class="box_items">
                <div class="box_items_img">
                    <img src="<?php echo 'uploads/' . $item['image'] ?> ">
                    <div class="add" href="">ADD TO CART</div>
                </div>
                <a class="item_name"
                    href="?module=products&action=detail&id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a>
                <p class="price">$<?php echo $item['price'] ?></p>
            </div>
            <?php endforeach;
            else :
                ?>
            <div class="alert alert-danger" style="grid-column: 1 / 3 span;">
                <p class="text-center">Hiện không có sản phẩm nào của danh mục <?php echo $firstCategory['name'] ?></p>
            </div>
            <?php
            endif ?>
        </div>
    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';