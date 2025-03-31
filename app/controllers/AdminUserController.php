<?php
namespace App\controllers;

use App\models\UserModel;

class AdminUserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Hiển thị danh sách khách hàng
    public function index() {
        $users = $this->userModel->getAllUsers();
        return $users;
    }

    // Thêm khách hàng
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'email' => $_POST['email'],
                'full_name' => $_POST['full_name'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];
            $this->userModel->addUser($data);
            header('Location: /index.php?action=users');
            exit;
        }
    }

    // Sửa khách hàng
    public function edit($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            die("Khách hàng không tồn tại!");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'full_name' => $_POST['full_name'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];
            $this->userModel->updateUser($id, $data);
            header('Location: /index.php?action=users');
            exit;
        }

        return $user;
    }

    public function view($id) {
        $user = $this->userModel->getUserById1($id);
        if (!$user) {
            die("Khách hàng không tồn tại!");
        }
        return $user;
    }

    // Xóa khách hàng
    public function delete($id) {
        $this->userModel->deleteUser($id);
        header('Location: /index.php?action=users');
        exit;
    }
}