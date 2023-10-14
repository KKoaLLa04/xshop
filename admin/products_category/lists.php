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

        $filter .= "$operator name LIKE '%$keyword%'";
    }

    if (!empty($body['user_id'])) {
        $userId = $body['user_id'];

        if (strpos($filter, 'WHERE') !== false) {
            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }


        $filter .= "$operator user_id=" . $userId;
    }
}

// Thuật toán phân trang
// 1.Số lượng bản ghi / 1 trang
$perPage = _PER_PAGE;
// 2.Lấy toàn bộ bản ghi trong db
$countType = getRows("SELECT id FROM type");
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

// Truy van co so du lieu type
if (isLogin()) {
    $clientId = isLogin()['client_id'];
    $listCateProduct = getRaw("SELECT type.* FROM type $filter ORDER BY id DESC LIMIT $offset,$perPage");
}

// Truy van co so du lieu client
// $listAllclient = getRaw("SELECT * FROM clients ORDER BY fullname");

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>DANH SÁCH LOẠI HÀNG HÓA</h1>
    </div>
    <div class="row2 form_content ">
        <hr>
        <?php echo getMsg($msg, $msg_type) ?>
        <form action="" method="get">
            <div class="row">
                <!-- <div class="col-3">
                    <select name="user_id" class="form-control">
                        <option value="0">---Chọn người đăng---</option>
                        <?php if (!empty($listAllUser)) :
                            foreach ($listAllUser as $item) :
                        ?>
                                <option value="<?php echo $item['id'] ?>" <?php echo (!empty($userId) && $userId == $item['id']) ? 'selected' : false ?>>
                                    <?php echo $item['fullname'] . ' (' . $item['email'] . ')' ?></option>
                        <?php endforeach;
                        endif ?>
                    </select>
                </div> -->

                <div class="col-9">
                    <input type="search" class="form-control" placeholder="Từ khóa tìm kiếm" name="keyword"
                        value="<?php echo !empty($keyword) ? $keyword : false ?>">
                </div>

                <div class="col-3">
                    <button type="submit" class="btn btn-primary form-control">Tìm kiếm</button>
                </div>
            </div>
        </form>
        <hr>
        <table class="table table-bordered my-4">
            <thead>
                <tr>
                    <th>Mã loại hàng</th>
                    <th>Tên loại hàng</th>
                    <!-- <th>Tạo bởi</th> -->
                    <th>Ngày tạo</th>
                    <th width="7%">Sửa</th>
                    <th width="7%">Xóa</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($listCateProduct)) :
                    foreach ($listCateProduct as $item) : ?>
                <tr>
                    <td>0<?php echo $item['id'] ?></td>
                    <td><?php echo $item['name'] ?></td>
                    <!-- <td><a href="#" class="postBy"><?php echo $item['fullname'] ?></a></td> -->
                    <td><?php echo $item['create_at'] ?></td>
                    <td><a href="?module=products_category&action=update&id=<?php echo $item['id'] ?>"><button
                                class="btn btn-warning">Sửa <i class="fa fa-edit"></i></button></a></td>
                    <td><a href="?module=products_category&action=delete&id=<?php echo $item['id'] ?>"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><button class="btn btn-danger">Xóa <i
                                    class="fa fa-trash-alt"></i></button></a></td>
                </tr>

                <?php endforeach;
                else : ?>
                <tr>
                    <td colspan="7" class="text-center">Không có dữ liệu</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example" class="d-flex justify-content-end btn-sm">
            <ul class="pagination">
                <?php if ($page > 1) :
                    $prev = $page - 1;
                ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $prev ?>">Trước</a></li>
                <?php endif; ?>
                <?php
                for ($i = 1; $i <= $maxPage; $i++) :
                ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if ($page < $maxPage) :
                    $next = $page + 1;
                ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $next ?>">Sau</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <a href="?module=products_category&action=add"><button type="button" class="btn btn-primary btn-sm">Thêm mới <i
                    class="fa fa-plus"></i></button></a>
    </div>
</div>
<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/footer.php';