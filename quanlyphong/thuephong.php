<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin phòng từ URL
$room_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin phòng để hiển thị
$sql = "SELECT * FROM rooms WHERE id = $room_id";
$result = $conn->query($sql);
$room = $result->fetch_assoc();

// Kiểm tra nếu có thông tin phòng
if (!$room) {
    die("Phòng không tồn tại.");
}

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenant_name = $_POST['tenant_name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $cccd = $_POST['cccd'];
    $address = $_POST['address'];
    $checkin_date = $_POST['checkin_date'];

    // Câu lệnh SQL để thêm thông tin khách thuê vào bảng tenants
    $sql = "INSERT INTO tenants (room_id, tenant_name, dob, phone, cccd, address, checkin_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'occupied')";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issssss", $room_id, $tenant_name, $dob, $phone, $cccd, $address, $checkin_date);
        if ($stmt->execute()) {
            echo "Đặt phòng thành công!";
            header("location:/baitaplon/quanlyphong/quanlyphong.php?facility_id=$facility_id");
        } else {
            echo "Lỗi: Không thể thêm thông tin khách.";
        }
        $stmt->close();
    } else {
        echo "Lỗi: Không thể thực thi câu lệnh SQL!";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thuê Phòng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/baiTapLon/quanlyphong/thuephong.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center text-primary">Thuê Phòng: <?php echo htmlspecialchars($room['room_name']); ?></h1>

        <form method="POST">
            <div class="form-group">
                <label for="tenant_name"><i class="fas fa-user"></i> Họ và tên:</label>
                <input type="text" name="tenant_name" id="tenant_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="dob"><i class="fas fa-calendar-alt"></i> Ngày sinh:</label>
                <input type="date" name="dob" id="dob" class="form-control">
            </div>

            <div class="form-group">
                <label for="phone"><i class="fas fa-phone-alt"></i> Số điện thoại:</label>
                <input type="text" name="phone" id="phone" class="form-control">
            </div>

            <div class="form-group">
                <label for="cccd"><i class="fas fa-id-card"></i> Căn cước công dân:</label>
                <input type="text" name="cccd" id="cccd" class="form-control">
            </div>

            <div class="form-group">
                <label for="address"><i class="fas fa-home"></i> Địa chỉ:</label>
                <input type="text" name="address" id="address" class="form-control">
            </div>

            <div class="form-group">
                <label for="checkin_date"><i class="fas fa-calendar-check"></i> Ngày nhận phòng:</label>
                <input type="date" name="checkin_date" id="checkin_date" class="form-control" required>
            </div>

            <!-- Thêm icon vào nút -->
            <button type="submit" class="btn btn-success mt-3">Thuê phòng
            </button>
            <button type="button" onclick="window.history.back();">Hủy</button>

            </a>
        </form>
    </div>
</body>
</html>
