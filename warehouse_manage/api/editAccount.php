<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

// Nhận dữ liệu từ form
$userID = $_POST['UserID'];
$userName = $_POST['UserName'];
$passWord = $_POST['PassWord'];

try {
    // Nếu người dùng nhập mật khẩu mới, hash mật khẩu
    if (!empty($passWord)) {
        $hashedPassword = password_hash($passWord, PASSWORD_DEFAULT);
        $sql = "UPDATE useraccount SET UserName = ?, PassWord = ? WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $userName, $hashedPassword, $userID);
    } else {
        // Nếu không nhập mật khẩu mới, chỉ cập nhật UserName
        $sql = "UPDATE useraccount SET UserName = ? WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userName, $userID);
    }
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Không thể cập nhật tài khoản: ' . $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>