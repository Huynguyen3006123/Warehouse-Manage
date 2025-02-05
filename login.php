<?php
session_start();
require 'db_mock.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = getUser($username);

    if ($hashed_password && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu.";
    }
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
