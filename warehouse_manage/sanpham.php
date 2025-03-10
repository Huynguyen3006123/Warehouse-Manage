<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Link tới file product.css mới -->
    <link rel="stylesheet" href="css/product.css">
</head>
<body>

    <!-- Sidebar (giống dashboard) -->
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

    <!-- Vùng hiển thị bảng -->
    <div class="table-container">
        <table class="product-table">
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên SP</th>
                    <th>Mã Danh Mục</th>
                    <th>ĐVT</th>
                    <th>Số Lượng</th>
                    <th>Giá Nhập</th>
                    <th>Giá Bán Lẻ</th>
                    <th>Giá Bán Sỉ</th>
                    <th>Mô Tả</th>
                    <th>Mã NCC</th>
                </tr>
            </thead>
            <tbody id="sanphamTableBody"></tbody>
        </table>
    </div>

    <!-- Script jQuery -->
    <script>
        $(document).ready(function () {
            $.getJSON("api/sanpham.php", function (data) {
                let rows = "";
                data.forEach(sanpham => {
                    rows += `
                        <tr>
                            <td>${sanpham.MaSP}</td>
                            <td>${sanpham.TenSP}</td>
                            <td>${sanpham.MaDanhMuc}</td>
                            <td>${sanpham.DVT}</td>
                            <td>${sanpham.SoLuong}</td>
                            <td>${sanpham.GiaNhap}</td>
                            <td>${sanpham.GiaBanLe}</td>
                            <td>${sanpham.GiaBanSi}</td>
                            <td>${sanpham.MoTa}</td>
                            <td>${sanpham.MaNCC}</td>
                        </tr>
                    `;
                });
                $("#sanphamTableBody").html(rows);
            });
        });
    </script>
</body>
</html>
