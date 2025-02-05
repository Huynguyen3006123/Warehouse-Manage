<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
echo "Chào mừng, " . $_SESSION['user_id'] . "! <a href='logout.php'>Đăng xuất</a>";
?>
