<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP File and String Operations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header-container">
        <img src="logo.png" alt="Logo" class="logo">
            <h1>Лабораторная работа №3.1</h1>
        
    </header>

    <main>
        <div class="content">
            <h2>Задачи</h2>

            <!-- Задача 1: Преобразование каждого второго слова -->
            <h3>1. Преобразование каждого второго слова в заглавные буквы</h3>
            <form method="POST">
                <input type="text" name="input_text" placeholder="Введите текст" value="<?php echo isset($_POST['input_text']) ? htmlspecialchars($_POST['input_text']) : ''; ?>">
                <input type="submit" value="Отправить">
            </form>
            <?php
            function convertSecondWordToUpper(&$words) {
                foreach ($words as $key => &$word) {
                    if (($key + 1) % 2 == 0) {
                        $word = strtoupper($word);
                    }
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['input_text'])) {
                $input = trim($_POST['input_text']);
                $words = explode(' ', $input);
                convertSecondWordToUpper($words);
                $result = implode(' ', $words);
                echo "<pre>Результат: $result</pre>";
            }
            ?>

            <!-- Задача 2: Запись в файл test.txt -->
            <h3>2. Запись текста '12345' в файл test.txt</h3>
            <?php
            $filename = 'test.txt';
            file_put_contents($filename, '12345');
            echo "<pre>Текст '12345' записан в $filename</pre>";
            ?>

            <!-- Задача 3: Объединение содержимого файлов в new.txt -->
            <h3>3. Объединение содержимого файлов 1.txt, 2.txt, 3.txt в new.txt</h3>
            <?php
            $files = ['1.txt', '2.txt', '3.txt'];
            $combined_content = '';
            foreach ($files as $file) {
                if (file_exists($file)) {
                    $combined_content .= file_get_contents($file);
                } else {
                    echo "<pre>Файл $file не существует</pre>";
                }
            }
            if ($combined_content !== '') {
                file_put_contents('new.txt', $combined_content);
                echo "<pre>Содержимое объединено и записано в new.txt</pre>";
            }
            ?>

            <!-- Задача 4: Добавление восклицательного знака в файлы -->
            <h3>4. Добавление '!' в конец файлов 1.txt, 2.txt, 3.txt</h3>
            <?php
            $files = ['1.txt', '2.txt', '3.txt'];
            foreach ($files as $file) {
                if (file_exists($file)) {
                    $content = file_get_contents($file);
                    file_put_contents($file, $content . '!');
                    echo "<pre>В файл $file добавлен '!'</pre>";
                } else {
                    echo "<pre>Файл $file не существует</pre>";
                }
            }
            ?>

            <!-- Задача 5: Счетчик в файле count.txt -->
            <h3>5. Счетчик обновлений страницы в count.txt</h3>
            <?php
            $counter_file = 'count.txt';
            if (!file_exists($counter_file)) {
                file_put_contents($counter_file, '0');
            }
            $count = (int)file_get_contents($counter_file);
            $count++;
            file_put_contents($counter_file, $count);
            echo "<pre>Текущее значение счетчика: $count</pre>";
            ?>
        </div>
    </main>

    <footer>
        <p>© 2025 Примеры PHP</p>
    </footer>
</body>
</html>
