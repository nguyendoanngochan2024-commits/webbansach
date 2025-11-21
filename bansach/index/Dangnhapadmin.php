<?php
include_once 'functionad.php';
$admin = new admin();
$msg = '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Đăng nhập Admin</title>
  <link rel="stylesheet" href="/bansach/style/styleadmin.css">
  <link rel="icon" href="/bansach/favicon.ico">
</head>
<body class="login-page">
  <div class="login-box">
    <h2>Đăng nhập quản trị</h2>
    <?php if ($msg): ?><p style="color:red; text-align:center;"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <form method="post" action="processadmin.php">
      <div class="form-group">
        <label for="DienThoai">Số điện thoại</label>
        <input type="int" id="DienThoai" name="DienThoai" required>
      </div>
      <div class="form-group">
        <label for="MatKhau">Mật khẩu</label>
        <input type="password" id="MatKhau" name="MatKhau" required>
      </div>
      <button class="btn-login" type="submit">Đăng nhập</button>
    </form>
  </div>
</body>
</html>