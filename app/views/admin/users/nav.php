<?php
// Lấy danh sách danh mục từ ProductModel
$productModel = new \App\models\ProductModel();
$categories = $productModel->getAllCategories();
?>
<div class="sidebar">
        <div class="navbar">
          <ul>
            <li><a href="?action=index">Home</a></li>
            <li class="product">
                <a href="#" class="drop-nav">Product</a>
                <div class="product-content">
                    <?php foreach ($categories as $category): ?>
                        <a href="/index.php?action=category&category_id=<?php echo $category['category_id']; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li><a href="?action=sale">Sale</a></li>
            <li><a href="">About Us</a></li>
            <?php
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    echo "<li><a href='?action=dashboard'>Admin</a></li>";
}
?>



          </ul>
        </div>
      </div>