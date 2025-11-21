<?php
include_once 'function.php';
$db = new khachhang();
if (!$db->KiemTraDangNhap()) {
    header("Location: Trangchu.php?key=dangnhap");
    exit();
}
$items = $db->LayGioHang();
if (empty($items)) {
    header("Location: Trangchu.php?key=giohang");
    exit();
}
$totalAmount = 0;
foreach ($items as $item) {
    $totalAmount += $item['Gia'] * $item['SoLuong'];
}
?>
    <div class="checkout-form">
        <h3>Thông tin thanh toán</h3>
        <form action="process.php?action=checkout" method="post" onsubmit="disableSubmitButton()">
            <div class="form-group">
                <label for="address">Địa chỉ nhận hàng:</label>
                <textarea id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="note">Ghi chú:</label>
                <textarea id="note" name="note"></textarea>
            </div>
            <div class="order-summary">
                <h4>Thông tin đơn hàng</h4>
                <?php foreach ($items as $item): ?>
                <div class="order-item">
                    <span class="item-name"><?= htmlspecialchars($item['TenSP']) ?></span>
                    <span class="item-quantity">x<?= $item['SoLuong'] ?></span>
                    <span class="item-price"><?= number_format($item['Gia'] * $item['SoLuong'], 0, ',', '.') ?> ₫</span>
                </div>
                <?php endforeach; ?>
                <div class="shipping-fee">
                    <span>Phí vận chuyển:</span>
                    <span>50,000 ₫</span>
                </div>
                <div class="total-amount">
                    <strong>Tổng thanh toán:</strong>
                    <strong><?= number_format($totalAmount + 50000, 0, ',', '.') ?> ₫</strong>
                </div>
            </div>

            <div class="form-actions">
                <a href="Trangchu.php?key=giohang" class="btn-secondary">Quay lại giỏ hàng</a>
                <button type="submit" class="btn-primary">Xác nhận đặt hàng</button>
            </div>
        </form>
    </div>

<script>
function disableSubmitButton() {
    var submitButton = document.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Đang xử lý...';
    return true;
}
</script>