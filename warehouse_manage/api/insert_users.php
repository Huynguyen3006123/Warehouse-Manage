<?php
require 'db.php'; // Kết nối database

$users = [
    ['USER13', 'ch2'],
    ['USER14', 'ch3'],
    ['USER15', 'ch4'],
    ['USER16', 'ch5'],
    ['USER17', 'ch6'],
    ['USER18', 'ch7'],
    ['USER19', 'ch8'],
    ['USER20', 'ch9'],
    ['USER21', 'ch10']
];

foreach ($users as $user) {
    $userID = $user[0];
    $username = $user[1];
    $password = password_hash('123', PASSWORD_BCRYPT); // Mã hóa mật khẩu '123'
    $role = 'Cửa Hàng';
    $status = 'normal';

    // Câu lệnh SQL để thêm tài khoản
    $sql = "INSERT INTO useraccount (UserID, UserName, Password, Role, TrangThai) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    $stmt->bind_param("sssss", $userID, $username, $password, $role, $status);
    if ($stmt->execute()) {
        echo "Thêm tài khoản $userID ($username) thành công!<br>";
    } else {
        echo "Lỗi khi thêm tài khoản $userID: " . $stmt->error . "<br>";
    }
    $stmt->close();
}

// Cập nhật UserID cho các cửa hàng trong bảng cuahang
$updates = [
    ['CH002', 'USER13'],
    ['CH003', 'USER14'],
    ['CH004', 'USER15'],
    ['CH005', 'USER16'],
    ['CH006', 'USER17'],
    ['CH007', 'USER18'],
    ['CH008', 'USER19'],
    ['CH009', 'USER20'],
    ['CH010', 'USER21']
];

foreach ($updates as $update) {
    $maCH = $update[0];
    $userID = $update[1];

    // Câu lệnh SQL để cập nhật UserID
    $sql = "UPDATE cuahang SET UserID = ? WHERE MaCH = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    $stmt->bind_param("ss", $userID, $maCH);
    if ($stmt->execute()) {
        echo "Cập nhật UserID cho cửa hàng $maCH thành công!<br>";
    } else {
        echo "Lỗi khi cập nhật cửa hàng $maCH: " . $stmt->error . "<br>";
    }
    $stmt->close();
}

// Đóng kết nối
$conn->close();
echo "Đã thêm tài khoản và cập nhật UserID cho các cửa hàng thành công!";
?>