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

// Xử lý thêm hóa đơn khi gửi form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = isset($_POST['room_id']) ? $_POST['room_id'] : '';
    $tien_phong = isset($_POST['tien_phong']) ? floatval(str_replace('.', '', $_POST['tien_phong'])) : 0;
    $phi_dich_vu = isset($_POST['phi_dich_vu']) ? floatval(str_replace('.', '', $_POST['phi_dich_vu'])) : 0;
    $tien_nuoc = isset($_POST['tien_nuoc']) ? floatval(str_replace('.', '', $_POST['tien_nuoc'])) : 0;
    $tien_dien = isset($_POST['tien_dien']) ? floatval(str_replace('.', '', $_POST['tien_dien'])) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    // Câu lệnh thêm hóa đơn vào cơ sở dữ liệu
    $insert_sql = "INSERT INTO hoadon (room_id, tien_phong, phi_dich_vu, tien_nuoc, tien_dien, status)
                   VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($insert_sql)) {
        $stmt->bind_param('ddddss', $room_id, $tien_phong, $phi_dich_vu, $tien_nuoc, $tien_dien, $status);
        
        if ($stmt->execute()) {
            echo "<script>alert('Thêm hóa đơn thành công!'); window.location.href='quanlyhoadon.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi thêm hóa đơn.');</script>";
        }

        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị câu lệnh: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Hóa Đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
</head>
<body style="background-color: #cee2f6;">
    <div class="container mt-4">
        <h1 class="text-center text-primary">Thêm Hóa Đơn</h1>

        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="room_id" class="form-label">ID Phòng</label>
                        <input type="text" class="form-control" id="room_id" name="room_id" required>
                    </div>

                    <div class="mb-3">
                        <label for="tien_phong" class="form-label">Tiền Phòng</label>
                        <input type="text" class="form-control" id="tien_phong" name="tien_phong" required>
                    </div>

                    <div class="mb-3">
                        <label for="phi_dich_vu" class="form-label">Phí Dịch Vụ</label>
                        <input type="text" class="form-control" id="phi_dich_vu" name="phi_dich_vu" required>
                    </div>

                    <div class="mb-3">
                        <label for="tien_nuoc" class="form-label">Tiền Nước</label>
                        <input type="text" class="form-control" id="tien_nuoc" name="tien_nuoc" required>
                    </div>

                    <div class="mb-3">
                        <label for="tien_dien" class="form-label">Tiền Điện</label>
                        <input type="text" class="form-control" id="tien_dien" name="tien_dien" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Tình Trạng</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Đã thanh toán">Đã thanh toán</option>
                            <option value="Chưa thanh toán">Chưa thanh toán</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Thêm Hóa Đơn</button>
                        <a href="quanlyhoadon.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
