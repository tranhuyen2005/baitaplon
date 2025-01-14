
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhà Trọ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eaf2f8;
            color: #2c3e50;
            display: flex; /* nằm ngang */
            flex-direction: column;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #34495e;
            color: #ecf0f1;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            padding: 15px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transform: translateX(-250px);
            transition: transform 0.3s ease;
        }

        .sidebar.visible {
            transform: translateX(0);
        }

        .menu-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            cursor: pointer;
            color: #ecf0f1;
            background: #2980b9;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            z-index: 1000;
            font-size: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .menu-toggle:hover {
            background-color: #3498db;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            background-color: #2c3e50;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #fff;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            padding: 15px 20px;
            border-bottom: 1px solid #3b4b5a;
            transition: background-color 0.3s, padding-left 0.3s;
        }

        .sidebar ul li:hover {
            background-color: #5dade2;
            color: #fff;
            padding-left: 25px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: inherit;
            display: block;
            font-size: 16px;
        }

        .header {
            background-color: #2980b9;
            color: #ecf0f1;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: margin-left 0.3s ease;
        }

        .header h1 {
            font-size: 26px;
        }

        .header .admin-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header .admin-info span {
            font-size: 18px;
        }

        .header .logout-btn {
            padding: 10px 20px;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .header .logout-btn:hover {
            background-color: #c0392b;
        }

        .content {
            flex: 1;
            padding: 30px;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .facility {
            margin-bottom: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .facility img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: transform 0.3s;
        }

        .facility img:hover {
            transform: scale(1.05);
        }

        .facility h3 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #34495e;
        }

        .facility p {
            margin-bottom: 5px;
            font-size: 14px;
            color: #7f8c8d;
        }

        .footer {
            padding: 20px;
            background-color: #2c3e50;
            color: #ecf0f1;
            font-size: 14px;
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }

        .footer p {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.visible {
                transform: translateX(0);
            }

            .header, .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle">☰</button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">Quản Lý Nhà Trọ</div>
        <ul>
            <li><a href="#">Trang chủ</a></li>
            <li><a href="#">Quản lí phòng</a></li>
            <li><a href="#">Quản lí khách thuê</a></li>
            <li><a href="#">Quản lí hóa đơn</a></li>
            <li><a href="#">Tiền dịch vụ</a></li>
            <li><a href="#">Báo cáo sự cố</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h1>Quản Lý Nhà Trọ</h1>
            <div class="admin-info">
                <span>Xin chào, Admin</span>
                <button class="logout-btn">Đăng xuất</button>
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

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
            if (sidebar.classList.contains('visible')) {
                content.style.marginLeft = '250px';
            } else {
                content.style.marginLeft = '0';
            }
        });
    </script>
</body>
</html>
