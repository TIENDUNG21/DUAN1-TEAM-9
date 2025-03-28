<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?php echo htmlspecialchars($order['order_id'] ?? 'N/A'); ?></title>
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
        <h2>Chi tiết đơn hàng #<?php echo htmlspecialchars($order['order_id'] ?? 'N/A'); ?></h2>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="mb-4">
            <p><strong>Tên khách hàng:</strong> <?php echo htmlspecialchars($order['full_name'] ?? 'N/A'); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email'] ?? 'N/A'); ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone'] ?? 'N/A'); ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address'] ?? 'N/A'); ?></p>
            <p><strong>Ngày đặt hàng:</strong> <?php echo htmlspecialchars($order['created_at'] ?? 'N/A'); ?></p>
            <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order['status'] ?? 'Đang xử lý'); ?></p>
        </div>

        <h3>Sản phẩm trong đơn hàng</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Màu</th>
                    <th>Size</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orderDetails)): ?>
                    <tr><td colspan="7" class="text-center">Không có sản phẩm nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($orderDetails as $detail): ?>
                        <tr>
                            <td><img src="/public/images/<?php echo htmlspecialchars($detail['product']['image'] ?? 'default.jpg'); ?>" width="50"></td>
                            <td><?php echo htmlspecialchars($detail['product']['name'] ?? 'Sản phẩm không xác định'); ?></td>
                            <td><?php echo number_format($detail['product']['price'] ?? $detail['price'] ?? 0, 0, ',', '.'); ?>đ</td>
                            <td><?php echo htmlspecialchars($detail['quantity'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($detail['color'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($detail['size'] ?? 'N/A'); ?></td>
                            <td><?php echo number_format(($detail['product']['price'] ?? $detail['price'] ?? 0) * ($detail['quantity'] ?? 0), 0, ',', '.'); ?>đ</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-end mb-3">
            <strong>Tổng cộng: <?php echo number_format($order['total_amount'] ?? 0, 0, ',', '.'); ?>đ</strong>
        </div>

        <a href="/index.php?action=orders" class="btn btn-primary">Quay lại</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>