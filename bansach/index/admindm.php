<?php
include_once 'functionad.php';
$admin = new admin();
if (!$admin->KiemTraDangNhapAdmin()) {
    header('Location: Dangnhapadmin.php');
    exit();
}

$msg = '';
// Xử lý POST xóa danh mục
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'delete') {
        $id = trim($_POST['idDM']);
        $res = $admin->XoaDanhMuc($id);
        $msg = $res === true ? "Xóa thành công." : "Lỗi: $res";
    }
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q !== '') {
    $categories = $admin->TimKiemDanhMucAdmin($q);
} else {
    $categories = $admin->LayTatCaDanhMuc();
}
?>
<div class="admin-panel">
    <h1>Quản lý danh mục</h1>
    <?php if($msg): ?><p><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <div style="margin-bottom:12px;">
        <a class="btn" href="Trangchuadmin.php?key=danhmuc">Danh sách</a>
        <a class="btn" href="Trangchuadmin.php?key=danhmuc&action=show_add">Thêm danh mục</a>
    </div>
    <form method="get" style="margin-bottom:10px;">
        <input type="hidden" name="key" value="danhmuc">
        <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" 
               placeholder="Tìm theo ID hoặc tên danh mục">
        <button type="submit">Tìm</button>
        <?php if ($q !== ''): ?>
            <a href="Trangchuadmin.php?key=danhmuc">Xóa bộ lọc</a>
        <?php endif; ?>
    </form>
    <!-- Bảng danh mục -->
    <table class="admin-table">
        <thead><tr><th>ID</th><th>Tên danh mục</th><th>Hành động</th></tr></thead>
        <tbody>
            <?php foreach ($categories as $dm): ?>
                <tr>
                    <td><?php echo htmlspecialchars($dm['idDM']); ?></td>
                    <td><?php echo htmlspecialchars($dm['TenDM']); ?></td>
                    <td>
                        <a href="Trangchuadmin.php?key=danhmuc&edit=<?php echo urlencode($dm['idDM']); ?>">Sửa</a>
                        <form style="display:inline" method="post" onsubmit="return confirm('Xóa danh mục?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="idDM" value="<?php echo htmlspecialchars($dm['idDM']); ?>">
                            <button type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
