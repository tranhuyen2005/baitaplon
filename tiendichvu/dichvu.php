<?php
require 'db.php';

// Lấy dữ liệu từ bảng `services`
$query = $conn->query("SELECT * FROM tiendichvu ");
$fees = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Phí Dịch Vụ</title>
    <link rel="stylesheet" href="dichvu.css">
</head>
<body>
    <div class="container">
        <h2>Tiền Dịch Vụ</h2>
        
        <!-- Bảng danh sách phí dịch vụ -->
        <table>
            <thead>
                <tr>
                    <th>Tên dịch vụ</th>
                    <th>Giá tiền</th>
                    <th>Đơn vị</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees as $fee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fee['name']); ?></td>
                        <td><?php echo number_format($fee['price'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo htmlspecialchars($fee['unit']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $fee['id']; ?>">Sửa</a> | 
                            <a href="delete.php?id=<?php echo $fee['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Liên kết đến trang thêm dịch vụ -->
        <a href="add.php">Thêm Dịch Vụ </a>
    </div>
</body>
</html>
