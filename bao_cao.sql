-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 06:09 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

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
-- Table structure for table `bao_cao`
--

CREATE TABLE `bao_cao` (
  `id` int(11) NOT NULL,
  `ten_nguoi_thue` varchar(255) NOT NULL,
  `so_phong` varchar(20) NOT NULL,
  `su_co` text NOT NULL,
  `do_uu_tien` varchar(20) NOT NULL,
  `thoi_gian_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `facility_id` int(11) NOT NULL,
  `dia_chi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bao_cao`
--

INSERT INTO `bao_cao` (`id`, `ten_nguoi_thue`, `so_phong`, `su_co`, `do_uu_tien`, `thoi_gian_tao`, `facility_id`, `dia_chi`) VALUES
(1, 'Hoàng Thị Hiền', ' 1.101', 'không có sự cố', 'không có', '2024-12-21 17:00:00', 1, 'Hà Nội'),
(2, 'Đỗ Thị Lan Hương', '1.102', 'không có sự cố', 'không có', '2024-12-21 17:00:00', 1, 'Hà Nội'),
(4, 'Trần Thị Thu Huyền', ' 1.103', 'không có sự cố', 'không có', '2024-12-23 17:00:00', 1, 'Hà Nội'),
(8, 'Phạm Ngọc Ánh', '1.104', 'không có sự cố', 'không có', '2024-12-20 17:00:00', 1, 'Hà Nội'),
(9, 'Nguyễn Thị Yến Nhi', '1.105', 'không có sự cố', 'không có', '2024-12-17 17:00:00', 1, 'Hà Nội'),
(10, 'Đỗ Hà Duyên', '1.106', 'không có sự cố', 'khôn', '2024-12-18 17:00:00', 1, 'Hà Nội'),
(11, 'Ninh Thị Lành', '2.101', 'không có sự cố', 'không có', '2024-12-19 17:00:00', 2, 'Hồ Chí Minh'),
(12, 'Nguyễn Công Mạnh', '2.102', 'Máy lạnh hỏng', 'Vừa', '2024-12-21 17:00:00', 2, 'Hồ Chí Minh'),
(13, 'Nguyễn Quang Huy', '2.103', 'Nước yếu', 'Thấp', '2024-12-22 17:00:00', 2, 'Hồ Chí Minh'),
(14, 'Phan Thị J', '2.104', 'Điện nước không tính toán', 'Cao', '2024-12-20 17:00:00', 2, 'Hồ Chí Minh'),
(15, 'Trần Anh K', '2.105', 'Sự cố hệ thống an ninh', 'Vừa', '2024-12-17 17:00:00', 2, 'Hồ Chí Minh'),
(16, 'Lê Đỗ L', '2.106', 'Hỏng cửa sổ', 'Thấp', '2024-12-18 17:00:00', 2, 'Hồ Chí Minh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bao_cao`
--
ALTER TABLE `bao_cao`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bao_cao`
--
ALTER TABLE `bao_cao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
