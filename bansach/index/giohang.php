<?php
include_once 'function.php';
$db = new khachhang();

if (!$db->KiemTraDangNhap()) {
    echo '<div class="alert">Vui lòng <a href="Trangchu.php?key=dangnhap">đăng nhập</a> để xem giỏ hàng</div>';
    return;
}
// Lấy thông báo nếu có
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
// Lấy nội dung giỏ hàng
$items = $db->LayGioHang();
?>
<div class="giohang-container">
    <h2>Giỏ Hàng Của Bạn</h2>

    <?php if ($msg): ?>
        <div class="alert"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="empty-cart">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a class="btn" href="Trangchu.php">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalAmount = 0;
                foreach ($items as $item): 
                    $subtotal = $item['Gia'] * $item['SoLuong'];
                    $totalAmount += $subtotal;
                ?>
                    <tr>
                        <td>
                            <div class="cart-product-info">
                                <img src="<?= htmlspecialchars($item['AnhSP']) ?>" 
                                     alt="<?= htmlspecialchars($item['TenSP']) ?>">
                                <span><?= htmlspecialchars($item['TenSP']) ?></span>
                            </div>
                        </td>
                        <td class="price"><?= number_format($item['Gia'], 0, ',', '.') ?> ₫</td>
                        <td>
                            <form action="process.php?action=update-cart" method="post" class="quantity-form">
                                <input type="hidden" name="idSP" value="<?= $item['idSP'] ?>">
                                <input type="number" name="quantity" value="<?= $item['SoLuong'] ?>" 
                                       min="0" max="99" class="quantity-input">
                                <button type="submit" class="update-btn">Cập nhật</button>
                            </form>
                        </td>
                        <td class="subtotal"><?= number_format($subtotal, 0, ',', '.') ?> ₫</td>
                        <td>
                            <form action="process.php?action=update-cart" method="post">
                                <input type="hidden" name="idSP" value="<?= $item['idSP'] ?>">
                                <input type="hidden" name="quantity" value="0">
                                <button type="submit" class="remove-btn">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="cart-summary">
            <p>Tổng cộng: <strong><?= number_format($totalAmount, 0, ',', '.') ?> ₫</strong></p>
            <a href="Trangchu.php?key=xacnhandon" class="checkout-btn">Thanh toán</a>
        </div>
    <?php endif; ?>
</div>