<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/db.php';

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nickname' => $user['nickname'],
            'email' => $user['email']
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $_SESSION['auth_msg'] = 'Неверный email или пароль';
        $_SESSION['auth_target'] = 'login';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    echo "Доступ запрещён.";
}
