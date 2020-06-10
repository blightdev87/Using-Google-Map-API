-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2020 at 07:36 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qicharge_caf`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `status` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deliveryFee` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minAmmount` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `freeDelivery` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deliveryFeeSettings` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deliveryReadyTime` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availableTimes` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shape_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `radius` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `x` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `y` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polygon_path`
--

CREATE TABLE `polygon_path` (
  `id` int(11) NOT NULL,
  `radius_id` int(11) NOT NULL,
  `x` decimal(15,11) NOT NULL,
  `y` decimal(15,11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polygon_path`
--
ALTER TABLE `polygon_path`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `polygon_path`
--
ALTER TABLE `polygon_path`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
