
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TuBoy</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/index.css" />
</head>
<body>
  
    <?php include __DIR__. '/share/header.php';?>
    <?php include __DIR__. '/share/nav.php';?>
    <main>
        <!-- Đây là banner -->
        <div class="banner">
            <div class="slideshow-container">
                <div class="mySlides fade">
                    <a href="/"><img src="/public/images/nikebanner.png" alt="Banner 1" /></a>
                </div>
                <div class="mySlides fade">
                    <a href="/"><img src="/public/images/nikebanner2.png" alt="Banner 2" /></a>
                </div>
                <div class="mySlides fade">
                    <a href="/"><img src="/public/images/nikebanner3.png" alt="Banner 3" /></a>
                </div>
            </div>
            <div class="benefits">
                <div class="benefit">
                    <span class="material-symbols-outlined">local_shipping</span>
                    <h3>Miễn phí vận chuyển</h3>
                    <p>Nhận ship toàn quốc tất cả các sản phẩm</p>
                </div>
                <div class="benefit">
                    <span class="material-symbols-outlined">currency_exchange</span>
                    <h3>Đổi trả miễn phí</h3>
                    <p>Không áp dụng đổi trả cho sản phẩm sale off</p>
                </div>
                <div class="benefit">
                    <span class="material-symbols-outlined">credit_card</span>
                    <h3>Giao hàng nhận tiền</h3>
                    <p>Thanh toán đơn hàng bằng hình thức trực tiếp tại cửa hàng</p>
                </div>
                <div class="benefit">
                    <span class="material-symbols-outlined">phone_in_talk</span>
                    <h3>Đặt hàng online</h3>
                    <p>0123456789</p>
                </div>
            </div>
        </div>

        <!-- Hàng giảm giá -->
        <div class="sale">
            <div class="line-text">
                <div class="line"></div>
                <h2 class="sale-titles">Siêu Sale Xả Kho -70%</h2>
                <div class="line"></div>
            </div>
            <div class="product-grid">
                <?php if (empty($products)): ?>
                    <p>Không có sản phẩm nào để hiển thị.</p>
                <?php else: ?>
                    <?php
                    // Lọc các sản phẩm có giảm giá (is_on_sale = 1)
                    $saleProducts = array_filter($products, function($product) {
                        return $product['is_on_sale'] == 1;
                    });
                    ?>
                    <?php if (empty($saleProducts)): ?>
                        <p>Không có sản phẩm giảm giá nào để hiển thị.</p>
                    <?php else: ?>
                        <?php foreach ($saleProducts as $product): ?>
                            <div class="product-card">
                                <img src="/public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                                <div class="sale-title">
                                    <?php if ($product['is_on_sale'] && $product['old_price']): ?>
                                        <div class="sale-badge">-<?php echo round((($product['old_price'] - $product['price']) / $product['old_price']) * 100); ?>%</div>
                                    <?php endif; ?>
                                    <h3 class="name-brand"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p class="brand"><?php echo htmlspecialchars($product['color'] ?? 'N/A'); ?></p>
                                    <div class="total-price">
                                        <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?>d</p>
                                        <?php if ($product['is_on_sale'] && $product['old_price']): ?>
                                            <p class="old-price"><?php echo number_format($product['old_price'], 0, ',', '.'); ?>d</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="add-see">
                                <?php
                                // Kiểm tra tổng tồn kho của tất cả biến thể (nếu có)
                                $totalStock = array_sum(array_column($product['variants'] ?? [], 'stock'));
                                ?>
                                <?php if ($totalStock > 0): ?>
                                    <form action="/index.php?action=add_to_cart" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
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
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="see-all">
                <a href="/sale"><button class="seeAll">See all</button></a>
            </div>
        </div>

        <div class="line"></div>

        <!-- Sản phẩm hot -->
        <div class="hot-product">
            <div class="line-text">
                <div class="line"></div>
                <div class="inline">
                    <h2 class="title-product">Sản phẩm hot</h2>
                </div>
                <div class="line"></div>
            </div>
            <p class="hot-title">Hàng luôn được cập nhật thường xuyên</p>
            <div class="hot-product-grid">
                <?php if (empty($products)): ?>
                    <p>Không có sản phẩm nào để hiển thị.</p>
                <?php else: ?>
                    <?php
                    // Lọc các sản phẩm không giảm giá hoặc có thể tùy chỉnh logic để chọn sản phẩm hot
                    $hotProducts = $products; // Có thể thêm logic để chọn sản phẩm hot (ví dụ: dựa trên lượt xem, lượt mua)
                    ?>
                    <?php foreach ($hotProducts as $product): ?>
                        <div class="product-card">
                            <a href="/?action=show&id=<?php echo $product['product_id']; ?>">
                            <img src="/public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                            </a>
                            <div class="sale-title">
                                <?php if ($product['is_on_sale'] && $product['old_price']): ?>
                                    <div class="sale-badge">-<?php echo round((($product['old_price'] - $product['price']) / $product['old_price']) * 100); ?>%</div>
                                <?php endif; ?>
                                <h3 class="name-brand"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="brand"><?php echo htmlspecialchars($product['color'] ?? 'N/A'); ?></p>
                                <div class="total-price">
                                    <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?>d</p>
                                    <?php if ($product['is_on_sale'] && $product['old_price']): ?>
                                        <p class="old-price"><?php echo number_format($product['old_price'], 0, ',', '.'); ?>d</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="add-see">
                                <?php
                                // Kiểm tra tổng tồn kho của tất cả biến thể
                                $totalStock = array_sum(array_column($product['variants'] ?? [], 'stock'));
                                ?>
                                <?php if ($totalStock > 0): ?>
                                    <button class="add-to-cart">
                                        <span class="material-symbols-outlined">shopping_cart</span>Add to cart
                                    </button>
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
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="see-all">
                <a href="?action=all_product"><button class="seeAll">See all</button></a>
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
    <script src="/public/js/slideshow.js"></script>
</body>
</html>