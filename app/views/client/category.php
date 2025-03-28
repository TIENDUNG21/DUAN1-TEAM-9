<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm theo danh mục</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/index.css">
    <style>
        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-card img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product-card h3 {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        .product-card p {
            color: #e74c3c;
            font-weight: bold;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .pagination a:hover:not(.active) {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../share/header.php'; ?>
    <?php include __DIR__ . '/../share/nav.php'; ?>
    <main>
        <div class="products-container">
            <h2>Sản phẩm trong danh mục: <?php echo htmlspecialchars($products[0]['category_name'] ?? 'Không xác định'); ?></h2>
            <?php if (empty($products)): ?>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="/public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                            <a href="/index.php?action=show&id=<?php echo $product['product_id']; ?>" class="btn">Xem chi tiết</a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Phân trang -->
                <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="/index.php?action=category&category_id=<?php echo $categoryId; ?>&page=<?php echo $currentPage - 1; ?>">&laquo; Trước</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="/index.php?action=category&category_id=<?php echo $categoryId; ?>&page=<?php echo $i; ?>" class="<?php echo $i === $currentPage ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="/index.php?action=category&category_id=<?php echo $categoryId; ?>&page=<?php echo $currentPage + 1; ?>">Tiếp &raquo;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__. '/../share/footer.php';?>
</body>
</html>