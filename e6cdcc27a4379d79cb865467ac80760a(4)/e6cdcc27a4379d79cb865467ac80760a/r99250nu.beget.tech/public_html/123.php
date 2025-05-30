<?php
session_start();
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>MigiForm - Xiaomi</title>
  <style>
    body {
      background-color: #11001c;
      color: #d6d6d6;
      font-family: 'Montserrat', sans-serif;
      font-size: 25px;
      line-height: 1.0;
      padding: 30px;
      margin: 0;
    }

    .tab {
      display: inline-block;
      margin: 0px;
      padding: 10px 20px;
      background-color: #616161;
      color: #ccc;
      text-decoration: none;
      cursor: pointer;
      font-size: 25px;
      border-radius: 10px 10px 0 0;
      transition: background-color 0.3s;
      border: 1px solid #ccc;
      border-bottom: none;
    }

    .tab:hover {
      background-color: #363636;
    }

    .active {
      background-color: #262626;
      font-weight: bold;
    }

    .content {
      background-color: #000;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 0 10px 10px 10px;
      display: none;
    }

    .active-content {
      display: block;
    }

    .section-header {
      font-weight: bold;
      font-size: 28px;
      padding-bottom: 10px;
      margin-bottom: 15px;
      background-color: #2e2e2e;
      padding: 10px;
      border-radius: 10px;
      color: #ddd;
    }

    .fw-button {
      display: inline-block;
      margin: 5px;
      padding: 10px 15px;
      background-color: #2e2e2e;
      color: #ccc;
      border: 1px solid #ccc;
      cursor: pointer;
      border-radius: 10px;
      transition: background-color 0.3s;
      font-size: 18px;
      font-family: 'Montserrat', sans-serif;
      text-align: center;
    }

    .fw-button:hover {
      background-color: #444;
    }

    .android-selection {
      display: none;
      margin-top: 10px;
    }

    a {
      color: #d6d6d6;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    #backButton {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #616161;
      color: #000;
      text-decoration: none;
      border: none;
      cursor: pointer;
      font-size: 25px;
      border-radius: 10px;
      transition: background-color 0.3s;
    }

    #backButton:hover {
      background-color: #d0cfcf;
    }

    .auth-buttons {
      position: absolute;
      top: 20px;
      right: 30px;
      display: flex;
      gap: 10px;
      z-index: 10;
    }

    .auth-button {
      background: linear-gradient(to right, #444, #2c2c2c);
      color: #f0f0f0;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-size: 16px;
      font-family: 'Montserrat', sans-serif;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    .auth-button:hover {
      background: linear-gradient(to right, #666, #444);
      transform: translateY(-2px);
    }

    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
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
      border-radius: 10px;
      width: 300px;
      color: #fff;
      box-shadow: 0 0 15px #000;
    }

    .modal-content input {
      width: 100%;
      padding: 8px;
      margin: 8px 0;
      border-radius: 5px;
      border: none;
    }

    .modal-content button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      background: #444;
      border: none;
      color: #fff;
      border-radius: 5px;
      cursor: pointer;
    }

    .close-btn {
      float: right;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="auth-buttons">
    <?php if ($user): ?>
      <div style="color: #ccc; display: flex; align-items: center; gap: 10px;">
        Добро пожаловать, <?= htmlspecialchars($user['nickname']) ?>!
        <a href="logout.php" class="auth-button" style="background: #800;">Выход</a>
      </div>
    <?php else: ?>
      <button class="auth-button" onclick="openModal('loginModal')">Вход</button>
      <button class="auth-button" onclick="openModal('registerModal')">Регистрация</button>
    <?php endif; ?>
  </div>

  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
      <h2>Вход</h2>
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
      <form method="POST" action="register.php">
        <input type="text" name="nickname" placeholder="Никнейм" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
      </form>
    </div>
  </div>

  <div>
    <div class="tab active" onclick="showContent('redmi5plus')">Redmi 5 Plus</div>
    <div class="tab" onclick="showContent('redmi9a')">Redmi 9A</div>
    <div class="tab" onclick="showContent('redmiNote10pro')">Redmi Note 10 Pro</div>
    <div class="tab" onclick="showContent('redmi4x')">Redmi 4X</div>
    <div class="tab" onclick="showContent('mi9tpro')">Mi 9T Pro</div>
  </div>

  <script>
    const devices = [
      { id: "redmi5plus", name: "Redmi 5 Plus" },
      { id: "redmi9a", name: "Redmi 9a" },
      { id: "redmiNote10pro", name: "Redmi Note 10 Pro" },
      { id: "redmi4x", name: "Redmi 4X" },
      { id: "mi9tpro", name: "Mi 9T Pro" },
    ];

    function createDeviceBlock(device) {
      document.write(`
      <div id="${device.id}" class="content ${device.id === 'redmi5plus' ? 'active-content' : ''}">
        <div class="section-header">${device.name}</div>
        <p>Контент для ${device.name}.</p>
        <div class="button-group">
          <div class="fw-button" onclick="toggleAndroidOptions('androidOptions${device.id}')">Прошивки</div>
          <div class="fw-button" onclick="showRecoveryOptions('rec${device.id}')">Recovery</div>
          <div class="fw-button" onclick="showRecoveryOptions('guide${device.id}')">Инструкции</div>
          <a class="fw-button" href="https://migiforum.tech/forum/${device.id}" target="_blank">Форум</a>
        </div>
        <div id="androidOptions${device.id}" class="android-selection">
          <div class="fw-button" onclick="showFirmware('android13${device.id}')">Android 13</div>
          <div class="fw-button" onclick="showFirmware('android15${device.id}')">Android 15</div>
        </div>
        <div id="android13${device.id}" class="fw-options" style="display: none;">
          <p>•<a href="#">Прошивка 1 для ${device.name} (Android 13)</a></p>
        </div>
        <div id="android15${device.id}" class="fw-options" style="display: none;">
          <p>•<a href="#">Прошивка 1 для ${device.name} (Android 15)</a></p>
        </div>
        <div id="rec${device.id}" class="fw-options" style="display: none;">
          <p>•<a href="#">Recovery 1</a></p>
        </div>
        <div id="guide${device.id}" class="fw-options" style="display: none;">
          <p>•<a href="#">Инструкция 1</a></p>
        </div>
      </div>
      `);
    }

    devices.forEach(createDeviceBlock);

    function showContent(tabId) {
      document.querySelectorAll('.content').forEach(c => c.classList.remove('active-content'));
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      document.getElementById(tabId).classList.add('active-content');
      const activeTab = Array.from(document.querySelectorAll('.tab')).find(t => t.getAttribute("onclick").includes(tabId));
      if (activeTab) activeTab.classList.add('active');
    }

    function toggleAndroidOptions(id) {
      document.querySelectorAll('.android-selection').forEach(e => e.style.display = 'none');
      const el = document.getElementById(id);
      el.style.display = el.style.display === 'block' ? 'none' : 'block';
      document.querySelectorAll('.fw-options').forEach(e => e.style.display = 'none');
    }

    function showFirmware(id) {
      document.querySelectorAll('.fw-options').forEach(e => e.style.display = 'none');
      document.getElementById(id).style.display = 'block';
    }

    function showRecoveryOptions(id) {
      document.querySelectorAll('.fw-options').forEach(e => e.style.display = 'none');
      document.querySelectorAll('.android-selection').forEach(e => e.style.display = 'none');
      document.getElementById(id).style.display = 'block';
    }

    function openModal(id) {Ы
      document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
      document.getElementById(id).style.display = 'none';
    }

    function goToHomePage() {
      window.location.href = 'Firmware-catalog.html';
    }
  </script>

  <button id="backButton" onclick="goToHomePage()">Назад</button>
</body>
</html>