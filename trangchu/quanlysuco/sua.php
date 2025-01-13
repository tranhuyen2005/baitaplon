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

// Lấy id từ URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Nếu id không hợp lệ, thông báo lỗi
if ($id == 0) {
    echo "<div class='alert alert-danger text-center'>Không tìm thấy ID sự cố!</div>";
    exit();
}

// Lấy thông tin sự cố từ cơ sở dữ liệu
$sql = "SELECT * FROM bao_cao WHERE id = $id";
$result = $conn->query($sql);

// Kiểm tra xem có kết quả hay không
if ($result->num_rows == 0) {
    echo "<div class='alert alert-danger text-center'>Không tìm thấy sự cố với ID: $id</div>";
    exit();
}

// Lấy dữ liệu từ kết quả truy vấn
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $so_phong = $_POST['so_phong'];
    $ten_nguoi_thue = $_POST['ten_nguoi_thue'];
    $su_co = $_POST['su_co'];
    $dia_chi = $_POST['dia_chi'];

    // Truy vấn để cập nhật sự cố
    $sql = "UPDATE bao_cao SET so_phong='$so_phong', ten_nguoi_thue='$ten_nguoi_thue', su_co='$su_co', dia_chi='$dia_chi' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Cập nhật sự cố thành công!</div>";
        header("Location: index.php"); // Quay lại trang danh sách
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sự Cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Sửa Thông Tin Sự Cố Phòng Trọ</h2>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="so_phong" class="form-label">Số Phòng</label>
                                <input type="text" class="form-control" id="so_phong" name="so_phong" value="<?php echo htmlspecialchars($row['so_phong']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="ten_nguoi_thue" class="form-label">Tên Người Thuê</label>
                                <input type="text" class="form-control" id="ten_nguoi_thue" name="ten_nguoi_thue" value="<?php echo htmlspecialchars($row['ten_nguoi_thue']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="su_co" class="form-label">Sự Cố</label>
                                <textarea class="form-control" id="su_co" name="su_co" required><?php echo htmlspecialchars($row['su_co']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="dia_chi" class="form-label">Địa Chỉ</label>
                                <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="<?php echo htmlspecialchars($row['dia_chi']); ?>" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-warning">Cập Nhật</button>
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
