<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $tenant_name = $_POST['tenant_name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $cccd = $_POST['cccd'];
    $address = $_POST['address'];
    $checkin_date = $_POST['checkin_date'];

    $conn = new mysqli("localhost", "root", "", "baiTapLon");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Thêm thông tin khách thuê
    $sql = "INSERT INTO tenants (room_id, tenant_name, dob, phone, cccd, address, checkin_date, status)
            VALUES ('$room_id', '$tenant_name', '$dob', '$phone', '$cccd', '$address', '$checkin_date', 'active')";

    if ($conn->query($sql) === TRUE) {
        // Cập nhật trạng thái phòng
        $update_room_sql = "UPDATE rooms SET status = 'Đã cho thuê' WHERE id = $room_id";
        $conn->query($update_room_sql);
        echo "Thuê phòng thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $conn->close();

    // Chuyển hướng về trang quản lý phòng
    header("Location: quanlyphong.php?facility_id=" . $facility_id);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thuê phòng</title>
    <link rel="stylesheet"href="/baitaplon/quanlyphong/thuephong_form.css">
</head>
<body>
<?php
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    ?>
    <form action="thuephong_form.php" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>" />
        
        <h2>Điền thông tin khách thuê</h2>
        
        <label for="tenant_name">Tên khách thuê:</label>
        <input type="text" id="tenant_name" name="tenant_name" required />

        <label for="dob">Ngày sinh:</label>
        <input type="date" id="dob" name="dob" required /><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" required />

        <label for="cccd">CCCD:</label>
        <input type="text" id="cccd" name="cccd" required /><br>

        <label for="address">Địa chỉ:</label>
        <textarea id="address" name="address" required></textarea>

        <label for="checkin_date">Ngày thuê:</label>
        <input type="date" id="checkin_date" name="checkin_date" required />

        <button type="submit" class="submit-button">Thuê phòng</button>
    </form>
    <?php
}
?>

</body>
</html>