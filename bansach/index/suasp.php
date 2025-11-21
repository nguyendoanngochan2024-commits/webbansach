<?php
include_once 'functionad.php';
include_once 'function.php';
$admin = new admin();
$khachhang = new khachhang();
if (!$admin->KiemTraDangNhapAdmin()) {
    header('Location: Dangnhapadmin.php');
    exit();
}
$msg = '';
// Xử lý form submit
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $idSP = trim($_POST['idSP']);
    $idDM = trim($_POST['idDM']);
    $tenSP = trim($_POST['TenSP']);
    $Gia = floatval($_POST['Gia']);
    $Hang = trim($_POST['Hang']);
    $AnhSP = trim($_POST['AnhSP']);
    $res = $admin->CapNhatSach($idSP, $idDM, $tenSP, $Gia, $Hang, $AnhSP);
    $msg = $res === true ? "Cập nhật thành công." : "Lỗi: $res";
    if ($res === true) {
        header('Location: Trangchuadmin.php?key=sanpham&msg='.urlencode("Cập nhật sản phẩm thành công"));
        exit();
    }
}
// Lấy thông tin sản phẩm cần sửa
if (isset($_GET['edit'])) {
    $id = trim($_GET['edit']);
    $products = $admin->LayTatCaSach();
    foreach ($products as $p) {
        if (isset($p['idSP']) && $p['idSP'] === $id) {
            $editSP = $p;
            break;
        }
    }
}
if (!isset($editSP)) {
    header('Location: Trangchuadmin.php?key=sanpham&msg='.urlencode("Không tìm thấy sản phẩm"));
    exit();
}
?>
<div class="admin-panel">
    <h1>Sửa sản phẩm</h1>
    <?php if($msg): ?><p class="message"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <div style="margin-bottom:12px;">
        <a class="btn" href="Trangchuadmin.php?key=sanpham">Quay lại danh sách</a>
    </div>
    <form method="post" class="admin-form-grid">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="idSP" value="<?php echo htmlspecialchars($editSP['idSP']); ?>">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="TenSP">Tên sản phẩm</label>
                <input id="TenSP" name="TenSP" value="<?php echo htmlspecialchars($editSP['TenSP']); ?>" placeholder="Nhập tên sản phẩm" required>
            </div>
            <div class="form-group">
                <label for="idDM">Danh mục</label>
                <select id="idDM" name="idDM" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php
                    $categories = $khachhang->LayDanhMuc();
                    $currentDM = htmlspecialchars($editSP['idDM']);
                    if (!empty($categories)) {
                        foreach ($categories as $dm) {
                            $selected = ($dm['idDM'] === $currentDM) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($dm['idDM']) . '" ' . $selected . '>' . htmlspecialchars($dm['TenDM']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Gia">Giá (VNĐ)</label>
                <input id="Gia" name="Gia" value="<?php echo htmlspecialchars($editSP['Gia']); ?>" placeholder="Ví dụ: 100000" type="number" step="1000" min="0" required>
            </div>
            <div class="form-group">
                <label for="Hang">Hãng</label>
                <select id="Hang" name="Hang" required>
                    <option value="">-- Chọn hãng --</option>
                    <?php
                    $brands = $khachhang->LayTatCaHang();
                    $currentHang = htmlspecialchars($editSP['Hang']);
                    if (!empty($brands)) {
                        foreach ($brands as $hang) {
                            $selected = ($hang === $currentHang) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($hang) . '" ' . $selected . '>' . htmlspecialchars($hang) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="AnhSP">Đường dẫn ảnh</label>
                <input id="AnhSP" name="AnhSP" value="<?php echo htmlspecialchars($editSP['AnhSP']); ?>" placeholder="Ví dụ: /bansach/image/sp001.jpg" required>
            </div>
            <div class="form-group">
                <label for="SoLuong">Số lượng</label>
                <input id="SoLuong" name="SoLuong" type="number" min="0" value="<?php echo htmlspecialchars($editSP['SoLuong'] ?? 0); ?>" placeholder="Nhập số lượng tồn kho">
            </div>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Cập nhật</button>
            <a class="btn" href="Trangchuadmin.php?key=sanpham">Hủy</a>
        </div>
    </form>
</div>

