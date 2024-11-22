<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['reg-username'];
    $password = password_hash($_POST['reg-password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);

    $result = $stmt->execute();
    if (!$result) {
        die("Ошибка выполнения запроса: " . $db->lastErrorMsg());
    }

    header("Location: forum.php");
    exit();
}
?>