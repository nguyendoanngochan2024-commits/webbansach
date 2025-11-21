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

<div class="order-details">
    <div class="order-header">
        <h2>Chi tiết đơn hàng #<?= htmlspecialchars($idHD) ?></h2>
        <div class="status-badge <?= strtolower($order['TrangThai']) ?>">
            <?= htmlspecialchars($order['TrangThai']) ?>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-section">
            <h3>Thông tin đơn hàng</h3>
            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['NgayTao'])) ?></p>
            <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['TrangThai']) ?></p>
            <p><strong>Địa chỉ nhận hàng:</strong><br><?= nl2br(htmlspecialchars($order['DiaChiNhanHang'])) ?></p>
            <?php if (!empty($order['GhiChu'])): ?>
            <p><strong>Ghi chú:</strong><br><?= nl2br(htmlspecialchars($order['GhiChu'])) ?></p>
            <?php endif; ?>
        </div>

        <div class="info-section">
            <h3>Tổng quan đơn hàng</h3>
            <div class="order-summary">
                <p>
                    <span>Tổng tiền hàng:</span>
                    <span><?= number_format($subtotal, 0, ',', '.') ?> ₫</span>
                </p>
                <p>
                    <span>Phí vận chuyển:</span>
                    <span><?= number_format($shipping, 0, ',', '.') ?> ₫</span>
                </p>
                <div class="total">
                    <span>Tổng thanh toán:</span>
                    <span><?= number_format($total, 0, ',', '.') ?> ₫</span>
                </div>
            </div>
        </div>
    </div>

    <div class="items-section">
        <h3>Chi tiết sản phẩm</h3>
        <div class="order-items">
            <?php foreach ($items as $item): ?>
            <div class="order-item">
                <div class="product-info">
                    <img src="<?= htmlspecialchars($item['AnhSP']) ?>" alt="">
                    <div class="product-details">
                        <h4><?= htmlspecialchars($item['TenSP']) ?></h4>
                        <p class="price">Đơn giá: <?= number_format($item['Gia']/$item['SoLuong'], 0, ',', '.') ?> ₫</p>
                    </div>
                </div>
                <div class="quantity">
                    Số lượng: <?= $item['SoLuong'] ?>
                </div>
                <div class="subtotal">
                    <?= number_format($item['Gia'], 0, ',', '.') ?> ₫
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="actions">
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert" style="margin-right:auto; color:#b91c1c;"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>
        <a href="Trangchu.php?key=hoadon" class="btn-secondary">Quay lại danh sách đơn hàng</a>
        <a href="Trangchu.php" class="btn-primary">Tiếp tục mua sắm</a>
        <?php if ($order['TrangThai'] === 'Chờ xử lý'): ?>
            <a href="process.php?action=cancel_order&id=<?= urlencode($idHD) ?>" 
               class="btn-secondary" 
               onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">Hủy đơn</a>
        <?php endif; ?>
    </div>
</div>
