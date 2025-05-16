<?php
session_start();



// Удаляем все переменные сессии
$_SESSION = [];

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на главную страницу или страницу входа
header("Location: http://localhost:5173/index.php");
exit();
?>