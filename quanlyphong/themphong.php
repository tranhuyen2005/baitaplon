<?php
$conn = mysqli_connect("localhost","root","","baiTapLon");
if($conn ->connect_errno){
    die("Kết nối thất bại".$conn->connect_errno);
}
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $facility_id = $_POST['facility_id'];
    $room_name = $_POST['room_name'];
    $price = $_POST['price'];
    $address = $_POST['address'];
    $so_nguoi_o = $_POST['so_nguoi_o'];
    $status = 'Còn trống'; // Trạng thái phòng mặc định


    // Chèn dữ liệu vào bảng rooms
    $sql = "INSERT INTO rooms (facility_id, room_name, price, status, address, so_nguoi_o)
            VALUES ('$facility_id', '$room_name', '$price', '$status', '$address', '$so_nguoi_o')";
    
    if ($conn->query($sql) === TRUE) {
        // Lấy id của phòng vừa chèn
        $room_id = $conn->insert_id;
        
        // Xử lý tải ảnh
        if (isset($_FILES['room_image']) && $_FILES['room_image']['error'] == 0) {
            $image_path = 'img/' . basename($_FILES['room_image']['name']);
            move_uploaded_file($_FILES['room_image']['tmp_name'], $image_path);
            
            // Chèn dữ liệu ảnh vào bảng images
            $sql_image = "INSERT INTO images (room_id, image_path) VALUES ('$room_id', '$image_path')";
            if ($conn->query($sql_image) === TRUE) {
                echo "Phòng và ảnh đã được tải lên thành công!";
                header("Location: quanlyphong.php?facility_id=" . $facility_id);
                exit();
            } else {
                echo "Lỗi: " . $sql_image . "<br>" . $conn->error;
            }
        } else {
            echo "Lỗi khi tải ảnh.";
        }
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Phòng</title>
    <link rel="stylesheet" href="/baiTapLon/quanlyphong/themphong.css">
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('image_preview');
                output.src = reader.result;
                output.style.display = 'block'; // Hiển thị ảnh preview
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>
<body>
<span class="close-btn" onclick="closeModal()">X</span>
    <h1>Thêm Phòng Mới</h1>
    
    <form action="themphong.php" method="POST" enctype="multipart/form-data">
        <label for="facility_id">Chọn Cơ Sở:</label>
        <select id="facility_id" name="facility_id" required>
            <?php
            // Lấy danh sách các cơ sở từ bảng facilities
            $sql_facilities = "SELECT * FROM facilities";
            $result = $conn->query($sql_facilities);
            
            if ($result->num_rows > 0) {
                // Hiển thị các cơ sở trong dropdown
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
            }
            ?>
        </select><br><br>
        
        <label for="room_name">Tên Phòng:</label>
        <input type="text" id="room_name" name="room_name" required><br><br>
        
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" required><br><br>
        
        <label for="address">Địa Chỉ:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="so_nguoi_o">Số Người Ở:</label>
        <input type="number" id="so_nguoi_o" name="so_nguoi_o" required><br><br>
        
        <label for="room_image">Ảnh Phòng:</label>
        <input type="file" id="room_image" name="room_image" accept="image/*" onchange="previewImage(event)" required><br><br>

        <!--Vùng hiển thị ảnh preview -->
        <img id="image_preview" src="" alt="Ảnh phòng" style="display: none; width: 200px; height: auto;"/><br>

        <button type="submit">Thêm Phòng</button>
    </form>
</body>
</html>
