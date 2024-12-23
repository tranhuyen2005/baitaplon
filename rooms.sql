-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 04:09 AM
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
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` varchar(10) NOT NULL,
  `facility_id` int(11) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `status` enum('empty','rented') NOT NULL,
  `tenant_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `owner_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `facility_id`, `room_name`, `price`, `status`, `tenant_name`, `address`, `owner_name`) VALUES
('1', 1, 'Phòng 1.01', 1800000, 'empty', NULL, '123 Đường ABC, Quận 1, TP.HCM', 'Trần Thị Thu Huyền'),
('10', 2, 'Phòng 2.04', 2000000, 'empty', NULL, '132 Đường BCD, Quận 5, TP.HCM', 'Nguyễn Thị Hiền Phương'),
('11', 2, 'Phòng 2.05', 2300000, 'empty', NULL, '133 Đường EFG, Quận 6, TP.HCM', 'Nguyễn Thị Thùy Linh'),
('12', 2, 'Phòng 2.06', 2600000, 'rented', NULL, '134 Đường HIJ, Quận 6, TP.HCM', 'Trần Thị Vân Anh'),
('2', 1, 'Phòng 1.02', 1800000, 'empty', NULL, '124 Đường DEF, Quận 1, TP.HCM', 'Đỗ Thị Lan Hương'),
('3', 1, 'Phòng 1.03', 2000000, 'rented', NULL, '125 Đường GHI, Quận 2, TP.HCM', 'Hoàng Thị Hiền'),
('4', 1, 'Phòng 1.04', 1900000, 'empty', NULL, '126 Đường JKL, Quận 2, TP.HCM', 'Đỗ Hà Duyên'),
('5', 1, 'Phòng 1.05', 2200000, 'empty', NULL, '127 Đường MNO, Quận 3, TP.HCM', 'Phạm Ngọc Ánh'),
('6', 1, 'Phòng 1.06', 2500000, 'rented', NULL, '128 Đường PQR, Quận 3, TP.HCM', 'Nguyễn Thị Yến Nhi'),
('7', 2, 'Phòng 2.01', 1900000, 'empty', NULL, '129 Đường STU, Quận 4, TP.HCM', 'Ninh Thị Lành'),
('8', 2, 'Phòng 2.02', 1900000, 'empty', NULL, '130 Đường VWX, Quận 4, TP.HCM', 'Nguyễn Công Mạnh'),
('9', 2, 'Phòng 2.03', 2100000, 'rented', NULL, '131 Đường YZA, Quận 5, TP.HCM', 'Nguyễn Quang Huy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
