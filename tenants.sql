-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 07:45 AM
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
  `room_id` varchar(10) DEFAULT NULL,
  `owner_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `id_card` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `room_id`, `owner_name`, `date_of_birth`, `id_card`, `address`, `checkin_date`, `checkout_date`, `status`) VALUES
(13, '1', 'Nguyễn Văn A', '1990-05-12', '012345678901', 'Hà Nội', '2024-01-01', NULL, 'active'),
(14, '2', 'Trần Thị B', '1985-09-20', '012345678902', 'Hà Nội', '2023-12-01', '2024-12-01', 'inactive'),
(15, '3', 'Lê Văn C', '1992-07-15', '012345678903', 'Bắc Ninh', '2024-03-10', NULL, 'active'),
(16, '4', 'Phạm Thị D', '1995-01-25', '012345678904', 'Hải Dương', '2024-02-15', NULL, 'active'),
(17, '5', 'Hoàng Văn E', '1988-11-30', '012345678905', 'Nam Định', '2024-01-10', '2024-10-10', 'inactive'),
(18, '6', 'Đặng Thị F', '1990-04-18', '012345678906', 'Thanh Hóa', '2024-02-01', NULL, 'active'),
(19, '7', 'Ngô Văn G', '1987-06-05', '012345678907', 'TP.HCM', '2024-03-01', NULL, 'active'),
(20, '8', 'Võ Thị H', '1991-03-20', '012345678908', 'TP.HCM', '2024-02-25', NULL, 'active'),
(21, '9', 'Bùi Văn I', '1993-10-12', '012345678909', 'Bình Dương', '2024-01-20', '2024-11-30', 'inactive'),
(22, '10', 'Đỗ Thị J', '1989-08-08', '012345678910', 'Đồng Nai', '2023-12-15', '2024-10-01', 'inactive'),
(23, '11', 'Lý Văn K', '1994-05-28', '012345678911', 'Cần Thơ', '2024-01-05', NULL, 'active'),
(24, '12', 'Dương Thị L', '1996-09-02', '012345678912', 'Vũng Tàu', '2024-02-10', NULL, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenants_ibfk_1` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
