<?php
namespace App\controllers;

use App\models\ProductModel;

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new ProductModel();
    }

    public function index() {
        $products = $this->model->getAllProducts();
        return $products;
    }
    

    public function show($id) {
        $product = $this->model->getProductById($id);
        return $product;
    }
    public function category() {
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 9; // Số sản phẩm mỗi trang

        if ($categoryId <= 0) {
            header('Location: /index.php');
            exit;
        }

        // Lấy sản phẩm theo danh mục
        $products = $this->model->getProductsByCategory($categoryId, $page, $perPage);

        // Tính tổng số trang
        $totalProducts = $this->model->countProductsByCategory($categoryId);
        $totalPages = ceil($totalProducts / $perPage);

        // Lấy danh sách danh mục
        $categories = $this->model->getAllCategories();

        return [
            'products' => $products,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'categoryId' => $categoryId
        ];
    }
    public function sale() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 9; // Số sản phẩm mỗi trang
    
        // Lấy sản phẩm đang giảm giá
        $products = $this->model->getSaleProducts($page, $perPage);
    
        // Tính tổng số trang
        $totalProducts = $this->model->countSaleProducts();
        $totalPages = ceil($totalProducts / $perPage);
    
        // Lấy danh sách danh mục
        $categories = $this->model->getAllCategories();
    
        return [
            'products' => $products,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
    }
    public function search() {
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 9; // Số sản phẩm mỗi trang
    
        if (empty($keyword)) {
            // Nếu không có từ khóa, chuyển hướng về trang chủ
            header('Location: /index.php');
            exit;
        }
    
        // Lấy sản phẩm theo từ khóa
        $products = $this->model->searchProducts($keyword, $page, $perPage);
    
        // Tính tổng số trang
        $totalProducts = $this->model->countSearchProducts($keyword);
        $totalPages = ceil($totalProducts / $perPage);
    
        // Lấy danh sách danh mục
        $categories = $this->model->getAllCategories();
    
        return [
            'products' => $products,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'keyword' => $keyword
        ];
    }
}