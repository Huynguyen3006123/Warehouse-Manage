<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$shop_name = $_POST['shop_name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';

if (empty($username) || empty($password) || empty($confirm_password) || empty($shop_name) || 
    empty($address) || empty($phone) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin']);
    exit();
}

if ($password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu xác nhận không khớp']);
    exit();
}

$stmt = $conn->prepare("SELECT UserID FROM useraccount WHERE UserName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Tên đăng nhập đã tồn tại']);
    $stmt->close();
    exit();
}
$stmt->close();

$sql = "SELECT UserID FROM useraccount ORDER BY UserID DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $lastUserID = $result->fetch_assoc()['UserID'];
    $number = (int) substr($lastUserID, 4) + 1;
} else {
    $number = 1;
}
$userID = 'USER' . str_pad($number, 3, '0', STR_PAD_LEFT);

$sql = "SELECT MaCH FROM cuahang ORDER BY MaCH DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $lastMaCH = $result->fetch_assoc()['MaCH'];
    $number = (int) substr($lastMaCH, 2) + 1;
} else {
    $number = 1;
}
$maCH = 'CH' . str_pad($number, 3, '0', STR_PAD_LEFT);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO useraccount (UserID, UserName, Password, Role) VALUES (?, ?, ?, 'Cửa hàng')");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị truy vấn useraccount']);
    exit();
}
$stmt->bind_param("sss", $userID, $username, $hashed_password);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("INSERT INTO cuahang (MaCH, TenCH, DiaChi, SoDienThoai, Email, UserID) VALUES (?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị truy vấn cuahang']);
    exit();
}
$stmt->bind_param("ssssss", $maCH, $shop_name, $address, $phone, $email, $userID);
$stmt->execute();
$stmt->close();

echo json_encode(['success' => true, 'message' => 'Đăng ký thành công! Vui lòng đăng nhập.']);
$conn->close();
?>