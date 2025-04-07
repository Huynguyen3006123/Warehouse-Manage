<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php';

// Bật báo lỗi chi tiết
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit();
}

// Lấy dữ liệu từ form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$shop_name = $_POST['shop_name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';

// Kiểm tra dữ liệu đầu vào
if (empty($username) || empty($password) || empty($confirm_password) || empty($shop_name) || 
    empty($address) || empty($phone) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin']);
    exit();
}

if ($password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu xác nhận không khớp']);
    exit();
}

// Kiểm tra username đã tồn tại
$stmt = $conn->prepare("SELECT UserID FROM useraccount WHERE UserName = ?");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị truy vấn kiểm tra username: ' . $conn->error]);
    exit();
}
$stmt->bind_param("s", $username);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Tên đăng nhập đã tồn tại']);
    $stmt->close();
    exit();
}
$stmt->close();

// Sinh UserID (dạng USERx, lấy giá trị lớn nhất và tăng lên 1)
$sql = "SELECT UserID FROM useraccount WHERE UserID REGEXP '^USER[0-9]+$' ORDER BY CAST(SUBSTRING(UserID, 5) AS UNSIGNED) DESC LIMIT 1";
$result = $conn->query($sql);
if ($result === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn UserID: ' . $conn->error]);
    exit();
}
if ($result->num_rows > 0) {
    $lastUserID = $result->fetch_assoc()['UserID'];
    $number = (int) substr($lastUserID, 4) + 1; // Lấy số sau "USER" và tăng lên 1
} else {
    $number = 0; // Nếu không có UserID nào, bắt đầu từ 0
}
$userID = 'USER' . $number;

// Kiểm tra trùng lặp UserID và tăng số cho đến khi không trùng
while (true) {
    $stmt = $conn->prepare("SELECT UserID FROM useraccount WHERE UserID = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị truy vấn kiểm tra UserID: ' . $conn->error]);
        exit();
    }
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // UserID không tồn tại, có thể sử dụng
        $stmt->close();
        break;
    }
    
    // UserID đã tồn tại, tăng số lên và thử lại
    $stmt->close();
    $number++;
    $userID = 'USER' . $number;
}

// Sinh MaCH với tiền tố CH
$sql = "SELECT MaCH FROM cuahang ORDER BY MaCH DESC LIMIT 1";
$result = $conn->query($sql);
if ($result === false) {
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn MaCH: ' . $conn->error]);
    exit();
}
if ($result->num_rows > 0) {
    $lastMaCH = $result->fetch_assoc()['MaCH'];
    $number = (int) substr($lastMaCH, 2) + 1;
} else {
    $number = 1;
}
$maCH = 'CH' . str_pad($number, 3, '0', STR_PAD_LEFT);

// Hash mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Bắt đầu transaction
$conn->begin_transaction();

try {
    // Ghi vào useraccount (thêm TrangThai)
    $stmt = $conn->prepare("INSERT INTO useraccount (UserID, UserName, Password, Role, TrangThai) VALUES (?, ?, ?, 'Cửa hàng', 'normal')");
    if ($stmt === false) {
        throw new Exception('Lỗi chuẩn bị truy vấn useraccount: ' . $conn->error);
    }
    $stmt->bind_param("sss", $userID, $username, $hashed_password);
    if (!$stmt->execute()) {
        throw new Exception('Lỗi khi ghi vào useraccount: ' . $stmt->error);
    }
    $stmt->close();

    // Ghi vào cuahang
    $stmt = $conn->prepare("INSERT INTO cuahang (MaCH, TenCH, DiaChi, SoDienThoai, Email, UserID) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        throw new Exception('Lỗi chuẩn bị truy vấn cuahang: ' . $conn->error);
    }
    $stmt->bind_param("ssssss", $maCH, $shop_name, $address, $phone, $email, $userID);
    if (!$stmt->execute()) {
        throw new Exception('Lỗi khi ghi vào cuahang: ' . $stmt->error);
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();

    // Trả về kết quả
    echo json_encode([
        'success' => true,
        'message' => 'Đăng ký thành công! Vui lòng đăng nhập.',
        'data' => [
            'UserID' => $userID,
            'MaCH' => $maCH
        ]
    ]);
} catch (Exception $e) {
    // Rollback nếu có lỗi
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>