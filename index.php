<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';



//Admin-Controller
use App\controllers\AdminProductController;
use App\controllers\AdminCategoryController;
use App\controllers\AdminOrderController;
use App\controllers\AdminUserController;
use App\controllers\AuthController;
//User-Controller
use App\controllers\ProductController;
use App\controllers\CartController;

//Admin-c
$AdminProduct = new AdminProductController();
$AdminCategory = new AdminCategoryController();
$AdminOrder = new AdminOrderController();
$AdminUser = new AdminUserController();
$AuthController = new AuthController();
//User-c
$Productcontroller = new ProductController();
$CartController = new CartController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

switch ($action) {
    // Phần cho người dùng 
    case 'show':
        // if ($userRole === 'guest') {
        //     die("Vui lòng đăng nhập để xem chi tiết!");
        // }
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = $Productcontroller->show($id);
        require_once __DIR__ . '/app/views/client/product-detail.php';
        break;
    case 'index':
        $products = $Productcontroller->index();
        require_once __DIR__ . '/app/views/home.php';
        break;
    case 'category':
        $data = $Productcontroller->category();
        $products = $data['products'];
        $categories = $data['categories'];
        $currentPage = $data['currentPage'];
        $totalPages = $data['totalPages'];
        $categoryId = $data['categoryId'];
        require_once __DIR__ . '/app/views/client/category.php';
        break;    
    case 'sale':
        $data = $Productcontroller->sale();
        $products = $data['products'];
        $categories = $data['categories'];
        $currentPage = $data['currentPage'];
        $totalPages = $data['totalPages'];
        require_once __DIR__ . '/app/views/client/sale.php';
        break;   
    case 'add_to_cart':
        $CartController->addToCart();
        break; 
    case 'cart':
        $data = $CartController->cart();
        $cart = $data['cart'];
        $total = $data['total'];
        require_once __DIR__ . '/app/views/client/cart.php';
        break;
    case 'update_cart':
        $CartController->updateCart();
        break;
    case 'delete_cart':
        $CartController->deleteCart();
        break;
    case 'checkout':
        $data = $CartController->checkout();
        $cart = $data['cart'];
        $total = $data['total'];
        require_once __DIR__ . '/app/views/client/checkout.php';
        break;
    case 'order_detail':
        $data = $CartController->orderDetail();
        $order = $data['order'];
        $orderDetails = $data['orderDetails'];
        require_once __DIR__ . '/app/views/client/order-detail.php';
        break;    
    case 'order':
        $data = $CartController->order();
        $orders = $data['orders'];
        $userId = $data['user_id'];;
        require_once __DIR__ . '/app/views/client/order.php';
        break;    
    // Xử lý thanh toán
    case 'payment':
        $CartController->payment();
        break;    
    // Phần tất cả sản phẩm
    // case 'all_product':
    //     $products = $Productcontroller->index();
    //     require_once __DIR__. '/app/views/client/all-product.php';
    //     break;    
    case 'search':
        $data = $Productcontroller->search();
        $products = $data['products'];
        $categories = $data['categories'];
        $currentPage = $data['currentPage'];
        $totalPages = $data['totalPages'];
        $keyword = $data['keyword'];
        require_once __DIR__ . '/app/views/client/search.php';
        break;
    case 'login':
        $data = $AuthController->login();
        if (isset($data['error'])) {
            $error = $data['error'];
        }
        require_once __DIR__ . '/app/views/auth/login.php';
        break;

    // Đăng ký
    case 'register':
        $data = $AuthController->register();
        if (isset($data['error'])) {
            $error = $data['error'];
        }
        require_once __DIR__ . '/app/views/auth/register.php';
        break;
    // Đăng xuất
    case 'logout':
        $AuthController->logout();
        break;
    case 'profile' :
        $data = $AuthController->index();
        if (isset($data['error'])) {
            $error = $data['error'];
        }
        $user = $data['user'];
        require_once __DIR__. '/app/views/client/profile.php';
        break;    
    // Phần cho admin

    case 'dashboard':
        // if ($userRole !== 'Admin') {
        //     die("Bạn không có quyền truy cập!");
        // }
        require_once __DIR__ . '/app/views/admin/index.php';
        break;

    case 'products':
        // if ($userRole !== 'Admin') {
        //     die("Bạn không có quyền truy cập!");
        // }
        $products = $AdminProduct->index();
        require_once __DIR__ . '/app/views/admin/products/index.php';
        break;

    case 'add_product':
       
        $categories = $AdminProduct->add();
        require_once __DIR__ . '/app/views/admin/products/add.php';
        break;
    case 'add_variant':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $data = $AdminProduct->addVariant($id);
        extract($data);
        require_once __DIR__ . '/app/views/admin/products/add_variant.php';
        break;    
    case 'edit_product':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $data = $AdminProduct->edit($id);
        $product = $data['product'];
        $categories = $data['categories'];
        require_once __DIR__ . '/app/views/admin/products/edit.php';
        break;

    case 'delete_product':
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $AdminProduct->delete($id);
        break;
    case 'categories':
      
        $categories = $AdminCategory->index();
        require_once __DIR__ . '/app/views/admin/categories/index.php';
        break;

    case 'add_category':
       
        $AdminCategory->add();
        require_once __DIR__ . '/app/views/admin/categories/add.php';
        break;

    case 'edit_category':
      
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $category = $AdminCategory->edit($id);
        require_once __DIR__ . '/app/views/admin/categories/edit.php';
        break;

    case 'delete_category':
      
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $AdminCategory->delete($id);
        break;

    // Quản lý đơn hàng
    case 'orders':
       
        $orders = $AdminOrder->index();
        require_once __DIR__ . '/app/views/admin/orders/index.php';
        break;

    case 'view_order':
      
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $data = $AdminOrder->view($id);
        $order = $data['order'];
        $orderDetails = $data['orderDetails'];
        require_once __DIR__ . '/app/views/admin/orders/view.php';
        break;

    case 'update_order':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $order = $AdminOrder->update($id);
        require_once __DIR__ . '/app/views/admin/orders/update.php';
        break;

    case 'delete_order':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $AdminOrder->delete($id);
        break;
    // Quản lý khách hàng
    case 'users':
        $users = $AdminUser->index();
        require_once __DIR__ . '/app/views/admin/users/index.php';
        break;
    case 'add_user':
        $AdminUser->add();
        require_once __DIR__ . '/app/views/admin/users/add.php';
        break;
    case 'edit_user':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $user = $AdminUser->edit($id);
        require_once __DIR__ . '/app/views/admin/users/edit.php';
        break;
    case 'view_user':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $user = $AdminUser->view($id);
        require_once __DIR__ . '/app/views/admin/users/view.php';
        break;
    default:
        $products = $Productcontroller->index();
        require_once __DIR__ . '/app/views/home.php';
        break;
}