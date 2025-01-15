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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        button {
            padding: 12px;
            font-size: 16px;
            background-color:rgb(76, 96, 175);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color:rgb(76, 96, 175);
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
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
    <div class="container">
        <h2>Sửa Dịch Vụ</h2>

        <!-- Hiển thị lỗi nếu có -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Form sửa dịch vụ -->
        <form method="POST">
            <label for="name">Tên Dịch Vụ:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($service['name']); ?>" required>

            <label for="price">Giá Tiền:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($service['price']); ?>" min="0" required>

            <label for="unit">Đơn Vị:</label>
            <input type="text" id="unit" name="unit" value="<?php echo htmlspecialchars($service['unit']); ?>" required>

            <button type="submit">Lưu</button>
            <a href="dichvu.php">Hủy</a>
        </form>
    </div>
</body>
</html>
