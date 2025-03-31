<?php
namespace App\controllers;

use App\models\CategoryModel;

class AdminCategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    // Hiển thị danh sách danh mục
    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        return $categories;
    }

    // Thêm danh mục
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ];
            $this->categoryModel->addCategory($data);
            header('Location: /index.php?action=categories');
            exit;
        }
    }

    // Sửa danh mục
    public function edit($id) {
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            die("Danh mục không tồn tại!");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ];
            $this->categoryModel->updateCategory($id, $data);
            header('Location: /index.php?action=categories');
            exit;
        }

        return $category;
    }

    // Xóa danh mục
    public function delete($id) {
        $this->categoryModel->deleteCategory($id);
        header('Location: /index.php?action=categories');
        exit;
    }
}