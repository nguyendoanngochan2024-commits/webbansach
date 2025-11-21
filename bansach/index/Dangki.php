<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Trang đăng kí</title>
        <link rel="stylesheet" href="/bansach/style/styleuser.css">
        <link rel="icon" href="/bansach/favicon.ico">
    </head>
    <body>
<?php
include_once 'function.php';
$db = new khachhang();
$db->ensureSessionStarted();
$msg = '';
if (!empty($_SESSION['flash_msg'])) {
    $msg = $_SESSION['flash_msg'];
    unset($_SESSION['flash_msg']);
}
?>

<main class="auth-page">
    <div class="auth-card">
        <h2>Đăng ký tài khoản</h2>
        <?php if (!empty($msg)): ?>
            <div class="alert"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>
        <form method="POST" action="process.php" class="auth-form">
            <input type="hidden" name="action" value="dangki">
            <label for="hoten">Họ tên</label>
            <input id="hoten" type="text" name="HoTen" required>

            <label for="email">Email</label>
            <input id="email" type="email" name="Email" required>

            <label for="dienthoai">Điện thoại</label>
            <input id="dienthoai" type="tel" name="DienThoai" required>

            <label for="matkhau">Mật khẩu</label>
            <input id="matkhau" type="password" name="MatKhau" required>

            <div class="form-actions">
                <button class="btn-primary" type="submit">Đăng ký</button>
                <a class="btn-secondary" href="Trangchu.php?key=dangnhap">Đã có tài khoản?</a>
            </div>
        </form>
    </div>
</main>

    </body>
</html>