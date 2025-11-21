<?php
include_once 'functionad.php';
$admin = new admin();
if (!$admin->KiemTraDangNhapAdmin()) {
    header('Location: Dangnhapadmin.php');
    exit();
}

$msg = '';
// xử lý POST thêm/sửa/xóa hiện có...
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'delete') {
        $id = trim($_POST['idSP']);
        $res = $admin->XoaSach($id);
        $msg = $res === true ? "Xóa thành công." : "Lỗi: $res";
    }
  }
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q !== '') {
    $products = $admin->TimKiemSachAdmin($q);
} else {
    $products = $admin->LayTatCaSach();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Quản lý sản phẩm</title>
  <link rel="stylesheet" href="/bansach/style/styleadmin.css">
  <link rel="icon" href="/bansach/favicon.ico">
</head>
<body class="admin-page">
  <div class="admin-panel">
    <h1>Quản lý sản phẩm</h1>
    <?php if($msg): ?><p><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
<div style="margin-bottom:12px;">
      <a class="btn" href="Trangchuadmin.php?key=sanpham">Danh sách</a>
      <a class="btn" href="Trangchuadmin.php?key=sanpham&action=show_add">Thêm sản phẩm</a>
    </div>
    <?php if (isset($_GET['action']) && $_GET['action'] === 'show_add'): ?>
      <?php include 'themsp.php'; ?>
    <?php endif; ?>
    <form method="get" style="margin-bottom:10px;">
      <input type="hidden" name="key" value="sanpham">
      <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" 
             placeholder="Tìm theo tên, id Danh mục hoặc hãng">
      <button type="submit">Tìm</button>
      <?php if ($q !== ''): ?>
        <a href="Trangchuadmin.php?key=sanpham">Xóa bộ lọc</a>
      <?php endif; ?>
    </form>
    <!-- bảng sản phẩm -->
    <table class="admin-table">
      <thead><tr><th>ID</th><th>Tên</th><th>id Danh mục</th><th>Giá</th><th>Hãng</th><th>Ảnh</th><th>Hành động</th></tr></thead>
      <tbody>
        <?php foreach ($products as $p): ?>
          <tr>
            <td><?php echo htmlspecialchars($p['idSP']); ?></td>
            <td><?php echo htmlspecialchars($p['TenSP']); ?></td>
            <td><?php echo htmlspecialchars($p['idDM']); ?></td>
            <td><?php echo htmlspecialchars($p['Gia']); ?></td>
            <td><?php echo htmlspecialchars($p['Hang']); ?></td>
            <td><?php echo '<img src="'.$p['AnhSP'].'" alt = "'.htmlspecialchars($p['TenSP']).'">'; ?></td>
            <td>
              <a href="Trangchuadmin.php?key=sanpham&edit=<?php echo urlencode($p['idSP']); ?>">Sửa</a>
              <form style="display:inline" method="post" onsubmit="return confirm('Xóa sản phẩm?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="idSP" value="<?php echo htmlspecialchars($p['idSP']); ?>">
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