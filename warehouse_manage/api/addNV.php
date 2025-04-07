<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

// Nhận dữ liệu từ form
$userID = $_POST['UserID'];
$userName = $_POST['UserName'];
$passWord = $_POST['PassWord'];
$maNV = $_POST['MaNV'];
$hoTen = $_POST['HoTen'];
$soDienThoai = $_POST['SoDienThoai'];
$role = "Nhân viên";
$hashedPassword = password_hash($passWord, PASSWORD_DEFAULT);
// Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
$conn->begin_transaction();

try {
    // Thêm vào bảng useraccount
    $sql1 = "INSERT INTO useraccount (UserID, UserName, PassWord, Role) VALUES (?, ?, ?, ?)";
    
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("ssss", $userID, $userName, $hashedPassword, $role);
    $stmt1->execute();

    // Thêm vào bảng nhanvien
    $sql2 = "INSERT INTO nhanvien (MaNV, HoTen, SoDienThoai, ChucVu, UserID) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("issss", $maNV, $hoTen, $soDienThoai, $role, $userID);
    $stmt2->execute();

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback nếu có lỗi
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Không thể thêm nhân viên: ' . $e->getMessage()]);
}

$stmt1->close();
$stmt2->close();
$conn->close();
?>