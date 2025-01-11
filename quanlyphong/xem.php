<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin phòng
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : null;
$sql_room = "SELECT * FROM rooms WHERE id = '$room_id'";
$result_room = $conn->query($sql_room);
$room = $result_room->fetch_assoc();

if (!$room) {
    die("Không tìm thấy thông tin phòng.");
}
// Lấy thông tin ảnh từ bảng images
$sql_images = "SELECT * FROM images";
$result_image = $conn->query($sql_images);



// Chỉ lấy thông tin khách thuê nếu trạng thái phòng không phải 'empty'
$tenant = null;
if ($room['status'] != 'empty') {
    $sql_guest = "SELECT * FROM tenants WHERE room_id = '$room_id' AND status = 'active'";
    $result_guest = $conn->query($sql_guest);
    $tenant = $result_guest->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Phòng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="xem.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="container-title">Thông Tin Phòng</h1>

        <div class="info-wrapper">
            <!-- Thông tin khách thuê - bên trái -->
            <div class="col-md-6">
                <div class="info-container">
                    <h3>Thông Tin Khách Thuê</h3>
                    <?php if ($room['status'] == 'empty'): ?>
                        <p>Phòng đang trống, không có khách thuê.</p>
                    <?php elseif ($tenant): ?>
                        <p><strong>Tên khách thuê:</strong> <?php echo $tenant['tanent-name']; ?></p>
                        <p><strong>Ngày sinh:</strong> <?php echo $tenant['dob']; ?></p>
                        <p><strong>CMND:</strong> <?php echo $tenant['cccd']; ?></p>
                        <p><strong>Địa chỉ:</strong> <?php echo $tenant['address']; ?></p>
                        <p><strong>Ngày thuê:</strong> <?php echo $tenant['checkin_date']; ?></p>
                        <?php if ($tenant['checkout_date']): ?>
                            <p><strong>Ngày trả phòng:</strong> <?php echo $tenant['checkout_date']; ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Không tìm thấy thông tin khách thuê.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Thông tin phòng - bên phải -->
            <div class="col-md-6">
                <div class="info-container">
                    <h3>Thông Tin Phòng</h3>
                    <p><strong>Tên phòng:</strong> <?php echo $room['room_name']; ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo $room['address']; ?></p>
                    <p><strong>Giá:</strong> <?php echo number_format($room['price'], 0, ',', '.'); ?> VNĐ</p>
                    <p><strong>Tình trạng:</strong> <?php echo $room['status'] == 'empty' ? 'Còn trống' : 'Đã cho thuê'; ?></p>
                </div>
            </div>
        </div>

        <!-- Hiển thị ảnh phòng -->
        <div class="mt-4">
            <h3>Ảnh Phòng</h3>
            <?php while($anh = $result_image->fetch_assoc()) : ?>
            <a href="xem.php?id=<?php echo $anh['image_id']; ?>">
                    <img src="<?php echo $anh['image_path']; ?>" alt="sample picture" width="100px" height="100px">
                    <p><?php echo $anh['room_id']; ?></p>
            </a>
            <?php endwhile; ?>
        </div>

        <!-- Nút quay lại -->
        <div class="mt-4">
            <a href="quanlyphong.php" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</body>
</html>
