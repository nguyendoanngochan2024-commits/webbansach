<?php
session_start();

// Auto-login từ cookie (nếu có)
if (isset($_COOKIE['email'])) {
    $_SESSION['Email'] = $_COOKIE['email'];
    $_SESSION['HoTen'] = $_COOKIE['hoten'];
    header('Location: Trangchu.php');
    exit();
}

include_once 'function.php';
$db = new khachhang();
$msg = '';

// Xử lý các action từ GET request
$getAction = $_GET['action'] ?? '';
switch ($getAction) {
    case 'logout':
        $db->DangXuat();
        exit();
        break;

    case 'product-list':
        // Xử lý danh sách sản phẩm theo danh mục
        $DanhMuc = $_GET['DanhMuc'] ?? '';
        $selectedBrand = isset($_GET['brand']) ? $_GET['brand'] : '';
        $minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : '';
        $maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : '';
        
        // Xử lý selectedBrand từ checkbox array
        $selectedBrandArray = is_array($selectedBrand) ? $selectedBrand : ($selectedBrand ? array($selectedBrand) : array());
        $danhsach = $db->LayDanhSachSanPham($DanhMuc, $selectedBrandArray, $minPrice, $maxPrice);
        
        // Truyền dữ liệu sang view
        $_GET['DanhMuc'] = $DanhMuc;
        $_GET['selectedBrand'] = $selectedBrandArray;
        $_GET['minPrice'] = $minPrice;
        $_GET['maxPrice'] = $maxPrice;
        $_GET['danhsach'] = $danhsach;
        include 'danhsachsptheodanhmuc.php';
        exit();
        break;
    case 'add-to-cart':
        if (!isset($_GET['id'])) {
            header("Location: Trangchu.php?key=giohang&msg=" . urlencode("Thiếu thông tin sản phẩm"));
            exit();
        }
        if (!$db->KiemTraDangNhap()) {
            $_SESSION['redirect_after_login'] = "process.php?action=add-to-cart&id=" . $_GET['id'];
            header("Location: Trangchu.php?key=dangnhap&msg=" . urlencode("Vui lòng đăng nhập để thêm vào giỏ hàng"));
            exit();
        }
        error_log("Adding to cart: ID=" . $_GET['id']);
        $result = $db->ThemVaoGioHang($_GET['id']);
        error_log("Add to cart result: " . $result);
        header("Location: Trangchu.php?key=giohang&msg=" . urlencode($result));
        exit();
        break;
    case 'update-cart':
        if (!$db->KiemTraDangNhap()) {
            header("Location: Trangchu.php?key=dangnhap");
            exit();
        }
        if (!isset($_POST['idSP']) || !isset($_POST['quantity'])) {
            header("Location: Trangchu.php?key=giohang&msg=" . urlencode("Thiếu thông tin cập nhật"));
            exit();
        }
        $result = $db->CapNhatSoLuong($_POST['idSP'], intval($_POST['quantity']));
        header("Location: Trangchu.php?key=giohang&msg=" . urlencode($result));
        exit();
        break;
    case 'checkout':
        if (!$db->KiemTraDangNhap()) {
            header("Location: Trangchu.php?key=dangnhap");
            exit();
        }
        if (!isset($_POST['address']) || empty($_POST['address'])) {
            header("Location: Trangchu.php?key=giohang&msg=" . urlencode("Vui lòng nhập địa chỉ nhận hàng"));
            exit();
        }
        $diaChi = $_POST['address'];
        $ghiChu = $_POST['note'] ?? '';
        $result = $db->TaoHoaDon($diaChi, $ghiChu);
        if (strpos($result, "thành công") !== false) {
            $idHD = substr($result, strrpos($result, ":") + 2);
            header("Location: Trangchu.php?key=chitiethoadon&id=" . urlencode($idHD));
        } else {
            header("Location: Trangchu.php?key=giohang&msg=" . urlencode($result));
        }
        exit();
        break;
    case 'cancel_order':
        if (!isset($_GET['id'])) {
            header("Location: Trangchu.php?key=hoadon&msg=" . urlencode("Thiếu mã đơn hàng"));
            exit();
        }
        if (!$db->KiemTraDangNhap()) {
            header("Location: Trangchu.php?key=dangnhap");
            exit();
        }
        $idHD = $_GET['id'];
        $res = $db->HuyHoaDon($idHD);
        // Chuyển hướng về trang chi tiết đơn hàng (hoặc danh sách nếu cần)
        header("Location: Trangchu.php?key=chitiethoadon&id=" . urlencode($idHD) . "&msg=" . urlencode($res));
        exit();
        break;
}
// Xử lý các action từ POST request
$postAction = $_POST['action'] ?? '';
if ($postAction === 'dangki') {
    $HoTen = trim($_POST['HoTen'] ?? '');
    $Email = trim($_POST['Email'] ?? '');
    $DienThoai = trim($_POST['DienThoai'] ?? '');
    $MatKhau = md5($_POST['MatKhau'] ?? '');
    $res = $db->DangKy($HoTen, $Email, $DienThoai, $MatKhau);
    $_SESSION['flash_msg'] = $res;
    if (strpos($res, 'Đăng ký thành công') !== false) {
        header('Location: Trangchu.php?key=dangnhap');
        exit();
    } else {
        header('Location: Dangki.php');
        exit();
    }
} elseif ($postAction === 'login' || (isset($_POST['Email']) && isset($_POST['MatKhau']))) {
    $email = trim($_POST['Email'] ?? '');
    $password = trim(md5($_POST['MatKhau'] ?? '') ?? '');
    $remember = isset($_POST['remember']);
    $res = $db->DangNhap($email, $password, $remember);
    if ($res === "Đăng nhập thành công!") {
        header('Location: Trangchu.php');
        exit();
    } else {
        $_SESSION['flash_msg'] = $res;
        header('Location: Trangchu.php?key=dangnhap');
        exit();
    }
}
?>