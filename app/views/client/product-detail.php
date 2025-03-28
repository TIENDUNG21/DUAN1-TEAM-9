<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuBoy - <?php echo htmlspecialchars($product['name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/product-detail.css">
</head>
<body>
    <?php include __DIR__ . '/../share/header.php'; ?>
    <?php include __DIR__ . '/../share/nav.php'; ?>

    <main>
        <!-- Sản phẩm -->
        <div class="container">
            <?php if ($product): ?>
                <div class="product-details">
                    <div class="product-image">
                        <div class="zoom-container">
                            <img id="productImg" src="/public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div id="zoomResult" class="zoom-result"></div>
                    </div>
                    
                    <div class="product-info">
                        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                        <p>Mã SP: <?php echo htmlspecialchars($product['product_id']); ?></p>
                        <div class="total-price">
                            <p class="price" id="price"><?php echo number_format($product['price'], 0, ',', '.'); ?>d</p>
                            <?php if ($product['is_on_sale'] && $product['old_price']): ?>
                                <p class="old-price" id="old-price"><?php echo number_format($product['old_price'], 0, ',', '.'); ?>d</p>
                            <?php endif; ?>
                        </div>

                        <!-- Hiển thị danh sách size -->
                        <div class="sizes">
                            <h3>Size:</h3>
                            <select class="size-options" name="size" id="size-select">
                                <?php
                                $sizes = array_unique(array_column($product['variants'], 'size'));
                                foreach ($sizes as $size):
                                ?>
                                    <option value="<?php echo htmlspecialchars($size); ?>"><?php echo htmlspecialchars($size); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Hiển thị danh sách màu sắc -->
                        <div class="colors">
                            <h3>Màu sắc:</h3>
                            <select class="color-options" name="color" id="color-select">
                                <?php
                                $colors = array_unique(array_column($product['variants'], 'color'));
                                foreach ($colors as $color):
                                ?>
                                    <option value="<?php echo htmlspecialchars($color); ?>"><?php echo htmlspecialchars($color); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Kiểm tra tồn kho và hiển thị nút -->
                        <div class="add-see">
                            <?php
                            // Kiểm tra tổng tồn kho của tất cả biến thể (nếu có)
                            $totalStock = array_sum(array_column($product['variants'] ?? [], 'stock'));
                            ?>
                            <?php if ($totalStock > 0): ?>
                                <form action="/index.php?action=add_to_cart" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="size" id="size-input" value="<?php echo htmlspecialchars($sizes[0]); ?>">
                                    <input type="hidden" name="color" id="color-input" value="<?php echo htmlspecialchars($colors[0]); ?>">
                                    <button type="submit" class="add-to-cart">
                                        <span class="material-symbols-outlined">shopping_cart</span>Add to cart
                                    </button>
                                </form>
                                <a href="?action=show&id=<?php echo $product['product_id']; ?>">
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
                </div>

                <!-- Mô tả -->
                <section class="product-description">
                    <h2>Mô tả sản phẩm</h2>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                </section>
            <?php else: ?>
                <p>Sản phẩm không tồn tại.</p>
                <a href="/">Quay lại</a>
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
                <p>Email: <span>themixvietnam@gmail.com</span></p>
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

    <script src="/public/js/zoom-img.js"></script>
<script>
    // Lấy danh sách biến thể từ PHP
    const variants = <?php echo json_encode($product['variants']); ?>;
    const sizeSelect = document.getElementById('size-select');
    const colorSelect = document.getElementById('color-select');
    const sizeInput = document.getElementById('size-input');
    const colorInput = document.getElementById('color-input');
    const priceElement = document.getElementById('price');
    const oldPriceElement = document.getElementById('old-price');

    // Hàm cập nhật thông tin dựa trên lựa chọn
    function updateVariant() {
        const selectedSize = sizeSelect.value;
        const selectedColor = colorSelect.value;

        // Cập nhật giá trị input hidden trong form
        sizeInput.value = selectedSize;
        colorInput.value = selectedColor;

        if (selectedSize && selectedColor) {
            // Tìm biến thể phù hợp
            const variant = variants.find(v => v.size === selectedSize && v.color === selectedColor);
            if (variant) {
                // Cập nhật giá
                priceElement.textContent = new Intl.NumberFormat('vi-VN').format(variant.price) + 'd';
                if (variant.is_on_sale && variant.old_price) {
                    oldPriceElement.style.display = 'block';
                    oldPriceElement.textContent = new Intl.NumberFormat('vi-VN').format(variant.old_price) + 'd';
                } else {
                    oldPriceElement.style.display = 'none';
                }
            }
        }
    }

    // Lắng nghe sự kiện thay đổi size và color
    sizeSelect.addEventListener('change', updateVariant);
    colorSelect.addEventListener('change', updateVariant);

    // Gọi hàm updateVariant khi trang tải để hiển thị giá trị mặc định
    updateVariant();
</script>
</body>
</html>