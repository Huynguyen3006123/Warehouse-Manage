<?php
require 'db.php'; // Kết nối database

// Mật khẩu mới (ví dụ)
$newPassword = "password6";

// Hash mật khẩu trước khi lưu vào database
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

try {
    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare("UPDATE `useraccount` SET `Password` = ? WHERE UserID = ?");
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    // Gán giá trị cho placeholder
    $userID = 'USER6';
    $stmt->bind_param("ss", $hashedPassword, $userID);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "Cập nhật mật khẩu thành công cho UserID: $userID";
    } else {
        throw new Exception("Lỗi khi thực thi: " . $stmt->error);
    }

    // Đóng statement
    $stmt->close();
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}

// Đóng kết nối
$conn->close();
?>