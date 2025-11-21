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
    $idKH = trim($_POST['idKH']);
    $HoTen = trim($_POST['HoTen']);
    $Email = trim($_POST['Email']);
    $DienThoai = trim($_POST['DienThoai']);
    $MatKhau = trim(md5($_POST['MatKhau']));
    $res = $admin->CapNhatNguoiDung($idKH, $HoTen, $Email, $DienThoai, $MatKhau);
    $msg = $res === true ? "Cập nhật thành công." : "Lỗi: $res";
    if ($res === true) {
        header('Location: Trangchuadmin.php?key=khachhang&msg='.urlencode("Cập nhật thông tin thành công"));
        exit();
    }
}
// Lấy thông tin người dùng cần sửa
if (isset($_GET['edit'])) {
    $id = trim($_GET['edit']);
    $users = $admin->LayTatCaNguoiDung();
    foreach ($users as $u) {
        if (isset($u['idKH']) && $u['idKH'] === $id) {
            $editUser = $u;
            break;
        }
    }
}
if (!isset($editUser)) {
    header('Location: Trangchuadmin.php?key=khachhang&msg='.urlencode("Không tìm thấy người dùng"));
    exit();
}
?>
<div class="admin-panel">
    <h1>Sửa thông tin khách hàng</h1>
    <?php if($msg): ?><p class="message"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <div style="margin-bottom:12px;">
        <a class="btn" href="Trangchuadmin.php?key=khachhang">Quay lại danh sách</a>
    </div>
    <form method="post" class="admin-form-grid">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="idKH" value="<?php echo htmlspecialchars($editUser['idKH']); ?>">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="HoTen">Họ và tên</label>
                <input id="HoTen" name="HoTen" value="<?php echo htmlspecialchars($editUser['HoTen']); ?>" placeholder="Nhập họ và tên" required>
            </div>
            <div class="form-group">
                <label for="DienThoai">Số điện thoại</label>
                <input id="DienThoai" name="DienThoai" type="tel" value="<?php echo htmlspecialchars($editUser['DienThoai']); ?>" placeholder="Nhập số điện thoại" required>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input id="Email" name="Email" type="email" value="<?php echo htmlspecialchars($editUser['Email']); ?>" placeholder="Nhập email" required>
            </div>
            <div class="form-group">
                <label for="MatKhau">Mật khẩu</label>
                <input id="MatKhau" name="MatKhau" type="password" value="<?php echo htmlspecialchars($editUser['MatKhau']); ?>" placeholder="Nhập mật khẩu" required>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Cập nhật</button>
            <a class="btn" href="Trangchuadmin.php?key=khachhang">Hủy</a>
        </div>
    </form>
</div>