<?php

function solveEquation($equation) {
    // пробелы
    $equation = str_replace(' ', '', $equation);
    
    //! Разделение  уравнения на левую и правую части
    $parts = explode('=', $equation);
    if (count($parts) !== 2) {
        return "Ошибка: Некорректное уравнение";
    }
    
    $leftSide = $parts[0];
    $rightSide = $parts[1];
    
    // *Поиск оператора и переменной
    $operators = ['+', '-', '*', '/'];
    $operator = '';
    $operatorPos = -1;
    
    foreach ($operators as $op) {
        if (strpos($leftSide, $op) !== false) {
            $operator = $op;
            $operatorPos = strpos($leftSide, $op);
            break;
        }
    }
    
    if ($operator === '') {
        return "Ошибка: Оператор не найден";
    }
    
    //? Определяю части уравнения
    $leftParts = explode($operator, $leftSide);
    $variable = '';
    $number = '';
    
    //!Определяю, где находится переменная
    if (str_contains($leftParts[0], 'X')) {
        $variable = trim($leftParts[0]);
        $number = trim($leftParts[1]);
    } else {
        $number = trim($leftParts[0]);
        $variable = trim($leftParts[1]);
    }
    
    // Проверка, является ли правая часть числом
    if (!is_numeric($rightSide)) {
        return "Ошибка: Правая часть уравнения должна быть числом";
    }
    
    $result = 0;
    $number = (float)$number;
    $rightSide = (float)$rightSide;
    
    //! Решение уравнения в зависимости от оператора и положения переменной
    switch ($operator) {
        case '+':
            if ($variable === $leftParts[0]) {
                $result = $rightSide - $number; // X + number = rightSide
            } else {
                $result = $rightSide - $number; // number + X = rightSide
            }
            break;
        case '-':
            if ($variable === $leftParts[0]) {
                $result = $rightSide + $number; // X - number = rightSide
            } else {
                $result = $number - $rightSide; // number - X = rightSide
            }
            break;
        case '*':
            if ($variable === $leftParts[0]) {
                $result = $rightSide / $number; // X * number = rightSide
            } else {
                $result = $rightSide / $number; // number * X = rightSide
            }
            break;
        case '/':
            if ($variable === $leftParts[0]) {
                $result = $rightSide * $number; // X / number = rightSide
            } else {
                $result = $number / $rightSide; // number / X = rightSide
            }
            break;
    }
    
    return [
        'operator' => $operator,
        'variable_position' => ($variable === $leftParts[0] ? 'left' : 'right'),
        'result' => $result
    ];
}

// Тестирование с заданным уравнением
$equation = "10 + X = 33";
$result = solveEquation($equation);

echo "Уравнение: $equation\n";
echo "Оператор: " . $result['operator'] . "\n";
echo "Положение переменной: " . $result['variable_position'] . "\n";
echo "Значение X: " . $result['result'] . "\n";
?>
