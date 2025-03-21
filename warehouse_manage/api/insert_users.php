<?php
require_once "db.php"; 

$users = [
    "admin" => password_hash("123456", PASSWORD_DEFAULT),
    "user1" => password_hash("password1", PASSWORD_DEFAULT),
    "user2" => password_hash("password2", PASSWORD_DEFAULT)
];

$sql = "INSERT INTO useraccount (UserID, UserName, Password, Role) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

foreach ($users as $username => $hashedPassword) {
    $userID = strtoupper($username); 
    $role = ($username == "admin") ? "Quản lý" : "Nhân viên"; 
    $stmt->bind_param("ssss", $userID, $username, $hashedPassword, $role);
    $stmt->execute();
}

echo "Thêm dữ liệu thành công!";


$stmt->close();
$conn->close();
?>
