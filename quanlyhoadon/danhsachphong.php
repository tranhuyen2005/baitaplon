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
$sql = "SELECT * FROM hoadon WHERE facility_id = $ma_co_so";

// Thêm điều kiện tìm kiếm từ khóa
if (!empty($tu_khoa)) {
    $sql .= " AND (so_phong LIKE '%$tu_khoa%' OR dia_chi LIKE '%$tu_khoa%')";
}

// Thêm điều kiện lọc theo trạng thái nếu có
if (!empty($tinh_trang)) {
    $sql .= " AND tinh_trang = '$tinh_trang'";
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
    <title>Quản Lý Hóa Đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6H4M6O2Go8hSIVp38IMjeU7b8n8fS6ttJ2klG6k5D5MZm9wewFz9c31fjf" crossorigin="anonymous">
    <link href="danhsachphong.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
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
                                <h5 class="card-title room-number"><i class="fa-solid fa-house"></i> <?php echo htmlspecialchars($row['so_phong']); ?></h5>
                                <p class="card-text room-address"><i class="fa-solid fa-location-dot"></i> Địa chỉ: <?php echo htmlspecialchars($row['dia_chi']); ?></p>
                                <p class="card-text room-owner"><i class="fa-solid fa-user"></i> Chủ sở hữu: <?php echo htmlspecialchars($row['chu_so_huu']); ?></p>
                                <p class="card-text room-status <?php echo $row['tinh_trang'] == 'Đã thanh toán' ? 'status-paid' : 'status-unpaid'; ?>">
                                    <i class="fa-solid fa-money-check-dollar"></i> Trạng thái: 
                                    <?php echo htmlspecialchars($row['tinh_trang']); ?></p>
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

