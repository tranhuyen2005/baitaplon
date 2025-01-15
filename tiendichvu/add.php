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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        button {
            padding: 10px;
            background-color:rgb(76, 96, 175);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color:rgb(76, 96, 175);
        }

        a {
            text-decoration: none;
            color:rgb(76, 96, 175);
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Thêm Dịch Vụ</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Tên dịch vụ" required>
        <input type="number" name="price" placeholder="Giá tiền" required>
        <input type="text" name="unit" placeholder="Đơn vị" required>
        <button type="submit">Thêm</button>
    </form>
</body>
</html>
