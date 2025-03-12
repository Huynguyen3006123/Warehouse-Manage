<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSP = $_POST['MaSP'];
    $sql = "DELETE FROM sanpham WHERE MaSP = '$MaSP'";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa sản phẩm thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
