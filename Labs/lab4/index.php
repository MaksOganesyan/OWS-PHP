<?php

// Решение задачи 1
// Дана строка вида 'a1b2c3'. Найти все цифры и удвоить их количество: 'a11b22c33'.
// Используем preg_replace с шаблоном \d для поиска цифр и заменяем каждую цифру на две таких же (\0\0).
$text = "a1b2c3";
$result = preg_replace('/\d/', '\0\0', $text);
echo "Задача 1: $result\n"; // Вывод: a11b22c33

// Решение задачи 2
// Определить, что строка является доменом вида http://site.ru или https://site.ru.
// Шаблон: ^https?://[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$ — проверяет протокол (http или https), имя домена и зону.
function isValidDomain($string) {
    $pattern = '/^https?:\/\/[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/';
    return preg_match($pattern, $string) === 1;
}
$tests2 = [
    "http://site.ru",
    "https://site.ru",
    "http://example.com",
    "ftp://site.ru",
    "https://site",
    "http://site.ru/",
];
echo "\nЗадача 2:\n";
foreach ($tests2 as $test) {
    echo "$test: " . (isValidDomain($test) ? "Valid" : "Invalid") . "\n";
}

// Решение задачи 3
// Определить, что строка является доменом с протоколом http (не https).
// Шаблон: ^http://[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$ — строго http, затем имя домена и зона.
function isHttpDomain($string) {
    $pattern = '/^http:\/\/[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/';
    return preg_match($pattern, $string) === 1;
}
$tests3 = [
    "http://site.ru",
    "http://site.com",
    "https://site.ru",
    "http://my-site123.com",
    "http://site",
    "http://site.ru/",
];
echo "\nЗадача 3:\n";
foreach ($tests3 as $test) {
    echo "$test: " . (isHttpDomain($test) ? "Valid" : "Invalid") . "\n";
}

// Решение задачи 4
// Определить, что строка является доменом 3-го уровня (например, hello.site.ru).
// Шаблон: ^[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$ — поддомен, домен, зона.
function isThirdLevelDomain($string) {
    $pattern = '/^[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/';
    return preg_match($pattern, $string) === 1;
}
$tests4 = [
    "hello.site.ru",
    "hello.site.com",
    "hello.my-site.com",
    "site.ru",
    "sub.sub.sub.com",
    "hello.site",
];
echo "\nЗадача 4:\n";
foreach ($tests4 as $test) {
    echo "$test: " . (isThirdLevelDomain($test) ? "Valid" : "Invalid") . "\n";
}

// Решение задачи 5
// Определить, что строка является доменом (например, site.ru, site.com).
// Шаблон: ^[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$ — имя домена и зона, без протокола.
function isDomain($string) {
    $pattern = '/^[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/';
    return preg_match($pattern, $string) === 1;
}
$tests5 = [
    "site.ru",
    "site.com",
    "my-site123.com",
    "hello.site.ru",
    "site",
    "site.ru/",
];
echo "\nЗадача 5:\n";
foreach ($tests5 as $test) {
    echo "$test: " . (isDomain($test) ? "Valid" : "Invalid") . "\n";
}
?>
