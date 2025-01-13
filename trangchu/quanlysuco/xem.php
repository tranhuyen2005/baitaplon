<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

// Lấy id từ URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Truy vấn để lấy thông tin sự cố từ cơ sở dữ liệu
$sql = "SELECT * FROM bao_cao WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!$row) {
    echo "<div class='alert alert-danger text-center' role='alert'>Không tìm thấy sự cố!</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sự Cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Chi Tiết Sự Cố Phòng Trọ</h2>
                <div class="card">
                    <div class="card-body">
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

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Quay lại</a>
                            <a href="sua_suco.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a>
                        </div>
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
