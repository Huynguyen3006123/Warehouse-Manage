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
          <th>MaXuat</th>
          <th>MaSP</th>
          <th>SoLuong</th>
          <th>GiaXuat</th>
          <th>NgayXuat</th>
          <th>MaKH</th>
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
              <td>${xuat.MaXuat}</td>
              <td>${xuat.MaSP}</td>
              <td>${xuat.SoLuong}</td>
              <td>${xuat.GiaXuat}</td>
              <td>${xuat.NgayXuat}</td>
              <td>${xuat.MaKH}</td>
            </tr>
          `;
        });
        $("#xuatTableBody").html(rows);
      });
    });
  </script>
</body>
</html>
