<?php
include_once 'functionad.php';
$admin = new admin();
if (!$admin->KiemTraDangNhapAdmin()) {
    header('Location: Dangnhapadmin.php');
    exit();
}
$msg = '';
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $HoTen = trim($_POST['HoTen']);
    $Email = trim($_POST['Email']);
    $DienThoai = trim($_POST['DienThoai']);
    $MatKhau = trim($_POST['MatKhau']);
    $res = $admin->ThemNguoiDung($HoTen, $Email, $DienThoai, $MatKhau);
    $msg = $res === true ? "Thêm người dùng thành công." : "Lỗi: $res";
    if ($res === true) {
        header('Location: Trangchuadmin.php?key=khachhang&msg='.urlencode("Thêm người dùng thành công"));
        exit();
    }
}
?>
<div class="admin-panel">
    <h1>Thêm khách hàng mới</h1>
    <?php if($msg): ?><p class="message"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <div style="margin-bottom:12px;">
        <a class="btn" href="Trangchuadmin.php?key=khachhang">Quay lại danh sách</a>
    </div>
    <form method="post" class="admin-form-grid">
        <input type="hidden" name="action" value="add">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="HoTen">Họ và tên</label>
                <input id="HoTen" name="HoTen" placeholder="Nhập họ và tên" required>
            </div>
            <div class="form-group">
                <label for="DienThoai">Số điện thoại</label>
                <input id="DienThoai" name="DienThoai" type="tel" placeholder="Nhập số điện thoại" required>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input id="Email" name="Email" type="email" placeholder="Nhập email" required>
            </div>
            <div class="form-group">
                <label for="MatKhau">Mật khẩu</label>
                <input id="MatKhau" name="MatKhau" type="password" placeholder="Nhập mật khẩu" required>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Thêm khách hàng</button>
            <a class="btn" href="Trangchuadmin.php?key=khachhang">Hủy</a>
        </div>
    </form>
</div>