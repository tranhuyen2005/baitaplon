<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

// Kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy `room_id` từ URL
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

// Xử lý form gửi lên
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $tenant_name = $_POST['tenant_name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $cccd = $_POST['cccd'];
    $address = $_POST['address'];
    $checkin_date = $_POST['checkin_date'];

    // Thêm khách thuê
    $insert_tenant = $conn->prepare("INSERT INTO tenants (room_id, tenant_name, dob, phone, cccd, address, checkin_date, status) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, 'Đang ở')");
    $insert_tenant->bind_param("issssss", $room_id, $tenant_name, $dob, $phone, $cccd, $address, $checkin_date);

    if ($insert_tenant->execute()) {
        // Cập nhật trạng thái phòng
        $update_room = $conn->prepare("UPDATE rooms SET status = 'Đã cho thuê' WHERE id = ?");
        $update_room->bind_param("i", $room_id);
        if ($update_room->execute()) {
            echo "Thuê phòng thành công!";
            header("Location: quanlyphong.php?facility_id=" . $_POST['facility_id']);
            exit();
        } else {
            echo "Lỗi khi cập nhật trạng thái phòng: " . $conn->error;
        }
    } else {
        echo "Lỗi khi thêm khách thuê: " . $conn->error;
    }
}

// Lấy thông tin phòng để hiển thị
$room_info = $conn->query("SELECT room_name, address_room, price FROM rooms WHERE id = $room_id")
->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thuê Phòng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/baiTapLon/quanlyphong/thuephong.css">
</head>
<body>
    <div class="container">
        <h1>Thuê Phòng</h1>
        <?php if ($room_info): ?>
            <h2>Phòng: <?php echo $room_info['room_name']; ?></h2>
            <p>Địa chỉ: <?php echo $room_info['address_room']; ?></p>
            <p>Giá: <?php echo number_format($room_info['price'], 0, ',', '.'); ?> VND</p>
        <?php else: ?>
            <p>Phòng không tồn tại.</p>
        <?php endif; ?>

        <form action="thuephong.php" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>" />
            <div class="form-group">
                <label for="tenant_name"><i class="fas fa-user"></i> Tên khách thuê:</label>
                <input type="text" id="tenant_name" name="tenant_name" required>
            </div>
            <div class="form-group">
                <label for="dob"><i class="fas fa-birthday-cake"></i> Ngày sinh:</label>
                <input type="date" id="dob" name="dob">
            </div>
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> Số điện thoại:</label>
                <input type="text" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="cccd"><i class="fas fa-id-card"></i> CMND/CCCD:</label>
                <input type="text" id="cccd" name="cccd">
            </div>
            <div class="form-group">
                <label for="address"><i class="fas fa-home"></i> Địa chỉ:</label>
                <input type="text" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="checkin_date"><i class="fas fa-calendar-day"></i> Ngày nhận phòng:</label>
                <input type="date" id="checkin_date" name="checkin_date" required>
            </div>
            <div class="form-actions">
                <button type="submit">Xác nhận thuê</button>
                <button type="button" onclick="window.location.href='/baitaplon/quanlyphong/quanlyphong.php?facility_id=<?php echo isset($_POST['facility_id']) ? $_POST['facility_id'] : ''; ?>'">Hủy</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
