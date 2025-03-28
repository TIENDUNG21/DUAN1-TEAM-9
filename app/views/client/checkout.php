<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/index.css">
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            gap: 20px;
        }
        .checkout-form, .checkout-summary {
            flex: 1;
        }
        .checkout-form h2, .checkout-summary h2 {
            margin-bottom: 20px;
        }
        .checkout-form form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .checkout-form input, .checkout-form textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .checkout-form textarea {
            resize: vertical;
        }
        .checkout-form button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .checkout-form button:hover {
            background-color: #0056b3;
        }
        .checkout-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .checkout-summary th, .checkout-summary td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .checkout-summary th {
            background-color: #f4f4f4;
        }
        .checkout-summary img {
            max-width: 50px;
            height: auto;
        }
        .error, .success {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../share/header.php'; ?>
    <?php include __DIR__ . '/../share/nav.php'; ?>
    <main>
        <div class="checkout-container">
            <div class="checkout-form">
                <h2>Thông tin thanh toán</h2>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <form action="/index.php?action=payment" method="POST">
                    <input type="text" name="full_name" placeholder="Họ và tên" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phone" placeholder="Số điện thoại" required>
                    <textarea name="address" placeholder="Địa chỉ giao hàng" required></textarea>
                    <button type="submit">Xác nhận thanh toán</button>
                </form>
            </div>
            <div class="checkout-summary">
                <h2>Tóm tắt đơn hàng</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <tr>
                                <td><img src="/public/images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-total">
                    <strong>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</strong>
                </div>
            </div>
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