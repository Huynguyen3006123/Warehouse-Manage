<?php
require_once "db.php"; // Kết nối database

// Danh sách user cần thêm
$users = [
    "ad" => password_hash("123", PASSWORD_DEFAULT),
    "u1" => password_hash("123", PASSWORD_DEFAULT)
];

// Chuẩn bị câu lệnh SQL
$sql = "INSERT INTO Users (UserID, UserName, Password, Role) VALUES (?, ?, ?, ?)";

// Chuẩn bị statement
$stmt = $conn->prepare($sql);

// Thêm từng user vào database
foreach ($users as $username => $hashedPassword) {
    $userID = strtoupper($username); // Chuyển UserID thành chữ hoa
    $role = ($username == "ad") ? "Admin" : "Employee"; // Phân quyền
    $stmt->bind_param("ssss", $userID, $username, $hashedPassword, $role);
    $stmt->execute();
}

echo "Thêm dữ liệu thành công!";

// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>
