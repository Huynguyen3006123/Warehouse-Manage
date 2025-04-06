<?php
header("Content-Type: application/json; charset=UTF-8");
include ('db.php');

$sql = "SELECT MaSP, TenSP, LoaiSP, KichCo, MauSac, GiaNhap, GiaXuat, SoLuongTon, NgayNhap FROM sanpham"; 
$result = $conn->query($sql);

// Hiển thị dữ liệu dưới dạng bảng HTML


// Kiểm tra dữ liệu có tồn tại không
echo '<div class="table-container">';
    echo "<table border='1' class='product-table'>
            <tr>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Loại SP</th>
                <th>Màu sắc</th>
                <th>Giá nhập</th>
                <th>Giá xuất</th>
                <th>Số lượng tồn</th>
                <th>Nhập Lần đầu</th>
                <th>Hành động</th>
            </tr>";
    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['MaSP']}</td>
                <td>{$row['TenSP']}</td>
                <td>{$row['LoaiSP']}</td>
                <td>{$row['MauSac']}</td>
                <td>{$row['GiaNhap']}</td>
                <td>{$row['GiaXuat']}</td>
                <td>{$row['SoLuongTon']}</td>
                <td>{$row['NgayNhap']}</td>
                <td></td>
              </tr>";
    } echo "</table>";}

$conn->close();
?>



<!-- Vùng hiển thị bảng -->


<!-- Modal for adding product -->
 
<!-- Nút thêm sản phẩm -->
<script src="js/jquery-3.7.js"></script>
<!-- <script src="js/script.js"></script> -->
<button id="addProductBtn">Thêm Sản Phẩm</button>
<!-- Modal thêm sản phẩm -->
<div id="addProductModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="addProductForm">
            <input type="text" name="MaSP" placeholder="Mã SP" required>
            <input type="text" name="TenSP" placeholder="Tên SP" required>
            <input type="text" name="LoaiSP" placeholder="Loại Sản Phẩm" required>
            <input type="text" name="MauSac" placeholder="Màu Sắc" required>
            <input type="number" step="0.01" name="GiaNhap" placeholder="Giá Nhập" required>
            <input type="number" step="0.01" name="GiaXuat" placeholder="Giá Xuất" required>
            <button type="submit">Thêm Sản Phẩm</button>
        </form>
    </div>
</div>
</div>
<script>
$(document).ready(function () {
    // Hiển thị modal khi nhấn nút Thêm Sản Phẩm
    $("#addProductBtn").click(function () {
        console.log("✅ Nút Thêm Sản Phẩm đã được click!");
        $("#addProductModal").fadeIn();
    });

    // Đóng modal khi nhấn vào nút đóng
    $(".close").click(function () {
        $("#addProductModal").fadeOut();
    });

    // Đóng modal khi nhấn ra ngoài modal
    $(window).click(function (event) {
        if ($(event.target).is("#addProductModal")) {
            $("#addProductModal").fadeOut();
        }
    });

    // Xử lý gửi form bằng AJAX
    $("#addProductForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "api/addSP.php",
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $("#addProductModal").fadeOut();
                location.reload(); // Tải lại trang để cập nhật sản phẩm mới
            },
            error: function () {
                alert("Lỗi khi thêm sản phẩm!");
            }
        });
    });
});
</script>





