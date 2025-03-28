<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/index.css">
    <style>
        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .cart-table th, .cart-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .cart-table th {
            background-color: #f4f4f4;
        }
        .cart-table img {
            max-width: 100px;
            height: auto;
        }
        .cart-table input[type="number"] {
            width: 60px;
            padding: 5px;
        }
        .cart-table .btn {
            padding: 5px 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .cart-table .btn:hover {
            background-color: #c0392b;
        }
        .cart-total {
            text-align: right;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .checkout-btn {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
        }
        .checkout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../share/header.php'; ?>
    <?php include __DIR__ . '/../share/nav.php'; ?>
    <main>
        <div class="cart-container">
            <h2>Giỏ hàng của bạn</h2>
            <?php if (empty($cart)): ?>
                <p>Giỏ hàng của bạn đang trống.</p>
            <?php else: ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Màu</th>
                            <th>Size</th>
                            <th>Tổng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $cartKey => $item): ?>
                            <tr>
                                <td><img src="/public/images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                <td>
                                    <form action="/index.php?action=update_cart" method="POST">
                                        <input type="hidden" name="cart_key" value="<?php echo htmlspecialchars($cartKey); ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                        <button type="submit">Cập nhật</button>
                                    </form>
                                </td>
                                <td><?php echo htmlspecialchars($item['color']); ?></td>
                                <td><?php echo htmlspecialchars($item['size']); ?></td>
                                <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ</td>
                                <td>
                                    <a href="/index.php?action=delete_cart&cart_key=<?php echo htmlspecialchars($cartKey); ?>" class="btn">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-total">
                    <strong>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</strong>
                </div>
                <a href="/index.php?action=checkout" class="checkout-btn">Thanh toán</a>
            <?php endif; ?>
        </div>
    </main>
    <?php include __DIR__ . '/../share/footer.php'; ?>
</body>
</html>