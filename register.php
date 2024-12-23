<?php
// Biến để lưu thông báo khi đăng ký
$register_message = '';

// Kiểm tra khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin đăng ký
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Kiểm tra nếu tên đăng nhập hoặc mật khẩu rỗng
    if (empty($username) || empty($password)) {
        $register_message = "<h2 style='color: red;'>Vui lòng điền đầy đủ thông tin!</h2>";
    } else {
        // Giả sử lưu vào cơ sở dữ liệu hoặc mảng (ở đây lưu vào mảng tạm thời)
        // Bạn có thể thêm mã lưu thông tin vào cơ sở dữ liệu ở đây.
        $register_message = "<h2 style='color: green;'>Đăng ký thành công! Bạn có thể đăng nhập ngay.</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="register-container">
        <h2>Đăng Ký Tài Khoản</h2>
        <form action="register.php" method="POST">
    <div class="input-group">
        <label for="full_name">Tên đầy đủ</label>
        <input type="text" id="full_name" name="full_name" required>
    </div>
    <div class="input-group">
        <label for="username">Tên đăng nhập</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="input-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="input-group">
        <label for="confirm_password">Xác nhận mật khẩu</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="input-group">
        <label for="phone">Số điện thoại (tuỳ chọn)</label>
        <input type="text" id="phone" name="phone">
    </div>
    <div class="input-group">
        <label for="dob">Ngày sinh (tuỳ chọn)</label>
        <input type="date" id="dob" name="dob">
    </div>
    <div class="input-group">
        <label for="gender">Giới tính</label>
        <select id="gender" name="gender">
            <option value="male">Nam</option>
            <option value="female">Nữ</option>
            <option value="other">Khác</option>
        </select>
    </div>
    <div class="input-group">
        <label for="address">Địa chỉ (tuỳ chọn)</label>
        <input type="text" id="address" name="address">
    </div>
    <div class="input-group">
        <label>
            <input type="checkbox" name="terms" required> Tôi đồng ý với <a href="#">Điều khoản và Chính sách bảo mật</a>
        </label>
    </div>
    <button type="submit" class="register-btn">Đăng ký</button>
</form>

        <!-- Liên kết quay lại trang đăng nhập -->
        <div class="login-link">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
        </div>
    </div>
</body>
</html>
