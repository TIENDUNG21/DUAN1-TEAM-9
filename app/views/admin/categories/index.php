<?php include __DIR__ . '/../auth/admin.php';  ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
        body {
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            height: 100%;
            background-color: black;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
        }
        .sidebar a ion-icon {
            font-size: 22px;
            margin-right: 10px;
        }
        .sidebar a:hover {
            background-color: #333;
        }
    </style>
</head>
<body class="d-flex">
    <div class="sidebar d-flex flex-column">
        <a href="?action=dashboard">
            <ion-icon name="home-outline"></ion-icon> Home
        </a>
        <a href="?action=products">
            <ion-icon name="cube-outline"></ion-icon> Sản Phẩm
        </a>
        <a href="?action=categories">
            <ion-icon name="list-outline"></ion-icon> Danh Mục
        </a>
        <a href="?action=orders">
            <ion-icon name="cart-outline"></ion-icon> Đơn Hàng
        </a>
        <a href="?action=users">
            <ion-icon name="person-outline"></ion-icon> Khách Hàng
        </a>
        <a href="?action=reports">
            <ion-icon name="bar-chart-outline"></ion-icon> Thống Kê
        </a>
        <a href="index.php?action=logout">
            <ion-icon name="log-out-outline"></ion-icon> Thoát Admin
        </a>
    </div>

    <div class="flex-grow-1 d-flex align-items-center justify-content-center">
        <h1 class="fw-bold">Welcome to Admin Panel</h1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>