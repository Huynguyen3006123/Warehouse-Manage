<?php
session_start();
require 'api/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT UserID, Password, Role FROM useraccount WHERE UserName = ?");
    $stmt->bind_param("s", $username); 
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['UserID']; 
        $_SESSION['role'] = $user['Role']; 

        if ($user['Role'] === 'Quản lý') {
            header("Location: dashboard.html");
        } else {
            header("Location: index.php"); 
        }
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Quản lý kho</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Web Quản Lý Kho</h1>
        <p>Hỗ trợ doanh nghiệp nhỏ và vừa</p>
        <div class="login-box">
            <h2>Đăng nhập</h2>
            <form action="#" method="post">
                <div class="input-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <?php if (isset($error)) : ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                <button type="submit">Đăng nhập</button>
            </form>
        </div>
    </div>
</body>
</html>
