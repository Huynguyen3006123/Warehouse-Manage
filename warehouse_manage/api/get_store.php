<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

$sql = "SELECT * FROM cuahang";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $SoDienThoai);
$stmt->execute();
$result = $stmt->get_result();
$data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

echo json_encode($data, JSON_NUMERIC_CHECK);
$conn->close();
?>