<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT n.MaPN, ncc.TenNCC, n.NgayNhap, nv.HoTen 
        FROM nhap n
        LEFT JOIN ncc ON n.MaNCC = ncc.MaNCC
        LEFT JOIN nhanvien nv ON n.MaNV = nv.MaNV 
        WHERE n.TrangThai = 'confirmed'";

$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>