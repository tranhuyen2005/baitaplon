<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

// Lấy id từ URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tiến hành xóa sự cố
    $sql = "DELETE FROM bao_cao WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Quay lại trang danh sách sau khi xóa thành công
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi khi xóa sự cố: " . $conn->error;
    }
} else {
    // Truy vấn để lấy thông tin sự cố từ cơ sở dữ liệu
    $sql = "SELECT * FROM bao_cao WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "<div class='alert alert-danger text-center' role='alert'>Không tìm thấy sự cố!</div>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Xóa Sự Cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Xác Nhận Xóa Sự Cố</h2>
                <div class="card">
                    <div class="card-body">
                        <p class="text-center">Bạn có chắc chắn muốn xóa sự cố này không?</p>
                        <table class="table table-bordered">
                            <tr>
                                <th>Số Phòng</th>
                                <td><?php echo htmlspecialchars($row['so_phong']); ?></td>
                            </tr>
                            <tr>
                                <th>Tên Người Thuê</th>
                                <td><?php echo htmlspecialchars($row['ten_nguoi_thue']); ?></td>
                            </tr>
                            <tr>
                                <th>Sự Cố</th>
                                <td><?php echo nl2br(htmlspecialchars($row['su_co'])); ?></td>
                            </tr>
                            <tr>
                                <th>Địa Chỉ</th>
                                <td><?php echo htmlspecialchars($row['dia_chi']); ?></td>
                            </tr>
                        </table>

                        <!-- Form Xóa sự cố -->
                        <form method="POST">
                            <div class="d-flex justify-content-between">
                                <!-- Nút Xóa sự cố -->
                                <button type="submit" class="btn btn-danger">Xóa</button>
                                <!-- Nút Hủy bỏ -->
                                <a href="index.php" class="btn btn-secondary">Hủy Bỏ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
