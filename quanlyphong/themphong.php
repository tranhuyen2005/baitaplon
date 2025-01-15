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

// Lấy danh sách cơ sở
$facilities_sql = "SELECT * FROM facilities";
$facilities_result = $conn->query($facilities_sql);

// Xử lý khi gửi biểu mẫu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $_POST['room_name'];
    $so_nguoi_o = $_POST['so_nguoi_o'];
    $address_room = $_POST['address_room'];
    $price = $_POST['price'];
    $facility_id = $_POST['facility_id'];
    $submit_action = $_POST['submit_action'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($room_name) || empty($so_nguoi_o) || empty($address_room) || empty($price) || empty($facility_id)) {
        $error_message = "Vui lòng nhập đầy đủ thông tin.";
    } elseif (!is_numeric($so_nguoi_o) || $so_nguoi_o <= 0) {
        $error_message = "Số người ở phải là số nguyên dương.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error_message = "Giá phòng phải là số dương.";
    } else {
        $insert_sql = $conn->prepare("INSERT INTO rooms (room_name, so_nguoi_o, address_room, price, status, facility_id) 
                                      VALUES (?, ?, ?, ?, 'vacant', ?)");
        $insert_sql->bind_param("sisdi", $room_name, $so_nguoi_o, $address_room, $price, $facility_id);

        if ($insert_sql->execute()) {
            if ($submit_action == 'save') {
                header("Location: /baitaplon/quanlyphong/quanlyphong.php?facility_id=$facility_id");
                exit();
            } elseif ($submit_action == 'save_and_add') {
                $success_message = "Phòng đã được thêm thành công! Bạn có thể thêm phòng khác.";
            }
        } else {
            $error_message = "Lỗi khi thêm phòng: " . $insert_sql->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phòng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/baiTapLon/quanlyphong/themphong.css">
</head>
<body>
<div class="container">
    <h1>Thêm phòng</h1>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <form action="themphong.php" method="POST">
        <div>
            <label for="facility_id">Cơ sở:</label>
            <select id="facility_id" name="facility_id" required>
                <option value="">Chọn cơ sở</option>
                <?php while ($row = $facilities_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo (isset($_POST['facility_id']) && $_POST['facility_id'] == $row['id']) ? 'selected' : ''; ?>>
                        <?php echo $row['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div>
            <label for="room_name">Tên phòng:</label>
            <input type="text" id="room_name" name="room_name" required>
        </div>
        <div>
            <label for="so_nguoi_o">Số người ở:</label>
            <input type="number" id="so_nguoi_o" name="so_nguoi_o" min="1" required>
        </div>
        <div>
            <label for="price">Giá phòng:</label>
            <input type="number" step="0.01" id="price" name="price" required>
        </div>
        <div>
            <label for="address_room">Địa chỉ phòng:</label>
            <input type="text" id="address_room" name="address_room" required>
        </div>
        <div class="button-group">
            <button type="submit" name="submit_action" value="save">Lưu</button>
            <button type="submit" name="submit_action" value="save_and_add">Lưu và thêm phòng khác</button>
            <button type="button" onclick="window.location.href='/baitaplon/quanlyphong/quanlyphong.php?facility_id=<?php echo isset($_POST['facility_id']) ? $_POST['facility_id'] : ''; ?>'">Hủy</button>
        </div>

    </form>
</div>
</body>
</html>
