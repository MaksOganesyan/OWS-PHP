<?php
// Улучшенная валидация
function validateExpression($expression) {
    // Усиленная очистка строки
    $expression = preg_replace('/[\x00-\x1F\x7F-\xFF]/u', '', $expression);
    $expression = trim($expression, " \t\n\r\0\x0B\xC2\xA0");

    // Пустое выражение
    if (empty($expression)) {
        return "Error: Empty expression";
    }

    // Проверка допустимых символов (исправлено экранирование скобок)
    if (!preg_match('/^[0-9+\-*\/\(\)]+$/', $expression)) {
        return "Error: Invalid characters in expression";
    }

    // Проверка баланса скобок
    $stack = [];
    for ($i = 0; $i < strlen($expression); $i++) {
        if ($expression[$i] === '(') {
            array_push($stack, '(');
        } elseif ($expression[$i] === ')') {
            if (empty($stack)) {
                return "Error: Unmatched closing parenthesis";
            }
            array_pop($stack);
        }
    }
    if (!empty($stack)) {
        return "Error: Unmatched opening parenthesis";
    }

    // Проверка на два оператора подряд
    if (preg_match('/[\+\-\*\/]{2,}/', $expression)) {
        return "Error: Consecutive operators";
    }

    // Проверка на оператор в начале или конце
    if (preg_match('/^[\+\*\/]/', $expression) || preg_match('/[\+\-\*\/]$/', $expression)) {
        return "Error: Operator at start or end";
    }

    // Проверка минимальной структуры (число-оператор-число)
    if (!preg_match('/[0-9]+[\+\-\*\/][0-9]+/', $expression)) {
        return "Error: Invalid expression structure (requires number-operator-number)";
    }

    return true;
}

function tokenize($expression) {
    $tokens = [];
    $number = '';
    $expression = str_replace(' ', '', $expression);
    for ($i = 0; $i < strlen($expression); $i++) {
        $char = $expression[$i];
        if (is_numeric($char)) {
            $number .= $char;
        } else {
            if ($number !== '') {
                $tokens[] = (float)$number;
                $number = '';
            }
            if (in_array($char, ['+', '-', '*', '/', '(', ')'])) {
                $tokens[] = $char;
            }
        }
    }
    if ($number !== '') {
        $tokens[] = (float)$number;
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
        default:
            return 0;
    }
}

function applyOperator($a, $b, $operator) {
    switch ($operator) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            if ($b == 0) {
                throw new Exception("Division by zero");
            }
            return $a / $b;
        default:
            throw new Exception("Invalid operator");
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
        } elseif (in_array($token, ['+', '-', '*', '/', '(', ')'])) {
            while (!empty($operators) && 
                   getPrecedence(end($operators)) >= getPrecedence($token)) {
                $op = array_pop($operators);
                $b = array_pop($values);
                $a = array_pop($values);
                array_push($values, applyOperator($a, $b, $op));
            }
            array_push($operators, $token);
        }
        $index++;
    }
    while (!empty($operators)) {
        $op = array_pop($operators);
        $b = array_pop($values);
        $a = array_pop($values);
        array_push($values, applyOperator($a, $b, $op));
    }
    return $values[0];
}

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expression = isset($_POST['expression']) ? $_POST['expression'] : '';
    // Усиленная очистка строки
    $expression = preg_replace('/[\x00-\x1F\x7F-\xFF]/u', '', $expression);
    $expression = trim($expression, " \t\n\r\0\x0B\xC2\xA0");

    $validationResult = validateExpression($expression);
    if ($validationResult !== true) {
        // Логирование символов для диагностики
        $charDebug = 'Chars: ';
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
        echo "Error: " . $e->getMessage();
    }
    exit();
}
?>
