-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 10:35 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbecomm`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  `category` enum('Womens','Mens','Kids') NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `name`, `price`, `category`, `description`, `quantity`, `available`) VALUES
(157573, 'assets/products/dusty olive.png', 'Dusty Olives', 3000.00, 'Mens', 'SIZE: 9 MENS (27CM)\r\nEXCELLENT CONDITION\r\nNO ISSUES', 1, 1),
(180479, 'assets/products/Corduroy Tigger Sleeves.jpg', 'Corduroy Sleeves', 450.00, 'Mens', 'SIZE: XL\r\nW:26\r\nL:29\r\nS:21', 1, 1),
(184631, 'assets/products/nike kids.jpg', 'Nike (Kids)', 1000.00, 'Kids', 'For ages 4-6<br />\r\nEXCELLENT CONDITION', 1, 1),
(279762, 'assets/products/PandaS.png', 'Panda Dunks', 2500.00, 'Mens', 'SIZE: 8.5 MENS (26.5)\r\nEXCELLENT CONDITION\r\nNO ISSUES', 1, 1),
(309547, 'assets/products/red dress child.jpg', 'Red Dress', 200.00, 'Kids', 'For ages 7-9<br />\r\nEXCELLENT CONDITION<br />\r\n', 1, 1),
(339445, 'assets/products/sport terno ble.jpg', 'Sports Terno (Blue)', 350.00, 'Kids', 'For ages 10-12<br />\r\nEXCELLENT CONDITION', 1, 1),
(382991, 'assets/products/mermaid dre.jpg', 'Mermaid Dress', 300.00, 'Kids', 'For ages 8-10<br />\r\nExcellent Condition', 1, 1),
(397659, 'assets/products/sport terno red.jpg', 'Sports Terno (Red)', 350.00, 'Kids', 'For ages 10-12<br />\r\nEXCELLENT CONDITION', 1, 1),
(423110, 'assets/products/sleevles top n sho.jpg', 'Sleeveless top (Terno)', 250.00, 'Kids', 'For ages 10-12', 1, 1),
(455298, 'assets/products/BLACK SHORTS.jpg', 'Black Shorts', 250.00, 'Womens', 'SIZE: MEDIUM\r\nEXCELLENT CONDITION\r\n', 1, 1),
(461588, 'assets/products/CORDUROY SKIRT.jpg', 'Corduroy Skirt', 450.00, 'Womens', 'SIZE: S - M\r\nW:25\r\nL:27 ', 1, 1),
(465799, 'assets/products/rose whisper.png', 'Rose Whisper', 3500.00, 'Womens', 'SIZE: 6 WOMENS \r\nEXCELLENT CONDITION\r\nNO ISSUES', 1, 1),
(481947, 'assets/products/white children dress.jpg', 'White Dress', 200.00, 'Kids', 'For ages 7-9<br />\r\nEXCELLENT CONDITION', 1, 1),
(527049, 'assets/products/SKIRT GRIND LINES.jpg', 'Skirt Grid Lines', 250.00, 'Womens', 'SIZE: SMALL', 1, 1),
(529479, 'assets/products/Harrington Jacket.jpg', 'Harrington Jacket', 750.00, 'Mens', 'SIZE: XL - XXL\r\n\r\nW:27 \r\nL:26\r\nS:24', 1, 1),
(530641, 'assets/products/90s Carpenter Denim.jpg', '90s Denim', 350.00, 'Mens', 'SIZE: XXL\r\nW:37\r\nL:41', 1, 1),
(625610, 'assets/products/syracuse.png', 'Syracuse', 3000.00, 'Womens', 'SIZE: 5 WOMENS\r\nEXCELLENT CONDITION\r\nNO ISSUES', 1, 1),
(670120, 'assets/products/Levis Jorts.jpg', 'Levis Jorts', 650.00, 'Mens', 'SIZE: XL - XXL\r\nW:36\r\nL:20', 1, 1),
(771164, 'assets/products/SPACE DRESS.jpg', 'Space Dress', 200.00, 'Womens', 'SIZE: MEDIUM', 1, 1),
(790382, 'assets/products/SHOLDR DRESS.jpg', 'Shoulder Dress', 400.00, 'Womens', 'SIZE: MEDIUM', 1, 1),
(834743, 'assets/products/Chunky Jorts.jpg', 'Chunky Jorts', 500.00, 'Mens', 'SIZE: XL - XXL\r\nW:36\r\nL:20', 1, 1),
(887044, 'assets/products/RED SHORTS.jpg', 'Red Shorts', 300.00, 'Womens', 'Size: SMALL\r\nW:12\r\n L:14.5', 1, 1),
(961722, 'assets/products/nb kids.jpg', 'New Balance (Kids)', 1200.00, 'Kids', 'For ages 4-6<br />\r\nEXCELLENT CONDITION', 1, 1),
(979545, 'assets/products/Levis 560.jpg', 'Levis 560', 800.00, 'Mens', 'SIZE: XL-XXL\r\nW:33\r\nL:43', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` float(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address_line1` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblorder_products`
--

CREATE TABLE `tblorder_products` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblregusers`
--

CREATE TABLE `tblregusers` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblregusers`
--

INSERT INTO `tblregusers` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'pass123', 'admin@gmail.com', 'assets/profile/chae.jpg'),
(3, 'lexx', 'lexx', 'lexgustilo6@gmail.com', 'assets/profile/chaeeeeeee.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbltransactions`
--

CREATE TABLE `tbltransactions` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` float(10,2) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblorder_products`
--
ALTER TABLE `tblorder_products`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `tblorder_products_ibfk_1` (`order_id`);

--
-- Indexes for table `tblregusers`
--
ALTER TABLE `tblregusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbltransactions`
--
ALTER TABLE `tbltransactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=991174;

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tblregusers`
--
ALTER TABLE `tblregusers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbltransactions`
--
ALTER TABLE `tbltransactions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD CONSTRAINT `tblcart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `tblorder_products`
--
ALTER TABLE `tblorder_products`
  ADD CONSTRAINT `tblorder_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tblorders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblorder_products_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbltransactions`
--
ALTER TABLE `tbltransactions`
  ADD CONSTRAINT `tbltransactions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `tbltransactions_ibfk_2` FOREIGN KEY (`username`) REFERENCES `tblregusers` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
