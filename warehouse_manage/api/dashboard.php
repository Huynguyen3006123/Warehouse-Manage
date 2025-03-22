<?php
header('Content-Type: application/json'); // Đặt header để trả về JSON
include("db.php"); // Kết nối CSDL

$sql = "SELECT MaSP, TenSP, SoLuongTon FROM sanpham WHERE SoLuongTon <= 5";
$result = $conn->query($sql);

$sanpham_list = [];
while ($row = $result->fetch_assoc()) {
    $sanpham_list[] = $row;
}

// Trả về dữ liệu JSON
echo json_encode($sanpham_list);
?>
