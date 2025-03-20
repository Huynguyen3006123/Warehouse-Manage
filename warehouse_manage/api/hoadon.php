
<?php
include 'db.php';

$sql = "SELECT * FROM hoadon";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();


?>
<div class="main-content-1">
<div class="table-container">
    <table class="hoadon-table">
      <thead>
        <tr>
          <th>MaDon</th>
          <th>MaKH</th>
          <th>NgayDat</th>
          <th>TrangThai</th>
          <th>ChiTiet</th>
        </tr>
      </thead>
      <tbody id="hoadonTableBody"></tbody>
    </table>
  </div>

  <!-- Script jQuery load dữ liệu -->
  <script>
    $(document).ready(function () {
      $.getJSON("hoadon.php", function (data) {
        let rows = "";
        data.forEach(hoadon => {
          rows += `
            <tr>
              <td>${hoadon.MaDon}</td>
              <td>${hoadon.MaKH}</td>
              <td>${hoadon.NgayDat}</td>
              <td>${hoadon.TrangThai}</td>
              <td>
                  <button class="detailBtn" data-id="${hoadon.MaDon}">Chi Tiết</button>
              </td>
            </tr>
          `;
        });
        $("#hoadonTableBody").html(rows);
      });
      
    // Sự kiện khi nhấn nút "Chi Tiết"
    $(document).on("click", ".detailBtn", function () {
        let maDon = $(this).data("id");
        
        $.ajax({
            url: "api/get_chitietdonhang.php",
            type: "GET",
            data: { MaDon: maDon },
            dataType: "json",
            success: function (data) {
                let modalContent = "";
                data.forEach(item => {
                    modalContent += `<tr>
                        <td>${item.MaChiTiet}</td>
                        <td>${item.MaDon}</td>
                        <td>${item.MaSP}</td>
                        <td>${item.SoLuong}</td>
                        <td>${item.DonGia}</td>
                        <td>${item.ThanhTien}</td>
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
    
    <h2>Chi Tiết Đơn Hàng</h2>
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr>
                <th>Mã Chi Tiết</th>
                <th>Mã Đơn</th>
                <th>Mã SP</th>
                <th>Số Lượng</th>
                <th>Đơn Giá</th>
                <th>Thành Tiền</th>
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
</div>