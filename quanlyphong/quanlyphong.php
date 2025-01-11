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

// Xử lý tìm kiếm
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
$search_status = isset($_GET['search_status']) ? $_GET['search_status'] : '';
$facility_id = isset($_GET['facility_id']) ? $_GET['facility_id'] : null;

// Lấy dữ liệu phòng từ cơ sở dữ liệu (bao gồm cơ sở)
$sql = "SELECT rooms.id, rooms.room_name, rooms.price, rooms.status, rooms.address, facilities.name AS facility_name, rooms.tenant_name
        FROM rooms
        JOIN facilities ON rooms.facility_id = facilities.id
        WHERE 1";

// Thêm điều kiện tìm kiếm theo tên phòng hoặc địa chỉ
if ($search_query) {
    $sql .= " AND (rooms.room_name LIKE '%$search_query%' OR rooms.address LIKE '%$search_query%')";
}

// Thêm điều kiện tìm kiếm theo trạng thái
if ($search_status) {
    $sql .= " AND rooms.status = '$search_status'";
}

// Thêm điều kiện tìm kiếm theo cơ sở
if ($facility_id) {
    $sql .= " AND rooms.facility_id = $facility_id";
}

$result = $conn->query($sql);

// Kiểm tra và xử lý yêu cầu xóa phòng
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM rooms WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Phòng đã được xóa.";
        // Sau khi xóa, chuyển hướng lại trang quản lý phòng
        header("Location: quanlyphong.php");
        exit();
    } else {
        echo "Lỗi xóa phòng: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Phòng</title>
    <link rel="stylesheet" href="quanlyphong.css">
</head>

<body>
<div class="container">
    <h1>Quản lý Phòng</h1>
    
    <!-- Form tìm kiếm -->
    <div class="search-container">
        <form method="GET" action="quanlyphong.php" style="flex: 1; display: flex; gap: 10px;">
            <input type="text" name="search_query" placeholder="Tìm kiếm theo tên phòng hoặc địa chỉ" value="<?php echo $search_query; ?>" />
            <select name="search_status">
                <option value="">Tìm kiếm theo trạng thái</option>
                <option value="empty" <?php echo $search_status == 'Còn trống' ? 'selected' : ''; ?>>Còn trống</option>
                <option value="rented" <?php echo $search_status == 'Đã cho thuê' ? 'selected' : ''; ?>>Đã thuê</option>
            </select>
            <button type="submit" class="search-button">Tìm kiếm</button>
        </form>
        <form action="themphong.php" method="GET" style="display: inline;">
            <button type="submit" class="add-room-button" >Thêm phòng</button>
        </form>
    </div>

    <!-- Nút chọn cơ sở -->
    <form method="GET" action="quanlyphong.php">
        <div class="facility-buttons">
            <button type="submit" name="facility_id" value="1" class="facility-button"><i class="fas fa-map-marker-alt"></i> Cơ sở 1</button>
            <button type="submit" name="facility_id" value="2" class="facility-button"><i class="fas fa-map-marker-alt"></i> Cơ sở 2</button>
        </div>
    </form>

    <!-- Nếu chưa chọn cơ sở -->
    <?php if (!$facility_id): ?>
        <p>Vui lòng chọn cơ sở của mình.</p>
    <?php elseif ($result->num_rows > 0): ?>
        <!-- Các phòng -->
        <div class="room-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="room-wrapper">
                <div class="room">
                    <h3><i class="fas fa-bed"></i> Phòng: <?php echo $row["room_name"]; ?></h3>
                    <p><i class="fas fa-user"></i> Khách thuê: <?php echo $row["tenant_name"] ? $row["tenant_name"] : "Chưa có"; ?></p>
                    <p><i class="fas fa-check-circle"></i> Trạng thái: 
                        <span style="color: <?php echo $row['status'] == 'Còn trống' ? 'green' : 'black'; ?>">
                            <?php echo ucfirst($row["status"]); ?>
                        </span>
                    </p>
                    <p><i class="fas fa-dollar-sign"></i> Giá: <span style="color: red;"><?php echo number_format($row["price"], 0, ',', '.'); ?> VND</span></p>

                    <p><i class="fas fa-building"></i> Cơ sở: <?php echo $row["facility_name"]; ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> Địa chỉ: <?php echo $row["address"]; ?></p>

                    <!-- Nút Thuê phòng hoặc Trả phòng -->
                    <?php if ($row["status"] == "Còn trống"): ?>
                        <form action="thuephong.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>" />
                            <button type="submit" class="rent-button"><i class="fas fa-handshake"></i> Thuê phòng</button>
                        </form>
                    <?php elseif ($row["status"] == "Đã cho thuê"): ?>
                        <form action="traphong.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>" />
                            <button type="submit" class="return-button"><i class="fas fa-undo-alt"></i> Trả phòng</button>
                        </form>
                    <?php endif; ?>

                    <!-- Nút Sửa -->
                    <form action="sua.php" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>" />
                        <button type="submit" class="edit-button"><i class="fas fa-edit"></i> Sửa</button>
                    </form>

                    <!-- Nút Xem phòng -->
                    <form action="xem.php" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>" />
                        <button type="submit" class="view-button"><i class="fas fa-eye"></i> Xem</button>
                    </form>

                    <!-- Nút Xóa -->
                    <form action="quanlyphong.php" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa phòng này?');">
                        <input type="hidden" name="delete_id" value="<?php echo $row["id"]; ?>" />
                        <button type="submit" class="delete-button"><i class="fas fa-trash-alt"></i> Xóa</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Không có phòng nào.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
