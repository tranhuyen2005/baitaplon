<?php
session_start(); // Khởi tạo session

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$db = 'baitaplon';
$user = 'root'; // Thay bằng username của MySQL
$pass = '';     // Thay bằng mật khẩu của MySQL

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Truy vấn kiểm tra thông tin đăng nhập
        $stmt = $conn->prepare("SELECT * FROM login WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // So sánh mật khẩu thuần túy
        if ($user && $user['password'] == $password) {
            // Đăng nhập thành công, lưu thông tin vào session
            $_SESSION['user'] = $user['username'];
            header('Location: trangchu.php'); // Quay lại trang btl.php sau khi đăng nhập thành công
            exit();
        } else {
            $error = "Tên người dùng hoặc mật khẩu không đúng.";
        }
    } else {
        $error = "Vui lòng nhập đầy đủ thông tin.";
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
