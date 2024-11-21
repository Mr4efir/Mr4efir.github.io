<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['post-title'];
    $author = $_POST['post-author'];
    $content = $_POST['post-content'];

    $sql = "INSERT INTO topics (title, author, content) VALUES (:title, :author, :content)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':author', $author, SQLITE3_TEXT);
    $stmt->bindValue(':content', $content, SQLITE3_TEXT);

    if ($stmt->execute()) {
        header("Location: forum.php");
        exit();
    } else {
        echo "Error: " . $db->lastErrorMsg();
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>