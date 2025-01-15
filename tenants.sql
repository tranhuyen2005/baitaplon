-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 07:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baitaplon`
--

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `tenant_name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cccd` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `status` enum('vacant','occupied') NOT NULL DEFAULT 'vacant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `room_id`, `tenant_name`, `dob`, `phone`, `cccd`, `address`, `checkin_date`, `status`) VALUES
(4, 4, 'Trần Huyền', '2017-01-04', NULL, NULL, 'Sóc Sơn', '2025-01-01', 'occupied'),
(5, 5, 'Lan Hương', '2018-01-01', '7845124851', '0012648585', 'Thủy Nguyên', '2020-01-02', 'occupied');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
