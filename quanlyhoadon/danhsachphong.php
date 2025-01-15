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

// Lấy và kiểm tra các tham số tìm kiếm
$search_query = isset($_GET['search_query']) ? mysqli_real_escape_string($conn, $_GET['search_query']) : '';
$search_status = isset($_GET['search_status']) ? mysqli_real_escape_string($conn, $_GET['search_status']) : '';
$facility_id = isset($_GET['facility_id']) ? (int)$_GET['facility_id'] : null;

// Kiểm tra nếu $facility_id không hợp lệ
if (!$facility_id) {
    echo "Vui lòng chọn cơ sở.";
    exit;
}

// Lấy dữ liệu phòng từ cơ sở dữ liệu (bao gồm cơ sở)
$sql = "SELECT r.id AS phong_id,
               r.room_name, 
               r.address_room, 
               r.price, 
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

// Kiểm tra và thực thi câu lệnh SQL
$result = $conn->query($sql);

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
    <title>Quản Lý Hóa Đơn</title>
    <link href="danhsachphong.css" rel="stylesheet">
</head>
<body style="background-color: #cee2f6;">
    <div class="container mt-4">
        <h1 class="text-center text-primary">Danh Sách Phòng</h1>

        <!-- Nút chọn cơ sở -->
        <div class="d-flex justify-content-center my-3">
            <form method="POST" action="" class="facility-form">
                <button type="submit" name="facility_id" value="1" class="btn btn-info facility-button <?php echo $ma_co_so == 1 ? 'active' : ''; ?>"><i class="fa-solid fa-location-dot"></i> Cơ Sở 1</button>
                <button type="submit" name="facility_id" value="2" class="btn btn-info facility-button <?php echo $ma_co_so == 2 ? 'active' : ''; ?>"><i class="fa-solid fa-location-dot"></i> Cơ Sở 2</button>
            </form>
        </div>

        <!-- Form tìm kiếm -->
        <form method="POST" action="" class="search-form">
            <input type="hidden" name="facility_id" value="<?php echo $ma_co_so; ?>">
            <div class="row g-3">
                <!-- Tìm kiếm theo từ khóa -->
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo số phòng" value="<?php echo htmlspecialchars($tu_khoa); ?>">
                </div>
                <!-- Lọc theo trạng thái -->
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="paid" <?php echo $tinh_trang == 'paid' ? 'selected' : ''; ?>>Đã thanh toán</option>
                        <option value="unpaid" <?php echo $tinh_trang == 'unpaid' ? 'selected' : ''; ?>>Chưa thanh toán</option>
                    </select>
                </div>
                <!-- Nút tìm kiếm -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                </div>
            </div>
        </form>

        <!-- Danh sách phòng -->
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card room-card">
                            <div class="card-body">
                                <h5 class="card-title room-number"><i class="fa-solid fa-house"></i> <?php echo htmlspecialchars($row['room_name']); ?></h5>
                                <p class="card-text room-address"><i class="fa-solid fa-location-dot"></i> Địa chỉ: <?php echo htmlspecialchars($row['address']); ?></p>
                                <p class="card-text room-owner"><i class="fa-solid fa-user"></i> Chủ sở hữu: <?php echo htmlspecialchars($row['tenant_name']); ?></p>
                                <p class="card-text room-status <?php echo $row['tinh_trang'] == 'Đã thanh toán' ? 'status-paid' : 'status-unpaid'; ?>">
                                    <i class="fa-solid fa-money-check-dollar"></i> Trạng thái: 
                                    <?php echo htmlspecialchars($row['status']); ?></p>
                                <div class="card-actions">
                                    <a href="xemhoadon.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i> Xem</a>
                                    <a href="suahoadon.php?id=<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-pen"></i> Sửa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-results">
                    Không có phòng nào phù hợp với tiêu chí tìm kiếm.
                </p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

