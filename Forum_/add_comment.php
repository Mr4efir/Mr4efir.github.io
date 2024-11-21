<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic_id = $_POST['topic_id'];
    $author = $_POST['comment-author'];
    $content = $_POST['comment-content'];

    $sql = "INSERT INTO comments (topic_id, author, content) VALUES (:topic_id, :author, :content)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':topic_id', $topic_id);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        header("Location: forum.php");
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->errorInfo()[2];
    }
}
?>