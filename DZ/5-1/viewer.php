<?php
function displayContacts($pdo, $sort, $page) {
    $itemsPerPage = 10;
    $offset = ($page - 1) * $itemsPerPage;

    $validSorts = ['created_at', 'surname', 'birth_date'];
    $sort = in_array($sort, $validSorts) ? $sort : 'created_at';

    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY $sort ASC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $totalItems = $stmt->fetchColumn();
    $totalPages = ceil($totalItems / $itemsPerPage);

    $html = '<table>';
    $html .= '<tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th><th>Дата рождения</th><th>Телефон</th><th>Адрес</th><th>Email</th><th>Комментарий</th></tr>';

    foreach ($contacts as $contact) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($contact['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['patronymic']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['gender']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['birth_date']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['address']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['comment']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    if ($totalPages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $html .= '<a href="index.php?action=view&sort=' . $sort . '&page=' . $i . '">' . $i . '</a>';
        }
        $html .= '</div>';
    }

    return $html;
}
?>
