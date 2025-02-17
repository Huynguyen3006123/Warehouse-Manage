<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Trang chính</h2>
        <ul>
            <li><a href="dashboard.php" >Tổng quan </a></li>
            <li><a href="api/sanpham.php" >Quản lý sản phẩm </a></li>
            <li><a href="api/nhap.php" >Nhập kho</a></li>
            <li><a href="api/xuat.php" >Xuất kho</a></li>
            <li><a href="api/hoadon.php" >Hoá Đơn</a></li>
        </ul>
        <a href="logout.php" class="logout-btn">Đăng xuất</a>
    </div>

    <!-- Nội dung chính -->
    <div class="main-content">
        <div class="dashboard-box">Bảng tổng quan</div>
        <div class="dashboard-box">Bảng đơn hàng mới nhất</div>
        <div class="dashboard-box">Biểu đồ nhập xuất kho</div>
        <div class="dashboard-box">Sản phẩm gần hết hàng</div>
    </div>

</body>
</html>
