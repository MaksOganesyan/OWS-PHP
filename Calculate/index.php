<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .calculator-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            max-width: 300px;
            margin: 1rem auto;
        }
        .display {
            grid-column: span 4;
            text-align: right;
            padding: 0.5rem;
            font-size: 1.5rem;
        }
        button {
            padding: 1rem;
            font-size: 1.2rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }
        .error {
            grid-column: span 4;
            color: red;
            font-size: 0.9rem;
            text-align: center;
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <input type="text" id="display" class="display bg-gray-200 border border-gray-300 rounded" readonly>
        <div id="error" class="error"></div>
        <div class="calculator-grid">
            <button class="bg-red-500 text-white" onclick="clearDisplay()">C</button>
            <button class="bg-red-500 text-white" onclick="backspace()">◄</button>
            <button class="bg-blue-500 text-white" onclick="appendToDisplay('sin(')">sin</button>
            <button class="bg-blue-500 text-white" onclick="appendToDisplay('cos(')">cos</button>
            <button class="bg-blue-500 text-white" onclick="appendToDisplay('tan(')">tan</button>
            <button class="bg-blue-500 text-white" onclick="appendToDisplay('/')">/</button>
            <button class="bg-gray-300" onclick="appendToDisplay('7')">7</button>
            <button class="bg-gray-300" onclick="appendToDisplay('8')">8</button>
            <button class="bg-gray-300" onclick="appendToDisplay('9')">9</button>
            <button class="bg-blue-500 text-white" onclick="appendToDisplay('*')">*</button>
            <button class="bg-gray-300" onclick="appendToDisplay('4')">4</button>
            <button class="bg-gray-300" onclick="appendToDisplay('5')">5</button>
            <button class="bg-gray-300" onclick="appendToDisplay('6')">6</button>
            <button class="bg-blue-500 text-white" onclick="appendToDisplay('-')">-</button>
            <button class="bg-gray-300" onclick="appendToDisplay('1')">1</button>
            <button class="bg-gray-300" onclick="appendToDisplay('2')">2</button>
            <button class="bg-gray-300" onclick="appendToDisplay('3')">3</button>
            <button class="bg-blue-500 text-white" onclick="appendToDisplay('+')">+</button>
            <button class="bg-gray-300" onclick="appendToDisplay('0')">0</button>
            <button class="bg-gray-300" onclick="appendToDisplay('(')">(</button>
            <button class="bg-gray-300" onclick="appendToDisplay(')')">)</button>
            <button class="bg-gray-300 col-span-2" onclick="calculate()">=</button>
        </div>
    </div>

    <script>
        function appendToDisplay(value) {
            const display = document.getElementById('display');
            display.value += value;
            hideError();
        }

        function clearDisplay() {
            document.getElementById('display').value = '';
            hideError();
        }

        function backspace() {
            const display = document.getElementById('display');
            display.value = display.value.slice(0, -1);
            hideError();
        }

        function hideError() {
            const error = document.getElementById('error');
            error.style.display = 'none';
            error.textContent = '';
        }

        async function calculate() {
            const display = document.getElementById('display');
            const expression = display.value.trim();
            const error = document.getElementById('error');

            if (!expression) {
                display.value = 'Error: Empty expression';
                error.textContent = 'Expression: ';
                error.style.display = 'block';
                return;
            }

            // Простая проверка допустимых символов
            if (!/^[0-9+\-*\/\(\)a-zA-Z]+$/.test(expression)) {
                display.value = 'Error: Invalid characters';
                error.textContent = `Expression: ${expression}`;
                error.style.display = 'block';
                return;
            }

            try {
                const response = await fetch('calculate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'expression=' + encodeURIComponent(expression)
                });

                if (!response.ok) {
                    throw new Error('Server error');
                }

                const result = await response.text();
                if (result.startsWith('Error')) {
                    display.value = result;
                    error.textContent = `Expression: ${expression}`;
                    error.style.display = 'block';
                } else {
                    display.value = result;
                    hideError();
                }
            } catch (err) {
                display.value = 'Error: ' + err.message;
                error.textContent = `Expression: ${expression}`;
                error.style.display = 'block';
            }
        }

        // Загрузка начального выражения из calculate.php
        async function loadInitialExpression() {
            try {
                const response = await fetch('calculate.php');
                const result = await response.text();
                if (!result.startsWith('Error') && result.trim() !== '') {
                    document.getElementById('display').value = result;
                }
            } catch (err) {
                console.error('Failed to load initial expression:', err);
            }
        }

        // Вызов при загрузке страницы
        window.onload = loadInitialExpression;
    </script>
</body>
</html>
