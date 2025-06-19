<?php
header('Content-Type: text/html; charset=UTF-8');

// Функция для получения заголовков
function get_headers_custom() {
    $headers = getallheaders();
    return $headers ? $headers : ['Info' => 'Заголовки не найдены'];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заголовки запроса</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Логотип МосПолитеха">
        <h1>Заголовки запроса</h1>
        <div></div>
    </header>
    <main>
        <h2>Результат функции get_headers</h2>
        <textarea readonly><?php
            $headers = get_headers_custom();
            foreach ($headers as $key => $value) {
                echo htmlspecialchars("$key: $value\n");
            }
        ?></textarea>
    </main>
    <footer>
        Задание для самостоятельной работы
    </footer>
</body>
</html>
