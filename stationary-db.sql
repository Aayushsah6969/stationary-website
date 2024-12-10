-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 09:54 AM
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
-- Database: `stationary`
--

-- --------------------------------------------------------

--
-- Table structure for table `authenticate`
--

CREATE TABLE `authenticate` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `last_attempt_time` datetime DEFAULT NULL,
  `is_blocked` tinyint(1) DEFAULT 0,
  `block_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authenticate`
--

INSERT INTO `authenticate` (`username`, `password`, `login_attempts`, `last_attempt_time`, `is_blocked`, `block_until`) VALUES
('aayush', '$2y$10$eN/oLoVWlm.ILoKSgzP82.xGtLafBKmPqmWo8YVr/uPq0Cnce2.uS', 3, NULL, 1, '2024-05-20 18:25:45'),
('@@aayush', '$2y$10$lP5MV5bvmraJEP2f3t2L7OLuDFkUyUoioIZudMim.ewdASzMBkQa.', 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'aa', 'a@gmail.com', 'aa', '2024-05-19 08:46:54'),
(2, 'contact', 'cont@gmail.com', 'contact', '2024-05-19 09:02:18');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_contact_number` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `product_id`, `product_name`, `order_quantity`, `customer_email`, `customer_contact_number`, `customer_address`, `order_date`) VALUES
(2, 'item', 6, 'items', 1, 'itme@gmail.com', '99999999999', 'rajbiraj', '2024-05-18 07:03:20'),
(3, 'Aayush', 27, 'Stationary tool box', 2, 'aa@gmail.com', '142355343', 'Nepal', '2024-05-18 08:16:00'),
(4, 'KUmar', 28, 'Gropu', 3, 'aks@gmail.com', '78576565', 'hg@gmail.com', '2024-05-18 08:16:35'),
(5, 'sah', 25, 'Notebooks', 6, 'nt@gmail.com', '775855765', 'nt@gmail.com', '2024-05-18 08:17:19'),
(6, 'customer', 11, 'tablet', 3, 'customer@gmail.com', '00990099', 'customer', '2024-05-18 09:54:20'),
(7, 'testing', 11, 'tablet', 1, 'testing@gmail.com', '111111111', 'testing', '2024-05-18 10:06:02'),
(8, 'notebook', 6, 'items', 3, 'notebook@gmail.com', '2311123', 'notebook', '2024-05-18 10:27:41'),
(10, 'mom pen', 5, 'Pen1', 1, 'mp@gmail.com', '1111111', 'mompen', '2024-05-18 15:12:09'),
(13, 'dummy', 22, 'tools', 3, 'd@gmail.com', '98984954', 'dummy', '2024-05-19 03:11:23'),
(14, 'featured', 8, 'colors', 1, 'featured@gmail.com', '111111111111', 'featured', '2024-05-19 09:01:04'),
(15, 'shop', 7, 'block', 2, 'shop@gmail.com', '22222222', 'shop', '2024-05-19 09:01:31'),
(16, 'topseller', 16, 'tools', 3, 'topseller@gmail.com', '3333333', 'topseller', '2024-05-19 09:02:02'),
(17, 'new ', 8, 'colors', 2, 'new@gmail.com', '44444444', 'new', '2024-05-20 07:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_brand` varchar(100) DEFAULT NULL,
  `product_category` varchar(100) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_image`, `product_description`, `product_brand`, `product_category`, `product_price`) VALUES
(4, 'Lenovo laptop', 'uploads/images (1).jpeg', 'This is a demo product test1 for a laptop', 'Lenovo', 'Laptop', 99445.00),
(5, 'Pen1', 'uploads/pewn1.jpg', 'pen', 'pen', 'pen', 9678.00),
(6, 'items', 'uploads/items.jpg', 'items', 'items', 'items', 3344.00),
(7, 'block', 'uploads/block.jpg', 'block', 'block', 'block', 5544.00),
(8, 'colors', 'uploads/colors.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'color', 'color', 999.00),
(9, 'bags', 'uploads/bags.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'bag', 'bag', 9988.00),
(11, 'tablet', 'uploads/tablets.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tablet', 'tablet', 2222.00),
(13, 'tablet', 'uploads/tablets.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tablet', 'tablet', 2222.00),
(14, 'tablet', 'uploads/tablets.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tablet', 'tablet', 2222.00),
(16, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(17, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(18, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(19, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(20, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(21, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(22, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(23, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(24, 'tools', 'uploads/tools.jpg', 'With DummyJSON, what you get is different types of REST Endpoints filled with JSON data which you can use in developing the frontend with your favorite framework and library without worrying about writing a backend.', 'tools', 'tools', 44553.00),
(25, 'Notebooks', 'uploads/computer-stationery.png', 'Notebooks ', 'Classmates ', 'Notebooks ', 100.00),
(26, 'Scissors ', 'uploads/LCIEbwN8EV_1024x.jpg', 'Scissors all science ', 'Cutter', 'Cuters', 505.00),
(27, 'Stationary tool box', 'uploads/LCIEbwN8EV_1024x.jpg', 'All tools required are given here.', 'Natraj', 'Given', 450.00),
(28, 'Gropu', 'uploads/images (2).jpeg', 'Group', 'Group', 'Group', 656.00),
(29, 'Sharpenner', 'uploads/sharp.jpg', 'This is a \nSharpenner', 'Sharpenner', 'Sharpenner', 5.00),
(30, 'papers', 'uploads/papers.jpg', 'this i sjust a demo paper for a final testing of this site', 'paper', 'paper', 55.00),
(31, 'Charger', 'uploads/charger.jpg', 'Charger is this', 'Lenovo', 'charger', 750.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
