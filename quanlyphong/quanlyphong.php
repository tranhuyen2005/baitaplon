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
// Câu truy vấn để lấy danh sách phòng, tên khách thuê, địa chỉ và giá phòng
$sql = "SELECT r.id AS phong_id,
               r.room_name, 
               r.address_room, 
               r.price, 
               r.status,
               COALESCE(t.tenant_name, 'Không có khách thuê') AS tenant_name
        FROM rooms AS r
        LEFT JOIN tenants AS t ON r.id = t.room_id
        WHERE r.facility_id = $facility_id";

// Thêm điều kiện tìm kiếm từ khóa
if ($search_query) {
    $sql .= " AND (r.room_name LIKE '%$search_query%' OR r.address_room LIKE '%$search_query%')";
}

// Thêm điều kiện tìm kiếm theo trạng thái
if ($search_status) {
    $sql .= " AND r.status = '$search_status'";
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

// Xử lý cập nhật thông tin phòng
if (isset($_POST['update_room'])) {
    $room_id = $_POST['room_id'];
    $room_name = $_POST['room_name'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $update_sql = "UPDATE rooms SET room_name = '$room_name', price = $price, status = '$status' WHERE id = $room_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "Cập nhật thông tin phòng thành công!";
    } else {
        echo "Lỗi khi cập nhật phòng: " . $conn->error;
    }

    // Reload trang sau khi cập nhật
    header("Location: quanlyphong.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Phòng</title>
    <link rel="stylesheet" href="quanlyphong.css">
    <link rel="stylesheet" href="/baiTapLon/quanlyphong/sua.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <button id="add-room-btn" class="add-room-button">Thêm phòng</button>
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
                    <p><i class="fas fa-map-marker-alt"></i> Địa chỉ: <?php echo $row["address_room"]; ?></p>

                    <!-- Nút Thuê phòng hoặc Trả phòng -->
                    <?php if ($row["status"] == "Còn trống"): ?>
                        <button type="button" class="rent-button open-modal" data-room-id="<?php echo $row['phong_id']; ?>">
                            <i class="fas fa-handshake"></i> Thuê phòng
                        </button>
                    <?php elseif ($row["status"] == "Đã cho thuê"): ?>
                        <form action="quanlyphong.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row["phong_id"]; ?>" />
                            <button type="submit" class="delete-button"><i class="fas fa-trash-alt"></i> Xóa</button>
                        </form>
                    <?php endif; ?>

                    <!-- Nút Sửa -->
                    <button type="button" class="edit-button" onclick="openModal(<?php echo $row['phong_id']; ?>)">
                        <i class="fas fa-edit"></i> Sửa
                    </button>

                    <!-- Nút Xem phòng -->
                    <form action="xem.php" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row["phong_id"]; ?>" />
                        <button type="submit" class="view-button"><i class="fas fa-eye"></i> Xem</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Không có phòng nào.</p>
    <?php endif; ?>
</div>

<!-- Các đoạn script vẫn giữ nguyên -->
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
