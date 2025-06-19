<?php
function displayAddForm($pdo) {
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $surname = $_POST['surname'] ?? '';
        $name = $_POST['name'] ?? '';
        $patronymic = $_POST['patronymic'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $birth_date = $_POST['birth_date'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $email = $_POST['email'] ?? '';
        $comment = $_POST['comment'] ?? '';

        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (surname, name, patronymic, gender, birth_date, phone, address, email, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$surname, $name, $patronymic, $gender, $birth_date, $phone, $address, $email, $comment]);
            $message = '<div class="message success">Запись добавлена</div>';
        } catch (PDOException $e) {
            $message = '<div class="message error">Ошибка: запись не добавлена</div>';
        }
    }

    $html = $message;
    $html .= '<form method="POST" action="index.php?action=add">';
    $html .= '<label>Фамилия: <input type="text" name="surname" required></label>';
    $html .= '<label>Имя: <input type="text" name="name" required></label>';
    $html .= '<label>Отчество: <input type="text" name="patronymic"></label>';
    $html .= '<label>Пол: <select name="gender" required><option value="М">М</option><option value="Ж">Ж</option></select></label>';
    $html .= '<label>Дата рождения: <input type="date" name="birth_date" required></label>';
    $html .= '<label>Телефон: <input type="text" name="phone"></label>';
    $html .= '<label>Адрес: <textarea name="address"></textarea></label>';
    $html .= '<label>Email: <input type="email" name="email"></label>';
    $html .= '<label>Комментарий: <textarea name="comment"></textarea></label>';
    $html .= '<button type="submit">Добавить</button>';
    $html .= '</form>';

    return $html;
}
?>
