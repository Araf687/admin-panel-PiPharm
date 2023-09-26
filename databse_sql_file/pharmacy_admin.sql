-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2023 at 06:30 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
