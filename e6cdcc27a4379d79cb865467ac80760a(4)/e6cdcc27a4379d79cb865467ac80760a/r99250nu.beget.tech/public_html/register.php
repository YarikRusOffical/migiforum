<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require 'db.php';

        $nickname = trim($_POST['nickname']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Проверка по email
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['auth_msg'] = 'Пользователь с таким email уже существует';
            $_SESSION['auth_target'] = 'register';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Проверка по nickname
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE nickname = ?");
        $stmt->execute([$nickname]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['auth_msg'] = 'Никнейм уже занят';
            $_SESSION['auth_target'] = 'register';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Добавляем пользователя
        $stmt = $db->prepare("INSERT INTO users (nickname, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$nickname, $email, $password])) {
            $_SESSION['user'] = [
                'id' => $db->lastInsertId(),
                'nickname' => $nickname,
                'email' => $email
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            throw new Exception('Ошибка при добавлении пользователя');
        }

    } catch (Exception $e) {
        // Логируем ошибку и отправляем сообщение
        $_SESSION['auth_msg'] = 'Ошибка: ' . $e->getMessage();
        $_SESSION['auth_target'] = 'register';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    echo "Доступ запрещён.";
}