<?php
if (!isset($db)) {
	include_once 'function.php';
	$db = new khachhang();
}

$id = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($id === '') {
	echo '<p>Sản phẩm không hợp lệ.</p>';
	return;
}

$product = $db->LaySanPhamTheoID($id);
if (!$product) {
	echo '<p>Không tìm thấy sản phẩm.</p>';
	return;
}

// Nếu trường mô tả không tồn tại, hiển thị placeholder
$description = '';
if (isset($product['MoTa'])) {
	$description = $product['MoTa'];
}

?>

<div class="product-detail-page">
	<a href="Trangchu.php?key=category&category=<?php echo urlencode($product['idDM']); ?>">&larr; Quay lại danh mục</a>

	<div class="product-detail">
		<div class="detail-left">
			<?php if (!empty($product['AnhSP'])): ?>
				<img src="<?php echo htmlspecialchars($product['AnhSP']); ?>" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
			<?php else: ?>
				<div class="placeholder-img">Không có ảnh</div>
			<?php endif; ?>
		</div>
		<div class="detail-right">
			<h1><?php echo htmlspecialchars($product['TenSP']); ?></h1>
			<p class="meta">Danh mục: <?php echo htmlspecialchars($product['TenDM'] ?? ''); ?></p>
			<p class="meta">Nhà xuất bản / Hãng: <?php echo htmlspecialchars($product['Hang']); ?></p>
			<p class="price"><?php echo number_format($product['Gia'], 0, ',', '.'); ?> ₫</p>

			<?php if ($description !== ''): ?>
				<div class="description">
					<?php echo nl2br(htmlspecialchars($description)); ?>
				</div>
			<?php else: ?>
				<div class="description">
					<p>Chưa có mô tả cho sản phẩm này.</p>
				</div>
			<?php endif; ?>

			<div class="actions">
				<a href="process.php?action=add-to-cart&id=<?php echo urlencode($product['idSP']); ?>" class="add-to-cart">Thêm vào giỏ</a>
			</div>
		</div>
	</div>
</div>

<style>
.product-detail-page { padding: 20px; }
.product-detail { display: flex; gap: 30px; align-items: flex-start; }
.detail-left { flex: 0 0 420px; max-width: 420px; }
.detail-left img { width: 100%; height: auto; border-radius: 8px; object-fit: cover; }
.detail-right { flex: 1 1 auto; min-width: 0; }
.detail-right h1 { margin-top: 0; font-size: 1.6em; }
.meta { color: #666; margin: 6px 0; }
.price { color: #e41e31; font-weight: bold; font-size: 1.4em; margin: 12px 0; }
.description { margin-top: 12px; background:#fff; padding:12px; border-radius:6px; border:1px solid #eee; }
.actions { margin-top: 16px; }
.placeholder-img { width:100%; height:420px; display:flex; align-items:center; justify-content:center; background:#f3f4f6; color:#888; border-radius:8px; }
@media (max-width:800px) {
	.product-detail { flex-direction: column; }
	.detail-left { flex: none; max-width: 100%; }
}
</style>
