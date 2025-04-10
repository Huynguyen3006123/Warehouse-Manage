<?php
$servername = "localhost"; // Hoặc địa chỉ IP của server MySQL
$username = "root"; // Thay bằng username của bạn
$password = ""; // Thay bằng mật khẩu của bạn
$database = "warehouse_db2"; // Tên database của bạn

// Kết nối đến MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập UTF-8 để hỗ trợ tiếng Việt
$conn->set_charset("utf8mb4");
?>
