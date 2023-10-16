<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

// check dang nhap, lay thong tin admin
if (isLogin()) {
    $clientId = isLogin()['client_id'];
    $clientDetail = getClientinfor($clientId);
} else {
    setFlashData("msg", 'Bạn không có quyền truy cập!');
    setFlashData("msg_type", 'danger');
    redirect('index.php');
}
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

        $filter .= "$operator fullname LIKE '%$keyword%' OR email LIKE '%$keyword%'";
    }
}

// Thuật toán phân trang
// 1.Số lượng bản ghi / 1 trang
$perPage = _PER_PAGE;
// 2.Lấy toàn bộ bản ghi trong db
$countClient = countClient($filter);
// 3.Tính số lượng trang lớn nhất
$maxPage = ceil($countClient / $perPage);
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

// Truy van co so du lieu clients
$listAllClients = allAdmin($offset, $perPage);

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>DANH SÁCH QUẢN TRỊ VIÊN</h1>
    </div>
    <div class="row2 form_content ">
        <hr>
        <?php echo getMsg($msg, $msg_type) ?>
        <hr>
        <table class="table table-bordered my-4">
            <thead>
                <tr>
                    <th width="4%">ID</th>
                    <th>Tên QTV</th>
                    <th>Email</th>
                    <th>Ngày tạo</th>
                    <th>Quyền</th>
                    <th width="10%">Trạng thái</th>
                    <th width="7%">Sửa</th>
                    <th width="7%">Xóa</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($listAllClients)) :
                    foreach ($listAllClients as $item) : ?>
                        <tr>
                            <td><?php echo $item['id'] ?></td>
                            <td><?php echo $item['fullname'] ?></td>
                            <td><?php echo $item['email'] ?></td>
                            </td>
                            <td><?php echo $item['create_at'] ?></td>
                            <td class="text-center">
                                <?php
                                if ($item['position'] == 1) {
                                    echo  '<span class="btn btn-primary btn-sm">Quản trị viên</span>';
                                } else if ($item['position'] == 2) {
                                    echo  '<span class="btn btn-secondary btn-sm">Admin</span>';
                                } else if ($item['position'] == 3) {
                                    echo  '<span class="btn btn-danger btn-sm">Super Admin</span>';
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php echo ($item['status'] == 1 && !empty($item['status'])) ? '<button class="btn btn-success btn-sm"> Đã kích hoạt </button> ' : '<button class="btn btn-warning btn-sm"> Chưa kích hoạt </button>' ?></button>
                            <td><a href="?module=manager&action=update&id=<?php echo $item['id'] ?>"><button class="btn btn-warning btn-sm">Sửa <i class="fa fa-edit"></i></button></a>
                                <?php if ($item['id'] !== $clientId) : ?>
                            <td><a href="?module=manager&action=delete&id=<?php echo $item['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><button class="btn btn-danger btn-sm">Xóa <i class="fa fa-trash"></i></button></a>
                            </td>
                        <?php endif ?>
                        </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>
        <a href="?module=manager&action=add" class="btn btn-primary btn-sm">Thêm quản trị viên <i class="fa fa-plus"></i></a>

        <nav aria-label="Page navigation example" class="d-flex justify-content-end btn-sm">
            <ul class="pagination">
                <?php if ($page > 1) :
                    $prev = $page - 1;
                ?>
                    <li class="page-item"><a class="page-link" href="?module=manager&page=<?php echo $prev ?>">Trước</a>
                    </li>
                <?php endif; ?>
                <?php
                for ($i = 1; $i <= $maxPage; $i++) :
                ?>
                    <li class="page-item"><a class="page-link" href="?module=manager&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if ($page < $maxPage) :
                    $next = $page + 1;
                ?>
                    <li class="page-item"><a class="page-link" href="?module=manager&page=<?php echo $next ?>">Sau</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/footer.php';
