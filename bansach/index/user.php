<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Khách Hàng</title>
    <link rel="stylesheet" href="/bansach/style/styleuser.css">
    <link rel="icon" href="/bansach/favicon.ico">
</head>
<body>
    <?php
    include_once 'function.php';
    $db = new khachhang();
    if (!$db->KiemTraDangNhap()) {
    echo "Bạn cần <a href='Trangchu.php?key=dangnhap'>đăng nhập<a> trước";
    exit();
}
    ?>
    <head>
        <div id="menu-user">
            <a class="back-home" href="Trangchu.php?key=updatepf">Cập Nhật Hồ Sơ</a>
            <a class="back-home" href="process.php?action=logout">Đăng Xuất</a>
        </div>
    </head>
    <main>
        
    </main>