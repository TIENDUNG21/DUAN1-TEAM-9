<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Biến thể cho <?php echo htmlspecialchars($product['name']); ?></title>
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
        <h2>Thêm Biến thể cho <?php echo htmlspecialchars($product['name']); ?></h2>
        <form method="POST">
            <div class="mb-3">
                <label for="size" class="form-label">Kích thước</label>
                <input type="text" class="form-control" id="size" name="size" required>
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Màu sắc</label>
                <input type="text" class="form-control" id="color" name="color" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Số lượng tồn</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="variant_price" class="form-label">Giá biến thể (nếu có)</label>
                <input type="number" class="form-control" id="variant_price" name="variant_price">
            </div>
            <div class="mb-3">
                <label for="variant_old_price" class="form-label">Giá cũ biến thể (nếu có)</label>
                <input type="number" class="form-control" id="variant_old_price" name="variant_old_price">
            </div>
            <div class="mb-3">
                <label for="variant_is_on_sale" class="form-label">Giảm giá biến thể</label>
                <input type="checkbox" id="variant_is_on_sale" name="variant_is_on_sale">
            </div>

            <button type="submit" class="btn btn-primary">Thêm biến thể</button>
            <a href="/index.php?action=products" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>