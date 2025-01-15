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

// Lấy và kiểm tra tham số facility_id
$facility_id = isset($_GET['facility_id']) ? (int)$_GET['facility_id'] : null;

// Nếu chưa chọn cơ sở, hiển thị giao diện chọn cơ sở
if (!$facility_id) {
    echo '
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chọn Cơ Sở</title>
        <link rel="stylesheet" href="danhsachphong.css">
    </head>
    <body style="background-color: #cee2f6;">
        <div class="container mt-4 text-center">
            <h1 class="text-primary">Vui Lòng Chọn Cơ Sở</h1>
            <div class="d-flex justify-content-center my-4">
                <a href="?facility_id=1" class="btn btn-info mx-2">Cơ Sở 1</a>
                <a href="?facility_id=2" class="btn btn-info mx-2">Cơ Sở 2</a>
            </div>
        </div>
    </body>
    </html>';
    exit;
}

// Lấy tham số tìm kiếm
$search_query = isset($_GET['search_query']) ? mysqli_real_escape_string($conn, $_GET['search_query']) : '';
$search_status = isset($_GET['search_status']) ? mysqli_real_escape_string($conn, $_GET['search_status']) : '';

// Lấy dữ liệu phòng từ cơ sở dữ liệu
$sql = "SELECT r.id AS phong_id,
               r.room_name, 
               r.address_room, 
               r.price, 
               COALESCE(t.tenant_name, 'Không có khách thuê') AS tenant_name,
               r.status
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
        <h1 class="text-center text-primary">Danh Sách Phòng - Cơ Sở <?php echo $facility_id; ?></h1>

        <!-- Form tìm kiếm -->
        <form method="GET" action="" class="search-form">
            <input type="hidden" name="facility_id" value="<?php echo $facility_id; ?>">
            <div class="row g-3">
                <!-- Tìm kiếm theo từ khóa -->
                <div class="col-md-6">
                    <input type="text" name="search_query" class="form-control" placeholder="Tìm kiếm theo số phòng" value="<?php echo htmlspecialchars($search_query); ?>">
                </div>
                <!-- Lọc theo trạng thái -->
                <div class="col-md-4">
                    <select name="search_status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="paid" <?php echo $search_status == 'paid' ? 'selected' : ''; ?>>Đã thanh toán</option>
                        <option value="unpaid" <?php echo $search_status == 'unpaid' ? 'selected' : ''; ?>>Chưa thanh toán</option>
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
                                <p class="card-text room-address"><i class="fa-solid fa-location-dot"></i> Địa chỉ: <?php echo htmlspecialchars($row['address_room']); ?></p>
                                <p class="card-text room-owner"><i class="fa-solid fa-user"></i> Chủ sở hữu: <?php echo htmlspecialchars($row['tenant_name']); ?></p>
                                <p class="card-text room-status <?php echo $row['status'] == 'paid' ? 'status-paid' : 'status-unpaid'; ?>">
                                    <i class="fa-solid fa-money-check-dollar"></i> Trạng thái: 
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </p>
                                <div class="card-actions">
                                    <a href="xemhoadon.php?id=<?php echo $row['phong_id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i> Xem</a>
                                    <a href="suahoadon.php?id=<?php echo $row['phong_id']; ?>" class="btn btn-warning"><i class="fa-solid fa-pen"></i> Sửa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-results">Không có phòng nào phù hợp với tiêu chí tìm kiếm.</p>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
    <a href="http://localhost/baiTapLon/trangchu/index.php" class="btn btn-secondary">Quay lại trang chủ</a>
</div>
    </div>
</body>
</html>
