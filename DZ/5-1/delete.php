<?php
function displayDeleteForm($pdo) {
    $message = '';
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $pdo->prepare("SELECT surname FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($contact) {
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->execute([$id]);
            $message = '<div class="message success">Запись с фамилией ' . htmlspecialchars($contact['surname']) . ' удалена</div>';
        }
    }

    $stmt = $pdo->query("SELECT id, surname, name, patronymic FROM contacts ORDER BY surname, name");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = $message;
    $html .= '<div class="contact-list">';
    foreach ($contacts as $contact) {
        // Формируем инициалы с использованием mb_substr для поддержки UTF-8
        $nameInitial = !empty($contact['name']) ? mb_substr($contact['name'], 0, 1, 'UTF-8') . '.' : '';
        $patronymicInitial = !empty($contact['patronymic']) ? mb_substr($contact['patronymic'], 0, 1, 'UTF-8') . '.' : '';
        $initials = $nameInitial . $patronymicInitial;
        $html .= '<a href="index.php?action=delete&id=' . $contact['id'] . '">' . htmlspecialchars($contact['surname'] . ' ' . $initials) . '</a>';
    }
    $html .= '</div>';

    return $html;
}
?>
