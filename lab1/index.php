<?php
$greeting = "Hello, World!";
$currentTime = date("H:i:s");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, World!</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="logo.png" alt="Логотип МосПолитеха" class="logo">
            <h1>Самостоятельная работа: Hello, World!</h1>
        </div>
    </header>
    <main>
        <div class="content">
            <h2><?php echo $greeting; ?></h2>
            <p>Текущее время: <span id="time"><?php echo $currentTime; ?></span></p>
            <script>
                setInterval(() => {
                    const timeElement = document.getElementById('time');
                    const now = new Date();
                    timeElement.textContent = now.toLocaleTimeString('ru-RU');
                }, 1000);
            </script>
        </div>
    </main>
    <footer>
        <p>Задание для самостоятельной работы</p>
    </footer>
</body>
</html>
