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

        $filter .= "$operator products.name LIKE '%$keyword%'";
    }

    if (!empty($body['user_id'])) {
        $userId = $body['user_id'];

        if (strpos($filter, 'WHERE') !== false) {
            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }


        $filter .= "$operator products.user_id=" . $userId;
    }

    if (!empty($body['type_id'])) {
        $typeId = $body['type_id'];

        if (strpos($filter, 'WHERE') !== false) {
            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }


        $filter .= "$operator products.type_id=" . $typeId;
    }
}

// Thuật toán phân trang
// 1.Số lượng bản ghi / 1 trang
$perPage = _PER_PAGE;
// 2.Lấy toàn bộ bản ghi trong db
$countProducts = countProduct($filter);
// 3.Tính số lượng trang lớn nhất
$maxPage = ceil($countProducts / $perPage);
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

// Truy van co so du lieu products
$listAllProducts = allProducts($filter, $offset, $perPage);

// Truy van co so du lieu type
$listAllType = allType();

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>DANH SÁCH HÀNG HÓA</h1>
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

                <div class="col-3">
                    <select name="type_id" class="form-control">
                        <option value="0">---Chọn danh mục---</option>
                        <?php if (!empty($listAllType)) :
                            foreach ($listAllType as $item) :
                        ?>
                                <option value="<?php echo $item['id'] ?>" <?php echo (!empty($typeId) && $item['id'] == $typeId) ? 'selected' : false ?>>
                                    <?php echo $item['name'] ?>
                                </option>
                        <?php endforeach;
                        endif ?>
                    </select>
                </div>

                <div class="col-6">
                    <input type="search" class="form-control" placeholder="Từ khóa tìm kiếm" name="keyword" value="<?php echo !empty($keyword) ? $keyword : false ?>">
                </div>

                <div class="col-3">
                    <button type="submit" class="btn btn-primary form-control">Tìm kiếm</button>
                    <input type="hidden" name="module" value="products">
                </div>
            </div>
        </form>
        <hr>
        <table class="table table-bordered my-4">
            <thead>
                <tr>
                    <th width="8%">Mã hàng hóa</th>
                    <th width="10%">Tên hàng hóa</th>
                    <th width="8%">giá</th>
                    <th width="15%">Ảnh minh họa</th>
                    <th>Danh mục</th>
                    <!-- <th>Tạo bởi</th> -->
                    <th>Tình trạng</th>
                    <th width="12%">Ngày tạo</th>
                    <th width="7%">Sửa</th>
                    <th width="7%">Xóa</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($listAllProducts)) :
                    foreach ($listAllProducts as $item) : ?>
                        <tr>
                            <td>00<?php echo $item['id'] ?></td>
                            <td><?php echo $item['name'] ?> <br> <button class="btn btn-warning btn-sm">Lượt
                                    xem: <?php echo $item['view'] ?></button></td>
                            <td><?php echo $item['price'] ?> VND</td>
                            <td><img src="<?php echo _WEB_HOST_ROOT . '/uploads/' . $item['image'] ?>" alt=""></td>
                            <td><a href="#"><?php echo $item['type_name'] ?></a></td>
                            <!-- <td><a href="#"><?php echo $item['fullname'] ?></a></td> -->
                            <td><?php echo ($item['status'] == 1) ? 'Còn hàng' : 'Hết hàng' ?></td>
                            <td><?php echo !empty($item['create_at']) ? $item['create_at'] : '00:00:00' ?></td>
                            <td><a href="?module=products&action=update&id=<?php echo $item['id'] ?>"><button class="btn btn-warning">Sửa <i class="fa fa-edit"></i></button></a></td>
                            <td><a href="?module=products&action=delete&id=<?php echo $item['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><button class="btn btn-danger">Xóa <i class="fa fa-trash-alt"></i></button></a></td>
                        </tr>

                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="10" class="text-center">Không có dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example" class="d-flex justify-content-end btn-sm">
            <ul class="pagination">
                <?php if ($page > 1) :
                    $prev = $page - 1;
                ?>
                    <li class="page-item"><a class="page-link" href="?module=products&page=<?php echo $prev ?>">Trước</a>
                    </li>
                <?php endif; ?>
                <?php
                for ($i = 1; $i <= $maxPage; $i++) :
                ?>
                    <li class="page-item"><a class="page-link" href="?module=products&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if ($page < $maxPage) :
                    $next = $page + 1;
                ?>
                    <li class="page-item"><a class="page-link" href="?module=products&page=<?php echo $next ?>">Sau</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <a href="?module=products&action=add"><button type="button" class="btn btn-primary btn-sm">Thêm mới <i class="fa fa-plus"></i></button></a>
    </div>
</div>
<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/footer.php';
