<?php
$db->ensureSessionStarted();
$message = "";

if (isset($_POST['HoTen']) && isset($_POST['DienThoai']) && isset($_POST['MatKhau'])) {
    $HoTen = $_POST['HoTen'];
    $DienThoai = $_POST['DienThoai'];
    $MatKhau = md5($_POST['MatKhau']);

    $message = $db->CapNhatThongTinKH($HoTen, $DienThoai, $MatKhau);
}
// Lấy lại dữ liệu hiện tại
$user = $db->LayThongTinKH($_SESSION['Email']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật thông tin cá nhân</title>
    <link rel="stylesheet" href="/bansach/style/styleuser.css">
    <link rel="icon" href="/bansach/favicon.ico">
</head>
<body>
    <h2>Cập nhật hồ sơ</h2>
    <form method="POST">
        Họ tên: <input type="text" name="HoTen" value="<?= $user['HoTen'] ?? '' ?>"><br><br>
        Điện thoại: <input type="text" name="DienThoai" value="<?= $user['DienThoai'] ?? '' ?>"><br><br>
        Mật khẩu: <input type="password" name="MatKhau" value="<?= $user['MatKhau'] ?? '' ?>"><br><br>
        <button type="submit">Cập nhật</button>
    </form>
    <p style="color:blue;"><?= $message ?></p>
</body>
</html>
