<?php
// Tu dong xoa token dang nhap
if (!isLogin()) {
    redirect('../index.php');
}
// autoRemoveTokenLogin();
// Truy van co so du lieu vs client
if (isLogin()) {
    $clientId = isLogin()['client_id'];
    $clientInfor = firstRaw("SELECT * FROM client WHERE id=$clientId");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dự án mẫu</title>

    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/assets/css/css.css?ver=<?php echo rand() ?>">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/assets/css/style.css?ver=<?php echo rand() ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

    </style>
</head>

<body>
    <div class="boxcenter">
        <!-- BIGIN HEADER -->
        <header>
            <div class="row mb header_admin">
                <h1>Admin</h1>
            </div>
            <div class="row mb menu">
                <ul>
                    <li><a href="<?php echo _WEB_HOST_ROOT ?>">Trang chủ <i class="fa fa-home"></i></a></li>
                    <li class="<?php echo (empty($_GET['module']) || $_GET['module'] == 'products_category' || (!empty($_GET['module']) && $_GET['module'] == 'category')) ? 'active' : 'Sai dieu kien' ?>">
                        <a href="?module=products_category">Danh mục <i class="fa-solid fa-bars"></i></a>
                    </li>
                    <li class="<?php echo (!empty($_GET['module']) && $_GET['module'] == 'products') ? 'active' : false ?>">
                        <a href="?module=products">Hàng hóa <i class="fa-solid fa-mobile-screen"></i></a>
                    </li>
                    <li class="<?php echo (!empty($_GET['module']) && $_GET['module'] == 'clients') ? 'active' : false ?>">
                        <a href="?module=clients">Khách hàng <i class="fa fa-user"></i></a>
                    </li>
                    <li class="<?php echo (!empty($_GET['module']) && $_GET['module'] == 'comments') ? 'active' : false ?>">
                        <a href="?module=comments">Bình luận <i class="fa fa-comment"></i></a>
                    </li>
                    <li class="<?php echo (!empty($_GET['module']) && $_GET['module'] == 'statistic') ? 'active' : false ?>">
                        <a href="?module=statistic">Thống kê <i class="fa fa-chart-bar"></i></a>
                    </li>
                    <li class="<?php echo (!empty($_GET['module']) && $_GET['module'] == 'bill') ? 'active' : false ?>">
                        <a href="?module=bill">Đơn hàng <i class="fa-solid fa-file-invoice-dollar"></i></a>
                    </li>
                    <?php if ($clientInfor['position'] >= 3) : ?>

                    <?php endif ?>
                    <?php if ($clientInfor['position'] >= 2) : ?>
                        <li class="<?php echo (!empty($_GET['action']) && $_GET['module'] == 'manager') ? 'active' : false ?>">
                            <a href="?module=manager&action=add">Thêm Quản trị viên <i class="fa fa-user-cog"></i></a>
                        </li>
                    <?php endif; ?>
                    <li class="<?php echo (!empty($_GET['module']) && empty($_GET['action']) && $_GET['module'] == 'manager') ? 'active' : false ?>">
                        <a href="?module=manager">Quản trị viên <i class="fa fa-user-cog"></i></a>
                    </li>
                    <li class="<?php echo (!empty($_GET['module']) && $_GET['module'] == 'options') ? 'active' : false ?>">
                        <a href="?module=options&action=general">Thiết lập <i class="fa fa-cog"></i></a>
                    </li>
                </ul>
            </div>
            <!-- </div> -->
        </header>

        <!-- END HEADER -->