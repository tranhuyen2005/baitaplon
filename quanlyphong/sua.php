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

// Lấy id của phòng từ URL
$room_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Nếu không có id hợp lệ, chuyển về trang danh sách
if ($room_id <= 0) {
    header("Location: index.php");
    exit;
}

// Lấy thông tin phòng từ cơ sở dữ liệu
$sql = "SELECT * FROM rooms WHERE id = $room_id";
$result = $conn->query($sql);

// Kiểm tra nếu không tìm thấy phòng
if ($result->num_rows == 0) {
    die("Phòng không tồn tại.");
}

// Lấy dữ liệu phòng
$room = $result->fetch_assoc();

// Xử lý cập nhật thông tin phòng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $conn->real_escape_string($_POST['room_name']);
    $address_room = $conn->real_escape_string($_POST['address_room']);
    $so_nguoi_o = intval($_POST['so_nguoi_o']);
    $price = floatval($_POST['price']);
    $status = $conn->real_escape_string($_POST['status']);

    $update_sql = "UPDATE rooms SET 
        room_name = '$room_name', 
        address_room = '$address_room', 
        so_nguoi_o = $so_nguoi_o, 
        price = $price, 
        status = '$status' 
        WHERE id = $room_id";

    if ($conn->query($update_sql) === TRUE) {
        
        // Chuyển hướng về trang danh sách với thông báo thành công
        header("Location: index.php?success=Phòng đã được cập nhật thành công.");
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
    <link rel="stylesheet"href="sua.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center text-primary">Sửa Thông Tin Phòng</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="room_name" class="form-label">Tên Phòng</label>
                <input type="text" class="form-control" id="room_name" name="room_name" value="<?php echo htmlspecialchars($room['room_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="address_room" class="form-label">Địa Chỉ</label>
                <input type="text" class="form-control" id="address_room" name="address_room" value="<?php echo htmlspecialchars($room['address_room']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="so_nguoi_o" class="form-label">Số Người Ở</label>
                <input type="number" class="form-control" id="so_nguoi_o" name="so_nguoi_o" value="<?php echo $room['so_nguoi_o']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá Phòng (VNĐ)</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $room['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Trạng Thái</label>
                <select class="form-select" id="status" name="status">
                    <option value="vacant" <?php echo $room['status'] == 'vacant' ? 'selected' : ''; ?>>Còn trống</option>
                    <option value="occupied" <?php echo $room['status'] == 'occupied' ? 'selected' : ''; ?>>Đã có người thuê</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="index.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>
