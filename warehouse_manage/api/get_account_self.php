<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php'; // Đảm bảo đường dẫn đúng

session_start();

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
    exit();
}

$UserID = $_SESSION['UserID'];

// Truy vấn từ useraccount và nhanvien
$sql = "SELECT ua.UserID, ua.UserName, ua.Role, nv.MaNV 
        FROM useraccount ua
        LEFT JOIN nhanvien nv ON ua.UserID = nv.UserID 
        WHERE ua.UserID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn: ' . $conn->error]);
    exit();
}

$stmt->bind_param("s", $UserID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    error_log("Role của tài khoản $UserID: " . $row['Role']);
    if (empty($row['Role']) || $row['Role'] !== "Quản lý") {
        session_unset();
        session_destroy();
        echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập, đang đăng xuất...', 'role' => $row['Role']]);
        exit();
    }
    $_SESSION['MaNV'] = $row['MaNV'] ?? '1'; // Lấy MaNV từ nhanvien, nếu null thì mặc định '1'
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    session_unset();
    session_destroy();
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy tài khoản, đang đăng xuất...']);
    exit();
}

$stmt->close();
$conn->close();
?>