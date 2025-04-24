<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'hypotenuse.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вычисление гипотенузы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="logo.png" alt="Логотип МосПолитеха" class="logo">
            <h1>Домашняя работа: Вычисление гипотенузы (Лабораторная работа №1.1)</h1>
        </div>
    </header>
    <main>
        <div class="content">
            <h2>Результат вычисления</h2>
            <p>Гипотенуза треугольника с катетами a = 27 и b = 12 равна: <span id="hypotenuse"><?php echo $hypotenuse_formatted; ?></span></p>
        </div>
    </main>
    <footer>
        <p>Задание для самостоятельной работы</p>
    </footer>
</body>
</html>
