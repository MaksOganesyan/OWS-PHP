<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['country'])) {
    $_SESSION['country'] = $_POST['country'];
    echo "Страна сохранена. Перейдите на <a href='test.php'>test.php</a>";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Введите страну</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="country" placeholder="Введите страну" required>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>
