<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

session_start();

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

$UserID = $_SESSION['UserID'];

$sql = "SELECT u.UserID, u.UserName, u.Role, n.MaNV 
        FROM useraccount u 
        LEFT JOIN nhanvien n ON u.UserID = n.UserID 
        WHERE u.UserID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->bind_param("s", $UserID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Log để kiểm tra Role
    error_log("Role của tài khoản $UserID: " . $row['Role']);
    if (empty($row['Role']) || $row['Role'] !== "Nhân viên") {
        session_unset();
        session_destroy();
        echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập, đang đăng xuất...', 'role' => $row['Role']]);
        exit();
    }
    $_SESSION['MaNV'] = $row['MaNV'];
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy tài khoản']);
}

$stmt->close();
$conn->close();
?>