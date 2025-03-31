<?php
namespace App\models;

use App\core\Database;

class OrderModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createOrder($data) {
        $query = "INSERT INTO orders (user_id, full_name, email, phone, address, total_amount) 
                  VALUES (:user_id, :full_name, :email, :phone, :address, :total_amount)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':address' => $data['address'],
            ':total_amount' => $data['total_amount']
        ]);

        return $this->conn->lastInsertId();
    }

    // Tạo chi tiết đơn hàng
    public function createOrderDetail($data) {
        $query = "INSERT INTO order_details (order_id, product_id, quantity, price, size, color) 
                  VALUES (:order_id, :product_id, :quantity, :price, :size, :color)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':order_id' => $data['order_id'],
            ':product_id' => $data['product_id'],
            ':quantity' => $data['quantity'],
            ':price' => $data['price'],
            ':size' => $data['size'],
            ':color' => $data['color']
        ]);
    }
    public function getAllOrders() {
        $query = "SELECT * FROM orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getOrderById($id) {
        $query = "SELECT * FROM orders WHERE order_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getOrderDetailsByOrderId($id) {
        $query = "SELECT * FROM order_details WHERE order_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function updateOrderStatus($id, $status) {
        $query = "UPDATE orders SET status = :status WHERE order_id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }
    public function deleteOrder($id) {
        $query = "DELETE FROM orders WHERE order_id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id
        ]);
    }
    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}