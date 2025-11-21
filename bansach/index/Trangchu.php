<?php
// chọn đường dẫn CSS/fav phù hợp tuỳ môi trường
$docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
$absCssPath = $docRoot . '/bansach/style/styleuser.css';
$absFavPath = $docRoot . '/bansach/favicon.ico';

// Nếu file tồn tại trong webroot/bansach/style thì dùng đường dẫn tuyệt đối /bansach/...
if (file_exists($absCssPath)) {
    $cssHref = '/bansach/style/styleuser.css';
    $favHref = '/bansach/favicon.ico';
} else {
    // ngược lại dùng đường dẫn tương đối từ index/ lên 1 cấp (Live Server)
    $cssHref = '../style/styleuser.css';
    $favHref = '../favicon.ico';
}
session_start();
include_once 'function.php';
$db = new khachhang();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang Chủ</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?php echo htmlspecialchars($cssHref, ENT_QUOTES); ?>">
  <link rel="icon" href="<?php echo htmlspecialchars($favHref, ENT_QUOTES); ?>">
</head>
<body>
  <header class="site-header">
    <div id="menu-trangchu" class="top-actions"><a class="icon1" href="Trangchu.php?" title="Trang chủ">
        <img src="../icon/book-open-cover.png" alt="Trang chủ"></a>ONLINE BOOK STORE </div>
    <nav id="menu-trangchu" class="top-actions" aria-label="Menu trang chủ">
      <a class="icon1" href="Trangchu.php?key=user" title="Trang khách hàng">
        <img src="../icon/user.jpg" alt="Người dùng">
      </a>
      <a class="icon1" href="Trangchu.php?key=giohang" title="Giỏ hàng">
        <img src="../icon/shopping-cart.jpg" alt="Mua hàng">
      </a>
      <a class="icon1" href="Trangchu.php?key=hoadon" title="Hóa đơn">
        <img src="../icon/order-history.png" alt="Hóa đơn">
      </a>
      <?php if (isset($_SESSION['HoTen'])): ?>
        <a class="icon1" href="process.php?action=logout" title="Đăng xuất">
          <img src="../icon/exit.png" alt="Đăng xuất">
        </a>
      <?php else: ?>
        <a class="icon1" href="Trangchu.php?key=dangnhap" title="Đăng nhập">
          <img src="../icon/sign-in-alt.png" alt="Đăng nhập">
        </a>
        <a class="icon1" href="Trangchu.php?key=dangki" title="Đăng ký">
        <img src="../icon/user-add.png" alt="Đăng ký">
      </a>
      <?php endif; ?>
    </nav>
  </header>
  <main class="content1">
    <?php if (isset($_GET['key']) && $_GET['key'] !== 'Trangchu'): ?>
      <a class="back-home" href="Trangchu.php">&larr; Quay về Trang chủ</a>
    <?php endif; ?>
    <div class="card">
          <?php if (isset($_SESSION['HoTen']) && !isset($_GET['key'])): ?>
      <div class="welcome-message">
        <h2>Xin chào, <?php echo htmlspecialchars($_SESSION['HoTen']); ?>!</h2>
              <h2>Chào mừng bạn đến với cửa hàng sách trực tuyến</h2>
      </div>
    <?php endif; ?>
      <?php
      $key = isset($_GET['key']) ? $_GET['key'] : 'Trangchu';
      switch ($_GET['key'] ?? '') {
          case 'user':
              include 'user.php';
              break;
          case 'giohang':
              include 'giohang.php';
              break;
          case 'dangki':
              include 'Dangki.php';
              break;
          case 'dangnhap':
              include 'Dangnhap.php';
              break;
          case 'category':
              include 'danhsachtheodanhmuc.php';
              break;
              case 'chitietsp':
              include 'chitietsp.php';
              break;
          case 'updatepf':
              include 'updateprofile.php';
              break;
          case 'xacnhandon':
              include 'xacnhandonhang.php';
              break;
          case 'hoadon':
              include 'hoadon.php';
              break;
          case 'chitiethoadon':
              include 'chitiethoadon.php';
              break;
      }
      ?>
    </div>
    <?php if ($key === 'Trangchu' || $key === '' ): ?>
    <div class="card">
      <h2>Danh mục sản phẩm</h2>
      <div class="category-grid">
        <?php
        $categories = $db->LayDanhMuc();
        foreach ($categories as $cat): 
        ?>
          <a href="Trangchu.php?key=category&category=<?php echo urlencode($cat['idDM']); ?>" 
             class="category-item">
            <span class="category-name"><?php echo htmlspecialchars($cat['TenDM']); ?></span>
            <span class="item-count"><?php echo $cat['SoLuong'] ?: 0; ?> sản phẩm</span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </main>
</body>
  <footer class="site-footer">
    <div class="footer-content">
      <div class="footer-left">&copy; <?php echo date('Y'); ?> BánSách. All rights reserved.</div>
      <div class="footer-right">
        <a href="Trangchu.php?key=policy">Chính sách</a>
        <span class="sep">·</span>
        <a href="Trangchu.php?key=contact">Liên hệ</a>
      </div>
    </div>
  </footer>
  </html>
