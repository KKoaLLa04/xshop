<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

// Xử lý lọc dữ liệu
if (isGet()) {
    $body = getBody();

    $filter = '';
    $operator = '';
    if (!empty($body['keyword'])) {
        $keyword = $body['keyword'];

        if (strpos($filter, 'WHERE') !== false) {
            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }

        $filter .= "$operator name LIKE '%$keyword%' OR email LIKE '%$keyword%'";
    }
}

// Thuật toán phân trang
// 1.Số lượng bản ghi / 1 trang
$perPage = _PER_PAGE;
// 2.Lấy toàn bộ bản ghi trong db
$countBill = getRows("SELECT id FROM bill $filter");
// 3.Tính số lượng trang lớn nhất
$maxPage = ceil($countBill / $perPage);
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
 *                     = (3-1)*2 = 4
 */
$offset = ($page - 1) * $perPage;

// Truy van co so du lieu bill
$listAllBill = getRaw("SELECT * FROM bill $filter ORDER BY client_id DESC LIMIT $offset, $perPage");

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>DANH SÁCH ĐƠN HÀNG</h1>
    </div>
    <div class="row2 form_content ">
        <hr>
        <?php echo getMsg($msg, $msg_type) ?>
        <form action="" method="get">
            <div class="row">
                <div class="col-9">
                    <input type="search" class="form-control" placeholder="Từ khóa tìm kiếm" name="keyword"
                        value="<?php echo !empty($keyword) ? $keyword : false ?>">
                </div>

                <div class="col-3">
                    <input type="hidden" name="module" value="bill">
                    <button type="submit" class="btn btn-primary form-control">Tìm kiếm</button>
                </div>
            </div>
        </form>
        <hr>
        <table class="table table-bordered my-4">
            <thead>
                <tr>
                    <th width="9%">Mã Đơn Hàng</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>phone</th>
                    <th>PTTT</th>
                    <th>Tổng</th>
                    <th width="10%">Trạng thái</th>
                    <th width="10%">Ngày Đặt</th>
                    <th width="3%">Sửa</th>
                    <th width="3%">Xóa</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($listAllBill)) :
                    foreach ($listAllBill as $item) :
                        $dateObj = date_create($item['create_at']);
                        $dateFormat = date_format($dateObj, 'd/m/Y');
                ?>
                <tr>
                    <td><?php echo $item['code'] ?></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['email'] ?></td>
                    <td><?php echo $item['address'] ?></td>
                    <td><?php echo $item['phone'] ?></td>
                    <td><?php echo (isset($item['pay']) && $item['pay'] == 0) ? 'Thanh toán khi nhận' : 'Thanh toán online' ?>
                    </td>
                    <td><?php echo $item['total'] ?></td>
                    <td><?php if ((!$item['status'] && $item['status'] == 0)) {
                                    echo '<a href="?module=bill&action=status&status=0&code=' . $item['code'] . '"><button class="btn btn-danger btn-sm">Đơn hàng mới</button></a>';
                                } elseif ($item['status'] == 1) {
                                    echo '<a href="?module=bill&action=status&status=1&code=' . $item['code'] . '"><button class="btn btn-warning btn-sm">Đang xử lý</button></a>';
                                } elseif ($item['status'] == 2) {
                                    echo  '<a href="?module=bill&action=status&status=2&code=' . $item['code'] . '"><button class="btn btn-primary btn-sm">Đang giao</button></a>';
                                } elseif ($item['status'] == 3) {
                                    echo  '<a href="?module=bill&action=status&status=3&code=' . $item['code'] . '"><button class="btn btn-success btn-sm">Đã giao</button></a>';
                                }   ?>
                    </td>
                    <td><?php echo $dateFormat ?></td>
                    <td><a href="?module=bill&action=update&id=<?php echo $item['id'] ?>"><button
                                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a>
                    <td><a href="#"><button class="btn btn-danger btn-sm" disabled> <i
                                    class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example" class="d-flex justify-content-end btn-sm">
            <ul class="pagination">
                <?php if ($page > 1) :
                    $prev = $page - 1;
                ?>
                <li class="page-item"><a class="page-link" href="?module=bill&page=<?php echo $prev ?>">Trước</a>
                </li>
                <?php endif; ?>
                <?php
                for ($i = 1; $i <= $maxPage; $i++) :
                ?>
                <li class="page-item"><a class="page-link"
                        href="?module=bill&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if ($page < $maxPage) :
                    $next = $page + 1;
                ?>
                <li class="page-item"><a class="page-link" href="?module=bill&page=<?php echo $next ?>">Sau</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/footer.php';