<?php
// === Настройки ===
$adminPassword = 'WXlBYVJ6MjAxMyA='; // 🔒 УСТАНОВИ СВОЙ НАДЁЖНЫЙ ПАРОЛЬ

// Проверка пароля
$inputPassword = $_POST['password'] ?? $_GET['password'] ?? '';

if ($inputPassword !== $adminPassword) {
    echo '<form method="POST">
        <h2>Введите пароль для очистки базы:</h2>
        <input type="password" name="password" required>
        <button type="submit">Очистить</button>
    </form>';
    exit;
}

// Путь к базе данных
$dbPath = __DIR__ . '/users.db';

// Удаляем файл базы данных
if (file_exists($dbPath)) {
    unlink($dbPath);
}

// Создаём новую базу с нужной структурой
try {
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nickname TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL
        );
    ";
    $db->exec($createTableSQL);

    echo "✅ База данных успешно пересоздана. Все пользователи удалены.";
} catch (PDOException $e) {
    echo "❌ Ошибка при создании базы данных: " . $e->getMessage();
}
?>