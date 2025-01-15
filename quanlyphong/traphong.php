<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu có ID phòng và gửi yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $room_id = $_POST['id'];

    // Cập nhật tên khách thuê và trạng thái phòng
    $update_sql = "UPDATE rooms SET tenant_name = NULL, status = 'Còn trống' WHERE id = $room_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Phòng đã được trả.";
    } else {
        echo "Lỗi khi trả phòng: " . $conn->error;
    }

    // Sau khi trả phòng thành công, chuyển hướng lại trang quản lý phòng
    header("Location: quanlyphong.php");
    exit();
}

$conn->close();
?>
