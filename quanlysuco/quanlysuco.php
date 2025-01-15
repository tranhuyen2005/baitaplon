<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon"; // Tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu có giá trị 'facility_id' trong POST, nếu không có, mặc định chọn cơ sở 1
$facility_id = isset($_POST['facility_id']) ? $_POST['facility_id'] : 1; // Mặc định là cơ sở 1

// Truy vấn danh sách phòng của cơ sở đã chọn
$sql = "SELECT * FROM bao_cao WHERE facility_id = $facility_id";
$result = $conn->query($sql);

// Địa chỉ tương ứng với mỗi cơ sở
$facility_addresses = [
    1 => "Hà Nội",
    2 => "Hồ Chí Minh"
];
$facility_address = isset($facility_addresses[$facility_id]) ? $facility_addresses[$facility_id] : "Hà Nội";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Sự Cố Phòng Trọ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Báo Cáo Sự Cố Phòng Trọ</h1>

        <!-- Hai nút cho Cơ Sở 1 và Cơ Sở 2 -->
        <div class="d-flex justify-content-center my-3">
            <form method="POST" action="">
                <button type="submit" name="facility_id" value="1" class="btn btn-primary mx-2">Cơ Sở 1 - Hà Nội</button>
                <button type="submit" name="facility_id" value="2" class="btn btn-primary mx-2">Cơ Sở 2 - Hồ Chí Minh</button>
            </form>
        </div>

        <!-- Hiển thị danh sách phòng của cơ sở đã chọn -->
        <h2 class="text-center">Danh sách phòng của cơ sở: <?php echo $facility_address; ?></h2>
        
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Phòng: <?php echo htmlspecialchars($row['so_phong']); ?></h5>
                                <p class="card-text">Người thuê: <?php echo htmlspecialchars($row['ten_nguoi_thue']); ?></p>
                                <p class="card-text">Sự cố: <?php echo htmlspecialchars($row['su_co']); ?></p>
                                <p class="card-text">Địa chỉ: <?php echo htmlspecialchars($row['dia_chi']); ?></p>

                                <!-- Nút Sửa, Xem và Xóa -->
                                <a href="sua.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a>
                                <a href="xemsuco.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Xem</a>
                                <!-- Nút Xóa -->
                                <form method="POST" action="xoa.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Không có phòng trong cơ sở này.</p>
            <?php endif; ?>
        </div>

        <!-- Nút Thêm -->
        <div class="text-center mt-4">
            <a href="them.php" class="btn btn-success">Thêm Sự Cố Mới</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="d-flex justify-content-start my-3">
            <a href="/baiTapLon/trangchu/trangchu.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ</a>
        </div>
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
