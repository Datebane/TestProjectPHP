<?php
session_start();
session_destroy(); // Знищуємо сесію
header("Location: login.php"); // Перенаправлення на сторінку входу
exit();
?>
