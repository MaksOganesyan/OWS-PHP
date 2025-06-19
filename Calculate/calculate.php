<?php
require_once 'trigonometric.php';

// Улучшенная валидация
function validateExpression($expression) {
    // Усиленная очистка строки
    $expression = preg_replace('/[\x00-\x1F\x7F-\xFF]/u', '', $expression);
    $expression = trim($expression, " \t\n\r\0\x0B\xC2\xA0");

    // Пустое выражение
    if (empty($expression)) {
        return "Ошибка: Пустое выражение";
    }

    // Проверка допустимых символов (добавлены тригонометрические функции)
    if (!preg_match('/^[0-9+\-*\/\(\)a-zA-Z]+$/', $expression)) {
        return "Ошибка: Недопустимые символы в выражении";
    }

    // Проверка баланса скобок
    $stack = [];
    for ($i = 0; $i < strlen($expression); $i++) {
        if ($expression[$i] === '(') {
            array_push($stack, '(');
        } elseif ($expression[$i] === ')') {
            if (empty($stack)) {
                return "Ошибка: Несогласованная закрывающая скобка";
            }
            array_pop($stack);
        }
    }
    if (!empty($stack)) {
        return "Ошибка: Несогласованная открывающая скобка";
    }

    // Проверка на два оператора подряд
    if (preg_match('/[\+\-\*\/]{2,}/', $expression)) {
        return "Ошибка: Последовательные операторы";
    }

    // Проверка на оператор в начале или конце
    if (preg_match('/^[\+\*\/]/', $expression) || preg_match('/[\+\-\*\/]$/', $expression)) {
        return "Ошибка: Оператор в начале или конце";
    }

    return true;
}

function tokenize($expression) {
    $tokens = [];
    $number = '';
    $function = '';
    $expression = str_replace(' ', '', $expression);
    
    for ($i = 0; $i < strlen($expression); $i++) {
        $char = $expression[$i];
        
        if (is_numeric($char) || $char === '.') {
            $number .= $char;
        } elseif (ctype_alpha($char)) {
            $function .= $char;
        } else {
            if ($number !== '') {
                $tokens[] = (float)$number;
                $number = '';
            }
            if ($function !== '') {
                $tokens[] = $function;
                $function = '';
            }
            if (in_array($char, ['+', '-', '*', '/', '(', ')'])) {
                $tokens[] = $char;
            }
        }
    }
    
    if ($number !== '') {
        $tokens[] = (float)$number;
    }
    if ($function !== '') {
        $tokens[] = $function;
    }
    
    return $tokens;
}

function getPrecedence($operator) {
    switch ($operator) {
        case '+':
        case '-':
            return 1;
        case '*':
        case '/':
            return 2;
        case 'sin':
        case 'cos':
        case 'tan':
        case 'asin':
        case 'acos':
        case 'atan':
            return 3;
        default:
            return 0;
    }
}

function applyOperator($a, $b, $operator) {
    if (in_array($operator, ['sin', 'cos', 'tan', 'asin', 'acos', 'atan'])) {
        return calculateTrig($operator, $b);
    }
    
    switch ($operator) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            if ($b == 0) {
                throw new Exception("Деление на ноль");
            }
            return $a / $b;
        default:
            throw new Exception("Недопустимый оператор");
    }
}

function evaluate($tokens, &$index) {
    $values = [];
    $operators = [];
    
    while ($index < count($tokens)) {
        $token = $tokens[$index];
        
        if (is_numeric($token)) {
            array_push($values, $token);
        } elseif ($token === '(') {
            $index++;
            $result = evaluate($tokens, $index);
            array_push($values, $result);
        } elseif ($token === ')') {
            break;
        } elseif (in_array($token, ['+', '-', '*', '/', 'sin', 'cos', 'tan', 'asin', 'acos', 'atan', '(', ')'])) {
            while (!empty($operators) && 
                   getPrecedence(end($operators)) >= getPrecedence($token)) {
                $op = array_pop($operators);
                if (in_array($op, ['sin', 'cos', 'tan', 'asin', 'acos', 'atan'])) {
                    $b = array_pop($values);
                    array_push($values, applyOperator(null, $b, $op));
                } else {
                    $b = array_pop($values);
                    $a = array_pop($values);
                    array_push($values, applyOperator($a, $b, $op));
                }
            }
            array_push($operators, $token);
        }
        $index++;
    }
    
    while (!empty($operators)) {
        $op = array_pop($operators);
        if (in_array($op, ['sin', 'cos', 'tan', 'asin', 'acos', 'atan'])) {
            $b = array_pop($values);
            array_push($values, applyOperator(null, $b, $op));
        } else {
            $b = array_pop($values);
            $a = array_pop($values);
            array_push($values, applyOperator($a, $b, $op));
        }
    }
    
    return $values[0];
}

// Обработка POST-запроса и чтение из файла
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expression = isset($_POST['expression']) ? $_POST['expression'] : '';
} else {
    $expression = @file_get_contents('Task/expression.txt');
    if ($expression === false) {
        echo "Ошибка: Не удалось прочитать expression.txt";
        exit();
    }
}

// Усиленная очистка строки
$expression = preg_replace('/[\x00-\x1F\x7F-\xFF]/u', '', $expression);
$expression = trim($expression, " \t\n\r\0\x0B\xC2\xA0");

$validationResult = validateExpression($expression);
if ($validationResult !== true) {
    // Логирование символов для диагностики
    $charDebug = 'Символы: ';
    for ($i = 0; $i < strlen($expression); $i++) {
        $charDebug .= $expression[$i] . '(' . ord($expression[$i]) . ') ';
    }
    echo $validationResult . ' [' . $charDebug . ']';
    exit();
}

try {
    $tokens = tokenize($expression);
    $index = 0;
    $result = evaluate($tokens, $index);
    echo $result;
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
exit();
?>
