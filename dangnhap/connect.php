<?php
$host = 'localhost'; // Địa chỉ server
$db = 'baiTapLon';   // Tên database
$user = 'root';      // Tên người dùng MySQL
$pass = '';          // Mật khẩu MySQL

// Tạo kết nối
$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
