<?php
include_once 'functionad.php';
$admin = new admin();
if (!$admin->KiemTraDangNhapAdmin()) {
    header('Location: Dangnhapadmin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Admin - Dashboard</title>
  <link rel="stylesheet" href="/bansach/style/styleadmin.css">
  <link rel="icon" href="/bansach/favicon.ico">
</head>
<body class="admin-page">
  <div class="admin-panel">
    <h1>Trang quản trị</h1>
    <div class="admin-actions">
      <a class="admin-card" href="Trangchuadmin.php?key=sanpham">Quản lý sản phẩm</a>
      <a class="admin-card" href="Trangchuadmin.php?key=khachhang">Quản lý khách hàng</a>
      <a class="admin-card" href="Trangchuadmin.php?key=danhmuc">Quản lý danh mục</a>
      <a class="admin-card" href="Trangchuadmin.php?key=hoadon">Quản lý hóa đơn</a>
      <a class="admin-card" href="processadmin.php?action=logout">Đăng xuất</a>
    </div>
    <div class="admin-content">
      <?php
      $key = isset($_GET['key']) ? $_GET['key'] : 'home';
      switch ($_GET['key'] ?? '') {
          case 'sanpham':
              if (isset($_GET['action']) && $_GET['action'] === 'show_add') {
                  include_once 'themsp.php';
              } elseif (isset($_GET['edit'])) {
                  include_once 'suasp.php';
              } else {
                  include_once 'adminsp.php';
              }
              break;
          case 'khachhang':
              if (isset($_GET['action']) && $_GET['action'] === 'show_add') {
                  include_once 'themkh.php';
              } elseif (isset($_GET['edit'])) {
                  include_once 'suakh.php';
              } else {
                  include_once 'adminkh.php';
              }
              break;
          case 'hoadon':
              if (isset($_GET['edit'])) {
                  include_once 'adminhd.php';
              } else {
                  include_once 'adminhd.php';
              }
              break;
          case 'danhmuc':
              if (isset($_GET['action']) && $_GET['action'] === 'show_add') {
                  include_once 'themdm.php';
              } elseif (isset($_GET['edit'])) {
                  include_once 'suadm.php';
              } else {
                  include_once 'admindm.php';
              }
              break;
          case 'dangnhap':
              include_once 'Dangnhapadmin.php';
              break;    
          default:
              echo '<p>Chào mừng đến với trang quản trị.</p>';
              break;
      }
      ?>
  </div>
</body>
</html>