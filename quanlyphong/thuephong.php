<?php
$conn = mysqli_connect("localhost", "root", "", "baiTapLon");
if ($conn->connect_errno) {
    die("Kết nối không thành công: " . $conn->connect_errno);
}

// Lấy danh sách phòng trống
$sql = "SELECT * FROM rooms WHERE status = 'vacant'";
$result = $conn->query($sql);

// Xử lý khi người dùng gửi form đặt phòng
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
        $stmt->bind_param("issssss", $_POST['room_id'], $tenant_name, $dob, $phone, $cccd, $address, $checkin_date);
        $stmt->execute();
        echo "Đặt phòng thành công!";
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
    <title>Đặt Phòng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/baiTapLon/quanlyphong/thuephong.css">
</head>
<body>

    <h2>Thông tin của phòng</h2>

    <!-- Hiển thị danh sách phòng trống -->
    <?php while ($row = $result->fetch_assoc()) { ?>
        <p>Phòng: <?= $row['room_name'] ?></p>
        <p>Địa chỉ: <?= $row['address_room'] ?></p>
        <p>Giá: <?= number_format($row['price'], 0, ',', '.') ?> VND</p>
        <hr>
    <?php } ?>

    <h2>Điền thông tin khách</h2>

    <form action="thuephong.php" method="POST">
    <form action="thuephong.php" method="POST">
    <div class="form-group">
        <label for="room_id"><i class="fas fa-bed"></i> Phòng:</label>
        <input type="text" name="room_id" id="room_id" value="101" disabled>
    </div>

    <div class="form-group">
        <label for="tenant_name"><i class="fas fa-user"></i> Họ và tên:</label>
        <input type="text" name="tenant_name" id="tenant_name" required>
    </div>

    <div class="form-group">
        <label for="dob"><i class="fas fa-birthday-cake"></i> Ngày sinh:</label>
        <input type="date" name="dob" id="dob">
    </div>

    <div class="form-group">
        <label for="phone"><i class="fas fa-phone-alt"></i> Số điện thoại:</label>
        <input type="text" name="phone" id="phone">
    </div>

    <div class="form-group">
        <label for="cccd"><i class="fas fa-id-card"></i> Căn cước công dân:</label>
        <input type="text" name="cccd" id="cccd">
    </div>

    <div class="form-group">
        <label for="address"><i class="fas fa-map-marker-alt"></i> Địa chỉ:</label>
        <input type="text" name="address" id="address">
    </div>

    <div class="form-group">
        <label for="checkin_date"><i class="fas fa-calendar-day"></i> Ngày nhận phòng:</label>
        <input type="date" name="checkin_date" id="checkin_date" required>
    </div>

    <div class="form-actions">
        <button type="submit">Đặt Phòng</button>
        <button type="button" onclick="window.history.back();">Hủy</button>
    </div>
</form>

    </form>

</body>
</html>
