<?php
include_once 'function.php';
$db = new khachhang();
if (!$db->KiemTraDangNhap()) {
    header("Location: Trangchu.php?key=dangnhap");
    exit();
}
if (!isset($_GET['id'])) {
    header("Location: Trangchu.php?key=hoadon");
    exit();
}
$idHD = $_GET['id'];
$order = $db->LayHoaDonById($idHD);
if (!$order) {
    echo '<div class="alert">Không tìm thấy đơn hàng.</div>';
    return;
}
$kh = $db->LayThongTinKH($_SESSION['Email']);
if (!$kh || $kh['idKH'] !== $order['idKH']) {
    echo '<div class="alert">Bạn không có quyền xem đơn hàng này.</div>';
    return;
}
$items = $db->LayChiTietHoaDon($idHD);
$subtotal = 0;
foreach ($items as $it) $subtotal += floatval($it['Gia']);
$shipping = 50000;
$total = $subtotal + $shipping;
?>
<div class="card">
    <h2>Chi tiết đơn hàng <?= htmlspecialchars($idHD) ?></h2>
    <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($order['NgayTao'] ?? '') ?></p>
    <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['TrangThai'] ?? '') ?></p>
    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['DiaChiNhanHang'] ?? '') ?></p>
    <p><strong>Ghi chú:</strong> <?= nl2br(htmlspecialchars($order['GhiChu'] ?? '')) ?></p>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $it): ?>
            <tr>
                <td>
                    <div class="cart-product-info">
                        <?php if (!empty($it['AnhSP'])): ?>
                            <img src="<?= htmlspecialchars($it['AnhSP']) ?>" alt="">
                        <?php endif; ?>
                        <span><?= htmlspecialchars($it['TenSP'] ?? $it['idSP']) ?></span>
                    </div>
                </td>
                <td><?= htmlspecialchars($it['SoLuong']) ?></td>
                <td><?= number_format($it['Gia'],0,',','.') ?> ₫</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="cart-summary">
        <p>Tiền hàng: <strong><?= number_format($subtotal,0,',','.') ?> ₫</strong></p>
        <p>Phí vận chuyển: <strong><?= number_format($shipping,0,',','.') ?> ₫</strong></p>
        <p>Tổng: <strong><?= number_format($total,0,',','.') ?> ₫</strong></p>
    </div>
    <a class="back-home" href="Trangchu.php?key=hoadon">&larr; Quay về danh sách đơn hàng</a>
</div>
