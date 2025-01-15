
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhà Trọ</title>
    <link rel="stylesheet" href="trangchu.css">
</head>
<body>
    <button class="menu-toggle" id="menuToggle">☰</button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">Quản Lý Nhà Trọ</div>
        <ul>
            <li><a href="trangchu.php">Trang chủ</a></li>
            <li><a href="http://localhost/baiTapLon/quanlyphong/quanlyphong.php">Quản lí phòng</a></li>
            <li><a href="http://localhost/baiTapLon/quanlyhoadon/quanlyhoadon.php">Quản lí hóa đơn</a></li>
            <li><a href="http://localhost/baiTapLon/tiendichvu/dichvu.php">Tiền dịch vụ</a></li>
            <li><a href="http://localhost/baiTapLon/quanlysuco/quanlysuco.php">Báo cáo sự cố</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h1>Quản Lý Nhà Trọ</h1>
            <div class="admin-info">
            <button class="logout-btn" id="logoutButton">Đăng xuất</button>
            </div>
        </div>

        <div class="facility">
            <img src="/trangchu/coso1.png" alt="Cơ sở 1">
            <h3>Cơ Sở 1</h3>
            <p><strong>Địa chỉ:</strong> 123 Đường A, Thành phố X</p>
            <p><strong>Thông tin:</strong> Có 20 phòng, tiện nghi hiện đại.</p>
        </div>

        <div class="facility">
            <img src="/trangchu/coso2.png" alt="Cơ sở 2">
            <h3>Cơ Sở 2</h3>
            <p><strong>Địa chỉ:</strong> 456 Đường B, Thành phố Y</p>
            <p><strong>Thông tin:</strong> Có 15 phòng, đầy đủ dịch vụ.</p>
        </div>
    </div>

    <div class="footer">
        <p><strong>Liên hệ chủ nhà:</strong></p>
        <p><strong>Điện thoại:</strong> 0123 456 789</p>
        <p><strong>Email:</strong> chu_nha@gmail.com</p>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const content = document.querySelector('.content');
        const logoutButton = document.getElementById('logoutButton');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
            if (sidebar.classList.contains('visible')) {
                content.style.marginLeft = '250px';
            } else {
                content.style.marginLeft = '0';
            }
        });

        logoutButton.addEventListener('click', () => {
            // Chuyển hướng về trang đăng nhập
            window.location.href = '/baiTapLon/dangnhap/dangnhap.php';
        });
    </script>
</body>
</html>
