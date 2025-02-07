<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Chuẩn bị truy vấn SQL
    $stmt = $conn->prepare("SELECT UserID, Password FROM Users WHERE UserName = ?");
    $stmt->bind_param("s", $username); // "s" đại diện cho kiểu string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['UserID']; // Lưu ID vào session
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Đăng nhập</title></head>
<body>
<form method="post">
    <input type="text" name="username" placeholder="Tên đăng nhập" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <button type="submit">Đăng nhập</button>
</form>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
