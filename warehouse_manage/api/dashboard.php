<?php
// Kết nối database nếu cần
include("db.php"); // Nếu có kết nối CSDL

// Query danh sách sản phẩm gần hết hàng
$sql = "SELECT MaSP, TenSP, SoLuongTon FROM sanpham WHERE SoLuongTon <= 5"; // Giả sử tồn kho <= 10 là sắp hết hàng
$result = $conn->query($sql);

$sanpham_list = [];
while ($row = $result->fetch_assoc()) {
    $sanpham_list[] = $row;
}
?>
<script src="js/jquery-3.7.js"></script>
<div class="main-contents">
<div class="main-content-1">
    <!-- Bảng tổng quan -->
    <div class="dashboard-box overview">
        <h3>Bảng tổng quan</h3>
        <p style="margin-top: 10px; font-weight: normal;">Dữ liệu tổng quan sẽ hiển thị ở đây.</p>
    </div>

    <!-- Biểu đồ nhập xuất kho -->
    <div class="dashboard-box chart">
        <h3>Biểu đồ nhập xuất kho</h3>
        <!-- <canvas id="chartNhapXuat"></canvas> -->
    </div>

    <!-- Sản phẩm gần hết hàng -->
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
            <tbody>
                <?php foreach ($sanpham_list as $sanpham) : ?>
                    <tr>
                        <td><?= htmlspecialchars($sanpham["MaSP"]) ?></td>
                        <td><?= htmlspecialchars($sanpham["TenSP"]) ?></td>
                        <td><?= htmlspecialchars($sanpham["SoLuongTon"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<script>
    
</script>