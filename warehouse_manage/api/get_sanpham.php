<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT MaSP, TenSP, LoaiSP, KichCo, MauSac, GiaNhap, GiaXuat, SoLuongTon, NgayNhap, TrangThai FROM sanpham";
$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data, JSON_NUMERIC_CHECK);
$conn->close();
?>