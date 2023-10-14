<?php
$listAllCategory = getRaw("SELECT * FROM type ORDER BY id DESC LIMIT 0,9");
// Tu dong xoa token dang nhap
// autoRemoveTokenLogin();
$title = getOption('general_title');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($data['page_title']) ? $data['page_title'] : 'Dự án mẫu' ?></title>
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/assets/css/css.css?ver=<?php echo rand() ?>">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/assets/css/style.css?ver=<?php echo rand() ?>">
    <script src="https://kit.fontawesome.com/509cc166d7.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="boxcenter">
        <!-- BIGIN HEADER -->
        <header>
            <div class="row mb header">
                <h1><?php echo !empty($title) ? $title : 'Trang chủ' ?></h1>
            </div>
            <div class="row mb menu">
                <ul>

                    <li class="dropdown <?php echo (empty($_GET['module'])) ? 'active' : false ?>">
                        <a href="index.php">Trang chủ <i class="fa fa-home"></i></a>
                    <li
                        class="dropdown <?php echo (!empty($_GET['module']) && $_GET['module'] == 'category') ? 'active' : false ?>">
                        <a class="dropdownbtn" href="">Danh mục <i class="fa fa-bars"></i></a>
                        <div class="dropdown_content">
                            <?php if (!empty($listAllCategory)) :
                                foreach ($listAllCategory as $item) : ?>
                            <a
                                href="?module=category&action=lists&id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a>
                            <?php endforeach;
                            endif ?>
                        </div>
                    <li
                        class="dropdown <?php echo (!empty($_GET['module']) && $_GET['module'] == 'products') ? 'active' : false ?>">
                        <a class="dropdownbtn" href="?module=products&action=lists">Sản Phẩm <i
                                class="fa fa-mobile-alt"></i></a>
                    <li
                        class="dropdown <?php echo (!empty($_GET['module']) && $_GET['module'] == 'comments') ? 'active' : false ?>">
                        <a class="dropdownbtn" href="?module=comments&action=lists">Bình luận <i
                                class="fa fa-comment"></i></a>
                    </li>
                    <?php if (isLogin()) : ?>
                    <li
                        class="dropdown <?php echo (!empty($_GET['module']) && $_GET['module'] == 'bill') ? 'active' : false ?>">
                        <a class="dropdownbtn" href="?module=bill&action=lists">Đơn hàng <i
                                class="fa-solid fa-file-invoice-dollar"></i></a>
                    </li>
                    <?php endif ?>

                </ul>
            </div>
        </header>
        <!-- END HEADER -->