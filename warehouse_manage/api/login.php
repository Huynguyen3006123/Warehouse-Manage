<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
require 'db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
    exit();
}

$stmt = $conn->prepare("SELECT UserID, PassWord, Role FROM useraccount WHERE UserName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['PassWord'])) {
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['Role'] = $user['Role'];
        echo json_encode(['success' => true, 'role' => $user['Role']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu không đúng']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Tên đăng nhập không tồn tại']);
}

$stmt->close();
$conn->close();
?>