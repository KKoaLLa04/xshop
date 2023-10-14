<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';

if (isPost()) {
    $getFields = getbody();

    if (!empty($getFields)) {
        $count = 0;
        foreach ($getFields as $key => $value) {
            $condition = "opt_key='$key'";

            $dataUpdate = [
                'opt_value' => $value,
            ];

            $updateStatus = update('options', $dataUpdate, $condition);
            if (!empty($updateStatus)) {
                $count++;
            }
        }
        if (!empty($_GET['act'])) {
            $act = $_GET['act'];
        } else {
            $act = 'general';
        }

        if ($count > 0) {
            setFlashData("msg", 'Cập nhật ' . $count . ' Bản ghi thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Có lỗi xảy ra!');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=options&action=general&act=' . $act);
    }
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<div class="row2">
    <div class="row2 font_title">
        <h1>Thiết lập chung</h1>
    </div>
    <div class="row2 form_content ">
        <hr>
        <div class="row">
            <div class="col-4">
                <ul>
                    <li><a href="?module=options&action=general&act=general">Thiết lập chung</a></li> <br />
                    <li><a href="?module=options&action=general&act=header">Thiết lập header</a></li> <br />
                    <li><a href="?module=options&action=general&act=footer">Thiết lập footer</a></li> <br />
                </ul>
            </div>
            <div class="col-8">
                <?php
                getMsg($msg, $msg_type);
                if (!empty($_GET['act'])) {
                    $act = $_GET['act'];
                } else {
                    $act = 'general';
                }
                switch ($act) {
                    case 'general':
                ?>
                <form action="" method="post" style="text-align: left;">
                    <div class="form-group">
                        <label for=""><?php echo getOption('general_hotline', 'label') ?></label>
                        <input type="text" class="form-control" name="general_hotline"
                            placeholder="<?php echo getOption('general_hotline', 'label') ?>..."
                            value="<?php echo getOption('general_hotline') ?>">
                    </div>
                    <div class="form-group">
                        <label for=""><?php echo getOption('general_address', 'label') ?></label>
                        <input type="text" class="form-control" name="general_address"
                            placeholder="<?php echo getOption('general_address', 'label') ?>.."
                            value="<?php echo getOption('general_address') ?>">
                    </div>
                    <div class="form-group">
                        <label for=""><?php echo getOption('general_email', 'label') ?></label>
                        <input type="text" class="form-control" name="general_email"
                            placeholder="<?php echo getOption('general_email', 'label') ?>..."
                            value="<?php echo getOption('general_email') ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Lưu thay
                        đổi</button>
                </form>
                <?php
                        break;
                    case 'header':
                        require_once 'header.php';
                        break;
                    case 'footer':
                        require_once 'footer.php';
                        break;
                    default:
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/footer.php';