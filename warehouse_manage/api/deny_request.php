<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (isset($_POST['MaPN'])) {
    $maPN = $_POST['MaPN'];

    // Cập nhật trạng thái phiếu nhập thành 'deny'
    $sql = "UPDATE nhap SET TrangThai = 'deny' WHERE MaPN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maPN);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Yêu cầu đã bị từ chối"]);
    } else {
        echo json_encode(["error" => "Lỗi khi cập nhật yêu cầu"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Không tìm thấy mã phiếu nhập"]);
}

$conn->close();
?>