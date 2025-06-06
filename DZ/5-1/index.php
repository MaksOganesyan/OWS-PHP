<?php
require_once 'database.php';
require_once 'menu.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <?php echo generateMenu($action, $sort); ?>
    </div>
    <?php
    if ($action === 'view') {
        require_once 'viewer.php';
        echo displayContacts($pdo, $sort, $page);
    } elseif ($action === 'add') {
        require_once 'add.php';
        echo displayAddForm($pdo);
    } elseif ($action === 'edit') {
        require_once 'edit.php';
        echo displayEditForm($pdo);
    } elseif ($action === 'delete') {
        require_once 'delete.php';
        echo displayDeleteForm($pdo);
    }
    ?>
</body>
</html>
