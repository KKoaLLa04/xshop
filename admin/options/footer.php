<form action="" method="post" style="text-align: left;">
    <div class="form-group">
        <label for=""><?php echo getOption('general_facebook', 'label') ?></label>
        <input type="text" class="form-control" name="general_facebook"
            placeholder="<?php echo getOption('general_facebook', 'label') ?>..."
            value="<?php echo getOption('general_facebook') ?>">
    </div>

    <div class="form-group">
        <label for=""><?php echo getOption('general_instagram', 'label') ?></label>
        <input type="text" class="form-control" name="general_instagram"
            placeholder="<?php echo getOption('general_instagram', 'label') ?>..."
            value="<?php echo getOption('general_instagram') ?>">
    </div>

    <div class="form-group">
        <label for=""><?php echo getOption('general_youtube', 'label') ?></label>
        <input type="text" class="form-control" name="general_youtube"
            placeholder="<?php echo getOption('general_youtube', 'label') ?>..."
            value="<?php echo getOption('general_youtube') ?>">
    </div>

    <div class="form-group">
        <label for=""><?php echo getOption('general_twitter', 'label') ?></label>
        <input type="text" class="form-control" name="general_twitter"
            placeholder="<?php echo getOption('general_twitter', 'label') ?>..."
            value="<?php echo getOption('general_twitter') ?>">
    </div>

    <div class="form-group">
        <label for=""><?php echo getOption('general_google', 'label') ?></label>
        <input type="text" class="form-control" name="general_google"
            placeholder="<?php echo getOption('general_google', 'label') ?>..."
            value="<?php echo getOption('general_google') ?>">
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Lưu thay
        đổi</button>
</form>