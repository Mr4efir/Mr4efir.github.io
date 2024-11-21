<?php
$db = new SQLite3('forum.db');

if (!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}
?>