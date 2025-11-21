<?php
include 'function.php';
$db = new khachhang();

// Lấy dữ liệu từ process
$DanhMuc = $_GET['DanhMuc'] ?? '';
$danhsach = $_GET['danhsach'] ?? null;
$selectedBrand = $_GET['selectedBrand'] ?? array();
$minPrice = $_GET['minPrice'] ?? '';
$maxPrice = $_GET['maxPrice'] ?? '';
//lấy từ request trực tiếp
if ($danhsach === null) {
    $brands = $db->LayTatCaHang();
    $selectedBrand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : '';
    $maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : '';
    
    $selectedBrandArray = is_array($selectedBrand) ? $selectedBrand : ($selectedBrand ? array($selectedBrand) : array());
    $danhsach = $db->LayDanhSachSanPham($DanhMuc, $selectedBrandArray, $minPrice, $maxPrice);
} else {
    $brands = $db->LayTatCaHang();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="/bansach/style/styleuser.css">
    <link rel="icon" href="/bansach/favicon.ico">
</head>
<body>
    <main class="content1">
        <a href="/bansach/index/Trangchu.php" class="back-home">← Quay về trang chủ</a>
        <h2>Danh sách sản phẩm <?= htmlspecialchars($DanhMuc ? "- $DanhMuc" : "") ?></h2>
        <div class="filter-products-container">
            <div class="filter-sidebar">
                <div class="filter-options">
                    <h3>Bộ lọc</h3>
                    <form method="GET" action="process.php">
                        <input type="hidden" name="action" value="product-list">
                        <input type="hidden" name="DanhMuc" value="<?= htmlspecialchars($DanhMuc) ?>">
                        <div class="filter-section">
                            <h4>Nhà xuất bản</h4>
                            <?php foreach ($brands as $brand): ?>
                            <label>
                                <input type="checkbox" name="brand[]" value="<?= htmlspecialchars($brand) ?>"
                                    <?= (is_array($selectedBrand) && in_array($brand, $selectedBrand)) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($brand) ?>
                            </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="filter-section">
                            <h4>Khoảng giá</h4>
                            <div class="price-inputs">
                                <input type="number" name="minPrice" placeholder="Giá từ" 
                                    value="<?= htmlspecialchars($minPrice) ?>">
                                <input type="number" name="maxPrice" placeholder="Đến" 
                                    value="<?= htmlspecialchars($maxPrice) ?>">
                            </div>
                        </div>
                        <button class="btn" type="submit">Áp dụng</button>
                    </form>
                </div>
            </div>
            <div class="products-grid">
                <?php if (!empty($danhsach)): ?>
                    <?php foreach ($danhsach as $sp): ?>
                        <div class="product-card">
                            <?php if (!empty($sp['HinhAnh'])): ?>
                                <img src="<?= htmlspecialchars($sp['HinhAnh']) ?>" alt="<?= htmlspecialchars($sp['TenSP']) ?>">
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($sp['TenSP']) ?></h3>
                            <div class="product-info">
                                <p class="brand"><?= htmlspecialchars($sp['Hang']) ?></p>
                                <p class="price"><?= number_format($sp['Gia'], 0, ',', '.') ?> đ</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">
                        <p>Không có sản phẩm nào phù hợp.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
