<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
        body { height: 100vh; }
        .sidebar { width: 250px; height: 100%; background-color: black; padding-top: 20px; }
        .sidebar a { color: white; text-decoration: none; padding: 12px 20px; display: flex; align-items: center; }
        .sidebar a ion-icon { font-size: 22px; margin-right: 10px; }
        .sidebar a:hover { background-color: #333; }
    </style>
</head>
<body class="d-flex">
    <div class="sidebar d-flex flex-column">
        <a href="/index.php?action=dashboard"><ion-icon name="home-outline"></ion-icon> Home</a>
        <a href="/index.php?action=products"><ion-icon name="cube-outline"></ion-icon> Sản Phẩm</a>
        <a href="/index.php?action=categories"><ion-icon name="list-outline"></ion-icon> Danh Mục</a>
        <a href="/index.php?action=orders"><ion-icon name="cart-outline"></ion-icon> Đơn Hàng</a>
        <a href="/index.php?action=users"><ion-icon name="person-outline"></ion-icon> Khách Hàng</a>
        <a href="/index.php?action=reports"><ion-icon name="bar-chart-outline"></ion-icon> Thống Kê</a>
        <a href="/logout"><ion-icon name="log-out-outline"></ion-icon> Thoát Admin</a>
    </div>

    <div class="flex-grow-1 p-4">
        <h2>Sửa Sản phẩm</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="old_price" class="form-label">Giá cũ (nếu có)</label>
                <input type="number" class="form-control" id="old_price" name="old_price" value="<?php echo $product['old_price']; ?>">
            </div>
            <div class="mb-3">
                <label for="is_on_sale" class="form-label">Giảm giá</label>
                <input type="checkbox" id="is_on_sale" name="is_on_sale" <?php echo $product['is_on_sale'] ? 'checked' : ''; ?>>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <img src="/public/images/<?php echo $product['image']; ?>" width="100" class="mt-2">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $product['category_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h4>Biến thể sản phẩm</h4>
            <?php if (!empty($product['variants'])): ?>
                <?php foreach ($product['variants'] as $index => $variant): ?>
                    <div class="mb-3">
                        <input type="hidden" name="variant_id[<?php echo $index; ?>]" value="<?php echo $variant['variant_id']; ?>">
                        <label for="size_<?php echo $index; ?>" class="form-label">Kích thước</label>
                        <input type="text" class="form-control" id="size_<?php echo $index; ?>" name="size[<?php echo $index; ?>]" value="<?php echo htmlspecialchars($variant['size']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="color_<?php echo $index; ?>" class="form-label">Màu sắc</label>
                        <input type="text" class="form-control" id="color_<?php echo $index; ?>" name="color[<?php echo $index; ?>]" value="<?php echo htmlspecialchars($variant['color']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="stock_<?php echo $index; ?>" class="form-label">Số lượng tồn</label>
                        <input type="number" class="form-control" id="stock_<?php echo $index; ?>" name="stock[<?php echo $index; ?>]" value="<?php echo $variant['stock']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="variant_price_<?php echo $index; ?>" class="form-label">Giá biến thể (nếu có)</label>
                        <input type="number" class="form-control" id="variant_price_<?php echo $index; ?>" name="variant_price[<?php echo $index; ?>]" value="<?php echo $variant['price']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="variant_old_price_<?php echo $index; ?>" class="form-label">Giá cũ biến thể (nếu có)</label>
                        <input type="number" class="form-control" id="variant_old_price_<?php echo $index; ?>" name="variant_old_price[<?php echo $index; ?>]" value="<?php echo $variant['old_price']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="variant_is_on_sale_<?php echo $index; ?>" class="form-label">Giảm giá biến thể</label>
                        <input type="checkbox" id="variant_is_on_sale_<?php echo $index; ?>" name="variant_is_on_sale[<?php echo $index; ?>]" <?php echo $variant['is_on_sale'] ? 'checked' : ''; ?>>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            <a href="/index.php?action=products" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>