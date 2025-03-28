<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng của bạn</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/index.css">
    <style>
        .orders-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .orders-container h2 {
            margin-bottom: 20px;
        }
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .orders-table th, .orders-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .orders-table th {
            background-color: #f4f4f4;
        }
        .orders-table a {
            color: #007bff;
            text-decoration: none;
        }
        .orders-table a:hover {
            text-decoration: underline;
        }
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../share/header.php'; ?>
    <?php include __DIR__ . '/../share/nav.php'; ?>

    <main>
        <div class="orders-container">
            <h2>Danh sách đơn hàng của bạn</h2>
            <?php if (empty($orders)): ?>
                <p>Bạn chưa có đơn hàng nào.</p>
            <?php else: ?>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['created_at'] ?? 'N/A'); ?></td>
                                <td><?php echo number_format($order['total_amount'] ?? 0, 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo htmlspecialchars($order['status'] ?? 'Đang xử lý'); ?></td>
                                <td><a href="/index.php?action=order_detail&order_id=<?php echo $order['order_id']; ?>">Xem chi tiết</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <a href="/index.php" class="back-btn">Quay lại</a>
        </div>
    </main>

    <?php include __DIR__ . '/../share/footer.php'; ?>
</body>
</html>