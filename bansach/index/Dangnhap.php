<?php
include_once 'function.php';
$db = new khachhang();
$db->ensureSessionStarted();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Trang đăng nhập</title>
        <link rel="stylesheet" href="/bansach/style/styleuser.css">
        <link rel="icon" href="/bansach/favicon.ico">
    </head>
    <body>
        <main class="auth-page">
            <div class="auth-card">
                <h2>Đăng nhập</h2>
                <?php if (!empty($_SESSION['flash_msg'])): ?>
                    <div class="alert"><?php echo htmlspecialchars($_SESSION['flash_msg']); unset($_SESSION['flash_msg']); ?></div>
                <?php endif; ?>
                <form method="POST" action="process.php" class="auth-form">
                    <input type="hidden" name="action" value="login">
                    <label for="email">Email</label>
                    <input id="email" type="text" name="Email" required>

                    <label for="matkhau">Mật khẩu</label>
                    <input id="matkhau" type="password" name="MatKhau" required>

                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ghi nhớ đăng nhập</label>
                    </div>

                    <div class="form-actions">
                        <button class="btn-primary" type="submit">Đăng nhập</button>
                        <a class="btn-secondary" href="Trangchu.php?key=dangki">Đăng ký</a>
                    </div>
                </form>
                <p class="auth-note">Nếu quên mật khẩu, liên hệ admin để được hỗ trợ.</p>
            </div>
        </main>
    </body>
</html>