<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/database/users.db'); // файл базы данных в той же папке
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}