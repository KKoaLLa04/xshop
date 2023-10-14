<?php

// Truy van lay tat ca du lieu cua bang type
$listAllCategory = getRaw("SELECT * FROM type ORDER BY id DESC");

// Truy van san pham ban chay 
$listSaleProducts = getRaw("SELECT * FROM products ORDER BY view DESC LIMIt 0,10");


?>
<div class="boxright">

    <?php require_once _WEB_PATH_ROOT . '/client/login/login.php' ?>
    <div class="mb">
        <div class="box_title">DANH MỤC</div>
        <div class="box_content2 product_portfolio">
            <ul>
                <?php if (!empty($listAllCategory)) :
                    foreach ($listAllCategory as $item) : ?>
                <li><a href=""><?php echo $item['name'] ?></a></li>
                <?php endforeach;
                endif; ?>
            </ul>
        </div>
        <div class="box_search">
            <form action="?module=products&action=lists" method="POST"
                style="display: flex; justify-content: space-between;">
                <input type="text" name="keyword" id="" placeholder="Tên sản phẩm tìm kiếm" class="form-control">
                <button type="submit" name="keywordButton" value="1"><i
                        class="fa-solid fa-magnifying-glass"></i></button>

            </form>
        </div>
    </div>
    <!-- DANH MỤC SẢN PHẨM BÁN CHẠY -->
    <div class="mb">
        <div class="box_title">SẢN PHẨM BÁN CHẠY</div>
        <div class="box_content">
            <?php if (!empty($listSaleProducts)) :
                foreach ($listSaleProducts as $item) : ?>
            <div class="selling_products" style="width:100%;">
                <img src="<?php echo _WEB_HOST_ROOT . '/uploads/' . $item['image'] ?>" alt="anh" width="150px"
                    height="50px">
                <a href="?module=products&action=detail&id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a>
            </div>
            <?php endforeach;
            endif ?>
        </div>
    </div>
</div>