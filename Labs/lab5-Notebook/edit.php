<?php
function displayEditForm($pdo) {
    $contactId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? 0;
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
            $stmt = $pdo->prepare("UPDATE contacts SET surname = ?, name = ?, patronymic = ?, gender = ?, birth_date = ?, phone = ?, address = ?, email = ?, comment = ? WHERE id = ?");
            $stmt->execute([$surname, $name, $patronymic, $gender, $birth_date, $phone, $address, $email, $comment, $id]);
            $message = '<div class="message success">Запись обновлена</div>';
        } catch (PDOException $e) {
            $message = '<div class="message error">Ошибка: запись не обновлена</div>';
        }
    }

    $stmt = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname, name");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($contactId === 0 && !empty($contacts)) {
        $contactId = $contacts[0]['id'];
    }

    $html = '<div class="contact-list">';
    foreach ($contacts as $contact) {
        $class = ($contact['id'] == $contactId) ? 'active' : '';
        $html .= '<a href="index.php?action=edit&id=' . $contact['id'] . '" class="' . $class . '">' . htmlspecialchars($contact['surname'] . ' ' . $contact['name']) . '</a>';
    }
    $html .= '</div>';

    $html .= $message;
    if ($contactId > 0) {
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$contactId]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($contact) {
            $html .= '<form method="POST" action="index.php?action=edit&id=' . $contactId . '">';
            $html .= '<input type="hidden" name="id" value="' . $contact['id'] . '">';
            $html .= '<label>Фамилия: <input type="text" name="surname" value="' . htmlspecialchars($contact['surname']) . '" required></label>';
            $html .= '<label>Имя: <input type="text" name="name" value="' . htmlspecialchars($contact['name']) . '" required></label>';
            $html .= '<label>Отчество: <input type="text" name="patronymic" value="' . htmlspecialchars($contact['patronymic']) . '"></label>';
            $html .= '<label>Пол: <select name="gender" required><option value="М"' . ($contact['gender'] == 'М' ? ' selected' : '') . '>М</option><option value="Ж"' . ($contact['gender'] == 'Ж' ? ' selected' : '') . '>Ж</option></select></label>';
            $html .= '<label>Дата рождения: <input type="date" name="birth_date" value="' . htmlspecialchars($contact['birth_date']) . '" required></label>';
            $html .= '<label>Телефон: <input type="text" name="phone" value="' . htmlspecialchars($contact['phone']) . '"></label>';
            $html .= '<label>Адрес: <textarea name="address">' . htmlspecialchars($contact['address']) . '</textarea></label>';
            $html .= '<label>Email: <input type="email" name="email" value="' . htmlspecialchars($contact['email']) . '"></label>';
            $html .= '<label>Комментарий: <textarea name="comment">' . htmlspecialchars($contact['comment']) . '</textarea></label>';
            $html .= '<button type="submit">Сохранить</button>';
            $html .= '</form>';
        }
    }

    return $html;
}
?>
