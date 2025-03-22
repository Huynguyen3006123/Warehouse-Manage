<?php
include 'db.php';
$sql = "SELECT MaSP, TenSP, SoLuongTon
FROM sanpham 
ORDER BY SoLuongTon ASC 
LIMIT 3";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>