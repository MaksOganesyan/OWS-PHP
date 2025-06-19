<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Array Functions</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header-container">
        <img src="logo.png" alt="Logo" class="logo">
        <h1>Лабораторная работа №2.1</h1>
    </header>

    <main>
        <div class="content">
            <h2>Задачи с массивами</h2>

            <?php
            // Задача 1: Подсчет количества каждой буквы
            echo "<h3>1. Подсчет количества букв (array_count_values)</h3>";
            $array1 = ['a', 'b', 'c', 'b', 'a'];
            $result1 = array_count_values($array1);
            echo "<pre>";
            print_r($result1);
            echo "</pre>";

            // Задача 2: Поменять местами ключи и значения
            echo "<h3>2. Поменять ключи и значения (array_flip)</h3>";
            $array2 = ['a' => 1, 'b' => 2, 'c' => 3];
            $result2 = array_flip($array2);
            echo "<pre>";
            print_r($result2);
            echo "</pre>";

            // Задача 3: Перевернуть массив
            echo "<h3>3. Перевернуть массив (array_reverse)</h3>";
            $array3 = [1, 2, 3, 4, 5];
            $result3 = array_reverse($array3);
            echo "<pre>";
            print_r($result3);
            echo "</pre>";

            // Задача 4: Создать ассоциативный массив
            echo "<h3>4. Создать ассоциативный массив (array_combine)</h3>";
            $keys = ['a', 'b', 'c'];
            $values = [1, 2, 3];
            $result4 = array_combine($keys, $values);
            echo "<pre>";
            print_r($result4);
            echo "</pre>";

            // Задача 5: Разделить ключи и значения
            echo "<h3>5. Разделить ключи и значения (array_keys, array_values)</h3>";
            $array5 = ['a' => 1, 'b' => 2, 'c' => 3];
            $keys5 = array_keys($array5);
            $values5 = array_values($array5);
            echo "<strong>Ключи:</strong><pre>";
            print_r($keys5);
            echo "</pre>";
            echo "<strong>Значения:</strong><pre>";
            print_r($values5);
            echo "</pre>";
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; Задание для самостоятельной работы</p>
    </footer>
</body>

</html>
