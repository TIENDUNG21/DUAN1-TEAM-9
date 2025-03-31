<?php
namespace App\controllers;

use App\models\ProductModel;
use App\models\OrderModel;

class CartController {
    private $productModel;
    private $orderModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        $size = isset($_POST['size']) ? trim($_POST['size']) : null;
        $color = isset($_POST['color']) ? trim($_POST['color']) : null;
    
        if ($productId <= 0 || $quantity <= 0) {
            header('Location: /index.php');
            exit;
        }
    
        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            header('Location: /index.php');
            exit;
        }
    
        // Lấy danh sách biến thể của sản phẩm
        $variants = $product['variants'] ?? [];
        if (empty($variants)) {
            header('Location: /index.php');
            exit;
        }
    
        // Nếu không có size hoặc color từ form (tức là từ trang chính), lấy mặc định từ biến thể đầu tiên
        if (!$size || !$color) {
            $defaultVariant = $variants[0];
            $size = $defaultVariant['size'];
            $color = $defaultVariant['color'];
            $price = $defaultVariant['price'] ?? $product['price'];
        } else {
            // Tìm biến thể phù hợp với size và color từ form
            $selectedVariant = array_filter($variants, function ($variant) use ($size, $color) {
                return $variant['size'] === $size && $variant['color'] === $color;
            });
            $selectedVariant = reset($selectedVariant);
            $price = $selectedVariant['price'] ?? $product['price'];
        }
    
        // Tạo cartKey duy nhất bằng cách thêm timestamp để tránh trùng lặp
        $cartKey = $productId . '_' . $size . '_' . $color . '_' . time();
    
        // Luôn tạo một mục mới trong giỏ hàng
        $_SESSION['cart'][$cartKey] = [
            'product_id' => $product['product_id'],
            'name' => $product['name'],
            'price' => $price,
            'image' => $product['image'],
            'size' => $size,
            'color' => $color,
            'quantity' => $quantity
        ];
    
        header('Location: /index.php?action=cart');
        exit;
    }

    // Hiển thị giỏ hàng
    public function cart() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return [
            'cart' => $cart,
            'total' => $total
        ];
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: /index.php?action=cart');
            exit;
        }
    
        $cartKey = isset($_POST['cart_key']) ? trim($_POST['cart_key']) : '';
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    
        if (empty($cartKey) || $quantity <= 0 || !isset($_SESSION['cart'][$cartKey])) {
            header('Location: /index.php?action=cart');
            exit;
        }
    
        $_SESSION['cart'][$cartKey]['quantity'] = $quantity;
    
        header('Location: /index.php?action=cart');
        exit;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCart() {
        $cartKey = isset($_GET['cart_key']) ? trim($_GET['cart_key']) : '';
    
        if (empty($cartKey) || !isset($_SESSION['cart'][$cartKey])) {
            header('Location: /index.php?action=cart');
            exit;
        }
    
        unset($_SESSION['cart'][$cartKey]);
    
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    
        header('Location: /index.php?action=cart');
        exit;
    }

    // Hiển thị trang thanh toán
    public function checkout() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: /index.php?action=cart');
            exit;
        }

        $cart = $_SESSION['cart'];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return [
            'cart' => $cart,
            'total' => $total
        ];
    }

    // Xử lý thanh toán và tạo đơn hàng
    public function payment() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: /index.php?action=cart');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /index.php?action=checkout');
            exit;
        }
    
        // Lấy thông tin từ form
        $fullName = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    
        // Kiểm tra thông tin
        if (empty($fullName) || empty($email) || empty($phone) || empty($address)) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";
            header('Location: /index.php?action=checkout');
            exit;
        }
    
        // Tính tổng tiền
        $cart = $_SESSION['cart'];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    
        // Lưu đơn hàng vào cơ sở dữ liệu
        $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
        $orderData = [
            'user_id' => $userId,
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'total_amount' => $total
        ];
    
        $orderId = $this->orderModel->createOrder($orderData);
    
        if ($orderId) {
            // Lưu chi tiết đơn hàng
            foreach ($cart as $item) {
                $orderDetailData = [
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'size' => $item['size'], // Thêm size
                    'color' => $item['color'] // Thêm color
                ];
                $this->orderModel->createOrderDetail($orderDetailData);
            }
    
            // Xóa giỏ hàng sau khi thanh toán thành công
            unset($_SESSION['cart']);
            $_SESSION['success'] = "Đặt hàng thành công! Mã đơn hàng của bạn là: #$orderId";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.";
        }
    
        header('Location: ?action=order_detail');
        exit;
    }
    public function order() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

        if ($userId <= 0) {
            header('Location: /index.php?action=login');
            exit;
        }

        $orders = $this->orderModel->getOrdersByUserId($userId);

        return [
            'orders' => $orders,
            'user_id' => $userId
        ];
    }
    public function orderDetail() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
        $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

        if ($userId <= 0) {
            header('Location: /index.php?action=login');
            exit;
        }

        if ($orderId <= 0) {
            header('Location: /index.php?action=order');
            exit;
        }

        $order = $this->orderModel->getOrderById($orderId);

        if (!$order || $order['user_id'] != $userId) {
            header('Location: /index.php?action=order');
            exit;
        }

        // Lấy chi tiết đơn hàng
        $orderDetails = $this->orderModel->getOrderDetailsByOrderId($orderId);

        // Lấy thông tin sản phẩm cho từng chi tiết đơn hàng
        foreach ($orderDetails as &$detail) {
            $product = $this->productModel->getProductById($detail['product_id']);
            if ($product) {
                // Tìm biến thể phù hợp với size và color
                $matchedVariant = null;
                foreach ($product['variants'] as $variant) {
                    if ($variant['size'] == $detail['size'] && $variant['color'] == $detail['color']) {
                        $matchedVariant = $variant;
                        break;
                    }
                }
                $detail['product'] = [
                    'name' => $product['name'],
                    'image' => $product['image'] ?? 'default.jpg',
                    'price' => $matchedVariant['price'] ?? $detail['price'] // Ưu tiên giá từ variant
                ];
            } else {
                $detail['product'] = [
                    'name' => 'Sản phẩm không xác định',
                    'image' => 'default.jpg',
                    'price' => $detail['price']
                ];
            }
        }

        return [
            'order' => $order,
            'orderDetails' => $orderDetails
        ];
    }
    
}