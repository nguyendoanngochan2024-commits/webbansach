<?php
include_once 'function.php';
$db = new khachhang();
if (!$db->KiemTraDangNhap()) {
    header("Location: Trangchu.php?key=dangnhap");
    exit();
}
$kh = $db->LayThongTinKH($_SESSION['Email']);
if (!$kh) {
    echo '<div class="alert">Không tìm thấy thông tin khách hàng</div>';
    return;
}
$idKH = $kh['idKH'];
$orders = $db->LayHoaDonTheoKH($idKH);
?>
<div class="card">
    <h2>Đơn hàng của tôi</h2>
    <?php if (empty($orders)): ?>
        <div class="empty-cart">
            <p>Bạn chưa có đơn hàng nào.</p>
            <a class="btn" href="Trangchu.php">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Tổng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order):
                    // Tính tổng từ chitiethoadon
                    $items = $db->LayChiTietHoaDon($order['idHD']);
                    $subtotal = 0;
                    foreach ($items as $it) $subtotal += floatval($it['Gia']);
                    $shipping = 50000;
                    $total = $subtotal + $shipping;
                ?>
                <tr>
                    <td><?= htmlspecialchars($order['idHD']) ?></td>
                    <td><?= htmlspecialchars($order['NgayTao'] ?? '') ?></td>
                    <td><?= htmlspecialchars($order['TrangThai'] ?? '') ?></td>
                    <td><?= number_format($total,0,',','.') ?> ₫</td>
                    <td><a class="back-home" href="Trangchu.php?key=chitiethoadon&id=<?= urlencode($order['idHD']) ?>">Xem chi tiết</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
