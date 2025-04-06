<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT * FROM nhanvien
where ChucVu = 'Nhân Viên'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    // Ép kiểu số điện thoại thành string
    $row['SoDienThoai'] = (string)$row['SoDienThoai'];
    $data[] = $row;
}

echo json_encode($data); // Không dùng JSON_NUMERIC_CHECK
$conn->close();
?>