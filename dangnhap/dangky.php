<?php
// Biến để lưu thông báo khi đăng ký
$register_message = '';

// Kết nối cơ sở dữ liệu
$servername = "localhost";  // Địa chỉ máy chủ
$username = "root";         // Tên người dùng MySQL
$password = "";             // Mật khẩu của MySQL
$dbname = "baitaplon";  // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Kiểm tra khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin đăng ký từ form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    // Kiểm tra nếu tên đăng nhập hoặc mật khẩu rỗng
    if (empty($username) || empty($password)) {
        $register_message = "<h2 style='color: red;'>Vui lòng điền đầy đủ thông tin!</h2>";
    } elseif ($password !== $confirm_password) {
        $register_message = "<h2 style='color: red;'>Mật khẩu và xác nhận mật khẩu không khớp!</h2>";
    } else {
        // Bảo mật: Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Chuẩn bị câu lệnh SQL để chèn thông tin vào cơ sở dữ liệu
        $sql = "INSERT INTO users (fullname, username, password, email, phone, dob, gender, address) 
                VALUES ('$full_name', '$username', '$hashed_password', '$email', '$phone', '$dob', '$gender', '$address')";

        if ($conn->query($sql) === TRUE) {
            header("Location: trangchu.php");
            exit();
        } else {
            $register_message = "<h2 style='color: red;'>Lỗi: " . $sql . "<br>" . $conn->error . "</h2>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <link rel="stylesheet" href="dangky.css">
</head>
<body>
    <div class="register-container">
        <h2>ĐĂNG KÝ TÀI KHOẢN</h2>
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
        <input type="checkbox" name="terms" required>Tôi đồng ý với <a href="#" id="policyLink">Điều khoản và Chính sách bảo mật</a>
        </label>
    </div>
    <button type="submit" class="register-btn">Đăng ký</button>
</form>

        <!-- Liên kết quay lại trang đăng nhập -->
        <div class="login-link">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
        </div>
    </div>
    <div id="terms-popup" class="terms-popup" style="display:none;">
        <div class="terms-content">
            <h2>Chính Sách và Điều Khoản</h2>
            <p><strong>Điều khoản sử dụng:</strong></p>
            <ul>
                <li>Điều khoản 1: Bạn phải cung cấp thông tin chính xác khi đăng ký.</li>
                <li>Điều khoản 2: Bạn không được phép sử dụng dịch vụ cho mục đích vi phạm pháp luật.</li>
                <li>Điều khoản 3: Chúng tôi có quyền thay đổi các điều khoản này bất cứ lúc nào mà không cần thông báo trước.</li>
            </ul>
            <p><strong>Chính sách bảo mật:</strong></p>
            <ul>
                <li>Chúng tôi chỉ thu thập thông tin cá nhân khi bạn đăng ký sử dụng dịch vụ.</li>
                <li>Thông tin của bạn sẽ được bảo mật và không được chia sẻ cho bên thứ ba mà không có sự đồng ý của bạn.</li>
                <li>Bạn có quyền yêu cầu xóa hoặc chỉnh sửa thông tin cá nhân của mình bất cứ lúc nào.</li>
            </ul>
            <button onclick="closeTerms()">Đóng</button>
        </div>
    </div>  
    <script>
     // Hiển thị popup khi nhấn vào liên kết điều khoản
document.getElementById('policyLink').addEventListener('click', function(event) {
    event.preventDefault(); // Ngăn hành động mặc định
    document.getElementById('terms-popup').style.display = 'block';
});

// Đóng popup
function closeTerms() {
    document.getElementById('terms-popup').style.display = 'none';
}

        </script>
</body>
</html>
