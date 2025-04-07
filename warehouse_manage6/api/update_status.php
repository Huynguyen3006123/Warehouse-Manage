<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSP = $_POST['MaSP'];
    $TrangThai = $_POST['TrangThai'];

    $sql = "UPDATE sanpham SET TrangThai = ? WHERE MaSP = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $TrangThai, $MaSP);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Cập nhật trạng thái thành công"]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi khi cập nhật trạng thái"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Yêu cầu không hợp lệ"]);
}
?>