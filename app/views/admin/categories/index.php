<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
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
        <h2>Quản lý Danh mục</h2>
        <a href="/index.php?action=add_category" class="btn btn-primary mb-3">Thêm danh mục</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo $category['category_id']; ?></td>
                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                        <td><?php echo htmlspecialchars($category['description'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="/index.php?action=edit_category&id=<?php echo $category['category_id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="/index.php?action=delete_category&id=<?php echo $category['category_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>