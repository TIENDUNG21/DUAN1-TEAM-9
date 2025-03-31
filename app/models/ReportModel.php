<?php
namespace App\models;

use App\core\Database;

class ReportModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getRevenueReport($month, $year) {
        $query = "SELECT SUM(total_amount) as total_revenue, COUNT(*) as total_orders 
                  FROM orders 
                  WHERE MONTH(order_date) = :month AND YEAR(order_date) = :year 
                  AND status = 'Đã giao'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':month' => $month, ':year' => $year]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserReport($month, $year) {
        $query = "SELECT COUNT(*) as total_users 
                  FROM users 
                  WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year 
                  AND role = 'Client'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':month' => $month, ':year' => $year]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}