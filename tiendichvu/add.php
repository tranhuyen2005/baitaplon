<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];

    // Thêm dữ liệu vào bảng
    $stmt = $conn->prepare("INSERT INTO tiendichvu (name, price, unit) VALUES (?, ?, ?)");
    $stmt->execute([$name, $price, $unit]);

    // Quay về trang chính
    header("Location: dichvu.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Dịch Vụ</title>
    <link rel="stylesheet" href="/baiTapLon/tiendichvu/add.css">
    <!-- Add Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <form method="POST">
            <h2>Thêm Dịch Vụ</h2>
            
            <!-- Tên dịch vụ input -->
            <div class="input-group">
                <i class="fas fa-cogs"></i> <!-- Service icon -->
                <input type="text" name="name" placeholder="Tên dịch vụ" required>
            </div>
            
            <!-- Giá tiền input -->
            <div class="input-group">
                <i class="fas fa-dollar-sign"></i> <!-- Dollar sign icon -->
                <input type="number" name="price" placeholder="Giá tiền" required>
            </div>
            
            <!-- Đơn vị input -->
            <div class="input-group">
                <i class="fas fa-weight-hanging"></i> <!-- Unit icon -->
                <input type="text" name="unit" placeholder="Đơn vị" required>
            </div>

            <!-- Submit button -->
            <button type="submit">
                <i class="fas fa-plus-circle"></i> Thêm <!-- Plus circle icon -->
            </button>
        </form>
    </div>
</body>

</html>
