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

// Kiểm tra nếu có dữ liệu từ form gửi đến (xử lý thanh toán)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $so_phong = isset($_POST['so_phong']) ? $_POST['so_phong'] : '';
    $chu_so_huu = isset($_POST['chu_so_huu']) ? $_POST['chu_so_huu'] : '';
    $thang_nam = isset($_POST['thang_nam']) ? $_POST['thang_nam'] : '';
    $tien_phong = isset($_POST['tien_phong']) ? floatval(str_replace('.', '', $_POST['tien_phong'])) : 0;
    $phi_dich_vu = isset($_POST['phi_dich_vu']) ? floatval(str_replace('.', '', $_POST['phi_dich_vu'])) : 0;
    $tien_nuoc = isset($_POST['tien_nuoc']) ? floatval(str_replace('.', '', $_POST['tien_nuoc'])) : 0;
    $tien_dien = isset($_POST['tien_dien']) ? floatval(str_replace('.', '', $_POST['tien_dien'])) : 0;
    $tinh_trang = isset($_POST['tinh_trang']) ? $_POST['tinh_trang'] : '';

    // Cập nhật dữ liệu vào cơ sở dữ liệu
    $sql = "UPDATE hoadon 
            SET so_phong = '$so_phong',chu_so_huu = '$chu_so_huu', thang_nam = '$thang_nam', tien_phong = $tien_phong, 
                phi_dich_vu = $phi_dich_vu, tien_nuoc = $tien_nuoc, tien_dien = $tien_dien, tinh_trang = '$tinh_trang' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Thành công, chuyển hướng về trang xem hóa đơn
        header("Location: xemhoadon.php?id=$id");
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    // Lấy ID từ URL
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Truy vấn thông tin hóa đơn của phòng
    $sql = "SELECT * FROM hoadon WHERE id = $id";
    $result = $conn->query($sql);

    // Kiểm tra nếu có dữ liệu hóa đơn
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Không tìm thấy hóa đơn.");
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Hóa Đơn</title>
    <link href="suahoadon.css" rel="stylesheet"> <!-- Liên kết đến file CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Thanh Toán Hóa Đơn - <?php echo $row['so_phong']; ?></h1>

        <!-- Form gửi dữ liệu sửa hóa đơn -->
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="mb-3">
                <label for="so_phong" class="form-label"><i class="fa-solid fa-house"></i> Số Phòng</label>
                <input type="text" class="form-control" id="so_phong" name="so_phong" value="<?php echo $row['so_phong']; ?>">
            </div>
            <div class="mb-3">
                <label for="chu_so_huu" class="form-label"><i class="fa-solid fa-user"></i> Chủ Sở Hữu</label>
                <input type="text" class="form-control" id="chu_so_huu" name="chu_so_huu" value="<?php echo $row['chu_so_huu']; ?>">
            </div>
            <div class="mb-3">
                <label for="thang_nam" class="form-label"><i class="fa-solid fa-calendar-days"></i> Tháng/Năm</label>
                <input type="text" class="form-control" id="thang_nam" name="thang_nam" value="<?php echo $row['thang_nam']; ?>">
            </div>

            <div class="mb-3">
                <label for="tien_phong" class="form-label"><i class="fa-solid fa-money-bill"></i> Tiền Phòng</label>
                <input type="text" class="form-control" id="tien_phong" name="tien_phong" value="<?php echo number_format($row['tien_phong'], 0, ',', '.'); ?>">
            </div>

            <div class="mb-3">
                <label for="phi_dich_vu" class="form-label"><i class="fa-solid fa-money-bill"></i> Phí Dịch Vụ</label>
                <input type="text" class="form-control" id="phi_dich_vu" name="phi_dich_vu" value="<?php echo number_format($row['phi_dich_vu'], 0, ',', '.'); ?>">
            </div>

            <div class="mb-3">
                <label for="tien_nuoc" class="form-label"><i class="fa-solid fa-droplet"></i> Tiền Nước</label>
                <input type="text" class="form-control" id="tien_nuoc" name="tien_nuoc" value="<?php echo number_format($row['tien_nuoc'], 0, ',', '.'); ?>">
            </div>

            <div class="mb-3">
                <label for="tien_dien" class="form-label"><i class="fa-solid fa-bolt"></i> Tiền Điện</label>
                <input type="text" class="form-control" id="tien_dien" name="tien_dien" value="<?php echo number_format($row['tien_dien'], 0, ',', '.'); ?>">
            </div>

            <div class="mb-3">
                <label for="tinh_trang" class="form-label"><i class="fa-solid fa-money-bill"></i> Tình Trạng</label>
                <input type="text" class="form-control" id="tinh_trang" name="tinh_trang" value="<?php echo $row['tinh_trang']; ?>">
            </div>

            <div class="text-center mt-3">
                <!-- Nút Lưu Hóa Đơn -->
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Lưu Hóa Đơn</button>

                <!-- Nút Quay Lại -->
                <a href="danhsachphong.php" class="btn btn-secondary"><i class="fa-solid fa-house"></i> Quay Lại</a>
            </div>
        </form>
    </div>

   
</body>
</html>

