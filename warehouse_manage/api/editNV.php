<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MaNV = $_POST['MaNV'];
    $HoTen = $_POST['HoTen'];
    $SoDienThoai = $_POST['SoDienThoai'];
    

    $sql = "UPDATE nhanvien SET HoTen = ?, SoDienThoai = ? WHERE MaNV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $HoTen, $SoDienThoai, $MaNV);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Cập nhật nhân viên thành công"]);
    } else {
        echo json_encode(["error" => "Lỗi khi cập nhật nhân viên"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Phương thức không hợp lệ"]);
}

$conn->close();
?>