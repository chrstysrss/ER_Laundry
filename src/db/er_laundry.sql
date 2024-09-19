-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2023 at 04:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `er_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` enum('Employee','Manager') NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `username`, `first_name`, `last_name`, `password`, `phone`, `email`, `role`, `status`, `created_at`) VALUES
(1, 'admin', 'Administrator', '', '$2y$10$T30maj9KZ4tDZTYNUqNWHO.v22cTfuU02Lc.5Q53RflG42CLwTJh6', '', '', 'Manager', 1, '2023-09-30'),
(2, 'TEST-1111', 'John', 'Doe', '$2y$10$TFrRTzAiCULkslO4eWWx0eDLkIqu/jlhD5mq0zpRp8JSL3TbiEA0a', '09161002000', 'test@gmail.com', 'Employee', 1, '2023-09-30'),
(3, 'TEST-2222', 'Aileen', 'Smith', '$2y$10$FSR/zpBtgyJTSg2JMJLmV.X4lbdRifeOzkSvMP/lhE2VSE2jjgsMW', '09161112222', 'test2@gmail.com', 'Employee', 0, '2023-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_firstname` varchar(50) DEFAULT NULL,
  `customer_lastname` varchar(50) DEFAULT NULL,
  `customer_phone` varchar(11) DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `amount_received` decimal(10,2) NOT NULL,
  `amount_change` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_firstname`, `customer_lastname`, `customer_phone`, `discount`, `grand_total`, `amount_received`, `amount_change`, `date`, `time`, `employee_id`) VALUES
(1, 'Sarel', 'Pebida', '09645557777', 0.00, 166.00, 200.00, 34.00, '2022-12-23', '08:19:54', 2),
(2, 'Francis', 'Villarba', '09120001234', 0.00, 150.00, 150.00, 0.00, '2022-12-23', '14:29:48', 2),
(3, 'Aloha', 'Haiya', '09121231234', 8.00, 220.00, 220.00, 0.00, '2023-01-03', '01:55:59', 2),
(4, 'Test9', '', '09129999999', 16.00, 300.00, 500.00, 200.00, '2023-01-05', '05:58:00', 2),
(5, 'Test6', 'Test6', '09126666666', 0.00, 10.00, 10.00, 0.00, '2023-01-05', '06:06:10', 2),
(6, 'Test8', 'Test8', '09888888888', 0.00, 120.00, 120.00, 0.00, '2023-02-16', '06:06:15', 2),
(7, 'Test7', 'Test7', '09127777777', 0.00, 370.00, 400.00, 30.00, '2023-02-20', '06:06:37', 3),
(8, 'Test', 'Testing', '09000000000', 0.00, 109.00, 109.00, 0.00, '2023-05-17', '06:09:18', 3),
(9, 'Test9', '', '09129999999', 0.00, 100.00, 100.00, 0.00, '2023-05-18', '00:12:54', 3),
(10, 'Aloha', 'Haiya', '09121231234', 0.00, 130.00, 150.00, 20.00, '2023-05-18', '00:13:36', 2),
(11, NULL, NULL, NULL, 100.00, 30.00, 50.00, 20.00, '2023-08-25', '22:39:48', 2),
(12, NULL, NULL, NULL, 100.00, 50.00, 50.00, 0.00, '2023-08-26', '13:21:54', 2),
(13, NULL, NULL, NULL, 0.00, 1000.00, 1000.00, 0.00, '2023-08-26', '13:24:20', 2),
(14, 'test2', 'test2', '09112223333', 90.00, 110.00, 200.00, 90.00, '2023-08-26', '14:07:48', 2),
(15, NULL, NULL, NULL, 0.00, 150.00, 150.00, 0.00, '2023-09-25', '23:59:42', 3),
(16, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0.00, '2023-09-26', '00:00:04', 3),
(17, NULL, NULL, NULL, 80.00, 100.00, 500.00, 400.00, '2023-09-26', '00:04:54', 1),
(18, NULL, NULL, NULL, 10000.00, 340.00, 40.00, 0.00, '2023-09-26', '15:36:06', 1),
(19, NULL, NULL, NULL, 100.00, 100.00, 500.00, 400.00, '2023-09-26', '15:41:35', 1),
(20, 'test', 'test', '091112323', 0.00, 70.00, 70.00, 0.00, '2023-09-26', '15:43:31', 2),
(21, NULL, NULL, NULL, 10.00, 200.00, 200.00, 0.00, '2023-09-30', '18:31:20', 1),
(22, 'Mary', 'Yeet', '09111512222', 0.00, 160.00, 160.00, 0.00, '2023-09-30', '18:33:04', 2),
(23, 'Joseph ', 'Magabilin', '09189987777', 0.00, 150.00, 150.00, 0.00, '2023-10-03', '15:20:13', 3),
(24, NULL, NULL, NULL, 0.00, 70.00, 70.00, 0.00, '2023-10-03', '15:32:47', 1),
(25, NULL, NULL, NULL, 10000.00, 190.00, 70.00, 10.00, '2023-10-03', '15:42:02', 2),
(26, NULL, NULL, NULL, 0.00, 180.00, 180.00, 0.00, '2023-10-03', '15:42:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`, `total`) VALUES
(1, 1, 1, 70.00),
(1, 2, 1, 80.00),
(1, 4, 1, 8.00),
(1, 5, 1, 8.00),
(2, 1, 1, 70.00),
(2, 2, 1, 80.00),
(3, 1, 1, 70.00),
(3, 2, 1, 80.00),
(3, 3, 1, 30.00),
(3, 4, 3, 24.00),
(3, 5, 3, 24.00),
(4, 1, 2, 20.00),
(4, 2, 2, 160.00),
(4, 3, 1, 30.00),
(4, 6, 3, 30.00),
(4, 5, 4, 76.00),
(5, 1, 1, 10.00),
(6, 1, 1, 10.00),
(6, 2, 1, 80.00),
(6, 3, 1, 30.00),
(7, 6, 2, 20.00),
(7, 1, 3, 30.00),
(7, 2, 4, 320.00),
(8, 1, 1, 10.00),
(8, 2, 1, 80.00),
(8, 5, 1, 19.00),
(10, 1, 5, 50.00),
(10, 2, 1, 80.00),
(11, 3, 1, 30.00),
(11, 2, 1, 80.00),
(11, 6, 2, 20.00),
(12, 1, 1, 70.00),
(12, 2, 1, 80.00),
(13, 6, 100, 1000.00),
(14, 3, 4, 120.00),
(14, 2, 1, 80.00),
(15, 1, 1, 70.00),
(15, 2, 1, 80.00),
(17, 1, 1, 70.00),
(17, 2, 1, 80.00),
(17, 3, 1, 30.00),
(18, 2, 3, 240.00),
(18, 1, 1, 70.00),
(18, 3, 1, 30.00),
(18, 7, 1, 10000.00),
(19, 1, 1, 70.00),
(19, 2, 1, 80.00),
(19, 3, 1, 30.00),
(19, 6, 1, 10.00),
(19, 8, 1, 10.00),
(20, 1, 1, 70.00),
(21, 1, 1, 70.00),
(21, 2, 1, 80.00),
(21, 3, 1, 30.00),
(21, 6, 3, 30.00),
(22, 1, 1, 70.00),
(22, 2, 1, 80.00),
(22, 6, 1, 10.00),
(23, 1, 1, 70.00),
(23, 2, 1, 80.00),
(24, 1, 1, 70.00),
(25, 2, 1, 80.00),
(25, 6, 1, 10.00),
(25, 1, 1, 70.00),
(25, 3, 1, 30.00),
(25, 7, 1, 10000.00),
(26, 2, 1, 80.00),
(26, 3, 1, 30.00),
(26, 1, 1, 70.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_type` enum('Service','Consumables') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_type`, `description`, `price`, `stock`) VALUES
(1, 'Wash', 'Service', NULL, 70.00, NULL),
(2, 'Dry', 'Service', NULL, 80.00, NULL),
(3, 'Drop-off', 'Service', NULL, 30.00, NULL),
(5, 'Fabric Conditioner', 'Consumables', NULL, 19.00, 0),
(6, 'Large White Plastic', 'Consumables', 'size : 12 inches x 15 inches', 10.00, 100),
(7, 'detergent', 'Consumables', 'fjdklafj;dkfd', 10000.00, 1),
(8, 'test', 'Consumables', '', 10.00, 5),
(9, 'test2', 'Consumables', NULL, 3.00, 34),
(10, 'test3', 'Consumables', NULL, 111.00, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_employee` (`employee_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD KEY `details_order` (`order_id`),
  ADD KEY `details_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
