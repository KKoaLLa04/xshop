<?php
$hotline = getOption('general_hotline');
$email = getOption('general_email');
$address = getOption('general_address');
$facebook = getOption('general_facebook');
$instagram = getOption('general_instagram');
$twitter = getOption('general_twitter');
$youtube = getOption('general_youtube');
$google = getOption('general_google');
?>
<!-- FOOTER -->
<footer class="box_footer row mb demo">
    <div id="footer">
        <div class="footer-left">
            <div class="footer-logo">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images//FPTShop_logo.jpg" alt="" />
            </div>
            <div class="card_1">
                <h3>CÔNG TY ĐIỆN TỬ FPT SỐ 1 VIỆT NAM</h3>
                <div>
                    <i class="fa-sharp fa-solid fa-location-pin"></i>
                    <p>
                        <?php echo !empty($address) ? $address : '1' ?>
                    </p>
                </div>

                <div>
                    <i class="fa-solid fa-phone-flip"></i>
                    <p><?php echo !empty($hotline) ? $hotline : false ?></p>
                </div>

                <div>
                    <i class="fa-solid fa-envelope"></i>
                    <p><?php echo !empty($email) ? $email : false ?></p>
                </div>

                <p>Số ĐKKD: 0106341306. Ngày cấp: 16/03/2017.</p>
                <p>Nơi cấp: Sở kế hoạch và Đầu tư Thành phố Hà Nội.</p>
                <div class="icons">
                    <a href="<?php echo !empty($facebook) ? $facebook : '#' ?>" target="_blank"> <i
                            class="fa-brands fa-facebook"></i></a>
                    <a href="<?php echo !empty($instagram) ? $instagram : '#' ?>" target="_blank"><i
                            class="fa-brands fa-square-instagram"></i></a>
                    <a href="<?php echo !empty($youtube) ? $youtube : '#' ?>" target="_blank"><i
                            class="fa-brands fa-youtube"></i></a>
                    <a href="<?php echo !empty($twitter) ? $twitter : '#' ?>" target="_blank"><i
                            class="fa-brands fa-square-twitter"></i></a>
                    <a href="<?php echo !empty($google) ? $google : '#' ?>" target="_blank"><i
                            class="fa-brands fa-google-plus"></i></a>
                </div>

                <div class="images">
                    <div class="image">
                        <img src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images//anh4.jpg" alt="" />
                    </div>
                    <div class="image">
                        <img src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images//anh1.jpg" alt="" />
                    </div>
                </div>

                <div class="image_3 image">
                    <img src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/images//anh2.jpg" alt="" />
                </div>
            </div>
        </div>
        <div class="footer-right">
            <div class="card_2">
                <h3>VỀ CHÚNG TÔI</h3>
                <a href="?module=pages&action=aboutus">Giới thiệu về XShop</a>
                <a href="gioithieu.html">Nhượng quyền</a>
                <a href="">Tin tức khuyến mại</a>
                <a href="">Cửa hàng</a>
                <a href="#">Quy định chung</a>
                <a href="#">TT liên hệ &#038; ĐKKD</a>
            </div>
            <div class="card_3">
                <h3>CHÍNH SÁCH</h3>
                <a href="#">Chính sách thành viên</a>
                <a href="#">Hình thức thanh toán</a>
                <a href="#">Vận chuyển giao nhận</a>
                <a href="#">Đổi trả và hoàn tiền</a>
                <a href="#">Bảo vệ thông tin cá nhân</a>
                <a href="#">Bảo trì, bảo hành</a>
            </div>
        </div>
    </div>
    <!-- footer section ends -->
</footer>
</div>
<script src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/js/main.js?ver=<?php echo rand() ?>"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/js/app.js?ver=<?php echo rand() ?>"></script>
</body>

</html>