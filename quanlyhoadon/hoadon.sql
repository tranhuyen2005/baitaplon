-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 09:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `id` int(11) NOT NULL,
  `so_phong` varchar(10) NOT NULL,
  `thang_nam` date NOT NULL,
  `so_nguoi_o` int(11) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `chu_so_huu` varchar(255) NOT NULL,
  `tien_phong` decimal(10,2) NOT NULL,
  `phi_dich_vu` decimal(10,2) NOT NULL,
  `tien_nuoc` decimal(10,2) NOT NULL,
  `tien_dien` decimal(10,2) NOT NULL,
  `tinh_trang` enum('Chưa thanh toán','Đã thanh toán') NOT NULL,
  `facility_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`id`, `so_phong`, `thang_nam`, `so_nguoi_o`, `dia_chi`, `chu_so_huu`, `tien_phong`, `phi_dich_vu`, `tien_nuoc`, `tien_dien`, `tinh_trang`, `facility_id`) VALUES
(1, 'Phòng 1.07', '2024-12-01', 2, 'Cơ sở 1', 'Trần Thị Thu Huyền', 3000000.00, 500000.00, 300000.00, 500000.00, 'Đã thanh toán', 1),
(2, 'Phòng 1.02', '2024-12-01', 3, 'Cơ sở 1', 'Nguyễn Thị Yến Nhi', 3200000.00, 500000.00, 250000.00, 400000.00, 'Đã thanh toán', 1),
(3, 'Phòng 1.03', '2024-01-01', 1, 'Cơ sở 1', 'Hoàng Thị Hiền ', 2800000.00, 500000.00, 150000.00, 200000.00, 'Đã thanh toán', 1),
(4, 'Phòng 1.04', '2024-01-01', 4, 'Cơ sở 1', '', 3500000.00, 500000.00, 300000.00, 500000.00, 'Chưa thanh toán', 1),
(5, 'Phòng 1.05', '2024-01-01', 2, 'Cơ sở 1', 'Ninh Thị Lành', 3000000.00, 500000.00, 200000.00, 300000.00, 'Chưa thanh toán', 1),
(6, 'Phòng 1.06', '2024-01-01', 3, 'Cơ sở 1', 'Nguyễn Công Mạnh', 3200000.00, 500000.00, 250000.00, 400000.00, 'Chưa thanh toán', 1),
(7, 'Phòng 2.01', '2024-01-01', 2, 'Cơ sở 1', 'Trần Thị Thu Huyền', 3000000.00, 500000.00, 200000.00, 300000.00, 'Chưa thanh toán', 2),
(8, 'Phòng 2.02', '2024-01-01', 3, 'Cơ sở 2', 'Đỗ Thị Lan Hương', 3200000.00, 500000.00, 250000.00, 400000.00, 'Chưa thanh toán', 2),
(9, 'Phòng 2.03', '2024-01-01', 1, 'Cơ sở 2', 'Phạm Ngọc Ánh', 2800000.00, 500000.00, 150000.00, 200000.00, 'Chưa thanh toán', 2),
(10, 'Phòng 104', '2024-01-01', 4, 'Cơ sở 2', '', 3500000.00, 500000.00, 300000.00, 500000.00, 'Chưa thanh toán', 2),
(11, 'Phòng 2.05', '2024-01-01', 2, 'Cơ sở 2', '', 3000000.00, 500000.00, 200000.00, 300000.00, 'Chưa thanh toán', 2),
(12, 'Phòng 2.06', '2024-01-01', 3, 'Cơ sở 2', '', 3200000.00, 500000.00, 250000.00, 400000.00, 'Chưa thanh toán', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
