<?php
require_once "db.php"; 

$users = [
    "user3" => password_hash("password3", PASSWORD_DEFAULT),
    
];

$sql = "INSERT INTO useraccount (UserID, UserName, Password, Role) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

foreach ($users as $username => $hashedPassword) {
    $userID = strtoupper($username); 
    $role = "Nhân viên"; 
    $stmt->bind_param("ssss", $userID, $username, $hashedPassword, $role);
    $stmt->execute();
}

echo "Thêm dữ liệu thành công!";


$stmt->close();
$conn->close();
?>
