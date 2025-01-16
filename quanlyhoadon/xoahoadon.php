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

// Xử lý xóa hóa đơn
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Câu lệnh xóa hóa đơn
    $delete_sql = "DELETE FROM hoadon WHERE id = ?";

    if ($stmt = $conn->prepare($delete_sql)) {
        $stmt->bind_param('i', $delete_id);

        if ($stmt->execute()) {
            echo "<script>alert('Hóa đơn đã được xóa thành công!'); window.location.href='quanlyhoadon.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa hóa đơn.');</script>";
        }

        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị câu lệnh: " . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML để hiển thị danh sách hóa đơn -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Phòng</th>
            <th scope="col">Tiền Phòng</th>
            <th scope="col">Phí Dịch Vụ</th>
            <th scope="col">Tình Trạng</th>
            <th scope="col">Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Truy vấn để lấy danh sách hóa đơn
        $sql = "SELECT * FROM hoadon";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['room_id']) . "</td>";
                echo "<td>" . number_format($row['tien_phong'], 0, ',', '.') . "</td>";
                echo "<td>" . number_format($row['phi_dich_vu'], 0, ',', '.') . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td><a href='?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa hóa đơn này?\");'>Xóa</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có hóa đơn nào</td></tr>";
        }
        ?>
    </tbody>
</table>
