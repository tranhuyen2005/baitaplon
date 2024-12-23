<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baiTapLon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách khách thuê
$facility_id = isset($_GET['facility_id']) ? $_GET['facility_id'] : null;
$search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';  // Tìm kiếm theo tên hoặc địa chỉ
$search_status = isset($_GET['search_status']) ? $_GET['search_status'] : '';  // Tình trạng khách thuê

// Điều kiện tìm kiếm
$where_clause = "";
if ($facility_id) {
    $where_clause = "WHERE rooms.facility_id = $facility_id";
}

if ($search_keyword) {
    $search_keyword = $conn->real_escape_string($search_keyword);  // An toàn SQL
    if ($where_clause) {
        $where_clause .= " AND (tenants.owner_name LIKE '%$search_keyword%' OR tenants.address LIKE '%$search_keyword%')";
    } else {
        $where_clause = "WHERE (tenants.owner_name LIKE '%$search_keyword%' OR tenants.address LIKE '%$search_keyword%')";
    }
}

if ($search_status) {
    if ($where_clause) {
        $where_clause .= " AND tenants.status = '$search_status'";
    } else {
        $where_clause = "WHERE tenants.status = '$search_status'";
    }
}

// Lấy dữ liệu khách thuê với điều kiện tìm kiếm
$sql_tenants = "SELECT tenants.*, rooms.room_name FROM tenants INNER JOIN rooms ON tenants.room_id = rooms.id $where_clause";
$result_tenants = $conn->query($sql_tenants);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Khách Thuê</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="quanlyphong.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Quản Lý Khách Thuê</h1>

        <div class="d-flex justify-content-between align-items-center my-3">
            <div class="d-flex w-100">
                <input type="text" class="form-control w-75 me-2" placeholder="Tìm phòng theo tên hoặc địa chỉ" id="search-keyword" name="search_keyword">
                <select class="form-select w-auto me-2" id="search-status" name="search_status">
                    <option value="">Tình trạng phòng</option>
                    <option value="empty">Còn trống</option>
                    <option value="rented">Đã cho thuê</option>
                </select>
                <button class="btn btn-primary" id="search-btn">Tìm kiếm</button>
            </div>
            <div>
                <button class="btn btn-success" id="add-room-btn">Thêm phòng</button>
            </div>
        </div>

        <!-- Ô vuông bao quát cơ sở 1 và cơ sở 2 -->
        <div class="facility-box">
            <div class="facility-header">
                <a href="?facility_id=1" class="btn btn-outline-primary">Cơ Sở 1 (Hà Nội)</a>
                <a href="?facility_id=2" class="btn btn-outline-primary">Cơ Sở 2 (TP.HCM)</a>
            </div>

            <!-- Danh sách phòng của cơ sở được chọn -->
            <?php if ($facility_id && $result_tenants && $result_tenants->num_rows > 0): ?>
                <div class="row mt-4">
                    <?php $counter = 0; ?>
                    <?php while ($room = $result_tenants->fetch_assoc()): ?>
                        <?php
                            // Kiểm tra trạng thái phòng để thêm lớp CSS thích hợp
                            $room_class = ($room['status'] == 'rented') ? 'text-primary' : 'text-success';
                        ?>
                        <?php if ($counter == 3): ?>
                            </div><div class="row"> <!-- Bắt đầu hàng mới sau 3 phòng -->
                            <?php $counter = 0; ?>
                        <?php endif; ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $room['room_name']; ?></h5>
                                    <p class="card-text <?php echo $room_class; ?>">
                                        <?php echo $room['status'] == 'empty' ? 'Còn trống' : 'Đã cho thuê'; ?>
                                    </p>
                                    <p class="card-text">
                                        <strong>Chủ sở hữu:</strong> 
                                        <?php echo $room['status'] == 'empty' ? 'Không có' : $room['owner_name']; ?>
                                    </p>
                                    <p class="card-text"><strong>Địa chỉ:</strong> <?php echo $room['address']; ?></p>
                                       <div class="btn-group">
                                        <button class="btn btn-sm btn-primary">Xem</button>
                                        <button class="btn btn-sm btn-warning">Sửa</button>
                                        <button class="btn btn-sm btn-danger">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                    <?php endwhile; ?>
                </div>
            <?php elseif ($facility_id): ?>
                <p class="text-center mt-4">Không có phòng nào trong cơ sở này.</p>
            <?php else: ?>
                <p class="text-center mt-4">Vui lòng chọn cơ sở để xem phòng.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
