<?php
function calculateTrig($function, $value) {
    // Преобразование градусов в радианы для тригонометрических функций PHP
    $radians = deg2rad($value);
    
    switch (strtolower($function)) {
        case 'sin':
            return sin($radians);
        case 'cos':
            return cos($radians);
        case 'tan':
            return tan($radians);
        case 'asin':
            return rad2deg(asin($value));
        case 'acos':
            return rad2deg(acos($value));
        case 'atan':
            return rad2deg(atan($value));
        default:
            throw new Exception("Недопустимая тригонометрическая функция: $function");
    }
}
?>
