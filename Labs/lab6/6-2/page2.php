<?php
session_start();
echo "Содержимое сессии: " . (isset($_SESSION['message']) ? $_SESSION['message'] : 'Нет данных');
?>
