<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

// Nhận dữ liệu từ form
$userID = $_POST['UserID'];
$userName = $_POST['UserName'];
$passWord = $_POST['PassWord'];

try {
    // Kiểm tra xem username đã tồn tại chưa (trừ chính user đang chỉnh sửa)
    $checkSql = "SELECT UserID FROM useraccount WHERE UserName = ? AND UserID != ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $userName, $userID);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Nếu username đã tồn tại, trả về lỗi
        echo json_encode(['success' => false, 'message' => 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác!']);
        $checkStmt->close();
        $conn->close();
        exit();
    }

    $checkStmt->close();

    // Nếu username không trùng, tiến hành cập nhật
    if (!empty($passWord)) {
        // Nếu người dùng nhập mật khẩu mới, hash mật khẩu
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