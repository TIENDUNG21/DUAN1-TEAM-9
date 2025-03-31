<?php
namespace App\models;

use App\core\Database;

class ProductModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả sản phẩm, bao gồm thông tin danh mục và biến thể
    public function getAllProducts() {
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Lấy biến thể cho từng sản phẩm
        foreach ($products as &$product) {
            $query = "SELECT * FROM product_variants WHERE product_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $product['product_id'], \PDO::PARAM_INT);
            $stmt->execute();
            $variants = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($variants as &$variant) {
                $variant['price'] = $variant['price'] ?? $product['price'];
                $variant['old_price'] = $variant['old_price'] ?? $product['old_price'];
                $variant['is_on_sale'] = $variant['is_on_sale'] ?? $product['is_on_sale'];
            }
            $product['variants'] = $variants;
        }

        return $products;
    }
  
    // Lấy thông tin sản phẩm theo ID
    public function getProductById($id) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.category_id 
                  WHERE p.product_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($product) {
            $query = "SELECT * FROM product_variants WHERE product_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $variants = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($variants as &$variant) {
                $variant['price'] = $variant['price'] ?? $product['price'];
                $variant['old_price'] = $variant['old_price'] ?? $product['old_price'];
                $variant['is_on_sale'] = $variant['is_on_sale'] ?? $product['is_on_sale'];
            }
            $product['variants'] = $variants;
        }

        return $product;
    }

    // Thêm sản phẩm mới
    public function addProduct($data) {
        $query = "INSERT INTO products (name, description, price, old_price, is_on_sale, image, category_id) 
                  VALUES (:name, :description, :price, :old_price, :is_on_sale, :image, :category_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':old_price' => $data['old_price'],
            ':is_on_sale' => $data['is_on_sale'],
            ':image' => $data['image'],
            ':category_id' => $data['category_id']
        ]);
        return $this->conn->lastInsertId();
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $data) {
        $query = "UPDATE products 
                  SET name = :name, description = :description, price = :price, old_price = :old_price, 
                      is_on_sale = :is_on_sale, image = :image, category_id = :category_id 
                  WHERE product_id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':old_price' => $data['old_price'],
            ':is_on_sale' => $data['is_on_sale'],
            ':image' => $data['image'],
            ':category_id' => $data['category_id']
        ]);
    }

    // Xóa sản phẩm
    public function deleteProduct($id) {
        // Xóa các biến thể trước do ràng buộc khóa ngoại
        $query = "DELETE FROM product_variants WHERE product_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        // Xóa sản phẩm
        $query = "DELETE FROM products WHERE product_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Thêm biến thể sản phẩm
    public function addVariant($data) {
        $query = "INSERT INTO product_variants (product_id, size, color, stock, price, old_price, is_on_sale) 
                  VALUES (:product_id, :size, :color, :stock, :price, :old_price, :is_on_sale)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':product_id' => $data['product_id'],
            ':size' => $data['size'],
            ':color' => $data['color'],
            ':stock' => $data['stock'],
            ':price' => $data['price'],
            ':old_price' => $data['old_price'],
            ':is_on_sale' => $data['is_on_sale']
        ]);
    }

    // Cập nhật biến thể
    public function updateVariant($id, $data) {
        $query = "UPDATE product_variants 
                  SET size = :size, color = :color, stock = :stock, price = :price, old_price = :old_price, is_on_sale = :is_on_sale 
                  WHERE variant_id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':size' => $data['size'],
            ':color' => $data['color'],
            ':stock' => $data['stock'],
            ':price' => $data['price'],
            ':old_price' => $data['old_price'],
            ':is_on_sale' => $data['is_on_sale']
        ]);
    }

    // Xóa biến thể
    public function deleteVariant($id) {
        $query = "DELETE FROM product_variants WHERE variant_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getProductsByCategory($categoryId, $page = 1, $perPage = 9) {
        $offset = ($page - 1) * $perPage;
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  JOIN categories c ON p.category_id = c.category_id 
                  WHERE p.category_id = :category_id 
                  LIMIT :offset, :per_page";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $perPage, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Đếm tổng số sản phẩm theo danh mục
    public function countProductsByCategory($categoryId) {
        $query = "SELECT COUNT(*) FROM products WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getAllCategories() {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    // Lấy sản phẩm đang giảm giá với phân trang
    public function getSaleProducts($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $query = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.category_id 
                WHERE p.is_on_sale > 0 
                LIMIT :offset, :per_page";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $perPage, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Đếm tổng số sản phẩm đang giảm giá
    public function countSaleProducts() {
        $query = "SELECT COUNT(*) FROM products WHERE is_on_sale > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    // Tìm kiếm sản phẩm theo từ khóa với phân trang
    public function searchProducts($keyword, $page = 1, $perPage = 9) {
        $offset = ($page - 1) * $perPage;
        $keyword = "%" . $keyword . "%"; // Thêm ký tự % để tìm kiếm gần đúng
        $query = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.category_id 
                WHERE p.name LIKE :keyword OR p.description LIKE :keyword 
                LIMIT :offset, :per_page";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyword', $keyword, \PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $perPage, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Đếm tổng số sản phẩm tìm được
    public function countSearchProducts($keyword) {
        $keyword = "%" . $keyword . "%";
        $query = "SELECT COUNT(*) 
                FROM products 
                WHERE name LIKE :keyword OR description LIKE :keyword";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyword', $keyword, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}