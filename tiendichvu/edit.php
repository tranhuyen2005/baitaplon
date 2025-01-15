<?php
// Kết nối với cơ sở dữ liệu sử dụng MySQLi
$conn = new mysqli('localhost', 'root', '', 'baiTapLon');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID của dịch vụ cần sửa từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra ID hợp lệ
if ($id <= 0) {
    die("ID dịch vụ không hợp lệ.");
}

// Truy vấn lấy thông tin dịch vụ từ bảng
$sql = "SELECT * FROM tiendichvu WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu không tìm thấy dịch vụ
if ($result->num_rows === 0) {
    die("Không tìm thấy dịch vụ với ID: $id.");
}

// Lấy dữ liệu dịch vụ
$service = $result->fetch_assoc();

// Xử lý khi người dùng gửi form cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $unit = $_POST['unit'] ?? '';

    // Kiểm tra dữ liệu hợp lệ
    if (empty($name) || empty($unit) || $price <= 0) {
        $error = "Vui lòng nhập đầy đủ thông tin và đảm bảo giá tiền lớn hơn 0.";
    } else {
        // Cập nhật thông tin dịch vụ
        $update_sql = "UPDATE tiendichvu SET name = ?, price = ?, unit = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sdsi", $name, $price, $unit, $id);
        $update_stmt->execute();

        // Chuyển hướng về trang danh sách
        header("Location: dichvu.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Dịch Vụ</title>
    <link rel="stylesheet" href="dichvu.css">
    <link rel="stylesheet" href="/baiTapLon/tiendichvu/edit.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Sửa Dịch Vụ</h2>

        <!-- Hiển thị lỗi nếu có -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Form sửa dịch vụ -->
        <form method="POST">
        <div class="input-group">
                <i class="fas fa-cogs"></i>
                <label for="name">Tên Dịch Vụ:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($service['name']); ?>" required>
            </div>

            <div class="input-group">
                <i class="fas fa-dollar-sign"></i>
                <label for="price">Giá Tiền:</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($service['price']); ?>" min="0" required>
            </div>

            <div class="input-group">
                <i class="fas fa-weight"></i>
                <label for="unit">Đơn Vị:</label>
                <input type="text" id="unit" name="unit" value="<?php echo htmlspecialchars($service['unit']); ?>" required>
            </div>

            <button type="submit">Lưu</button>
            <button type="button" onclick="window.location.href='dichvu.php'">Hủy</button>
        </form>
    </div>
</body>
</html>
