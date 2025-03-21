<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Xuất Table</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Link tới file xuat.css -->
  <link rel="stylesheet" href="css/xuat.css">
</head>
<body>
  <!-- Sidebar (giống như sanpham.php) -->
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

  <!-- Vùng chứa bảng -->
  <div class="table-container">
    <table class="xuat-table">
      <thead>
        <tr>
          <th>MaPX</th>
          <th>MaNV</th>
          <th>NgayXuat</th>
          <th>TrangThai</th>
          <th>ChiTiet</th>
        </tr>
      </thead>
      <tbody id="xuatTableBody"></tbody>
    </table>
  </div>

  <!-- Script jQuery load dữ liệu -->
  <script>
    $(document).ready(function () {
      $.getJSON("api/xuat.php", function (data) {
        let rows = "";
        data.forEach(xuat => {
          rows += `
            <tr>
              <td>${xuat.MaPX}</td>
              <td>${xuat.MaNV}</td>
              <td>${xuat.NgayXuat}</td>
              <td>${xuat.TrangThai}</td>
              <td>
                  <button class="detailBtn" data-id="${xuat.MaPX}">Chi Tiết</button>
              </td>
            </tr>
          `;
        });
        $("#xuatTableBody").html(rows);
      });
      // Sự kiện khi nhấn nút "Chi Tiết"
    $(document).on("click", ".detailBtn", function () {
        let maPX = $(this).data("id");
        
        $.ajax({
            url: "api/get_chitietxuat.php",
            type: "GET",
            data: { MaPX: maPX },
            dataType: "json",
            success: function (data) {
                let modalContent = "";
                data.forEach(item => {
                    modalContent += `<tr>
                        <td>${item.MaPX}</td>
                        <td>${item.MaSP}</td>
                        <td>${item.TenSP}</td>
                        <td>${item.SoLuongXuat}</td>
                        <td>${item.GiaXuat}</td>
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

    $("#closeModal").click(function () {
    $("#detailModal").fadeOut();
    $("#overlay").fadeOut();
});

});

    </script>
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
    
    <h2>Chi Tiết Phiếu Xuất</h2>
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr>
                <th>Mã PX</th>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Số Lượng Xuất</th>
                <th>Giá Xuất</th>
            </tr>
        </thead>
        <tbody id="detailTableBody"></tbody>
    </table>
    <br>
    <button id="closeModal" style="background: red; color: white; padding: 10px; border: none; cursor: pointer;">Đóng</button>
</div>

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
