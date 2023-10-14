<form action="" method="post" style="text-align: left;">
    <div class="form-group">
        <label for=""><?php echo getOption('general_title', 'label') ?></label>
        <input type="text" class="form-control" name="general_title"
            placeholder="<?php echo getOption('general_title', 'label') ?>..."
            value="<?php echo getOption('general_title') ?>">
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Lưu thay
        đổi</button>
</form>