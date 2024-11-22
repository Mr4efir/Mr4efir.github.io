<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic_id = $_POST['topic_id'];
    $author = $_POST['comment-author'];
    $content = $_POST['comment-content'];

    $sql = "INSERT INTO comments (topic_id, author, content) VALUES (:topic_id, :author, :content)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':topic_id', $topic_id, SQLITE3_INTEGER);
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