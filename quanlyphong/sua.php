<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : null;

if ($room_id) {
    $sql = "SELECT * FROM rooms WHERE id = $room_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin phòng</title>
    <link rel="stylesheet" href="sua.css">
</head>
<body>
        <div class="modal-header">
            <h2>Sửa thông tin phòng</h2>
        </div>
        <form method="POST" action="quanlyphong.php">
            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
            <label for="room_name">Tên phòng:</label>
            <input type="text" name="room_name" id="room_name" value="<?php echo $room['room_name']; ?>" required>
            
            <label for="price">Giá:</label>
            <input type="number" name="price" id="price" value="<?php echo $room['price']; ?>" required>

            <label for="status">Trạng thái:</label>
            <select name="status" id="status">
                <option value="Còn trống" <?php echo $room['status'] == 'Còn trống' ? 'selected' : ''; ?>>Còn trống</option>
                <option value="Đã cho thuê" <?php echo $room['status'] == 'Đã cho thuê' ? 'selected' : ''; ?>>Đã cho thuê</option>
            </select>
            
            <button type="submit" name="update_room">Lưu</button>
        </form>
        <?php
    } else {
        echo "<p>Không tìm thấy thông tin phòng.</p>";
    }
} else {
    echo "<p>ID phòng không hợp lệ.</p>";
}

$conn->close();
?>
</body>
</html>
