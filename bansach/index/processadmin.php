<?php
include_once 'functionad.php';
$admin = new admin();
$msg = '';
// Xử lý GET action
$getAction = $_GET['action'] ?? '';
if ($getAction === 'logout') {
    $admin->DangXuatAdmin();
    exit();
}
// Xử lý POST form đăng nhập
if (isset($_POST['DienThoai']) && isset($_POST['MatKhau'])) { 
    $dienthoai = trim($_POST['DienThoai'] ?? '');
    $password = trim($_POST['MatKhau'] ?? '');
    $res = $admin->LoginAdmin($dienthoai, $password);
    if ($res === "Đăng nhập thành công!") {
        header('Location: Trangchuadmin.php');
        exit();
    } else {
        $msg = $res;
    }
}
// Xử lý action
$postAction = $_POST['action'] ?? '';
if ($postAction === 'add_product') {
    $res = $admin->ThemSach($_POST['idDM'], $_POST['TenSP'], $_POST['Gia'], $_POST['Hang'], $_POST['AnhSP']);
    header('Location: Trangchuadmin.php?key=sanpham&msg=' . urlencode($res === true ? "Thêm thành công" : $res));
    exit();
} elseif ($postAction === 'update_product') {
    $res = $admin->CapNhatSach($_POST['idSP'], $_POST['idDM'], $_POST['TenSP'], $_POST['Gia'], $_POST['Hang'], $_POST['AnhSP']);
    header('Location: Trangchuadmin.php?key=sanpham&msg=' . urlencode($res === true ? "Cập nhật thành công" : $res));
    exit();
}
if ($postAction === 'add_user') {
    $res = $admin->ThemNguoiDung($_POST['HoTen'], $_POST['Email'], $_POST['DienThoai'], $_POST['MatKhau']);
    header('Location: Trangchuadmin.php?key=khachhang&msg=' . urlencode($res === true ? "Thêm thành công" : $res));
    exit();
} elseif ($postAction === 'update_user') {
    $res = $admin->CapNhatNguoiDung($_POST['idKH'], $_POST['HoTen'], $_POST['Email'], $_POST['DienThoai'], $_POST['MatKhau']);
    header('Location: Trangchuadmin.php?key=khachhang&msg=' . urlencode($res === true ? "Cập nhật thành công" : $res));
    exit();
}
if ($postAction === 'update_order_status') {
    $res = $admin->CapNhatTrangThaiHoaDon($_POST['idHD'], $_POST['trangThai']);
    header('Location: Trangchuadmin.php?key=hoadon&msg=' . urlencode($res === true ? "Cập nhật thành công" : $res));
    exit();
}
header('Location: Trangchuadmin.php');
exit();
?>