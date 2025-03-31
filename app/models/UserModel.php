<?php
namespace App\models;

use App\core\Database;

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả khách hàng
    public function getAllUsers() {
        $query = "SELECT * FROM users WHERE role = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Lấy khách hàng theo ID
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE user_id = :id AND role = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getUserById1($id) {
        $query = "SELECT * FROM users WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    // Lấy thông tin người dùng đã đăng nhập
    public function getUserBySessionId($userId) {
        $query = "SELECT * FROM users WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Thêm khách hàng mới
    public function addUser($data) {
        $query = "INSERT INTO users (username, password, email, phone) 
                  VALUES (:username, :password, :email, :phone )";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':username' => $data['username'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':email' => $data['email'],
            ':phone' => $data['phone'],
        ]);
    }

    // Cập nhật khách hàng
    public function updateUser($id, $data) {
        $query = "UPDATE users 
                  SET username = :username, email = :email, full_name = :full_name, 
                      phone = :phone, address = :address 
                  WHERE user_id = :id ";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'],
            ':address' => $data['address']
        ]);
    }

    // Cập nhật thông tin hồ sơ người dùng
    public function updateProfile($userId, $data) {
        $query = "UPDATE users 
                  SET full_name = :full_name, phone = :phone, gender = :gender, 
                      birth_date = :birth_date, avatar = :avatar, address = :address 
                  WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $userId,
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'],
            ':gender' => $data['gender'],
            ':birth_date' => $data['birth_date'],
            ':avatar' => $data['avatar'],
            ':address' => $data['address']
        ]);
    }

    // Xóa khách hàng
    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE user_id = :id ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Kiểm tra đăng nhập
    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Kiểm tra username hoặc email đã tồn tại chưa
    public function checkUserExists($username, $email) {
        $query = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}