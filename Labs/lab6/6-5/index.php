<?php
session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}
$seconds_ago = time() - $_SESSION['start_time'];
echo "Вы зашли на сайт $seconds_ago секунд назад.";
?>
