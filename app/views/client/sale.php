<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm đang giảm giá</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/index.css">
    <style>
        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .products-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
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
        .product-card .price {
            color: #e74c3c;
            font-weight: bold;
        }
        .product-card .original-price {
            color: #999;
            text-decoration: line-through;
            font-size: 0.9rem;
        }
        .product-card .discount {
            color: #2ecc71;
            font-size: 0.9rem;
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
            <h2>Sản phẩm đang giảm giá</h2>
            <?php if (empty($products)): ?>
                <p>Không có sản phẩm nào đang giảm giá.</p>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="/public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                            <p class="original-price"><?php echo number_format($product['old_price'], 0, ',', '.'); ?> VNĐ</p>
                           
                            <div class="sale-badge">-<?php echo round((($product['old_price'] - $product['price']) / $product['old_price']) * 100); ?>%</div>

                            <a href="/index.php?action=show&id=<?php echo $product['product_id']; ?>" class="btn">Xem chi tiết</a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Phân trang -->
                <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="/index.php?action=sale&page=<?php echo $currentPage - 1; ?>">« Trước</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="/index.php?action=sale&page=<?php echo $i; ?>" class="<?php echo $i === $currentPage ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="/index.php?action=sale&page=<?php echo $currentPage + 1; ?>">Tiếp »</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <div class="out">
            <div class="about">
                <h4>GIỚI THIỆU</h4>
                <div class="line2"></div>
                <p>Hộ kinh doanh Be YourSelf GPKD số 41A8049969 cấp ngày 30/3/2022 tại Sở kế hoạch và đầu tư Tp. HCM</p>
                <p>Địa chỉ: 120 Trần Hưng Đạo, Phường Phạm Ngũ Lão, Quận 1, Tp. Hồ Chí Minh</p>
                <p>Phone: <span>0933597986</span></p>
                <p>Email: <span>ShopTuBoy@gmail.com</span></p>
            </div>
            <div class="chinhsach">
                <h4>Chính sách hỗ trợ</h4>
                <div class="line2"></div>
                <p>Chính sách đổi trả</p>
                <p>Chính sách bảo mật</p>
                <p>Hướng dẫn thanh toán</p>
                <p>Chính sách kiểm hàng</p>
                <p>Chính sách vận chuyển</p>
            </div>
        </div>
    </footer>
</body>
</html>