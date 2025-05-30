<?php
session_start();
$user = $_SESSION['user'] ?? null;
require __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="mf-mini-logo.png">
  <meta charset="UTF-8">
  <title>MigiForm — Главная</title>
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #11001c;
      color: #d6d6d6;
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      transition: background-color 0.5s;
    }
    .top-bar {
      background-color: #400c5d;
      text-align: center;
      padding: 10px;
      font-size: 14px;
      border-radius: 0 0 10px 10px;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background-color: #1a092b;
      border-radius: 0 0 20px 20px;
    }
    .logo img {
      height: 40px;
    }
    .auth-buttons {
      display: flex;
      gap: 10px;
    }
    .auth-button {
      background: linear-gradient(to right, #444, #2c2c2c);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
    }
    .auth-button:hover {
      background: #5a5a5a;
      transform: translateY(-2px);
    }
    .auth-message {
      color: #ff8080;
      font-weight: bold;
      text-align: center;
      margin-bottom: 10px;
    }
    main {
      display: flex;
      padding: 30px;
      gap: 30px;
    }
    .news {
      flex: 3;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .news-item {
      background-color: #2e1b4d;
      padding: 20px;
      border-radius: 15px;
      transition: 0.3s;
    }
    .news-item:hover {
      background-color: #3d255f;
    }
    .news-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 8px;
    }
    .ads {
      flex: 1;
      background-color: white;
      color: black;
      padding: 20px;
      border-radius: 15px;
      text-align: center;
    }
    .brand-section {
      font-size: 24px;
      padding: 15px 30px;
      background-color: #2d1140;
      border-radius: 15px 15px 0 0;
      margin: 30px 20px 0;
    }
    .brands {
      display: flex;
      justify-content: space-around;
      background-color: #1a092b;
      padding: 20px;
      border-radius: 0 0 15px 15px;
      margin: 0 20px 40px;
    }
    .brand-logo {
        background: #3d255f; /* тёмно-серый */
        color: white;
        width: 120px;
        height: 140px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        border-radius: 15px;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
    }
    .brand-logo:hover {
      background: #ddd;
    }
    .brand-logo img {
      width: 60px;
      height: 60px;
      margin-bottom: 8px;
    }
    .modal {
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.4s ease;

      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 100;
    }
    .modal-content {
      background: #1e1e1e;
      padding: 20px;
      border-radius: 15px;
      width: 320px;
      color: #fff;
      box-shadow: 0 0 15px #000;
    }
    .modal-content input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 7px;
      border: none;
    }
    .modal-content button {
      width: 100%;
      padding: 12px;
      background: #444;
      color: #fff;
      border: none;
      border-radius: 7px;
      cursor: pointer;
    }
    .close-btn {
      float: right;
      cursor: pointer;
      font-size: 18px;
    }
  </style>
</head>
<body>


<header>
  <div class="logo"><img src="../mf-logo-glass.png" alt="MF"></div>
  <div class="auth-buttons">
    <?php if ($user): ?>
  <div style="display: flex; align-items: center; gap: 10px;">
    <span style="font-weight: bold;">Добро пожаловать, <?= htmlspecialchars($user['nickname']) ?>!</span>
    <a href="logout.php" class="auth-button">Выход</a>
  </div>
    <?php else: ?>
      <button class="auth-button" onclick="openModal('loginModal')">Вход</button>
      <button class="auth-button" onclick="openModal('registerModal')">Регистрация</button>
    <?php endif; ?>
  </div>
</header>

<main>
  <div class="news">
    
<div class="news-item" style="display: flex; align-items: flex-start;">
  <img src="mf-logo.png"
       alt="test" style="width: 80px; height: 80px; margin-right: 15px; border-radius: 10px;">
  <div>
    <div class="news-title">Тестовая новость</div>
    <div>Тестируем для будущего.</div>
  </div>
</div>

    
<div class="news-item" style="display: flex; align-items: flex-start;">
  <img src="mf-logo.png"
       alt="test2" style="width: 80px; height: 80px; margin-right: 15px; border-radius: 10px;">
  <div>
    <div class="news-title">Опять тест №2</div>
    <div>Опять тестируем.</div>
  </div>
</div>

  </div>
  <div class="ads">Здесь могла быть ваша реклама</div>
</main>

<div class="brand-section">Выберите бренд</div>
<div class="brands">
  <a href="xiaomi/xiaomi.php" class="brand-logo">
    <img src="img/xiaomi.png" alt="Xiaomi">
    Xiaomi
  </a>
  <a href="samsung/samsung.html" class="brand-logo">
    <img src="img/samsung.png" alt="Samsung" style="height: 55px;">
    Samsung
  </a>
  <a href="lg/lg.html" class="brand-logo">
    <img src="img/lg.png" alt="LG" style="height: 65px;">
    LG
  </a>
  <a href="lenovo.html" class="brand-logo">
    <img src="img/lenovo.png" alt="Lenovo" style="height: 40px;">
    Lenovo
  </a>
  <a href="nothing/nothing.php" class="brand-logo">
    <img src="img/nothing.png" alt="Nothing" style="height: 50px;">
    Nothing
  </a>
</div>

<!-- Модальные окна -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
    <h2>Вход</h2>
    <?php if (!empty($_SESSION['auth_target']) && $_SESSION['auth_target'] === 'login' && !empty($_SESSION['auth_msg'])): ?>
      <div class="auth-message"><?= htmlspecialchars($_SESSION['auth_msg']) ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <input type="text" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Войти</button>
    </form>
  </div>
</div>

<div id="registerModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('registerModal')">&times;</span>
    <h2>Регистрация</h2>
    <?php if (!empty($_SESSION['auth_target']) && $_SESSION['auth_target'] === 'register' && !empty($_SESSION['auth_msg'])): ?>
      <div class="auth-message"><?= htmlspecialchars($_SESSION['auth_msg']) ?></div>
    <?php endif; ?>
    <form method="POST" action="register.php">
      <input type="text" name="nickname" placeholder="Никнейм" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Зарегистрироваться</button>
    </form>
  </div>
</div>



</body>
</html>

<script>
  function openModal(id) {
    const modal = document.getElementById(id);
    modal.style.display = 'flex';
    setTimeout(() => {
      modal.style.opacity = '1';
      modal.style.pointerEvents = 'auto';
    }, 10);
  }

  function closeModal(id) {
    const modal = document.getElementById(id);
    modal.style.opacity = '0';
    modal.style.pointerEvents = 'none';
    setTimeout(() => modal.style.display = 'none', 400);
  }

  <?php if (!empty($_SESSION['auth_msg']) && !empty($_SESSION['auth_target'])): ?>
    window.onload = function () {
      openModal('<?= $_SESSION['auth_target'] === 'register' ? 'registerModal' : 'loginModal' ?>');
    };
  <?php 
    unset($_SESSION['auth_msg']);
    unset($_SESSION['auth_target']);
  endif; ?>
</script>
