<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<title>Страница не найдена</title>
<style>
  body {
    background-color: #11001c;
    font-family: 'Montserrat', sans-serif;
    font-size: 25px;
    color: #d6d6d6;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
  }

  h1 {
    font-size: 36px;
    margin-bottom: 20px;
  }

  p {
    font-size: 25px;
    margin-bottom: 20px;
  }

  #redirectBtn {
    padding: 20px 30px;
    font-size: 25px;
    border-radius: 10px;
    border: none;
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
  }

  #redirectBtn:hover {
    background-color: #45a049;
    transform: scale(1.05);
  }

  #countdown {
    font-weight: bold;
    margin-top: 10px;
  }
</style>
<script>
const delaySeconds = 5;
let remainingSeconds = delaySeconds;

const rand = Math.random();

let redirectUrl;

if (rand < 0.025) {
  redirectUrl = "https://www.youtube.com/watch?v=dQw4w9WgXcQ"; // 🎣 Rickroll
} else if (rand < 0.05) {
  redirectUrl = "https://rutube.ru/video/f3b615db135287a64584737e664e1e4b/"; // рикролл
} else {
  redirectUrl = "/index.php"; // 🏠 Обычный переход
}

function updateCountdown() {
  document.getElementById('countdown').textContent =
    `Перенаправление через ${remainingSeconds} секунд...`;
}

function startCountdown() {
  updateCountdown();
  
  const intervalId = setInterval(() => {
    remainingSeconds--;
    if (remainingSeconds > 0) {
      updateCountdown();
    } else {
      clearInterval(intervalId);
      window.location.href = redirectUrl;
    }
  }, 1000);
}

function goHome() {
  window.location.href = redirectUrl;
}

window.onload = startCountdown;
</script>
</head>
<body>
<h1>Упс... этой страницы не существует (404)</h1>
<p>Вы будете перенаправлены через несколько секунд...</p>
<div id="countdown"></div>
<button id="redirectBtn" onclick="goHome()">Перейти на главную</button>
</body>
</html>