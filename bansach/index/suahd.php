<?php
// Form chỉnh sửa trạng thái hóa đơn - được include từ adminhd.php
if (!isset($editOrder) || !$editOrder) {
    echo '<p>Không tìm thấy hóa đơn.</p>';
    return;
}
?>
<div style="background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; max-width: 800px;">
    <h2>Chi tiết hóa đơn <?php echo htmlspecialchars($editOrder['idHD']); ?></h2>
    <div style="background: #f8fafc; padding: 16px; border-radius: 6px; margin-bottom: 20px;">
        <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($editOrder['HoTen']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($editOrder['Email']); ?></p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($editOrder['DiaChiNhanHang']); ?></p>
        <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($editOrder['GhiChu']); ?></p>
        <p><strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($editOrder['NgayTao'])); ?></p>
    </div>
    <form method="post" action="processadmin.php" class="admin-form">
        <input type="hidden" name="action" value="update_order_status">
        <input type="hidden" name="idHD" value="<?php echo htmlspecialchars($editOrder['idHD']); ?>">
        <div class="form-group">
            <label for="trangThai">Trạng thái:</label>
            <select id="trangThai" name="trangThai" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                <option value="Chờ xử lý" <?php echo $editOrder['TrangThai'] === 'Chờ xử lý' ? 'selected' : ''; ?>>Chờ xử lý</option>
                <option value="Đã xác nhận" <?php echo $editOrder['TrangThai'] === 'Đã xác nhận' ? 'selected' : ''; ?>>Đã xác nhận</option>
                <option value="Đang giao" <?php echo $editOrder['TrangThai'] === 'Đang giao' ? 'selected' : ''; ?>>Đang giao</option>
                <option value="Đã giao" <?php echo $editOrder['TrangThai'] === 'Đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                <option value="Đã hủy" <?php echo $editOrder['TrangThai'] === 'Đã hủy' ? 'selected' : ''; ?>>Đã hủy</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn">Cập nhật trạng thái</button>
            <a href="Trangchuadmin.php?key=hoadon" class="btn">Quay lại</a>
        </div>
    </form>
</div>
