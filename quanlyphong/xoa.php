<?php
$conn = mysqli_connect("localhost","root","","baiTapLon");
if($conn->connect_errno){
    die("Kết nối không thành công".$conn->connect_errno);
}
// Kiểm tra xem có yêu cầu xóa phòng không
if (isset($_GET['delete_id'])) {
    $room_id = intval($_GET['delete_id']);
    $facility_id = intval($_GET['facility_id']); // Lấy facility_id từ URL để quay lại đúng cơ sở

    // Câu truy vấn xóa phòng
    $delete_sql = "DELETE FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $room_id);

    if ($stmt->execute()) {
        // Nếu xóa thành công, chuyển hướng về trang danh sách phòng
        header("Location: quanlyphong.php?facility_id=" . $facility_id);
        exit();
    } else {
        echo "Lỗi khi xóa phòng: " . $conn->error;
    }
} else {
    // Nếu không có delete_id, quay lại trang danh sách phòng
    header("Location: quanlyphong.php");
    exit();
}
?>