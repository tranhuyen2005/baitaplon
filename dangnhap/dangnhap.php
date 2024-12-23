<?php
// Thông tin đăng nhập giả định
$valid_username = 'Đỗ Hà Duyên';
$valid_password = '123';

// Biến để lưu thông báo lỗi hoặc thành công
$message = '';

// Kiểm tra khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin đăng nhập
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra tên đăng nhập và mật khẩu
    if ($username === $valid_username && $password === $valid_password) {
        $message = "<h2 style='color: green;'>Đăng nhập thành công!</h2>";
    } else {
        $message = "<h2 style='color: red;'>Tên đăng nhập hoặc mật khẩu sai!</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <form action="login.php" method="POST">
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
            <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
        </div>
    </div>
</body>
</html>
