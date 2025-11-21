<?php
include_once 'functionad.php';
$admin = new admin();
if (!$admin->KiemTraDangNhapAdmin()) {
    header('Location: Dangnhapadmin.php');
    exit();
}

$msg = '';
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'delete') {
        $id = trim($_POST['idHD']);
        $res = $admin->XoaHoaDon($id);
        $msg = $res === true ? "Xóa thành công." : "Lỗi: $res";
    }
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$orders = $q !== '' ? $admin->TimKiemHoaDonAdmin($q) : $admin->LayTatCaHoaDon();

$editOrder = null;
if (isset($_GET['edit'])) {
    $id = trim($_GET['edit']);
    foreach ($orders as $o) {
        if (isset($o['idHD']) && $o['idHD'] === $id) { $editOrder = $o; break; }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Quản lý hóa đơn</title>
  <link rel="stylesheet" href="/bansach/style/styleadmin.css">
  <link rel="icon" href="/bansach/favicon.ico">
</head>
<body class="admin-page">
  <div class="admin-panel">
    <h1>Quản lý hóa đơn</h1>
    <?php if($msg): ?><p><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>

    <div style="margin-bottom:12px;">
      <a class="btn" href="Trangchuadmin.php?key=hoadon">Danh sách</a>
    </div>

    <?php if ($editOrder): ?>
      <?php include 'suahd.php'; ?>
    <?php endif; ?>

    <!-- Tìm kiếm -->
    <form method="get" style="margin-bottom:10px;">
      <input type="hidden" name="key" value="hoadon">
      <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" 
             placeholder="Tìm theo mã hóa đơn, tên khách hàng hoặc email">
      <button type="submit">Tìm</button>
      <?php if ($q !== ''): ?>
        <a href="Trangchuadmin.php?key=hoadon">Xóa bộ lọc</a>
      <?php endif; ?>
    </form>

    <!-- Bảng hóa đơn -->
    <table class="admin-table">
      <thead>
        <tr>
          <th>Mã HĐ</th>
          <th>Khách hàng</th>
          <th>Email</th>
          <th>Trạng thái</th>
          <th>Địa chỉ</th>
          <th>Ngày tạo</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $o): ?>
          <tr>
            <td><?php echo htmlspecialchars($o['idHD']); ?></td>
            <td><?php echo htmlspecialchars($o['HoTen']); ?></td>
            <td><?php echo htmlspecialchars($o['Email']); ?></td>
            <td><?php echo htmlspecialchars($o['TrangThai']); ?></td>
            <td><?php echo htmlspecialchars(substr($o['DiaChiNhanHang'], 0, 30)) . (strlen($o['DiaChiNhanHang']) > 30 ? '...' : ''); ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($o['NgayTao'])); ?></td>
            <td>
              <a href="Trangchuadmin.php?key=hoadon&edit=<?php echo urlencode($o['idHD']); ?>">Sửa</a>
              <form style="display:inline" method="post" onsubmit="return confirm('Xóa hóa đơn?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="idHD" value="<?php echo htmlspecialchars($o['idHD']); ?>">
                <button type="submit">Xóa</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
