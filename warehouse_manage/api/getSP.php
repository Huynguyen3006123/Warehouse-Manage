<?php
include 'db.php';

if (isset($_GET['MaSP'])) {
    $MaSP = $_GET['MaSP'];
    $sql = "SELECT * FROM sanpham WHERE MaSP = '$MaSP'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Không tìm thấy sản phẩm"]);
    }
}

$conn->close();
?>
