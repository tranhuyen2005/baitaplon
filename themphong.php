<?php 
$conn = mysqli_connect("localhost","root","","baiTapLon");
if($conn->connect_error){
    die("Kết nối thất bại".$conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phòng</title>
</head>
<body>
    <form>
        <label>Tên phòng:</label>
        <input type="text" name="tenphong" placeholder="Điền tên phòng" readonly><br>
        <label>Tình trạng phòng</label>
        <input type="radio" name="tinhtrang">
        <label>Giá tiền</label>
        <label>Nội thất</label>

    </form>
</body>
</html>