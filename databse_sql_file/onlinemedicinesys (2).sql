-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2023 at 01:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinemedicinesys`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `first_name` varchar(70) NOT NULL,
  `last_name` varchar(70) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `admin_img` varchar(200) NOT NULL,
  `admin_type` varchar(20) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `domain` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `admin_email`, `phone`, `admin_img`, `admin_type`, `admin_pass`, `domain`) VALUES
(1, 'Super', 'Admin', 'info@food-coral.com', '741852963', '1677839072.png', 'admin', '$2y$10$SlBpafQSINcV0vKg14/1z.i.3ZHenTPe/nWcRpDcFURuXxaFAbley', 'food-coral.com'),
(2, 'Admin', 'PiPharm2', 'info@food-lover.store', '741852963', '1677839072.png', 'admin', '$2y$10$iFLCKc/lN4q4oLj7VNSyfuiXWKvmOKWUCkZL/KxaO5/5FYQArIzvC', 'food-lover.store'),
(3, 'Admin', 'PiPharm1', 'info1@food-coral.com', '741852963', '1678734530.png', 'admin', '$2y$10$SlBpafQSINcV0vKg14/1z.i.3ZHenTPe/nWcRpDcFURuXxaFAbley', 'food-coral.com'),
(4, 'Pi', 'Admin', 'infonew@food-coral.com', '741852963', '1677839072.png', 'admin', '$2y$10$SlBpafQSINcV0vKg14/1z.i.3ZHenTPe/nWcRpDcFURuXxaFAbley', 'food-coral.com'),
(8, 'Papiya', 'Sultana', 'papiyasultana@gmail.com', '01456789123', '1694965523.png', 'admin', '$2y$10$IaacL3WrIcZOAESFsJCZuuG0miZIaf.RX87lin6rQK7eGK9QYcI86', NULL),
(9, 'araf', 'Yeasin', 'arafyeasin@gmail.com', '01614756856', '1695012098.png', 'admin', '$2y$10$C0QUIi1OaTNQoqhldNyvuuE8pvNZJpOBu7IrDkGgDm9gs0O/Lm41i', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `attr_value` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `cart_Total` decimal(11,2) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `cat_image` varchar(30) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_name`, `cat_image`, `slug`, `admin_id`, `is_featured`, `created_date`) VALUES
(217, 'Medicine & Treatment', '1693772190.jpg', 'medicine-&-treatment', 1, 0, '2023-09-03 20:16:30'),
(218, 'Vitamnis & SUpliments', '1693772239.jpg', 'vitamnis-&-supliments', 1, 0, '2023-09-03 20:17:19'),
(219, 'Beauty & Health', '1693772269.jpg', 'beauty-&-health', 1, 0, '2023-09-03 20:17:49'),
(220, 'Diabetes & Blood Pressure', '1693772327.jpg', 'diabetes-&-blood-pressure', 1, 0, '2023-09-03 20:18:47'),
(221, 'Covid-19', '1693772362.jpg', 'covid-19', 1, 0, '2023-09-03 20:19:22'),
(222, 'General Drugs', '1693772399.jpg', 'general-drugs', 1, 0, '2023-09-03 20:19:59'),
(223, 'Skin Care', '1693772487.jpg', 'skin-care', 1, 0, '2023-09-03 20:21:27'),
(224, 'Others', '1693772588.jpg', 'others', 1, 0, '2023-09-03 20:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `order_code` varchar(25) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `attr_value` varchar(70) NOT NULL,
  `qty` int(11) NOT NULL,
  `subTotal` decimal(11,2) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(25) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `total_items` int(11) NOT NULL,
  `sale_amount` decimal(11,2) NOT NULL,
  `tax` decimal(11,2) NOT NULL,
  `shipping_cost` decimal(11,2) NOT NULL,
  `shipping_address` varchar(200) NOT NULL,
  `delivery_status` varchar(20) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `order_type` varchar(200) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_address`
--

CREATE TABLE `pharmacy_address` (
  `address_id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `zip_code` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacy_address`
--

INSERT INTO `pharmacy_address` (`address_id`, `pharmacy_id`, `address`, `country`, `zip_code`, `state`, `city`, `created_at`) VALUES
(1, 5, 'street', 'country', 'zipcode', 'state', 'city', '2023-09-26 15:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_admin`
--

CREATE TABLE `pharmacy_admin` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `admin_email` varchar(250) NOT NULL,
  `admin_phone` varchar(15) NOT NULL,
  `admin_pass` text NOT NULL,
  `admin_type` varchar(255) NOT NULL,
  `admin_img` text NOT NULL,
  `shop_name` varchar(250) NOT NULL,
  `shop_image` text NOT NULL,
  `brand_logo` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacy_admin`
--

INSERT INTO `pharmacy_admin` (`id`, `first_name`, `last_name`, `admin_email`, `admin_phone`, `admin_pass`, `admin_type`, `admin_img`, `shop_name`, `shop_image`, `brand_logo`, `status`, `created_by`, `created_at`) VALUES
(5, 'mahi1', 'alam', 'mahialam@gmail.com', '01614756856', '$2y$10$ECd.lbIU63.plJhvH3zhbeEVd6LV/LN/FYloBQ8r/6bVANKzZ6Zdm', 'pharmacy', '1695651558.png', ' storeName', 'BNR1696257029.jpg', 'LG1696257029.jpg', 'active', 8, '2023-10-02 15:05:25');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prd_id` int(11) NOT NULL,
  `prd_image` varchar(300) DEFAULT NULL,
  `prd_name` varchar(100) NOT NULL,
  `prd_cat_id` int(11) NOT NULL,
  `prd_sub_cat_id` int(11) NOT NULL,
  `prd_price` decimal(11,2) NOT NULL,
  `prd_description` varchar(400) DEFAULT NULL,
  `slug` varchar(200) NOT NULL,
  `prd_status` varchar(30) DEFAULT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prd_id`, `prd_image`, `prd_name`, `prd_cat_id`, `prd_sub_cat_id`, `prd_price`, `prd_description`, `slug`, `prd_status`, `pharmacy_id`, `created_date`) VALUES
(1815, '1693847535-0assortment-colorful-pills.jpg', 'Napa2', 217, 4, 1.00, '<p>this is the description</p>', 'napa', 'In Stock', 1, '2023-09-05 15:16:52'),
(1817, '1695141844-0electricity-transmission-pylon-silhouetted-against-blue-sky-d.jpg', 'Ace', 217, 5, 2.00, '<p>asdasdasd</p>', 'ace', 'In Stock', 8, '2023-09-19 16:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `slider_name` varchar(200) NOT NULL,
  `slider_image` varchar(300) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `slider_name`, `slider_image`, `slug`, `admin_id`, `created_date`) VALUES
(3, 'slider12', '1696259006.jpg', 'slider1', 5, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `store_location` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `banner` varchar(50) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `store_name`, `phone`, `store_location`, `email`, `logo`, `banner`, `admin_id`, `created_at`) VALUES
(7, 'Food Coral', '147258369', 'Houston', 'info@food-coral.com', 'LG1677838705.png', 'BNR1677838705.jpg', 1, '2023-05-16 07:41:31'),
(8, 'Food Lover', '147258369', 'Houston', 'info@food-lover.store', 'LG1677838705.png', 'BNR1677838705.jpg', 2, '2023-05-16 07:41:22'),
(9, 'store name', '01614756856', 'location', 'storeemail@gmail.com', 'LG1695653186.png', 'BNR1695653186.jpg', 5, '2023-09-25 14:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `sub_category_image` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `sub_category_name`, `sub_category_image`, `slug`, `category_id`, `pharmacy_id`, `created_date`) VALUES
(4, 'wqw', '1693774625.png', 'wqw', 219, 1, '2023-09-03 20:57:05'),
(5, 'abs', '1695141514.png', 'abs', 222, 8, '2023-09-19 16:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` text NOT NULL,
  `image` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`, `image`, `status`, `created_at`) VALUES
(5, 'araf', 'arafyeasin@gmail.com', '', 'Araf12345', '', 'active', '2023-06-25 18:05:09'),
(6, 'Papiya Sultana', 'papiyasultana@gmail.com', '', 'Papiya12345', '', 'active', '2023-07-29 15:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `house_name` varchar(250) NOT NULL,
  `street` varchar(250) NOT NULL,
  `porst_office` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_address`
--
ALTER TABLE `pharmacy_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `pharmacy_admin`
--
ALTER TABLE `pharmacy_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prd_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cartitem`
--
ALTER TABLE `cartitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacy_address`
--
ALTER TABLE `pharmacy_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pharmacy_admin`
--
ALTER TABLE `pharmacy_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1818;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
