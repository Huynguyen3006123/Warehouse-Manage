<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu']);
    exit();
}

$stmt = $conn->prepare("SELECT UserID, Password, Role FROM useraccount WHERE UserName = ?");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu']);
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['Password'])) {
    $_SESSION['UserID'] = $user['UserID'];
    $_SESSION['Role'] = $user['Role'];
    echo json_encode(['success' => true, 'role' => $user['Role']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Sai tài khoản hoặc mật khẩu']);
}

$stmt->close();
$conn->close();
?>