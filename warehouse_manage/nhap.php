<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Link tới file nhap.css -->
    <link rel="stylesheet" href="css/nhap.css">
</head>
<body>
    <!-- Sidebar giống như sanpham.php -->
    <div class="sidebar">
        <h2>Trang chính</h2>
        <ul>
            <li><a href="dashboard.php">Tổng quan</a></li>
            <li><a href="sanpham.php">Quản lý sản phẩm</a></li>
            <li><a href="nhap.php">Nhập kho</a></li>
            <li><a href="xuat.php">Xuất kho</a></li>
            <li><a href="hoadon.php">Hoá Đơn</a></li>
        </ul>
        <a href="logout.php" class="logout-btn">Đăng xuất</a>
    </div>

    <!-- Vùng chứa bảng nhập -->
    <div class="table-container">
        <table class="nhap-table">
            <thead>
                <tr>
                    <th>MaNhap</th>
                    <th>MaSP</th>
                    <th>SoLuong</th>
                    <th>GiaNhap</th>
                    <th>NgayNhap</th>
                    <th>MaNCC</th>
                </tr>
            </thead>
            <tbody id="nhapTableBody">
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $.getJSON("api/nhap.php", function (data) {
                let rows = "";
                data.forEach(nhap => {
                    rows += `<tr>
                        <td>${nhap.MaNhap}</td>
                        <td>${nhap.MaSP}</td>
                        <td>${nhap.SoLuong}</td>
                        <td>${nhap.GiaNhap}</td>
                        <td>${nhap.NgayNhap}</td>
                        <td>${nhap.MaNCC}</td>
                    </tr>`;
                });
                $("#nhapTableBody").html(rows);
            });
        });
    </script>
</body>
</html>
