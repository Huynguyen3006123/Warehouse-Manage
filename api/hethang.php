<?php
include 'db.php';
$sql = "SELECT TenSP, SoLuong, DVT, MaNCC 
FROM sanpham 
ORDER BY SoLuong ASC 
LIMIT 10";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>