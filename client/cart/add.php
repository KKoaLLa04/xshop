<?php
// Xử lý add sản phẩm vào giỏ hàng và database
if (isLogin()) {
    $clientId = isLogin()['client_id'];
    if (!empty($_GET['product_id'])) {
        $productId = $_GET['product_id'];
        // Truy vấn cơ sở dữ liệu tới bảng product
        $productDetail = firstRaw("SELECT * FROM products WHERE id=$productId");

        if (!empty($productDetail)) {
            $name = $productDetail['name'];
            $images = $productDetail['image'];
            $price = $productDetail['price'];
            $quantity = 1;

            $data = [
                'name' => $name,
                'images' => $images,
                'price' => $price,
                'quantity' => $quantity,
                'client_id' => $clientId,
                'create_at' => date('Y/m/d H:i:s')
            ];

            $insertStatus = insert('cart', $data);
            if (!empty($insertStatus)) {
                setFlashData('msg', 'Bạn đã thêm sản phẩm vào giỏ hàng!');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Có lỗi xảy ra, vui lòng thử lại!');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Không thể đặt hàng, Sản phẩm này hiện không tồn tại!');
            setFlashData('msg_type', 'danger');
        }
    } else {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            // Truy vấn cơ sở dữ liệu tới bảng product
            $productDetail = firstRaw("SELECT * FROM products WHERE id=$id");

            if (!empty($productDetail)) {
                $name = $productDetail['name'];
                $images = $productDetail['image'];
                $price = $productDetail['price'];
                $quantity = 1;

                $data = [
                    'name' => $name,
                    'images' => $images,
                    'price' => $price,
                    'quantity' => $quantity,
                    'client_id' => $clientId,
                    'create_at' => date('Y/m/d H:i:s')
                ];

                $insertStatus = insert('cart', $data);
                if (!empty($insertStatus)) {
                    setFlashData('msg', 'Bạn đã thêm sản phẩm vào giỏ hàng!');
                    setFlashData('msg_type', 'success');
                } else {
                    setFlashData('msg', 'Có lỗi xảy ra, vui lòng thử lại!');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Không thể đặt hàng, Sản phẩm này hiện không tồn tại!');
                setFlashData('msg_type', 'danger');
            }
            redirect('?module=products&action=detail&id=' . $id);
        }
    }
} else {
    setFlashData('msg', 'Bạn cần phải đăng nhập mới có thế thêm sản phẩm vào giỏ hàng');
    setFlashData('msg_type', 'danger');
    redirect('index.php');
}
redirect('index.php');