<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hoá Đơn Table</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Link tới file hoadon.css -->
  <link rel="stylesheet" href="css/hoadon.css">
</head>
<body>
  <!-- Sidebar (giống như các trang khác) -->
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
    <table class="hoadon-table">
      <thead>
        <tr>
          <th>MaDon</th>
          <th>MaKH</th>
          <th>NgayDat</th>
          <th>MaSP</th>
          <th>SoLuong</th>
          <th>DonGia</th>
          <th>ThanhTien</th>
          <th>TrangThai</th>
          <th>GhiChu</th>
        </tr>
      </thead>
      <tbody id="hoadonTableBody"></tbody>
    </table>
  </div>

  <!-- Script jQuery load dữ liệu -->
  <script>
    $(document).ready(function () {
      $.getJSON("api/hoadon.php", function (data) {
        let rows = "";
        data.forEach(hoadon => {
          rows += `
            <tr>
              <td>${hoadon.MaDon}</td>
              <td>${hoadon.MaKH}</td>
              <td>${hoadon.NgayDat}</td>
              <td>${hoadon.MaSP}</td>
              <td>${hoadon.SoLuong}</td>
              <td>${hoadon.DonGia}</td>
              <td>${hoadon.ThanhTien}</td>
              <td>${hoadon.TrangThai}</td>
              <td>${hoadon.GhiChu}</td>
            </tr>
          `;
        });
        $("#hoadonTableBody").html(rows);
      });
    });
  </script>
</body>
</html>
