<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

if (isset($_POST['MaDon'])) {
    $maDon = $_POST['MaDon'];

    // Cập nhật trạng thái đơn hàng thành 'approved' (hoặc trạng thái bạn muốn)
    $sql = "UPDATE donhang SET TrangThai = 'confirmed' WHERE MaDon = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maDon);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Đơn hàng đã được duyệt"]);
    } else {
        echo json_encode(["error" => "Lỗi khi cập nhật đơn hàng"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Không tìm thấy mã đơn hàng"]);
}

$conn->close();
?>