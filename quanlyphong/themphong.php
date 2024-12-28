<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý khi form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $facility_id = $_POST['facility_id'];
    $room_name = $_POST['room_name'];
    $address = $_POST['address'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $owner_name = $_POST['owner_name'];
    $tenant_name = $_POST['tenant_name'];

    // Chèn phòng vào bảng rooms
    $sql = "INSERT INTO rooms (facility_id, room_name, price, status, tenant_name, address, owner_name)
            VALUES ('$facility_id', '$room_name', '$price', '$status', '$tenant_name', '$address', '$owner_name')";

    if ($conn->query($sql) === TRUE) {
        // Lấy ID của phòng vừa chèn vào
        $room_id = $conn->insert_id;
        echo "Thêm phòng thành công<br>";

        // Xử lý upload ảnh phòng
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["room_image"]["name"]);
        $image_upload_ok = 1;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra nếu file là ảnh thực sự
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["room_image"]["tmp_name"]);
            if ($check !== false) {
                $image_upload_ok = 1;
            } else {
                echo "File không phải là ảnh.";
                $image_upload_ok = 0;
            }
        }

        // Kiểm tra kích thước file
        if ($_FILES["room_image"]["size"] > 500000) {
            echo "Xin lỗi, file của bạn quá lớn.";
            $image_upload_ok = 0;
        }

        // Cho phép các định dạng ảnh nhất định
        if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
            echo "Xin lỗi, chỉ cho phép các file JPG, JPEG, PNG và GIF.";
            $image_upload_ok = 0;
        }

        // Kiểm tra nếu có lỗi trong quá trình upload ảnh
        if ($image_upload_ok == 0) {
            echo "Xin lỗi, file của bạn không được tải lên.";
        } else {
            if (move_uploaded_file($_FILES["room_image"]["tmp_name"], $target_file)) {
                echo "File " . basename($_FILES["room_image"]["name"]) . " đã được tải lên.";

                // Chèn thông tin ảnh vào bảng images
                $image_path = $target_file; // Đường dẫn ảnh đã tải lên
                $sql_image = "INSERT INTO images (room_id, image_path) VALUES ('$room_id', '$image_path')";

                if ($conn->query($sql_image) === TRUE) {
                    echo "Ảnh phòng đã được lưu vào cơ sở dữ liệu.";
                    header("location:quanlyphong.php");
                } else {
                    echo "Lỗi khi thêm ảnh vào cơ sở dữ liệu: " . $conn->error;
                }
            } else {
                echo "Xin lỗi, có lỗi khi tải lên file của bạn.";
            }
        }
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Phòng</title>
    <link href="/baiTapLon/quanlyphong/themphong.css" rel="stylesheet">
</head>
<body>

<h2>THÊM PHÒNG MỚI</h2>

<form action="themphong.php" method="POST" enctype="multipart/form-data">
    <label for="facility_id">Cơ sở:</label>
    <select name="facility_id" required>
        <?php
        // Lấy danh sách các cơ sở từ cơ sở dữ liệu
        $conn = new mysqli($servername, $username, $password, $dbname);
        $result = $conn->query("SELECT id, name FROM facilities");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select>
    <br><br>

    <label for="room_name">Tên Phòng:</label>
    <input type="text" name="room_name" required>
    <br><br>

    <label for="address">Địa chỉ:</label>
    <input type="text" name="address" required>
    <br><br>

    <label for="price">Giá Phòng:</label>
    <input type="number" name="price" required>
    <br><br>

    <label for="status">Trạng Thái Phòng:</label>
    <select name="status" required>
        <option value="empty">Trống</option>
        <option value="rented">Đã thuê</option>
    </select>
    <br><br>

    <label for="tenant_name">Khách Thuê:</label>
    <input type="text" name="tenant_name">
    <br><br>

    <label for="owner_name">Chủ Sở Hữu:</label>
    <input type="text" name="owner_name" required>
    <br><br>

    <label for="room_image">Ảnh Phòng:</label>
    <input type="file" name="room_image" accept="image/*" required>
    <br><br>

    <input type="submit" name="submit" value="Thêm Phòng">
</form>

</body>
</html>
