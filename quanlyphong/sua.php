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

// Kiểm tra và lấy thông tin phòng từ ID
if (isset($_GET['id'])) {
    $room_id = $_GET['id'];
    $room_sql = "SELECT rooms.*, facilities.name AS facility_name 
                 FROM rooms 
                 JOIN facilities ON rooms.facility_id = facilities.id 
                 WHERE rooms.id = $room_id";
    $room_result = $conn->query($room_sql);
    if ($room_result->num_rows > 0) {
        $room = $room_result->fetch_assoc();
    } else {
        echo "Không tìm thấy phòng.";
        exit();
    }
}

// Kiểm tra và lấy thông tin khách hàng
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];
    $customer_sql = "SELECT * FROM customers WHERE id = $customer_id";
    $customer_result = $conn->query($customer_sql);
    if ($customer_result->num_rows > 0) {
        $customer = $customer_result->fetch_assoc();
    } else {
        echo "Không tìm thấy khách hàng.";
        exit();
    }
}

// Xử lý form sửa phòng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_room'])) {
    $room_name = $conn->real_escape_string($_POST['room_name']);
    $price = (float)$_POST['price'];
    $status = $conn->real_escape_string($_POST['status']);
    $address = $conn->real_escape_string($_POST['address']);
    $facility_id = (int)$_POST['facility_id'];

    // Ánh xạ giá trị trạng thái
    if ($status === "Còn trống") {
        $status = "empty";
    } elseif ($status === "Đã thuê") {
        $status = "rented";
    }

    $update_room_sql = "UPDATE rooms 
                        SET room_name = '$room_name', price = $price, status = '$status', address = '$address', facility_id = $facility_id 
                        WHERE id = $room_id";

    if ($conn->query($update_room_sql) === TRUE) {
        echo "<script>alert('Phòng đã được cập nhật thành công!');</script>";
        echo "<script>window.location.href='quanlyphong.php';</script>";
    } else {
        echo "Lỗi cập nhật phòng: " . $conn->error;
    }
}

// Xử lý form sửa khách hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_customer'])) {
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $customer_email = $conn->real_escape_string($_POST['customer_email']);
    $customer_phone = $conn->real_escape_string($_POST['customer_phone']);

    $update_customer_sql = "UPDATE customers 
                            SET name = '$customer_name', email = '$customer_email', phone = '$customer_phone' 
                            WHERE id = $customer_id";

    if ($conn->query($update_customer_sql) === TRUE) {
        echo "<script>alert('Thông tin khách hàng đã được cập nhật thành công!');</script>";
        echo "<script>window.location.href='quanlyphong.php';</script>";
    } else {
        echo "Lỗi cập nhật thông tin khách hàng: " . $conn->error;
    }
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Phòng và Khách Hàng</title>
    <link rel="stylesheet" href="sua.css">
</head>
<body>
<h1>Sửa Phòng và Khách Hàng</h1>
<div class="container">

    <!-- Form sửa thông tin phòng -->
    <form method="POST" action="sua.php?id=<?php echo $room_id; ?>">
        <fieldset>
            <h2>Sửa Thông Tin Phòng</h2>

            <div class="form-group">
                <label for="room_name">Tên Phòng:</label>
                <input type="text" name="room_name" value="<?php echo $room['room_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="number" name="price" value="<?php echo $room['price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái:</label>
                <select name="status">
                    <option value="Còn trống" <?php echo $room['status'] == 'Còn trống' ? 'selected' : ''; ?>>Còn trống</option>
                    <option value="Đã thuê" <?php echo $room['status'] == 'Đã thuê' ? 'selected' : ''; ?>>Đã thuê</option>
                </select>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" name="address" value="<?php echo $room['address']; ?>" required>
            </div>

            <div class="form-group">
                <label for="facility_id">Cơ sở:</label>
                <select name="facility_id">
                    <option value="1" <?php echo $room['facility_id'] == 1 ? 'selected' : ''; ?>>Cơ sở 1</option>
                    <option value="2" <?php echo $room['facility_id'] == 2 ? 'selected' : ''; ?>>Cơ sở 2</option>
                </select>
            </div>

            <button type="submit" name="update_room">Cập nhật phòng</button>
        </fieldset>
    </form>

    <!-- Form sửa thông tin khách hàng -->
    <?php if (isset($customer)): ?>
    <form method="POST" action="sua.php?customer_id=<?php echo $customer_id; ?>">
        <fieldset>
            <h2>Sửa Thông Tin Khách Hàng</h2>

            <div class="form-group">
                <label for="customer_name">Tên Khách Hàng:</label>
                <input type="text" name="customer_name" value="<?php echo $customer['name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="customer_email">Email:</label>
                <input type="email" name="customer_email" value="<?php echo $customer['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="customer_phone">Số điện thoại:</label>
                <input type="text" name="customer_phone" value="<?php echo $customer['phone']; ?>" required>
            </div>

            <button type="submit" name="update_customer">Cập nhật khách hàng</button>
        </fieldset>
    </form>
    <?php endif; ?>
</div>
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
