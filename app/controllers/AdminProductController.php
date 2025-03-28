<?php
namespace App\controllers;

use App\models\ProductModel;
use App\models\CategoryModel;

class AdminProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // Hiển thị danh sách sản phẩm
    public function index() {
        $products = $this->productModel->getAllProducts();
        return $products;
    }

    // Thêm sản phẩm
    public function add() {
        $categories = $this->categoryModel->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload hình ảnh
            $image = $_FILES['image']['name'];
            if (!empty($image)) {
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/images/' . $image);
            } else {
                $image = 'default.jpg'; // Hình ảnh mặc định nếu không upload
            }
    
            // Dữ liệu sản phẩm
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'old_price' => !empty($_POST['old_price']) ? $_POST['old_price'] : null,
                'is_on_sale' => isset($_POST['is_on_sale']) ? 1 : 0,
                'image' => $image,
                'category_id' => $_POST['category_id']
            ];
    
            // Thêm sản phẩm
            $this->productModel->addProduct($data);
    
            header('Location: /index.php?action=products');
            exit;
        }
    
        return $categories;
    }
    public function addVariant($productId) {
        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            die("Sản phẩm không tồn tại!");
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $variantData = [
                'product_id' => $productId,
                'size' => $_POST['size'],
                'color' => $_POST['color'],
                'stock' => $_POST['stock'],
                'price' => !empty($_POST['variant_price']) ? $_POST['variant_price'] : null,
                'old_price' => !empty($_POST['variant_old_price']) ? $_POST['variant_old_price'] : null,
                'is_on_sale' => isset($_POST['variant_is_on_sale']) ? 1 : 0
            ];
    
            $this->productModel->addVariant($variantData);
    
            header('Location: /index.php?action=products');
            exit;
        }
    
        return ['product' => $product];
    }

    // Sửa sản phẩm
    public function edit($id) {
        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getAllCategories();

        if (!$product) {
            die("Sản phẩm không tồn tại!");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload hình ảnh
            $image = $product['image'];
            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/images/' . $image);
            }

            // Dữ liệu sản phẩm
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'old_price' => !empty($_POST['old_price']) ? $_POST['old_price'] : null,
                'is_on_sale' => isset($_POST['is_on_sale']) ? 1 : 0,
                'image' => $image,
                'category_id' => $_POST['category_id']
            ];

            // Cập nhật sản phẩm
            $this->productModel->updateProduct($id, $data);

            // Cập nhật biến thể
            if (isset($_POST['variant_id'])) {
                foreach ($_POST['variant_id'] as $index => $variantId) {
                    $variantData = [
                        'size' => $_POST['size'][$index],
                        'color' => $_POST['color'][$index],
                        'stock' => $_POST['stock'][$index],
                        'price' => !empty($_POST['variant_price'][$index]) ? $_POST['variant_price'][$index] : null,
                        'old_price' => !empty($_POST['variant_old_price'][$index]) ? $_POST['variant_old_price'][$index] : null,
                        'is_on_sale' => isset($_POST['variant_is_on_sale'][$index]) ? 1 : 0
                    ];
                    $this->productModel->updateVariant($variantId, $variantData);
                }
            }

            header('Location: /index.php?action=products');
            exit;
        }

        return ['product' => $product, 'categories' => $categories];
    }

    // Xóa sản phẩm
    public function delete($id) {
        $this->productModel->deleteProduct($id);
        header('Location: /index.php?action=products');
        exit;
    }
}