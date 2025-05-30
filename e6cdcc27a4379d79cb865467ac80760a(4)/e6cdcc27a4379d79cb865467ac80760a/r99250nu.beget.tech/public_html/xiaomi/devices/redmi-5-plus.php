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
  <title>Redmi 5 Plus — MigiForm</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background-color: #11001c;
      color: #fff;
      transition: filter 0.5s ease;
    }
    a {
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
    .blurred #main-content {
      filter: blur(6px);
    }
    header {
      background-color: #1a092b;
      padding: 20px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-radius: 0 0 20px 20px;
    }
    .logo-container {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .logo img {
      height: 40px;
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
    .container {
      text-align: center;
      padding: 40px 20px;
    }
    .device-title {
      font-size: 36px;
      margin-bottom: 10px;
      font-weight: 600;
    }
    .device-image {
      width: 300px;
      margin: 20px auto;
    }
    .buttons {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 кнопки в ряд */
  gap: 24px;
  max-width: 800px;
  margin: 60px auto;
  padding: 30px;
  box-sizing: border-box;
}
    .buttons button {
  padding: 18px 24px;
  font-size: 17px;
  border: none;
  background-color: #2e1b4d;
  border-radius: 12px;
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  min-width: 0; /* чтобы кнопки не "вытягивались" */
}

.buttons button:hover {
  transform: scale(1.08);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
}
    .modal-button {
      background: #2e1b4d;
      border: none;
      padding: 20px 22px;
      font-size: 14px;
      font-weight: 600;
      font-family: 'Montserrat', sans-serif;
      border-radius: 10px;
      color: white;
      cursor: pointer;
      transition: transform 0.3s ease;
      position: relative;
      z-index: 1;
    }
    .modal-button:hover {
      background: #eee;
      color: #000;
      transform: scale(1.05);
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
    .tabs {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  margin-bottom: 20px;
}
.tab {
  background-color: #404040;
  padding: 10px;
  text-align: center;
  cursor: pointer;
  border-radius: 5px;
}
.tab.active {
  background-color: #888;
}
    .tab-content {
      display: none;
    }
    .tab-content.active {
      display: block;
    }
    .tab-content a {
      display: block;
      color: #b38bfa;
      margin-bottom: 8px;
      text-decoration: none;
    }
  </style>
</head>
<body>
<header>
  <div class="logo-container">
    <a href="/index.php" class="logo"><img src="/mf-logo-glass.png" alt="MF"></a>
    <a href="../xiaomi.php" class="back-button">← Назад</a>
  </div>
  <div class="auth-buttons">
    <?php if ($user): ?>
      <span style="font-weight: bold;">Добро пожаловать, <?= htmlspecialchars($user['nickname']) ?>!</span>
      <a href="/logout.php" class="auth-button">Выход</a>
    <?php else: ?>
      <button class="auth-button" onclick="openModal('loginModal')">Вход</button>
      <button class="auth-button" onclick="openModal('registerModal')">Регистрация</button>
    <?php endif; ?>
  </div>
</header>
<div class="container">
  <div class="device-title">Redmi 5 Plus</div>
  <img src="/xiaomi/img/devices/redmi-5-plus.png" class="device-image" alt="Redmi 5 Plus">
  <div class="buttons">
    <button class="modal-button" onclick="openDeviceModal('roms')">Прошивки</button>
    <button class="modal-button" onclick="openDeviceModal('gapps')">GApps</button>
    <button class="modal-button" onclick="openDeviceModal('kernels')">Ядра</button>
    <button class="modal-button" onclick="openDeviceModal('guides')">Инструкции</button>
    <button class="modal-button" onclick="openDeviceModal('recovery')">Рекавери</button>
    <button class="modal-button" onclick="openDeviceModal('useful')">Полезное</button>
    <button class="modal-button" onclick="openDeviceModal('characteristics')">Характеристики</button>
    <a class="modal-button" href="http://r99250nu.beget.tech/forum/xiaomi/redmi-5-plus/xxxxxx/XXX" target="_blank">Обсудить на форуме</a>
    <button class="modal-button" onclick="openDeviceModal('reviews')">Отзывы</button>
    <!-- xxxxxx - номер страницы, XXX - номер поста -->
  </div>
</div>
<div id="deviceModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('deviceModal')">×</span>
    <div id="modal-content-wrapper"></div>
  </div>
</div>
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('loginModal')">×</span>
    <h2>Вход</h2>
    <?php if (!empty($msg) && $target === 'login'): ?><div class="auth-message"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="POST" action="/login.php">
      <input type="text" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Войти</button>
    </form>
  </div>
</div>
<div id="registerModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('registerModal')">×</span>
    <h2>Регистрация</h2>
    <?php if (!empty($msg) && $target === 'register'): ?><div class="auth-message"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="POST" action="/register.php">
      <input type="text" name="nickname" placeholder="Никнейм" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Зарегистрироваться</button>
    </form>
  </div>
</div>
<script>
  function showTab(id) {
  // Удалить класс active у всех табов и контента
  document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
  document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));

  // Назначить active для нужного контента
  const content = document.getElementById(id);
  if (content) content.classList.add('active');

  // Назначить active для соответствующей вкладки
  document.querySelectorAll('.tab').forEach(tab => {
    if (tab.getAttribute('onclick')?.includes(id)) {
      tab.classList.add('active');
    }
  });
}

  function getContent(type) {
    if (type === 'roms') {
      return `
        <h3>Прошивки</h3>
        <div class="tabs">
          <div class="tab active" onclick="showTab('a13')">Android 13</div>
          <div class="tab" onclick="showTab('a14')">Android 14</div>
          <div class="tab" onclick="showTab('a15')">Android 15</div>
        </div>
        <div id="a13" class="tab-content active">
          <a href="redmi-5-plus/android-13/PixelExperience-13">• PixelExperience 13</a>
          <a href="redmi-5-plus/android-13/crDroid-8.9">• crDroid 8.9</a>
        </div>
        <div id="a14" class="tab-content">
          <a href="redmi-5-plus/android-14/EvolutionX-14">• EvolutionX 14</a>
          <a href="redmi-5-plus/android-14/LineageOS-21">• LineageOS 21</a>
        </div>
        <div id="a15" class="tab-content">
          <a href="redmi-5-plus/android-15/AOSP-15">• AOSP 15</a>
          <a href="redmi-5-plus/android-15/ArrowOS-15">• ArrowOS 15</a>
        </div>
      `;
    }
    if (type === 'gapps') {
  return `
    <h3>GApps</h3>
    <div class="tabs">
      <div class="tab active" onclick="showTab('opengapps')">OpenGapps</div>
      <div class="tab" onclick="showTab('nikgapps')">NikGapps</div>
      <div class="tab" onclick="showTab('bitgapps')">BitGapps</div>
    </div>
    <div id="opengapps" class="tab-content active">
      <p><strong>OpenGapps</strong> — подойдет для 5-11 Android</p>
      <a href="https://opengapps.org" target="_blank">Скачать OpenGapps</a>
    </div>
    <div id="nikgapps" class="tab-content">
      <p><strong>NikGapps</strong> — подходит для 10-15 Android.</p>
      <a href="https://nikgapps.com" target="_blank">Скачать NikGapps</a>
    </div>
    <div id="bitgapps" class="tab-content">
      <p><strong>BitGapps</strong> — подходит для 7.1.1-15 Android.</p>
      <a href="https://bitgapps.io/" target="_blank">Скачать BitGapps</a>
    </div>
  `;
}
    if (type === 'kernels') return '<h3>Ядра</h3><p>Скоро список кастомных ядер.</p>';
    if (type === 'guides') return '<h3>Инструкции</h3><p>Полезные инструкции по установке.</p>';
    if (type === 'recovery') return '<h3>Рекавери</h3><p>Тврп или лиса?</p>';
    if (type === 'characteristics') {
  return `
    <h3>Характеристики</h3>
    <div class="tabs">
      <div class="tab active" onclick="showTab('base')">Основное</div>
      <div class="tab" onclick="showTab('cpu')">Процессор</div>
      <div class="tab" onclick="showTab('memory')">Память</div>
      <div class="tab" onclick="showTab('camera')">Камера</div>
    </div>
    <div id="base" class="tab-content active">
      <p>Ширина — 75.5 мм</p>
      <p>Высота — 158.5 мм</p>
      <p>Толщина - 8.1 мм</p>
      <p>Вес - 180 г</p>
      <p>Идентифицируется как - обычный размер (не считается ни лопатой, ни компактом)</p>
    </div>
    <div id="cpu" class="tab-content">
      <p>Процессор - Snapdragon 625</p>
      <p>Ядер и частота - 8 ядер на 2 ГГц</p>
      <p>Графика - Adreno 506</p>
      <p>Техпроцесс - 14 нм</p>
      <p>Antutu v9 на стоке - 124978 баллов</p>
    </div>
    <div id="memory" class="tab-content">
      <p>Встроенная память - 32/64 ГБ</p>
      <p>Оперативная память - 3/4 ГБ</p>
      <p>Максимальный объём SD-карты - 128 ГБ</p>
    </div>
    <div id="camera" class="tab-content">
      <p>Основная камера — 12 МП, f/2.2, 1.25µm, PDAF</p>
      <p>Видео основное — до 4K@30fps, FullHD@30fps</p>
      <p>Фронтальная камера — 5 МП, f/2.0</p>
      <p>Вспышка — одинарная светодиодная</p>
      <p>Доп. возможности — HDR, панорама, распознавание лиц</p>
    </div>
  `;
}
    return '';
  }

  function openModal(id) {
    const modal = document.getElementById(id);
    modal.style.display = 'flex';
    setTimeout(() => {
      modal.style.opacity = '1';
      modal.style.pointerEvents = 'auto';
    }, 10);
  }

  function openDeviceModal(type) {
    const modal = document.getElementById('deviceModal');
    const content = document.getElementById('modal-content-wrapper');
    content.innerHTML = getContent(type);
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

  <?php if (!empty($msg)): ?>
    window.onload = function () {
      openModal('<?= $target === 'register' ? 'registerModal' : 'loginModal' ?>');
    };
  <?php endif; ?>
</script>
</body>
</html>
