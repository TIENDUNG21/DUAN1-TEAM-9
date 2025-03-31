<?php
namespace App\core;

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'duan1';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: '';

        try {
            $this->conn = new \PDO(
                "mysql:host=$this->host;dbname=$this->db_name;charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}