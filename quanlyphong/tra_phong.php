<?php
$servername="localhost";
$username = "root";
$password="";
$dbname="baiTapLon";
$conn= new mysqli($servername, $username,$password,$dbname);

if($conn->connect_error){
    die("Ket noi that bai:" . $conn->connect_error);
}
// Lấy id phòng từ URL
$room_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Nếu không có id hợp lệ, chuyển về trang danh sách
if ($room_id <= 0) {
    header("Location: index.php");
    exit;
}

// Kiểm tra nếu phòng đang được thuê
$sql = "SELECT * FROM rooms WHERE id = $room_id AND status = 'occupied'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Cập nhật trạng thái phòng về 'vacant' (còn trống)
    $update_sql = "UPDATE rooms SET status = 'vacant' WHERE id = $room_id";

    if ($conn->query($update_sql) === TRUE) {
        // Thực hiện xóa thông tin người thuê trong bảng tenants
        $delete_tenant_sql = "DELETE FROM tenants WHERE room_id = $room_id";
        $conn->query($delete_tenant_sql);
        
        // Chuyển hướng về trang danh sách với thông báo thành công
        header("Location: /baiTapLon/quanlyphong/quanlyphong.php?success=Phòng đã được trả và trạng thái cập nhật thành công.");
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Phòng không tồn tại hoặc không có người thuê.";
}
?>