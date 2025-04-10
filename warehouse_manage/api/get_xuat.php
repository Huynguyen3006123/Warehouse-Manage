<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT n.MaPX, ch.TenCH, n.NgayXuat, nv.HoTen 
        FROM xuat n
        LEFT JOIN cuahang ch ON n.MaCH = ch.MaCH
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