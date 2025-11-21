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
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $idDM = trim($_POST['idDM']);
    $tenSP = trim($_POST['TenSP']);
    $Gia = floatval($_POST['Gia']);
    $Hang = trim($_POST['Hang']);
    $AnhSP = trim($_POST['AnhSP']);
    $res = $admin->ThemSach($idDM, $tenSP, $Gia, $Hang, $AnhSP);
    $msg = $res === true ? "Thêm sản phẩm thành công." : "Lỗi: $res";
    if ($res === true) {
        header('Location: Trangchuadmin.php?key=sanpham&msg='.urlencode("Thêm sản phẩm thành công"));
        exit();
    }
}
?>
<div class="admin-panel">
    <h1>Thêm sản phẩm mới</h1>
    <?php if($msg): ?><p class="message"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <div style="margin-bottom:12px;">
        <a class="btn" href="Trangchuadmin.php?key=sanpham">Quay lại danh sách</a>
    </div>
    <form method="post" class="admin-form-grid">
        <input type="hidden" name="action" value="add">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="TenSP">Tên sản phẩm</label>
                <input id="TenSP" name="TenSP" placeholder="Nhập tên sản phẩm" required>
            </div>
            <div class="form-group">
                <label for="idDM">Danh mục</label>
                <select id="idDM" name="idDM" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php
                    $categories = $khachhang->LayDanhMuc();
                    if (!empty($categories)) {
                        foreach ($categories as $dm) {
                            echo '<option value="' . htmlspecialchars($dm['idDM']) . '">' . htmlspecialchars($dm['TenDM']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Gia">Giá (VNĐ)</label>
                <input id="Gia" name="Gia" placeholder="Ví dụ: 100000" type="number" step="1000" min="0" required>
            </div>
            <div class="form-group">
                <label for="Hang">Hãng</label>
                <select id="Hang" name="Hang" required>
                    <option value="">-- Chọn hãng --</option>
                    <?php
                    $brands = $khachhang->LayTatCaHang();
                    if (!empty($brands)) {
                        foreach ($brands as $hang) {
                            echo '<option value="' . htmlspecialchars($hang) . '">' . htmlspecialchars($hang) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="AnhSP">Đường dẫn ảnh</label>
                <input id="AnhSP" name="AnhSP" placeholder="Ví dụ: /bansach/image/sp001.jpg" required>
            </div>
            <div class="form-group">
                <label for="SoLuong">Số lượng</label>
                <input id="SoLuong" name="SoLuong" type="number" min="0" value="0" placeholder="Nhập số lượng tồn kho">
            </div>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Thêm sản phẩm</button>
            <a class="btn" href="Trangchuadmin.php?key=sanpham">Hủy</a>
        </div>
    </form>
</div>

