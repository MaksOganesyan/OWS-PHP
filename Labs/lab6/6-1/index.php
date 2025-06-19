<?php
session_start();
if (!isset($_SESSION['text'])) {
    $_SESSION['text'] = 'test';
}
echo "Содержимое сессии: " . $_SESSION['text'];
?>
