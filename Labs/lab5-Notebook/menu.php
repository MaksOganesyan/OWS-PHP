<?php
function generateMenu($activeAction, $activeSort) {
    $menuItems = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];

    $sortItems = [
        'created_at' => 'По дате добавления',
        'surname' => 'По фамилии',
        'birth_date' => 'По дате рождения'
    ];

    $html = '<div class="menu">';
    foreach ($menuItems as $action => $label) {
        $class = ($action === $activeAction) ? 'active' : '';
        $html .= '<a href="index.php?action=' . $action . '" class="' . $class . '">' . $label . '</a>';
    }

    if ($activeAction === 'view') {
        $html .= '<div class="sub-menu">';
        foreach ($sortItems as $sort => $label) {
            $class = ($sort === $activeSort) ? 'active' : '';
            $html .= '<a href="index.php?action=view&sort=' . $sort . '" class="' . $class . '">' . $label . '</a>';
        }
        $html .= '</div>';
    }

    $html .= '</div>';
    return $html;
}
?>
