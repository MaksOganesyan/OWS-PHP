<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Part 1: Calculate hypotenuse
$a = 27; // First cathetus
$b = 12; // Second cathetus
$hypotenuse = sqrt($a * $a + $b * $b);
$hypotenuse_formatted = number_format($hypotenuse, 2, '.', '');

// Part 2: Calculate second cathetus
$hypotenuse_input = 27; // Hypotenuse
$first_cathetus = 12; // First cathetus
$second_cathetus = sqrt($hypotenuse_input * $hypotenuse_input - $first_cathetus * $first_cathetus);
$second_cathetus_formatted = number_format($second_cathetus, 2, '.', '');
?>
