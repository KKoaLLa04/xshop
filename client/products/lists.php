<?php
$data = [
    'page_title' => 'XSHOP - sản phẩm'
];
// require_once _WEB_PATH_TEMPLATE . '/client/header.php';
loadLayoutClient('header.php', $data);

// Lọc dữ liệu
$filter = '';
if (!empty($_POST['keywordButton'])) {
    $keyword = getBody()['keyword'];
    $operator = 'WHERE';
    // if (strpos($operator, 'WHERE') !== false) {
    //     $operator = ' WHERE ';
    // } else {
    //     $operator = ' AND ';
    // }
    $filter = "$operator name LIKE '%$keyword%'";
}

// Thuật toán phân trang
// 1.Số lượng bản ghi / 1 trang
$perPage = _PER_PAGE;
// 2.Lấy toàn bộ bản ghi trong db
$countType = getRows("SELECT id FROM products $filter");
// 3.Tính số lượng trang lớn nhất
$maxPage = ceil($countType / $perPage);
// 4.Điều kiện
$page = 1;
if (!empty($_GET['page'])) {
    $page = $_GET['page'];
    if ($page <= 0 || $page > $maxPage) {
        $page = 1;
    }
} else {
    $page = 1;
}

// 5.Tinh offset
/**
 * ($page-1)*$perPage = (1-1)*2 = 0
 *                    =(2-1)*2 = 2
 * = (3-1)*2 = 4
 */
$offset = ($page - 1) * $perPage;

$listAllProduct = clientAllProduct($filter, $offset, $perPage);
?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>
        <h4 class="my-5">Toàn bộ sản phẩm: </h4>
        <div class="items my-5">
            <?php if (!empty($listAllProduct)) :
                foreach ($listAllProduct as $item) :
            ?>
            <div class="box_items">
                <div class="box_items_img">
                    <img src="<?php echo 'uploads/' . $item['image'] ?> ">
                    <div class="add" href=""><a href="?module=cart&action=add&product_id=<?php echo $item['id'] ?>">ADD
                            TO CART</a></div>
                </div>
                <a class="item_name"
                    href="?module=products&action=detail&id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a>
                <p class="price">$<?php echo $item['price'] ?></p>
            </div>
            <?php endforeach;
            else :
                ?>
            <div class="alert alert-danger" style="grid-column: 1 / 3 span;">
                <p class="text-center">Hiện không có sản phẩm nào</p>
            </div>
            <?php
            endif ?>

            <nav aria-label="Page navigation example" class="d-flex justify-content-end btn-sm"
                style="grid-column: 1 / 3 span;">
                <?php
                $start = $page - 2;
                $end = $page + 2;
                if ($start <= 1) {
                    $start = 1;
                }

                if ($end >= $maxPage) {
                    $end = $maxPage;
                }
                if ($maxPage > 1) :
                ?>
                <ul class="pagination">
                    <?php if ($page > 1) :
                            $prev = $page - 1;
                        ?>
                    <li class="page-item"><a class="page-link"
                            href="?module=products&action=lists&page=<?php echo $prev ?>">Trước</a>
                    </li>
                    <?php endif; ?>
                    <?php
                        for ($i = $start; $i <= $end; $i++) :
                        ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : false ?>"><a class="page-link"
                            href="?module=products&action=lists&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php endfor; ?>
                    <?php if ($page < $maxPage) :
                            $next = $page + 1;
                        ?>
                    <li class="page-item"><a class="page-link"
                            href="?module=products&action=lists&page=<?php echo $next ?>">Sau</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>
            </nav>
        </div>
    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';