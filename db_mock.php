<?php
$users = [
    "ad" => password_hash("123", PASSWORD_DEFAULT),
    "u1" => password_hash("123", PASSWORD_DEFAULT)
];

function getUser($username) {
    global $users;
    return isset($users[$username]) ? $users[$username] : null;
}
?>
