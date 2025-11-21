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
        $id = trim($_POST['idKH']);
        $res = $admin->XoaNguoiDung($id);
        $msg = $res === true ? "Xóa thành công." : "Lỗi: $res";
    }
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q !== '') {
    $users = $admin->TimKiemNguoiDung($q);
} else {
    $users = $admin->LayTatCaNguoiDung();
}

$editUser = null;
if (isset($_GET['edit'])) {
    $id = trim($_GET['edit']);
    foreach ($users as $u) {
        if (isset($u['idKH']) && $u['idKH'] === $id) { $editUser = $u; break; }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Quản lý khách hàng</title>
  <link rel="stylesheet" href="/bansach/style/styleadmin.css">
  <link rel="icon" href="/bansach/favicon.ico">
</head>
<body class="admin-page">
  <div class="admin-panel">
    <h1>Quản lý khách hàng</h1>
    <?php if($msg): ?><p><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>

    <div style="margin-bottom:12px;">
      <a class="btn" href="Trangchuadmin.php?key=khachhang">Danh sách</a>
      <a class="btn" href="Trangchuadmin.php?key=khachhang&action=show_add">Thêm khách hàng</a>
    </div>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'show_add'): ?>
      <?php include 'themkh.php'; ?>
    <?php endif; ?>

    <?php if ($editUser): ?>
      <?php include 'suakh.php'; ?>
    <?php endif; ?>

    <!-- danh sách người dùng -->
    <table class="admin-table">
      <thead><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Điện thoại</th><th>Hành động</th></tr></thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?php echo htmlspecialchars($u['idKH']); ?></td>
            <td><?php echo htmlspecialchars($u['HoTen']); ?></td>
            <td><?php echo htmlspecialchars($u['Email']); ?></td>
            <td><?php echo htmlspecialchars($u['DienThoai']); ?></td>
            <td>
              <a href="Trangchuadmin.php?key=khachhang&edit=<?php echo urlencode($u['idKH']); ?>">Sửa</a>
              <form style="display:inline" method="post" onsubmit="return confirm('Xóa người dùng?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="idKH" value="<?php echo htmlspecialchars($u['idKH']); ?>">
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