<?php

session_start();

// Удаление переменных сессии
session_unset();

// Уничтожение сессии
session_destroy();

// Перенаправление на страницу входа
header('Location: ../HTML/Autorization.php');
exit;
?>
