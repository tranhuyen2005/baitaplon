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

// Lấy ID phòng từ GET
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 0;

// Truy vấn thông tin hóa đơn và phòng
$sql = "SELECT h.id AS hoadon_id,
               r.room_name, 
               r.address_room, 
               r.so_nguoi_o, 
               h.tien_phong, 
               h.phi_dich_vu, 
               h.tien_nuoc, 
               h.tien_dien, 
               h.status, 
               COALESCE(t.tenant_name, 'Không có khách thuê') AS tenant_name
        FROM hoadon AS h
        JOIN rooms AS r ON h.room_id = r.id
        LEFT JOIN tenants AS t ON r.id = t.room_id
        WHERE h.room_id = $room_id";

$result = $conn->query($sql);

// Kiểm tra xem có lỗi trong câu truy vấn hay không
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}

// Kiểm tra xem có dữ liệu trả về không
if ($result->num_rows > 0) {
    // Lấy dữ liệu hóa đơn
    $row = $result->fetch_assoc();
} else {
    echo "Không tìm thấy hóa đơn.";
    exit;
}

// Xử lý cập nhật khi gửi form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tien_phong = isset($_POST['tien_phong']) ? floatval(str_replace('.', '', $_POST['tien_phong'])) : 0;
    $phi_dich_vu = isset($_POST['phi_dich_vu']) ? floatval(str_replace('.', '', $_POST['phi_dich_vu'])) : 0;
    $tien_nuoc = isset($_POST['tien_nuoc']) ? floatval(str_replace('.', '', $_POST['tien_nuoc'])) : 0;
    $tien_dien = isset($_POST['tien_dien']) ? floatval(str_replace('.', '', $_POST['tien_dien'])) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    // Cập nhật dữ liệu
    $update_sql = "UPDATE hoadon
                   SET tien_phong = ?, phi_dich_vu = ?, tien_nuoc = ?, tien_dien = ?, status = ?
                   WHERE room_id = ?";

    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($update_sql)) {
        $stmt->bind_param('ddddsi', $tien_phong, $phi_dich_vu, $tien_nuoc, $tien_dien, $status, $room_id);
        
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            echo "<script>alert('Cập nhật hóa đơn thành công!'); window.location.href='quanlyhoadon.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi cập nhật hóa đơn.');</script>";
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
    <title>Thanh Toán Hóa Đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="suahoadon.css">
</head>
<body style="background-color: #cee2f6;">
    <div class="container mt-4">
        <h1 class="text-center text-primary">Chỉnh Sửa Hóa Đơn</h1>

        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['hoadon_id']); ?>">

                    <h5 class="card-title room-number"><i class="fa-solid fa-house"></i> Số Phòng</h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['room_name']); ?></p>

                    <div class="mb-3">
                        <label for="tien_phong" class="form-label"><i class="fa-solid fa-money-bill-wave"></i> Tiền Phòng</label>
                        <input type="text" class="form-control" id="tien_phong" name="tien_phong" value="<?php echo number_format($row['tien_phong'], 0, ',', '.'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="phi_dich_vu" class="form-label"><i class="fa-solid fa-cogs"></i> Phí Dịch Vụ</label>
                        <input type="text" class="form-control" id="phi_dich_vu" name="phi_dich_vu" value="<?php echo number_format($row['phi_dich_vu'], 0, ',', '.'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="tien_nuoc" class="form-label"><i class="fa-solid fa-tint"></i> Tiền Nước</label>
                        <input type="text" class="form-control" id="tien_nuoc" name="tien_nuoc" value="<?php echo number_format($row['tien_nuoc'], 0, ',', '.'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="tien_dien" class="form-label"><i class="fa-solid fa-bolt"></i> Tiền Điện</label>
                        <input type="text" class="form-control" id="tien_dien" name="tien_dien" value="<?php echo number_format($row['tien_dien'], 0, ',', '.'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label"><i class="fa-solid fa-info-circle"></i> Tình Trạng</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Đã Thanh Toán" <?php echo ($row['status'] == 'Đã Thanh Toán') ? 'selected' : ''; ?>>Đã Thanh Toán</option>
                            <option value="Chưa Thanh Toán" <?php echo ($row['status'] == 'Chưa Thanh Toán') ? 'selected' : ''; ?>>Chưa Thanh Toán</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Lưu Hóa Đơn</button>
                        <a href="quanlyhoadon.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
