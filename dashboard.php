<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="js/jquery-3.7.js"></script>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Trang chính</h2>
        <ul>
            <li><a href="dashboard.php" >Tổng quan </a></li>
            <li><a href="sanpham.html" >Quản lý sản phẩm </a></li>
            <li><a href="nhap.html" >Nhập kho</a></li>
            <li><a href="xuat.html" >Xuất kho</a></li>
            <li><a href="hoadon.html" >Hoá Đơn</a></li>
        </ul>
        <a href="logout.php" class="logout-btn">Đăng xuất</a>
    </div>

    <!-- Nội dung chính -->
    <div class="main-content">
        <!-- chỉ cóp phần script với bảng bên trên(nhớ chỉnh sửa thẻ <tbody>)  -->
        <div class="dashboard-box">Bảng tổng quan</div>
        <div class="dashboard-box">Biểu đồ nhập xuất kho</div>
        <div class="dashboard-box">Sản phẩm gần hết hàng
        <table>
            <thead>
                    
                    <th>TenSP</th>
                    <th>SoLuong</th>
                    <th>DVT</th>
                    <th>MaNCC</th>
                </tr>
            </thead>
            <tbody id="sanphamTableBody">
            </tbody>
        </table>
        </div>
    </div>

</body>
    <script>
        $(document).ready(function () {
            $.getJSON("api/hethang.php", function (data) {
                let rows = "";
                data.forEach(sanpham => {
                    rows += `<tr>
                        <td>${sanpham.TenSP}</td>
                        <td>${sanpham.SoLuong}</td>
                        <td>${sanpham.DVT}</td>
                        <td>${sanpham.MaNCC}</td>
                    </tr>`;
                });
                $("#sanphamTableBody").html(rows);
            });
        });
    </script>
</html>
