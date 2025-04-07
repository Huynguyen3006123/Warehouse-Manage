<?php
session_start(); // Khởi động session
session_destroy(); // Hủy session hoàn toàn
header("Location: login.html"); // Chuyển hướng về trang login
exit(); // Dừng script
?>