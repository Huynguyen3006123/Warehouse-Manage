<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT MaHoaDon,LoaiPhieu, NgayThucHien, MaNV, TrangThai FROM hoadon";
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