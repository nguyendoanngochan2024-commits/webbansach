<?php
include_once 'functionad.php';
$admin = new admin();
if (!$admin->KiemTraDangNhapAdmin()) {
    header('Location: Dangnhapadmin.php');
    exit();
}
$msg = '';
// Xử lý form submit
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $idDM = trim($_POST['idDM']);
    $TenDM = trim($_POST['TenDM']);
    $res = $admin->CapNhatDanhMuc($idDM, $TenDM);
    $msg = $res === true ? "Cập nhật thành công." : "Lỗi: $res";
    if ($res === true) {
        header('Location: Trangchuadmin.php?key=danhmuc&msg='.urlencode("Cập nhật danh mục thành công"));
        exit();
    }
}
// Lấy thông tin danh mục cần sửa
if (isset($_GET['edit'])) {
    $id = trim($_GET['edit']);
    $categories = $admin->LayTatCaDanhMuc();
    foreach ($categories as $c) {
        if (isset($c['idDM']) && $c['idDM'] === $id) {
            $editDM = $c;
            break;
        }
    }
}
if (!isset($editDM)) {
    header('Location: Trangchuadmin.php?key=danhmuc&msg='.urlencode("Không tìm thấy danh mục"));
    exit();
}
?>
<div class="admin-panel">
    <h1>Sửa danh mục</h1>
    <?php if($msg): ?><p class="message"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <div style="margin-bottom:12px;">
        <a class="btn" href="Trangchuadmin.php?key=danhmuc">Quay lại danh sách</a>
    </div>
    <form method="post" class="admin-form-grid">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="idDM" value="<?php echo htmlspecialchars($editDM['idDM']); ?>">
        <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
            <div class="form-group">
                <label for="TenDM">Tên danh mục</label>
                <input id="TenDM" name="TenDM" value="<?php echo htmlspecialchars($editDM['TenDM']); ?>" placeholder="Nhập tên danh mục" required>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Cập nhật</button>
            <a class="btn" href="Trangchuadmin.php?key=danhmuc">Hủy</a>
        </div>
    </form>
</div>