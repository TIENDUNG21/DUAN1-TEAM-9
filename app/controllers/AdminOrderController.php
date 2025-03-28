<?php
namespace App\controllers;

use App\models\OrderModel;
use App\models\ProductModel;
class AdminOrderController {
    private $orderModel;
    private $productModel;
    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
    }

    // Hiển thị danh sách đơn hàng
    public function index() {
        $orders = $this->orderModel->getAllOrders();
        
        return $orders;
    }
    

    public function view($id) {
        // Lấy thông tin đơn hàng
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            die("Đơn hàng không tồn tại!");
        }

        // Lấy chi tiết đơn hàng
        $orderDetails = $this->orderModel->getOrderDetailsByOrderId($id);

        // Lấy thông tin sản phẩm và khớp với biến thể
        foreach ($orderDetails as &$detail) {
            $product = $this->productModel->getProductById($detail['product_id']);
            if ($product) {
                // Tìm biến thể phù hợp với size và color trong order_details
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
                    'price' => $matchedVariant['price'] ?? $product['price'],
                    'variant' => $matchedVariant
                ];
            } else {
                $detail['product'] = [
                    'name' => 'Sản phẩm không xác định',
                    'image' => 'default.jpg',
                    'price' => $detail['price']
                ];
            }
        }

        // Trả về dữ liệu
        return [
            'order' => $order,
            'orderDetails' => $orderDetails
        ];
    }
    

    // Cập nhật trạng thái đơn hàng
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            $this->orderModel->updateOrderStatus($id, $status);
            header('Location: /index.php?action=orders');
            exit;
        }

        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            die("Đơn hàng không tồn tại!");
        }
        return $order;
    }

    // Xóa đơn hàng
    public function delete($id) {
        $this->orderModel->deleteOrder($id);
        header('Location: /index.php?action=orders');
        exit;
    }
}