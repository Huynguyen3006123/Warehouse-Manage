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
                    <th>Mã Phiếu Nhập</th>
                    <th>Mã NCC</th>
                    <th>Ngày Nhập</th>
                    <th>Mã Nhân Viên</th>
                    <th>Trạng Thái</th>
                    <th>Chi Tiết</th>
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
                <td>${nhap.MaPN}</td>
                <td>${nhap.MaNCC}</td>
                <td>${nhap.NgayNhap}</td>
                <td>${nhap.MaNV}</td>
                <td>${nhap.TrangThai}</td>
                <td>
                    <button class="detailBtn" data-id="${nhap.MaPN}">Chi Tiết</button>
                </td>
            </tr>`;
        });
        $("#nhapTableBody").html(rows);
    });

    // Sự kiện khi nhấn nút "Chi Tiết"
    $(document).on("click", ".detailBtn", function () {
        let maPN = $(this).data("id");
        
        $.ajax({
            url: "api/get_chitietnhap.php",
            type: "GET",
            data: { MaPN: maPN },
            dataType: "json",
            success: function (data) {
                let modalContent = "";
                data.forEach(item => {
                    modalContent += `<tr>
                        <td>${item.MaPN}</td>
                        <td>${item.MaSP}</td>
                        <td>${item.TenSP}</td>
                        <td>${item.SoLuongNhap}</td>
                        <td>${item.GiaNhap}</td>
                    </tr>`;
                });

                $("#detailTableBody").html(modalContent);
                $("#detailModal").fadeIn();
            },
            error: function () {
                alert("Không thể lấy dữ liệu!");
            }
        });
    });

    // Đóng popup
    $("#closeModal").click(function () {
        $("#detailModal").fadeOut();
    });
});

    </script>
<!-- Modal hiển thị chi tiết phiếu nhập -->
<div id="detailModal" style="
    display: none; 
    position: fixed; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%);
    background: white; 
    padding: 20px; 
    border-radius: 8px; 
    box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
    z-index: 1000;">
    
    <h2>Chi Tiết Phiếu Nhập</h2>
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr>
                <th>Mã PN</th>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Số Lượng Nhập</th>
                <th>Giá Nhập</th>
            </tr>
        </thead>
        <tbody id="detailTableBody"></tbody>
    </table>
    <br>
    <button id="closeModal" style="background: red; color: white; padding: 10px; border: none; cursor: pointer;">Đóng</button>
</div>

<!-- Lớp nền tối để khi mở modal nhìn đẹp hơn -->
<div id="overlay" style="
    display: none; 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;"></div>

</body>
</html>
