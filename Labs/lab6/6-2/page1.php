<?php
session_start();
$_SESSION['message'] = 'Привет с первой страницы!';
echo "Текст записан в сессию. Перейдите на <a href='page2.php'>page2.php</a>";
?>
