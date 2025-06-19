<?php
session_start();
echo "Страна пользователя: " . (isset($_SESSION['country']) ? $_SESSION['country'] : 'Не указана');
?>
