<?php
namespace App\controllers;

use App\models\UserModel;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Hiển thị form đăng nhập và xử lý đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);
            if ($user) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 1) { 
                    header('Location: /index.php?action=dashboard');
                } else {
                    header('Location: /index.php');
                }
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
                return ['error' => $error];
            }
        }
        return [];
    }

    // Hiển thị form đăng ký và xử lý đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];

            // Kiểm tra username hoặc email đã tồn tại
            if ($this->userModel->checkUserExists($username, $email)) {
                $error = "Tên đăng nhập hoặc email đã tồn tại!";
                return ['error' => $error];
            }

            // Thêm người dùng mới
            $data = [
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'phone' => $phone,
            ];
            $this->userModel->addUser($data);

            // Chuyển hướng đến trang đăng nhập
            header('Location: /index.php?action=login');
            exit;
        }
        return [];
    }

    // Đăng xuất
    public function logout() {
        // Xóa tất cả dữ liệu session
        session_unset();
        session_destroy();
        header('Location: /index.php');
        exit;
    }
    public function index() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserBySessionId($userId);

        if (!$user) {
            session_unset();
            session_destroy();
            header('Location: /index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload ảnh đại diện
            $avatar = $user['avatar'] ?? 'default.jpg';
            if (!empty($_FILES['avatar']['name'])) {
                $avatar = $_FILES['avatar']['name'];
                // Sửa đường dẫn thư mục đích
                $targetDir = __DIR__ . '../../../public/images/avatars/';
                // Đảm bảo tên file không trùng
                $avatar = time() . '_' . basename($avatar);
                $targetFile = $targetDir . $avatar;

                // Kiểm tra xem thư mục có tồn tại không, nếu không thì tạo
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Kiểm tra dung lượng file (tối đa 1MB)
                if ($_FILES['avatar']['size'] > 1048576) {
                    $error = "Dung lượng file vượt quá 1MB!";
                    return ['user' => $user, 'error' => $error];
                }

                // Kiểm tra định dạng file
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if (!in_array($fileType, ['jpg', 'jpeg', 'png'])) {
                    $error = "Chỉ chấp nhận file .JPG, .JPEG, .PNG!";
                    return ['user' => $user, 'error' => $error];
                }

                // Upload file
                if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                    $error = "Có lỗi khi upload ảnh! Vui lòng kiểm tra quyền truy cập thư mục.";
                    return ['user' => $user, 'error' => $error];
                }
            }

            // Xử lý ngày sinh
            $birthDate = null;
            if (!empty($_POST['day']) && !empty($_POST['month']) && !empty($_POST['year'])) {
                $birthDate = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
            }

            // Dữ liệu cập nhật
            $data = [
                'full_name' => $_POST['full_name'],
                'phone' => $_POST['phone'],
                'gender' => $_POST['gender'] ?? null,
                'birth_date' => $birthDate,
                'avatar' => $avatar,
                'address' => $_POST['address'] // Thêm trường address
            ];

            // Cập nhật thông tin
            $this->userModel->updateProfile($userId, $data);
            header('Location: /index.php?action=profile');
            exit;
        }

        return ['user' => $user];
    }
}