<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

// Giả lập UserID từ session (thay bằng cách lấy thực tế từ session)
session_start();
if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

$UserID = $_SESSION['UserID'];

$sql = "SELECT UserID, UserName, Role FROM useraccount WHERE UserID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->bind_param("s", $UserID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy tài khoản']);
}

$stmt->close();
$conn->close();
?>