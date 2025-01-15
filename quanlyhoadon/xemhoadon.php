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

// Lấy ID hóa đơn từ GET
$hoa_don_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy vấn thông tin hóa đơn và phòng
$sql = "SELECT h.id AS hoa_don_id,
               r.room_name, 
               r.address_room, 
               r.so_nguoi_o, 
               h.tien_phong, 
               h.phi_dich_vu, 
               h.tien_nuoc, 
               h.tien_dien, 
               h.tinh_trang, 
               COALESCE(t.tenant_name, 'Không có khách thuê') AS tenant_name
        FROM hoadon AS h
        JOIN rooms AS r ON h.facility_id = r.facility_id
        LEFT JOIN tenants AS t ON r.id = t.room_id
        WHERE h.id = $hoa_don_id";

// Thực thi câu truy vấn
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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Hóa Đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="xemhoadon.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body style="background-color: #cee2f6;">
    <div class="container mt-4">
        <h1 class="text-center text-primary">Chi Tiết Hóa Đơn</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title room-number"><i class="fa-solid fa-house"></i> Phòng: <?php echo htmlspecialchars($row['room_name']); ?></h5>
                <p class="card-text room-address"><i class="fa-solid fa-location-dot"></i> Địa chỉ: <?php echo htmlspecialchars($row['address_room']); ?></p>
                <p class="card-text tenant-name"><i class="fa-solid fa-user"></i> Tên khách thuê: <?php echo htmlspecialchars($row['tenant_name']); ?></p>
                <p class="card-text room-people"><i class="fa-solid fa-users"></i> Số người ở: <?php echo htmlspecialchars($row['so_nguoi_o']); ?></p>

                <h5 class="card-title">Thông Tin Hóa Đơn</h5>
                <p><i class="fa-solid fa-money-bill-wave"></i> <strong>Tiền phòng:</strong> <?php echo number_format($row['tien_phong'], 0, ',', '.'); ?> VND</p>
                <p><i class="fa-solid fa-cogs"></i> <strong>Phí dịch vụ:</strong> <?php echo number_format($row['phi_dich_vu'], 0, ',', '.'); ?> VND</p>
                <p><i class="fa-solid fa-tint"></i> <strong>Tiền nước:</strong> <?php echo number_format($row['tien_nuoc'], 0, ',', '.'); ?> VND</p>
                <p><i class="fa-solid fa-bolt"></i> <strong>Tiền điện:</strong> <?php echo number_format($row['tien_dien'], 0, ',', '.'); ?> VND</p>
                <p><i class="fa-solid fa-info-circle"></i> <strong>Tình trạng:</strong> <?php echo htmlspecialchars($row['tinh_trang']); ?></p>

                <div class="card-actions">
                    <a href="danhsachphong.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
