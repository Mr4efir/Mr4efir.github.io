<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['post-title'];
    $author = $_POST['post-author'];
    $content = $_POST['post-content'];

    $sql = "INSERT INTO topics (title, author, content) VALUES (:title, :author, :content)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        header("Location: forum.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->errorInfo()[2];
    }
} else {

    http_response_code(405);
    echo "Method Not Allowed";
}
?>