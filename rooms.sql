-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 02:42 AM
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
  `address` varchar(255) NOT NULL,
  `owner_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `facility_id`, `room_name`, `price`, `status`, `address`, `owner_name`) VALUES
('1', 1, 'Phòng 101', 1800000, 'empty', '123 Đường ABC, Quận 1, TP.HCM', 'Trần Thị Thu Huyền'),
('10', 2, 'Phòng 204', 2000000, 'empty', '132 Đường BCD, Quận 5, TP.HCM', 'Nguyễn Thị Hiền Phương'),
('11', 2, 'Phòng 205', 2300000, 'empty', '133 Đường EFG, Quận 6, TP.HCM', 'Nguyễn Thị Thùy Linh'),
('12', 2, 'Phòng 206', 2600000, 'rented', '134 Đường HIJ, Quận 6, TP.HCM', 'Trần Thị Vân Anh'),
('2', 1, 'Phòng 102', 1800000, 'empty', '124 Đường DEF, Quận 1, TP.HCM', 'Đỗ Thị Lan Hương'),
('3', 1, 'Phòng 103', 2000000, 'rented', '125 Đường GHI, Quận 2, TP.HCM', 'Hoàng Thị Hiền'),
('4', 1, 'Phòng 104', 1900000, 'empty', '126 Đường JKL, Quận 2, TP.HCM', 'Đỗ Hà Duyên'),
('5', 1, 'Phòng 105', 2200000, 'empty', '127 Đường MNO, Quận 3, TP.HCM', 'Phạm Ngọc Ánh'),
('6', 1, 'Phòng 106', 2500000, 'rented', '128 Đường PQR, Quận 3, TP.HCM', 'Nguyễn Thị Yến Nhi'),
('7', 2, 'Phòng 201', 1900000, 'empty', '129 Đường STU, Quận 4, TP.HCM', 'Ninh Thị Lành'),
('8', 2, 'Phòng 202', 1900000, 'empty', '130 Đường VWX, Quận 4, TP.HCM', 'Nguyễn Công Mạnh'),
('9', 2, 'Phòng 203', 2100000, 'rented', '131 Đường YZA, Quận 5, TP.HCM', 'Nguyễn Quang Huy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facility_id` (`facility_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
