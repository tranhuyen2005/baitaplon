<?php
session_start();  // Bắt đầu phiên làm việc (session)

// Hủy tất cả dữ liệu trong session
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header('Location: login.php');
exit;
?>
