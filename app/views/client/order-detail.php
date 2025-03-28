<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?php echo htmlspecialchars($order['order_id'] ?? 'N/A'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/index.css">
    <style>
        .order-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .order-info {
            margin-bottom: 20px;
        }
        .order-info h2 {
            margin-bottom: 10px;
        }
        .order-info p {
            margin: 5px 0;
        }
        .order-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .order-details-table th, .order-details-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .order-details-table th {
            background-color: #f4f4f4;
        }
        .order-details-table img {
            max-width: 100px;
            height: auto;
        }
        .order-total {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 20px;
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
        <div class="order-container">
            <div class="order-info">
                <h2>Chi tiết đơn hàng #<?php echo htmlspecialchars($order['order_id'] ?? 'N/A'); ?></h2>
                <p><strong>Tên khách hàng:</strong> <?php echo htmlspecialchars($order['full_name'] ?? 'N/A'); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email'] ?? 'N/A'); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone'] ?? 'N/A'); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address'] ?? 'N/A'); ?></p>
                <p><strong>Ngày đặt hàng:</strong> <?php echo htmlspecialchars($order['created_at'] ?? 'N/A'); ?></p>
                <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order['status'] ?? 'Đang xử lý'); ?></p>
            </div>

            <h3>Sản phẩm trong đơn hàng</h3>
            <?php if (empty($orderDetails)): ?>
                <p>Không có sản phẩm nào trong đơn hàng này.</p>
            <?php else: ?>
                <table class="order-details-table">
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
                        <?php foreach ($orderDetails as $detail): ?>
                            <tr>
                                <td><img src="/public/images/<?php echo htmlspecialchars($detail['product']['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($detail['product']['name'] ?? 'Sản phẩm'); ?>"></td>
                                <td><?php echo htmlspecialchars($detail['product']['name'] ?? 'Sản phẩm không xác định'); ?></td>
                                <td><?php echo number_format($detail['product']['price'] ?? $detail['price'] ?? 0, 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo htmlspecialchars($detail['quantity'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($detail['color'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($detail['size'] ?? 'N/A'); ?></td>
                                <td><?php echo number_format(($detail['product']['price'] ?? $detail['price'] ?? 0) * ($detail['quantity'] ?? 0), 0, ',', '.'); ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div class="order-total">
                Tổng cộng: <?php echo number_format($order['total_amount'] ?? 0, 0, ',', '.'); ?> VNĐ
            </div>

            <a href="/index.php?action=user_orders" class="back-btn">Quay lại danh sách đơn hàng</a>
        </div>
    </main>

    <?php include __DIR__ . '/../share/footer.php'; ?>
</body>
</html>