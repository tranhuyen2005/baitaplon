<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy cơ sở đã chọn (mặc định là cơ sở 1 nếu không được chọn)
$ma_co_so = isset($_POST['facility_id']) ? intval($_POST['facility_id']) : 1;

// Lấy từ khóa tìm kiếm và trạng thái nếu có
$tu_khoa = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';
$tinh_trang = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : '';

// Xây dựng câu truy vấn danh sách phòng
$sql = "SELECT r.id AS room_id, r.room_name, r.address_room, r.so_nguoi_o, r.price, 
               CASE 
                   WHEN t.room_id IS NOT NULL THEN 'occupied' 
                   ELSE 'vacant' 
               END AS status, 
               t.tenant_name
        FROM rooms AS r
        LEFT JOIN tenants AS t ON r.id = t.room_id
        WHERE r.facility_id = $ma_co_so";


// Thêm điều kiện tìm kiếm từ khóa
if (!empty($tu_khoa)) {
    $sql .= " AND (r.room_name LIKE '%$tu_khoa%' OR r.address_room LIKE '%$tu_khoa%')";
}

// Thêm điều kiện lọc theo trạng thái nếu có
if (!empty($tinh_trang)) {
    $sql .= " AND r.status = '$tinh_trang'";
}

// Thực thi câu truy vấn
$result = $conn->query($sql);

// Kiểm tra xem có lỗi trong câu truy vấn hay không
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Phòng Trọ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6H4M6O2Go8hSIVp38IMjeU7b8n8fS6ttJ2klG6k5D5MZm9wewFz9c31fjf" crossorigin="anonymous">
    <link href="quanlyphong.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body style="background-color: #cee2f6;">
    <div class="container mt-4">
        <h1 class="text-center text-primary">Danh Sách Phòng Trọ</h1>

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
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên phòng hoặc địa chỉ" value="<?php echo htmlspecialchars($tu_khoa); ?>">
                </div>
                <!-- Lọc theo trạng thái -->
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="occupied" <?php echo $tinh_trang == 'occupied' ? 'selected' : ''; ?>>Đã có người thuê</option>
                        <option value="vacant" <?php echo $tinh_trang == 'vacant' ? 'selected' : ''; ?>>Còn trống</option>
                    </select>
                </div>
                <!-- Nút tìm kiếm và thêm phòng -->
                <div class="col-md-2 d-flex">
                    <button type="submit" class="btn btn-success me-2"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                    <a href="themphong.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm phòng</a>
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
                                <h5 class="card-title room-number"><i class="fa-solid fa-house"></i> Phòng: <?php echo htmlspecialchars($row['room_name']); ?></h5>
                                <p class="card-text room-address"><i class="fa-solid fa-location-dot"></i> Địa chỉ: <?php echo htmlspecialchars($row['address_room']); ?></p>
                                <p class="card-text tenant-name"><i class="fa-solid fa-user"></i> Tên khách thuê: <?php echo htmlspecialchars($row['tenant_name'] ?? 'Chưa có người thuê'); ?></p>
                                <p class="card-text room-status <?php echo $row['status'] == 'vacant' ? 'status-vacant' : 'status-occupied'; ?>">
                                    <i class="fa-solid fa-door-closed"></i> Trạng thái: 
                                    <?php echo $row['status'] == 'vacant' ? 'Còn trống' : 'Đã cho thuê'; ?>
                                </p>

                                <p class="room-price"><i class="fa-solid fa-dollar-sign"></i> Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</p>
                                <div class="card-actions">
                                    <a href="xem.php" class="btn btn-primary"><i class="fa-solid fa-eye"></i> Xem</a>
                                    <a href="sua.php?id=<?php echo $row['room_id']; ?>" class="btn btn-warning"><i class="fa-solid fa-pen"></i> Sửa</a>
                                    <button type="submit" class="btn custom-btn-delete"><i class="fa-solid fa-trash"></i> Xóa phòng</button>
                                    <!-- Nút thuê phòng và trả phòng -->
                                    <?php if ($row['status'] == 'vacant'): ?>
                                        <a href="thue_phong.php?id=<?php echo $row['room_id']; ?>" class="btn btn-success"><i class="fa-solid fa-hand-holding"></i> Thuê phòng</a>
                                    <?php else: ?>
                                        <a href="tra_phong.php?id=<?php echo $row['room_id']; ?>" class="btn btn-danger"><i class="fa-solid fa-arrow-right-to-bracket"></i> Trả phòng</a>
                                    <?php endif; ?>
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
