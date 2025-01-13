<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $so_phong = $_POST['so_phong'];
    $ten_nguoi_thue = $_POST['ten_nguoi_thue'];
    $su_co = $_POST['su_co'];
    $dia_chi = $_POST['dia_chi'];

    // Truy vấn để thêm sự cố
    $sql = "INSERT INTO bao_cao (so_phong, ten_nguoi_thue, su_co, dia_chi) VALUES ('$so_phong', '$ten_nguoi_thue', '$su_co', '$dia_chi')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center' role='alert'>Thêm sự cố thành công!</div>";
        header("Location: index.php"); // Quay lại trang danh sách
        exit();
    } else {
        echo "<div class='alert alert-danger text-center' role='alert'>Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sự Cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Thêm Thông Tin Sự Cố Phòng Trọ</h2>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="so_phong" class="form-label">Số Phòng</label>
                                <input type="text" class="form-control" id="so_phong" name="so_phong" required>
                            </div>
                            <div class="mb-3">
                                <label for="ten_nguoi_thue" class="form-label">Tên Người Thuê</label>
                                <input type="text" class="form-control" id="ten_nguoi_thue" name="ten_nguoi_thue" required>
                            </div>
                            <div class="mb-3">
                                <label for="su_co" class="form-label">Sự Cố</label>
                                <textarea class="form-control" id="su_co" name="su_co" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="dia_chi" class="form-label">Địa Chỉ</label>
                                <input type="text" class="form-control" id="dia_chi" name="dia_chi" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">Thêm</button>
                                <a href="index.php" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
