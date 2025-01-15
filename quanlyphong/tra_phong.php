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

// Lấy ID phòng từ URL
if (isset($_GET['id'])) {
    $room_id = intval($_GET['id']);

    // Xóa thông tin khách thuê và cập nhật trạng thái phòng
    $sql = "UPDATE rooms SET status = 'vacant' WHERE id = $room_id";
    $delete_tenant_sql = "DELETE FROM tenants WHERE room_id = $room_id";

    if ($conn->query($sql) === TRUE && $conn->query($delete_tenant_sql) === TRUE) {
        echo "<script>alert('Đã trả phòng thành công.'); window.location.href = '/baiTapLon/quanlyphong/quanlyphong.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "<script>alert('ID phòng không hợp lệ.'); window.location.href = '/baiTapLon/quanlyphong/quanlyphong.php';</script>";
}

$conn->close();
?>
