<?php
if (!isset($db)) {
    include_once 'function.php';
    $db = new khachhang();
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$products = $db->LayDanhSachSanPham($category);
// Lấy tên danh mục từ sản phẩm đầu tiên (đã join với bảng danhmuc)
$categoryName = '';
if (!empty($products)) {
    $categoryName = $products[0]['TenDM'];
}
// biến lưu các tùy chọn lọc
$brands = [];
$minPrice = null;
$maxPrice = null;
foreach ($products as $p) {
    $brands[$p['Hang']] = true;
    $price = floatval($p['Gia']);
    if ($minPrice === null || $price < $minPrice) $minPrice = $price;
    if ($maxPrice === null || $price > $maxPrice) $maxPrice = $price;
}
$brands = array_keys($brands);
// đọc điều kiện lọc
$selectedBrands = isset($_GET['brand']) ? (array)$_GET['brand'] : [];
$priceMin = isset($_GET['price_min']) && $_GET['price_min'] !== '' ? floatval($_GET['price_min']) : null;
$priceMax = isset($_GET['price_max']) && $_GET['price_max'] !== '' ? floatval($_GET['price_max']) : null;
// lọc sản phẩm dựa trên bộ lọc
$filtered = [];
foreach ($products as $p) {
    if (!empty($selectedBrands) && !in_array($p['Hang'], $selectedBrands)) continue;
    $price = floatval($p['Gia']);
    if ($priceMin !== null && $price < $priceMin) continue;
    if ($priceMax !== null && $price > $priceMax) continue;
    $filtered[] = $p;
}
// nếu không có bộ lọc nào được áp dụng, hiển thị tất cả
$displayProducts = !empty($filtered) ? $filtered : $products;
?>
<link rel="stylesheet" href="/bansach/style/styleuser.css">
<div class="products-page">
    <aside class="filters">
        <form method="get" id="filterForm">
            <input type="hidden" name="key" value="category">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <div class="filter-card">
                <h3>Filter Options</h3>
                <div class="filter-group">
                    <label>Brands</label>
                    <?php foreach ($brands as $b): ?>
                        <div>
                            <label>
                                <input type="checkbox" name="brand[]" value="<?php echo htmlspecialchars($b); ?>" <?php echo in_array($b, $selectedBrands) ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($b); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="filter-group">
                    <label>Price range</label>
                    <div>
                        <input type="number" name="price_min" placeholder="Min" value="<?php echo $priceMin !== null ? htmlspecialchars($priceMin) : ''; ?>">
                        <input type="number" name="price_max" placeholder="Max" value="<?php echo $priceMax !== null ? htmlspecialchars($priceMax) : ''; ?>">
                    </div>
                </div>
                <div style="margin-top:10px;">
                    <button type="submit" class="btn">Apply</button>
                    <a class="btn" href="Trangchu.php?key=category&category=<?php echo urlencode($category); ?>">Reset</a>
                </div>
            </div>
        </form>
    </aside>

    <div class="product-container">
        <h2><?php echo $categoryName ? htmlspecialchars($categoryName) : 'Tất cả sản phẩm'; ?></h2>
        <div class="product-grid">
            <?php if (empty($displayProducts)): ?>
                <p>Không có sản phẩm phù hợp với bộ lọc.</p>
            <?php else: ?>
                <?php foreach ($displayProducts as $product): ?>
                    <div class="product-card">
                        <a class="product-link" href="Trangchu.php?key=chitietsp&id=<?php echo urlencode($product['idSP']); ?>">
                            <img src="<?php echo htmlspecialchars($product['AnhSP']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['TenSP']); ?></h3>
                                <p class="price"><?php echo number_format($product['Gia'], 0, ',', '.'); ?> ₫</p>
                                <p class="brand"><?php echo htmlspecialchars($product['Hang']); ?></p>
                            </div>
                        </a>
                        <a href="process.php?action=add-to-cart&id=<?php echo urlencode($product['idSP']); ?>" 
                           class="add-to-cart">
                            Thêm vào giỏ
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
