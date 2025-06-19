<?php
// Установка кодировки для русского языка
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Логотип МосПолитеха">
        <h1> Домашняя работа: 4.1 (Форма обратной связи)</h1>
        <div></div>
    </header>
    <main>
        <?php
        // Обработка формы
        $errors = [];
        $success = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $type = $_POST['type'] ?? '';
            $message = trim($_POST['message'] ?? '');
            $response_sms = isset($_POST['response_sms']);
            $response_email = isset($_POST['response_email']);

            // Валидация
            if (empty($name)) {
                $errors[] = 'Введите имя';
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Введите корректный email';
            }
            if ($response_sms && empty($phone)) {
                $errors[] = 'Введите номер телефона для ответа по SMS';
            }
            if ($response_sms && !preg_match('/^\+?\d{10,15}$/', $phone)) {
                $errors[] = 'Введите корректный номер телефона';
            }
            if (empty($type)) {
                $errors[] = 'Выберите тип обращения';
            }
            if (empty($message)) {
                $errors[] = 'Введите текст обращения';
            }
            if (!$response_sms && !$response_email) {
                $errors[] = 'Выберите хотя бы один вариант ответа';
            }

           
            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'type' => $type,
                    'message' => $message,
                    'response_sms' => $response_sms,
                    'response_email' => $response_email
                ];

                $options = [
                    'http' => [
                        'header' => "Content-Type: application/json\r\n",
                        'method' => 'POST',
                        'content' => json_encode($data)
                    ]
                ];
                $context = stream_context_create($options);
                $result = file_get_contents('https://httpbin.org/post', false, $context);

                if ($result !== false) {
                    $success = true;
                } else {
                    $errors[] = 'Ошибка при отправке формы';
                }
            }
        }
        ?>

        <?php if ($success): ?>
            <p style="color: green;">Форма успешно отправлена!</p>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="name">Имя пользователя:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="email">E-mail пользователя:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона (для SMS):</label>
                <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="type">Тип обращения:</label>
                <select id="type" name="type">
                    <option value="">Выберите тип</option>
                    <option value="complaint" <?php echo (isset($_POST['type']) && $_POST['type'] === 'complaint') ? 'selected' : ''; ?>>Жалоба</option>
                    <option value="suggestion" <?php echo (isset($_POST['type']) && $_POST['type'] === 'suggestion') ? 'selected' : ''; ?>>Предложение</option>
                    <option value="gratitude" <?php echo (isset($_POST['type']) && $_POST['type'] === 'gratitude') ? 'selected' : ''; ?>>Благодарность</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Текст обращения:</label>
                <textarea id="message" name="message" rows="5"><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
            </div>
            <div class="checkbox-group">
                <label><input type="checkbox" name="response_sms" <?php echo isset($_POST['response_sms']) ? 'checked' : ''; ?>> Ответ по SMS</label>
                <label><input type="checkbox" name="response_email" <?php echo isset($_POST['response_email']) ? 'checked' : ''; ?>> Ответ по E-mail</label>
            </div>
            <button type="submit">Отправить</button>
        </form>
        <a href="headers.php">Перейти на страницу заголовков</a>
    </main>
    <footer>
        Задание для самостоятельной работы
    </footer>
</body>
</html>
