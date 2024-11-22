<?php
require 'db.php';

$sql = "SELECT * FROM topics ORDER BY created_at DESC";
$result = $db->query($sql);
$topics = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $topics[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форум о Скандинавии</title>
    <link rel="stylesheet" href="forum.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html" class="btn-1">Домой</a></li>
                <li><a href="myths.html" class="btn-1">Миры</a></li>
                <li><a href="#about" class="btn-1">О нас</a></li>
                <li><a href="culture.html" class="btn-1">Культура</a></li>
                <li><a href="person.html" class="btn-1">Боги</a></li>
                <li><a href="forum.php" class="btn-1">Форум</a></li>
            </ul>
        </nav>
        <div class="background-container">
        </div>
    </header>
    <main>
        <section id="forum">
            <h1>Форум о Скандинавии</h1>
            <div class="forum-topics">
                <h2>Темы форума</h2>
                <div class="forum-posts">
                    <?php foreach ($topics as $topic): ?>
                        <div class="forum-post">
                            <h3><?= htmlspecialchars($topic['title']) ?></h3>
                            <p class="post-meta">Автор: <?= htmlspecialchars($topic['author']) ?> | Дата: <?= $topic['created_at'] ?></p>
                            <p><?= htmlspecialchars($topic['content']) ?></p>

                            <div class="comments">
                                <h4>Комментарии</h4>
                                <?php
                                $sql_comments = "SELECT * FROM comments WHERE topic_id = :topic_id ORDER BY created_at DESC";
                                $stmt_comments = $db->prepare($sql_comments);
                                $stmt_comments->bindValue(':topic_id', $topic['id'], SQLITE3_INTEGER);
                                $result_comments = $stmt_comments->execute();
                                $comments = [];
                                while ($row = $result_comments->fetchArray(SQLITE3_ASSOC)) {
                                    $comments[] = $row;
                                }
                                ?>
                                <?php foreach ($comments as $comment): ?>
                                    <div class="comment">
                                        <p class="comment-meta">Автор: <?= htmlspecialchars($comment['author']) ?> | Дата: <?= $comment['created_at'] ?></p>
                                        <p><?= htmlspecialchars($comment['content']) ?></p>
                                    </div>
                                <?php endforeach; ?>

                                <div class="comment-form">
                                    <h4>Добавить комментарий</h4>
                                    <form action="add_comment.php" method="post">
                                        <input type="hidden" name="topic_id" value="<?= $topic['id'] ?>">
                                        <label for="comment-author">Ваше имя:</label>
                                        <input type="text" id="comment-author" name="comment-author" required>

                                        <label for="comment-content">Комментарий:</label>
                                        <textarea id="comment-content" name="comment-content" rows="3" required></textarea>

                                        <button type="submit">Отправить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="forum-form">
                <h2>Добавить новое сообщение</h2>
                <form action="add_topic.php" method="post">
                    <label for="post-title">Тема:</label>
                    <input type="text" id="post-title" name="post-title" required>

                    <label for="post-author">Ваше имя:</label>
                    <input type="text" id="post-author" name="post-author" required>

                    <label for="post-content">Сообщение:</label>
                    <textarea id="post-content" name="post-content" rows="5" required></textarea>

                    <button type="submit">Отправить</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>