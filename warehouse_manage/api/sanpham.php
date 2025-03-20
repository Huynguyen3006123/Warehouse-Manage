<?php
header("Content-Type: application/json; charset=UTF-8");
include ('db.php');

$sql = "SELECT MaSP, TenSP, LoaiSP, KichCo, MauSac, GiaNhap, GiaXuat, SoLuongTon, NgayNhap FROM sanpham"; 
$result = $conn->query($sql);

// Hiển thị dữ liệu dưới dạng bảng HTML


// Kiểm tra dữ liệu có tồn tại không
if ($result->num_rows > 0) {
    echo "<table border='1' class='product-table'>
            <tr>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Loại SP</th>
                <th>Màu sắc</th>
                <th>Giá nhập</th>
                <th>Giá xuất</th>
                <th>Số lượng tồn</th>
                <th>Hành động</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['MaSP']}</td>
                <td>{$row['TenSP']}</td>
                <td>{$row['LoaiSP']}</td>
                <td>{$row['MauSac']}</td>
                <td>{$row['GiaNhap']}</td>
                <td>{$row['GiaXuat']}</td>
                <td>{$row['SoLuongTon']}</td>
                <td>
                    <button class='edit' data-id='{$row['MaSP']}'>Sửa</button>
                    <button class='copy' data-id='{$row['MaSP']}'>Chép</button>
                    <button class='delete' data-id='{$row['MaSP']}'>Xóa</button>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có sản phẩm nào.";
}



$conn->close();
?>



<!-- Vùng hiển thị bảng -->

<script src="js/jquery-3.7.js"></script>
<!-- Modal for adding product -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="addProductForm">
            <input type="text" name="MaSP" placeholder="Mã SP" required>
            <input type="text" name="TenSP" placeholder="Tên SP" required>
            <input type="text" name="LoaiSP" placeholder="Loai Sản Phẩm" required>
            <input type="text" name="MauSac" placeholder="Màu Sắc" required>
            <input type="number" step="0.01" name="Gia" placeholder="Giá" required>
            <button type="submit">Thêm Sản Phẩm</button>
        </form>
    </div>
</div>
</div>



