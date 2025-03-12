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
            <li><a href="dashboard.php">Tổng quan</a></li>
            <li><a href="sanpham.php">Quản lý sản phẩm</a></li>
            <li><a href="nhap.php">Nhập kho</a></li>
            <li><a href="xuat.php">Xuất kho</a></li>
            <li><a href="hoadon.php">Hoá Đơn</a></li>
        </ul>
        <a href="logout.php" class="logout-btn">Đăng xuất</a>
    </div>

    <!-- Nội dung chính -->
    <div class="main-content">
        
        <!-- Bảng tổng quan (trái, chiếm 2 hàng) -->
        <div class="dashboard-box overview">
            <!-- Đưa tiêu đề vào thẻ h3 để nằm trên cùng -->
            <h3>Bảng tổng quan</h3>
            <!-- Nếu có nội dung chi tiết, thêm vào đây -->
            <p style="margin-top: 10px; font-weight: normal;">

            </p>
        </div>

        <!-- Biểu đồ nhập xuất kho (phía trên bên phải) -->
        <div class="dashboard-box chart">
            <h3>Biểu đồ nhập xuất kho</h3>
            <!-- Nội dung biểu đồ nếu có -->
            <p style="margin-top: 10px; font-weight: normal;">
            </p>
        </div>

        <!-- Sản phẩm gần hết hàng (phía dưới bên phải) -->
        <div class="dashboard-box low-stock">
            <h3>Sản phẩm gần hết hàng</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mã Sản Phẩm</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng Tồn</th>
                    </tr>
                </thead>
                <tbody id="sanphamTableBody">
                    <!-- Dữ liệu sẽ được load bằng jQuery -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script jQuery load dữ liệu -->
    <script>
        $(document).ready(function () {
            $.getJSON("api/hethang.php", function (data) {
                let rows = "";
                data.forEach(sanpham => {
                    rows += `
                        <tr>
                            <td>${sanpham.MaSP}</td>
                            <td>${sanpham.TenSP}</td>
                            <td>${sanpham.SoLuongTon}</td>
                        </tr>
                    `;
                });
                $("#sanphamTableBody").html(rows);
            }).fail(function() {
                $("#sanphamTableBody").html("<tr><td colspan='4'>Không thể tải dữ liệu</td></tr>");
            });
        });
    </script>

</body>
</html>
