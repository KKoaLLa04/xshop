<?php
require_once _WEB_PATH_TEMPLATE . '/client/header.php';
?>
<main class="catalog  mb">

    <div class="boxleft">
        <div class="banner">
            <img id="banner" src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images/anh0.jpg" alt="">
            <button class="pre" onclick="pre()">&#10094;</button>
            <button class="next" onclick="next()">&#10095;</button>
        </div>
        <h4 class="my-5 text-center">VỀ CHÚNG TÔI </h4>
        <p></p>

    </div>
    <?php require_once _WEB_PATH_TEMPLATE . '/client/sidebar.php' ?>

</main>
<!-- BANNER 2 -->
<?php

require_once _WEB_PATH_TEMPLATE . '/client/footer.php';
