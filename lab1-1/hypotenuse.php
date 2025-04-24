<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$a = 27;
$b = 12;
$hypotenuse = sqrt($a * $a + $b * $b);
$hypotenuse_formatted = number_format($hypotenuse, 2, '.', '');
?>
