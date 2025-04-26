<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$a = 27; // Гипотенуза
$b = 12; // Первый катет
$second_cathetus = sqrt($a * $a - $b * $b); // Второй катет
$second_cathetus_formatted = number_format($second_cathetus, 2, '.', ''); // Форматирование до 2 знаков
?>
