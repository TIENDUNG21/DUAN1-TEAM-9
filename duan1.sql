-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th4 02, 2025 lúc 03:56 PM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duan1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Giày thể thao', 'Giày dành cho hoạt động thể thao, chạy bộ, tập gym'),
(2, 'Giày da', 'Giày da sang trọng, phù hợp đi làm, dự tiệc'),
(3, 'Giày cao gót', 'Giày cao gót cho nữ, thời trang và thanh lịch'),
(5, 'dũng test', 'dũng test');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `product_id`, `content`, `created_at`) VALUES
(1, 12, 3, 'kk', '2025-04-02 12:50:56'),
(2, 12, 3, 'kk', '2025-04-02 12:51:04'),
(3, 12, 3, 'kk', '2025-04-02 12:51:13'),
(4, 12, 3, 'kk', '2025-04-02 12:52:03'),
(5, 12, 3, 'kk', '2025-04-02 12:53:28'),
(6, 12, 3, 'kk', '2025-04-02 12:55:33'),
(7, 12, 3, 'kk', '2025-04-02 12:56:35'),
(8, 12, 3, 'kk', '2025-04-02 13:00:26'),
(9, 12, 3, 'kk\r\n', '2025-04-02 13:00:31'),
(10, 12, 3, 'hh', '2025-04-02 13:01:27'),
(11, 12, 3, 'hhhhhh', '2025-04-02 13:01:58'),
(12, 12, 3, 'kk', '2025-04-02 13:02:05'),
(13, 12, 3, 'kk', '2025-04-02 13:03:02'),
(14, 12, 3, 'hưng kiều', '2025-04-02 13:06:10'),
(15, 12, 8, 'kk', '2025-04-02 13:08:34'),
(16, 12, 3, 'kk', '2025-04-02 13:10:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Chờ xác nhận','Đang giao','Đã giao','Hủy') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Chờ xác nhận',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `full_name`, `email`, `phone`, `address`, `total_amount`, `status`, `created_at`) VALUES
(3, 4, 'dungtest', 'dungptph49495@gmail.com', '0787140137', 'xzczxc\r\nzxc', 3600000.00, 'Đang giao', '2025-03-22 07:16:20'),
(4, 6, 'dungtest', 'fpolyduan@gmail.com', '0826483753', 'xzczxc\r\nzxc', 162000.00, 'Chờ xác nhận', '2025-03-22 08:34:32'),
(5, 6, 'dungtest2', 'dungtest@gmail.com', '093745638547', 'xzczxc\r\nzxc', 1200000.00, 'Chờ xác nhận', '2025-03-22 08:49:56'),
(9, 12, 'Phi Hung', 'hungpkph49841@gmail.com', '0346342005', 'Hanoi', 4000000.00, 'Chờ xác nhận', '2025-03-31 11:33:21'),
(10, 12, 'Phi Hung', 'hungpkph49841@gmail.com', '0346342005', 'Hanoi', 2000000.00, 'Chờ xác nhận', '2025-03-31 11:42:49'),
(12, 12, 'Phi Hung', 'hungpkph49841@gmail.com', '0346342005', 'Hanoi', 2000000.00, 'Chờ xác nhận', '2025-03-31 11:49:25'),
(13, 12, 'Phi Hung', 'hungpkph49841@gmail.com', '0346342005', 'Hanoi', 2000000.00, 'Chờ xác nhận', '2025-03-31 11:51:32'),
(14, 12, 'Phi Hung', 'hungpkph49841@gmail.com', '0346342005', 'Hanoi', 3500000.00, 'Chờ xác nhận', '2025-04-02 11:53:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_id`, `quantity`, `price`, `size`, `color`) VALUES
(3, 3, 4, 1, 1200000.00, '37', 'Trắng'),
(4, 3, 4, 1, 1200000.00, '38', 'Trắng'),
(5, 3, 4, 1, 1200000.00, '39', 'Đen'),
(8, 5, 4, 1, 1200000.00, '37', 'Trắng'),
(12, 9, 3, 1, 2000000.00, '38', 'Xám'),
(13, 9, 3, 1, 2000000.00, '38', 'Xám'),
(14, 10, 3, 1, 2000000.00, '38', 'Xám'),
(16, 12, 3, 1, 2000000.00, '38', 'Xám'),
(17, 13, 3, 1, 2000000.00, '38', 'Xám'),
(18, 14, 8, 1, 2300000.00, 'S', 'Đen trắng'),
(19, 14, 4, 1, 1200000.00, '37', 'Trắng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `is_on_sale` tinyint(1) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `description`, `price`, `old_price`, `is_on_sale`, `image`, `created_at`) VALUES
(1, 1, 'Nike Air Force 111', 'Giày thể thao cổ điển với thiết kế tinh tế, phù hợp cho mọi phong cách.', 1700000.00, 3400000.00, 1, 'nikeaf1.png', '2025-03-21 06:13:19'),
(2, 2, 'Adidas Ultraboost', 'Giày chạy bộ cao cấp với công nghệ Boost, mang lại cảm giác êm ái.', 2500000.00, NULL, 0, 'Mencco.jpg', '2025-03-21 06:13:19'),
(3, 2, 'Puma RS-X', 'Giày thể thao phong cách retro, nổi bật với màu sắc hiện đại.', 2000000.00, 3000000.00, 1, 'Mencco.jpg', '2025-03-21 06:13:19'),
(4, 1, 'Converse Chuck Taylor', 'Giày vải cổ điển, phù hợp cho cả nam và nữ.', 1200000.00, 1800000.00, 1, 'Mencco.jpg', '2025-03-21 06:13:19'),
(8, 1, 'Giày thể thao sneaker', 'Giày thể thao giá rẻ', 2300000.00, 4200000.00, 1, 'giay1.jpg', '2025-03-31 11:37:35'),
(10, 1, 'Giày thẻ thao nữ', 'Giày Thể Thao HồngLowtop Zoe (Giày Sneaker Hồng- LT001) giúp bạn luôn cảm thấy tự tin, thoải mái và thời trang mỗi bước đi. Phong cách giày sneaker basic phù hợp với nhiều đối tượng khác nhau, từ các bạn trẻ yêu thể thao đến những người yêu thích phong cách đơn giản và trẻ trung. Là sự lựa chọn hoàn hảo cho những buổi dạo phố, đi chơi hoặc thậm chí là cho những buổi đi làm casual.', 364000.00, 800000.00, 1, '17272523427143851(1).webp', '2025-03-31 12:05:01'),
(11, 1, 'ưadwdawwadawd', '', 123000.00, 123.00, 0, '17272523222407712_512.webp', '2025-03-31 12:26:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `variant_id` int NOT NULL,
  `product_id` int NOT NULL,
  `size` varchar(10) NOT NULL,
  `color` varchar(50) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `price` decimal(10,2) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `is_on_sale` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`variant_id`, `product_id`, `size`, `color`, `stock`, `price`, `old_price`, `is_on_sale`) VALUES
(1, 1, '38', 'Trắng', 5, 1700000.00, 3400000.00, 1),
(2, 1, '38', 'Đen', 0, 1700000.00, 3400000.00, 1),
(3, 1, '39', 'Trắng', 10, 1750000.00, 3500000.00, 1),
(4, 1, '39', 'Đỏ', 3, 1700000.00, 3400000.00, 1),
(5, 1, '40', 'Trắng', 8, 1700000.00, 3400000.00, 1),
(6, 2, '39', 'Đen', 7, NULL, NULL, NULL),
(7, 2, '40', 'Xanh', 4, 2600000.00, NULL, 0),
(8, 2, '41', 'Đen', 2, NULL, NULL, NULL),
(9, 3, '38', 'Xám', 6, NULL, NULL, NULL),
(10, 3, '39', 'Đen', 3, 2100000.00, 3200000.00, 1),
(11, 3, '40', 'Xám', 3, NULL, NULL, NULL),
(12, 4, '37', 'Trắng', 12, NULL, NULL, NULL),
(13, 4, '38', 'Đen', 8, NULL, NULL, NULL),
(14, 4, '39', 'Xanh Navy', 5, 1300000.00, 1900000.00, 1),
(22, 8, 'S', 'Đen trắng', 20, NULL, NULL, 0),
(24, 10, 'M', 'Hồng', 10, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `promotion_id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`promotion_id`, `code`, `discount`, `start_date`, `end_date`, `description`) VALUES
(1, 'SALE2025', 20.00, '2025-03-01', '2025-03-31', 'Giảm giá 20% cho tất cả sản phẩm trong tháng 3'),
(2, 'FREESHIP', 0.00, '2025-03-01', '2025-12-31', 'Miễn phí vận chuyển cho đơn hàng trên 1 triệu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reports`
--

CREATE TABLE `reports` (
  `report_id` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `data` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `reports`
--

INSERT INTO `reports` (`report_id`, `type`, `data`, `created_at`) VALUES
(1, 'Doanh thu', '{\"month\": \"03/2025\", \"total_revenue\": 4700000, \"orders\": 2}', '2025-03-03 02:00:00'),
(2, 'Khách hàng', '{\"new_users\": 2, \"active_users\": 2}', '2025-03-03 02:30:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support`
--

CREATE TABLE `support` (
  `support_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `response` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` int NOT NULL DEFAULT '0',
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `birth_date` datetime DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `avatar` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `role`, `full_name`, `phone`, `address`, `created_at`, `birth_date`, `gender`, `avatar`) VALUES
(2, 'dungtest', '123', 'client1@example.com', 0, 'Dũng test', '0912344235', 'FPOLY hanoi', '2025-02-01 08:30:00', '2025-03-21 14:57:46', '0', ''),
(3, 'dungtest2', '123', 'dungtest2@example.com', 0, 'Dũng test2', '0923456789', 'FPOLY hanoi', '2025-03-01 02:00:00', '2025-03-21 14:57:46', '0', ''),
(4, 'dungtest3', '123', 'dungtest3@example.com', 1, 'dungtest3', '09416118832', 'xzczxc\r\nzxc', '2025-03-21 07:26:49', '2025-03-21 00:00:00', 'male', ''),
(6, 'dungtest4', '123', 'dungtest4@gmail.com', 0, 'dũng test4', '1234567891', 'xzczxc\r\nzxc', '2025-03-22 08:31:28', '2008-10-19 00:00:00', 'male', ''),
(11, 'phamtiendung', '$2y$10$F8nz9Ihr9U6KxMsviNd.suscXMKl2ZqHtXcWS2.wkzMNxLM8zEZJi', 'dungptph49495@gmail.com', 1, 'Phạm Tiến Dũng', '0123456789', 'FPOLY HANOI', '2025-03-23 04:55:11', NULL, NULL, '1742705871_Hinh-nen-may-man-tai-loc-cho-may-tinh-1.jpg'),
(12, 'kieuhung205', '$2y$10$vG3q/5t6G7XIlpWDvXfvx.yqZ7Nymb4Su29e.D.zq3WFX4NKPPd3u', 'hungpkph49841@gmail.com', 0, NULL, '0346342005', NULL, '2025-03-31 11:32:35', NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`variant_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promotion_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Chỉ mục cho bảng `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`support_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `variant_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promotion_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `support`
--
ALTER TABLE `support`
  MODIFY `support_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `support`
--
ALTER TABLE `support`
  ADD CONSTRAINT `support_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
