<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db.php';

// Nhận dữ liệu từ form (không cần UserID và MaNV nữa)
$userName = $_POST['UserName'];
$passWord = $_POST['PassWord'];
$hoTen = $_POST['HoTen'];
$soDienThoai = $_POST['SoDienThoai'];
$role = "Nhân viên";
$hashedPassword = password_hash($passWord, PASSWORD_DEFAULT);

// Bật chế độ báo lỗi MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
$conn->begin_transaction();

try {
    // Tự sinh MaNV: Lấy mã lớn nhất từ bảng nhanvien và tăng lên 1
    $sql_max_nv = "SELECT MAX(MaNV) as maxMaNV FROM nhanvien";
    $result_nv = $conn->query($sql_max_nv);
    $row_nv = $result_nv->fetch_assoc();
    $maNV = $row_nv['maxMaNV'] ? (int)$row_nv['maxMaNV'] + 1 : 1; // Nếu không có mã nào thì bắt đầu từ 1

    // Tự sinh UserID: Lấy số lớn nhất từ UserID dạng USERx
    $sql_max_user = "SELECT UserID FROM useraccount WHERE UserID LIKE 'USER%' ORDER BY CAST(SUBSTRING(UserID, 5) AS UNSIGNED) DESC LIMIT 1";
    $result_user = $conn->query($sql_max_user);
    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $lastUserID = $row_user['UserID'];
        $lastNumber = (int)substr($lastUserID, 4); // Lấy số từ "USERx"
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; // Nếu chưa có UserID nào thì bắt đầu từ USER1
    }
    $userID = "USER" . $newNumber;

    // Thêm vào bảng useraccount
    $sql1 = "INSERT INTO useraccount (UserID, UserName, PassWord, Role) VALUES (?, ?, ?, ?)";
    $stmt1 = $conn->prepare($sql1);
    if ($stmt1 === false) {
        throw new Exception('Lỗi khi chuẩn bị truy vấn useraccount: ' . $conn->error);
    }
    $stmt1->bind_param("ssss", $userID, $userName, $hashedPassword, $role);
    if (!$stmt1->execute()) {
        throw new Exception('Lỗi khi thêm vào useraccount: ' . $stmt1->error);
    }

    // Thêm vào bảng nhanvien
    $sql2 = "INSERT INTO nhanvien (MaNV, HoTen, SoDienThoai, ChucVu, UserID) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    if ($stmt2 === false) {
        throw new Exception('Lỗi khi chuẩn bị truy vấn nhanvien: ' . $conn->error);
    }
    $stmt2->bind_param("issss", $maNV, $hoTen, $soDienThoai, $role, $userID);
    if (!$stmt2->execute()) {
        throw new Exception('Lỗi khi thêm vào nhanvien: ' . $stmt2->error);
    }

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true, 'message' => "Nhân viên đã được thêm với UserID: $userID, MaNV: $maNV"]);
} catch (Exception $e) {
    // Rollback nếu có lỗi
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Không thể thêm nhân viên: ' . $e->getMessage()]);
} finally {
    if (isset($stmt1)) $stmt1->close();
    if (isset($stmt2)) $stmt2->close();
    $conn->close();
}
?>