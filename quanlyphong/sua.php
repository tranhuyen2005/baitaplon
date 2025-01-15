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

// Lấy id phòng từ URL
$room_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$facility_id = isset($_GET['facility_id']) ? intval($_GET['facility_id']) : 1;

// Kiểm tra id hợp lệ
if ($room_id <= 0) {
    header("Location: /baiTapLon/quanlyphong/quanlyphong.php?facility_id=$facility_id");
    exit;
}

// Lấy thông tin phòng từ cơ sở dữ liệu
$sql = "SELECT r.*, 
               CASE 
                   WHEN t.room_id IS NOT NULL THEN 'occupied' 
                   ELSE 'vacant' 
               END AS status
        FROM rooms AS r
        LEFT JOIN tenants AS t ON r.id = t.room_id
        WHERE r.id = $room_id AND r.facility_id = $facility_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Phòng không tồn tại.");
}

$room = $result->fetch_assoc();

// Xử lý cập nhật thông tin phòng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $conn->real_escape_string($_POST['room_name']);
    $address_room = $conn->real_escape_string($_POST['address_room']);
    $so_nguoi_o = intval($_POST['so_nguoi_o']);
    $price = floatval($_POST['price']);

    $update_sql = "UPDATE rooms SET 
        room_name = '$room_name', 
        address_room = '$address_room', 
        so_nguoi_o = $so_nguoi_o, 
        price = $price
        WHERE id = $room_id AND facility_id = $facility_id";

    if ($conn->query($update_sql) === TRUE) {
        // Chuyển hướng về trang danh sách
        header("Location: /baiTapLon/quanlyphong/quanlyphong.php?facility_id=$facility_id&success=Phòng đã được cập nhật.");
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Phòng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/baiTapLon/quanlyphong/sua.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center text-primary">Sửa Thông Tin Phòng</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="room_name" class="form-label">
                    <i class="fa-solid fa-house"></i> Tên Phòng</label>
                <input type="text" class="form-control" id="room_name" name="room_name" value="<?php echo htmlspecialchars($room['room_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="address_room" class="form-label">
                    <i class="fa-solid fa-location-dot"></i> Địa Chỉ</label>
                <input type="text" class="form-control" id="address_room" name="address_room" value="<?php echo htmlspecialchars($room['address_room']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="so_nguoi_o" class="form-label">
                    <i class="fa-solid fa-users"></i> Số Người Ở</label>
                <input type="number" class="form-control" id="so_nguoi_o" name="so_nguoi_o" value="<?php echo $room['so_nguoi_o']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">
                    <i class="fa-solid fa-dollar-sign"></i> Giá Phòng (VNĐ)</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $room['price']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="/baiTapLon/quanlyphong/quanlyphong.php?facility_id=<?php echo $facility_id; ?>" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>
