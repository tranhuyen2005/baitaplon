<?php
session_start(); // Khởi động session
require 'connect.php'; // Kết nối database

$message = ""; // Biến lưu thông báo lỗi hoặc thành công

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form đăng nhập
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Không cần escape vì không đưa trực tiếp vào SQL

    // Kiểm tra thông tin nhập vào
    if (!empty($username) && !empty($password)) {
        // Truy vấn kiểm tra người dùng theo username
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Kiểm tra mật khẩu bằng password_verify
            if (password_verify($password, $user['password'])) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];

                // Chuyển hướng đến trang chính
                header("Location:/baiTapLon/trangchu/trangchu.php");
                exit();
            } else {
                $message = "Mật khẩu không đúng!";
            }
        } else {
            $message = "Tên đăng nhập không tồn tại!";
        }
    } else {
        $message = "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="dangnhap.css">
</head>
<body>
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <form action="dangnhap.php" method="POST">
            <div class="input-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            <!-- Hiển thị thông báo dưới trường mật khẩu -->
            <?php
            if (!empty($message)) {
                echo "<div class='message-container'>" . $message . "</div>";
            }
            ?>
            <button type="submit" class="login-btn">Đăng Nhập</button>
        </form>
        <div class="register-link">
            <p>Chưa có tài khoản? <a href="dangky.php">Đăng ký ngay</a></p>
        </div>
    </div>
</body>
</html>
