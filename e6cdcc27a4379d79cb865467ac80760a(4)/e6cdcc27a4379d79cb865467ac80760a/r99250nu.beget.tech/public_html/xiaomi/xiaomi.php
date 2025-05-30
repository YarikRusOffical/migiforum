<?php
session_start();
$user = $_SESSION['user'] ?? null;
$msg = $_SESSION['auth_msg'] ?? '';
$target = $_SESSION['auth_target'] ?? '';
unset($_SESSION['auth_msg'], $_SESSION['auth_target']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Каталог устройств — MigiForm</title>
  <link rel="icon" href="../mf-mini-logo.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      background-color: #11001c;
      color: #fff;
      font-family: 'Montserrat', sans-serif;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #1a092b;
      padding: 20px 40px;
      border-radius: 0 0 20px 20px;
    }
    .logo-container {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .logo img {
      height: 40px;
      display: block;
    }
    .back-button {
      font-size: 16px;
      color: #b38bfa;
      text-decoration: none;
      background: transparent;
      border: 1px solid #b38bfa;
      padding: 8px 14px;
      border-radius: 8px;
      transition: 0.3s;
    }
    .back-button:hover {
      background-color: #b38bfa;
      color: #1a092b;
    }
    .auth-buttons {
      display: flex;
      align-items: center;
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
    .brand-group {
      padding: 50px 40px;
    }
    .brand-title {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .device-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
    }
    .device-box {
      background: #2e1b4d;
      height: 300px;
      width: 230px;
      border-radius: 10px;
      margin: auto;
      transition: transform 0.2s, background 0.3s;
      cursor: pointer;
      text-align: center;
      padding: 10px;
    }
    .device-box:hover {
      transform: scale(1.05);
      background: #eee;
    }
    .device-box img {
      margin-top: 15px;
      width: 100%;
      max-height: 260px;
      object-fit: contain;
      border-radius: 8px 8px 0 0;
      transform: scale(1.30);
    }
    .device-box-name {
      margin-top: 15px;
      color: #fff;
      font-weight: 600;
      font-size: 24px;
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
      padding: 40px 30px;
      border-radius: 15px;
      width: 390px;
      color: #fff;
      box-shadow: 0 0 15px #000;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .modal-content input, .modal-content button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 7px;
      border: none;
    }
    .modal-content button {
      background: #444;
      color: #fff;
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
  <div class="logo-container">
    <a href="../index.php" class="logo"><img src="../mf-logo-glass.png" alt="MF"></a>
    <a href="../index.php" class="back-button">← Назад</a>
  </div>
  <div class="auth-buttons">
    <?php if ($user): ?>
      <span style="font-weight: bold;">Добро пожаловать, <?= htmlspecialchars($user['nickname']) ?>!</span>
      <a href="../logout.php" class="auth-button">Выход</a>
    <?php else: ?>
      <button class="auth-button" onclick="openModal('loginModal')">Вход</button>
      <button class="auth-button" onclick="openModal('registerModal')">Регистрация</button>
    <?php endif; ?>
  </div>
</header>

<?php
$brands = [
  "Xiaomi" => ["Mi 11", "Mi 10", "Mi Note 10", "Mi Mix 3", "Mi A3", "Mi 9 SE", "Mi 9T", "Mi Max 3"],
  "Redmi" => ["Redmi Note 12", "Redmi 10", "Redmi Note 10 Pro", "Redmi 9A", "Redmi 8", "Redmi 7", "Redmi 6A", "Redmi 5 Plus"],
  "Poco" => ["Poco X3 NFC", "Poco F3", "Poco M3", "Poco X4 Pro", "Poco F4", "Poco C3", "Poco M4 Pro", "Poco X5"]
];
foreach ($brands as $brand => $devices) {
  echo "<div class='brand-group'>
          <div class='brand-title'>$brand</div>
          <div class='device-grid'>";
  foreach ($devices as $device) {
    $slug = strtolower(str_replace([' ', '.'], ['-', ''], $device));
    $imgFile = $slug . ".png";
    echo "<a href='devices/$slug.php' class='device-box'>
            <img src='../xiaomi/img/devices/$imgFile' alt='$device'>
            <div class='device-box-name'>$device</div>
          </a>";
  }
  echo "</div></div>";
}
?>

<!-- Модальные окна -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
    <h2>Вход</h2>
    <?php if (!empty($msg) && $target === 'login'): ?><div class="auth-message"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="POST" action="../login.php">
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
    <?php if (!empty($msg) && $target === 'register'): ?><div class="auth-message"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="POST" action="../register.php">
      <input type="text" name="nickname" placeholder="Никнейм" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Зарегистрироваться</button>
    </form>
  </div>
</div>

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
  // Автооткрытие модального окна при ошибке
  <?php if (!empty($msg)): ?>
    window.onload = function () {
      openModal('<?= $target === 'register' ? 'registerModal' : 'loginModal' ?>');
    };
  <?php endif; ?>
</script>
</body>
</html>
