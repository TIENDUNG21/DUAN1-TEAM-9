<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả sản phẩm</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/index.css">
</head>
<body>
    <?php include __DIR__ . '/../share/header.php'; ?>
    <?php include __DIR__ . '/../share/nav.php'; ?>

    <main>
        <div class="container">
            <h2>Tất cả sản phẩm</h2>
            <div class="hot-product-grid">
                <?php if (empty($products)): ?>
                    <p>Không có sản phẩm nào để hiển thị.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="/public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                            <div class="sale-title">
                                <?php if ($product['is_on_sale'] && $product['old_price']): ?>
                                    <div class="sale-badge">-<?php echo round((($product['old_price'] - $product['price']) / $product['old_price']) * 100); ?>%</div>
                                <?php endif; ?>
                                <h3 class="name-brand"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="brand"><?php echo htmlspecialchars($product['color'] ?? 'N/A'); ?></p>
                                <div class="total-price">
                                    <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</p>
                                    <?php if ($product['is_on_sale'] && $product['old_price']): ?>
                                        <p class="old-price"><?php echo number_format($product['old_price'], 0, ',', '.'); ?>đ</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="add-see">
                                <?php
                                $totalStock = array_sum(array_column($product['variants'] ?? [], 'stock'));
                                ?>
                                <?php if ($totalStock > 0): ?>
                                    <a href="/cart/add/<?php echo $product['product_id']; ?>">
                                        <button class="add-to-cart">
                                            <span class="material-symbols-outlined">shopping_cart</span>Add to cart
                                        </button>
                                    </a>
                                    <a href="/product/show/<?php echo $product['product_id']; ?>">
                                        <button class="see-detail">
                                            <span class="material-symbols-outlined">visibility</span>See detail
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <p class="out-of-stock">
                                        <span class="material-symbols-outlined">shopping_cart_off</span>Sold out
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../share/footer.php'; ?>
    <script src="/public/js/slideshow.js"></script>
</body>
</html>