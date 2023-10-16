<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

// Lấy dữ liệu
$listAllCate = allChart();

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>THỐNG KÊ SẢN PHẨM THEO LOẠI</h1>
    </div>
    <div class="row2 form_content ">
        <hr>
        <?php echo getMsg($msg, $msg_type) ?>
        <hr>
        <table class="table table-bordered my-4">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên loại hàng</th>
                    <th>Số lượng</th>
                    <th>Giá cao nhất</th>
                    <th>Giá thấp nhất</th>
                    <th>Giá trung bình</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listAllCate)) :
                    $count = 0;
                    foreach ($listAllCate as $item) :
                        $count++;
                ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $item['name'] ?></td>
                            <td><?php echo $item['count_id'] ?></td>
                            <td><?php echo $item['max_price'] ?></td>
                            <td><?php echo $item['min_price'] ?></td>
                            <td><?php echo $item['avg_price'] ?></td>
                        </tr>
                <?php endforeach;
                endif ?>
            </tbody>
        </table>
        <a href="?module=statistic&action=chart"><button class="btn btn-primary">Biểu đồ</button></a>
    </div>
</div>
<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/footer.php';
