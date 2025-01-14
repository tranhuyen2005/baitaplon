<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn tất cả các sự cố
$sql = "SELECT * FROM bao_cao";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sự Cố Phòng Trọ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Danh Sách Sự Cố Phòng Trọ</h1>
        
        <!-- Nút Thêm sự cố -->
        <div class="mb-3">
            <a href="them.php" class="btn btn-success">Thêm Sự Cố</a>
        </div>

        <!-- Hiển thị danh sách sự cố -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Số Phòng</th>
                    <th>Tên Người Thuê</th>
                    <th>Sự Cố</th>
                    <th>Địa Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['so_phong']); ?></td>
                            <td><?php echo htmlspecialchars($row['ten_nguoi_thue']); ?></td>
                            <td><?php echo htmlspecialchars($row['su_co']); ?></td>
                            <td><?php echo htmlspecialchars($row['dia_chi']); ?></td>
                            <td>
                                <!-- Nút Xem -->
                                <a href="xem.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Xem</a>
                                
                                <!-- Nút Sửa -->
                                <a href="sua.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                
                                <!-- Nút Xóa -->
                                <a href="xoa.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sự cố này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Không có sự cố nào trong cơ sở dữ liệu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
