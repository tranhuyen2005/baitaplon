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
    <link rel="stylesheet" href="/baiTapLon/tiendichvu/dichvu.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Tiền Dịch Vụ</h2>
        
        <!-- Bảng danh sách phí dịch vụ -->
        <table>
            <thead>
                <tr>
                <th><i class="fas fa-cogs"></i> Tên dịch vụ</th>
                    <th><i class="fas fa-tag"></i> Giá tiền</th>
                    <th><i class="fas fa-ruler"></i> Đơn vị</th>
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
                        <button class="btn-edit" onclick="window.location.href='edit.php?id=<?php echo $fee['id']; ?>'">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <button class="btn-delete" onclick="if (confirm('Bạn có chắc chắn muốn xóa?')) window.location.href='delete.php?id=<?php echo $fee['id']; ?>'">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Liên kết đến trang thêm dịch vụ -->
        <button class="btn-add" onclick="window.location.href='add.php'">
            <i class="fas fa-plus-circle"></i> Thêm Dịch Vụ
        </button>
    </div>
</body>
</html>
