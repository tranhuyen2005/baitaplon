<?php
// Dữ liệu về các loại phí dịch vụ
$fees = [
    ['name' => 'Phí điện', 'price' => 3500, 'unit' => 'VND/1kWh'],
    ['name' => 'Phí nước', 'price' => 30000, 'unit' => 'VND/khối'],
    ['name' => 'Phí mạng', 'price' => 100000, 'unit' => 'VND/phòng'],
    ['name' => 'Phí rác', 'price' => 20000, 'unit' => 'VND/người'],
    ['name' => 'Phí máy giặt', 'price' => 50000, 'unit' => 'VND/người'],
    ['name' => 'Phí thang máy', 'price' => 50000, 'unit' => 'VND/người'],
    ['name' => 'Phí gửi xe', 'price' => 20000, 'unit' => 'VND/xe/tháng'],
    ['name' => 'Phí bảo vệ', 'price' => 30000, 'unit' => 'VND/tháng'],
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BẢNG PHÍ DỊCH VỤ</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <h2>BẢNG PHÍ DỊCH VỤ</h2>
        <table>
            <thead>
                <tr>
                    <th>Tên dịch vụ</th>
                    <th>Giá tiền</th>
                    <th>Đơn vị</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees as $fee): ?>
                    <tr>
                        <td><?php echo $fee['name']; ?></td>
                        <td><?php echo number_format($fee['price'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo $fee['unit']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
