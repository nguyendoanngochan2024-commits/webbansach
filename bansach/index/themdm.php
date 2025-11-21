<?php
include_once 'functionad.php';
$admin = new admin();
if (!$admin->KiemTraDangNhapAdmin()) {
    header('Location: Dangnhapadmin.php');
    exit();
}
$msg = '';
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $TenDM = trim($_POST['TenDM']);
    $res = $admin->ThemDanhMuc($TenDM);
    $msg = $res === true ? "Thêm danh mục thành công." : "Lỗi: $res";
    if ($res === true) {
        header('Location: Trangchuadmin.php?key=danhmuc&msg='.urlencode("Thêm danh mục thành công"));
        exit();
    }
}
?>
<div class="admin-panel">
    <h1>Thêm danh mục mới</h1>
    <?php if($msg): ?><p class="message"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <div style="margin-bottom:12px;">
        <a class="btn" href="Trangchuadmin.php?key=danhmuc">Quay lại danh sách</a>
    </div>
    <form method="post" class="admin-form-grid">
        <input type="hidden" name="action" value="add">
        <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
            <div class="form-group">
                <label for="TenDM">Tên danh mục</label>
                <input id="TenDM" name="TenDM" placeholder="Nhập tên danh mục" required>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Thêm danh mục</button>
            <a class="btn" href="Trangchuadmin.php?key=danhmuc">Hủy</a>
        </div>
    </form>
</div>
