<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    $sql = "SELECT * FROM rooms WHERE id = $room_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <form id="edit-room-form" method="POST" action="quanlyphong.php">
            <h2>Sửa thông tin phòng</h2>
            <input type="hidden" name="room_id" value="<?php echo $row['id']; ?>">
            <label for="room_name">Tên phòng:</label>
            <input type="text" name="room_name" id="room_name" value="<?php echo $row['room_name']; ?>" required>
            
            <label for="price">Giá phòng:</label>
            <input type="number" name="price" id="price" value="<?php echo $row['price']; ?>" required>
            
            <label for="status">Trạng thái:</label>
            <select name="status" id="status">
                <option value="Còn trống" <?php echo $row['status'] == 'Còn trống' ? 'selected' : ''; ?>>Còn trống</option>
                <option value="Đã cho thuê" <?php echo $row['status'] == 'Đã cho thuê' ? 'selected' : ''; ?>>Đã cho thuê</option>
            </select>
            
            <div class="form-buttons">
    <button type="submit" name="update_room">Cập nhật</button>
    <button type="button" onclick="closeModal()">Hủy</button>
</div>

        </form>
        <?php
    } else {
        echo "<p>Không tìm thấy thông tin phòng.</p>";
    }
}

$conn->close();
?>
