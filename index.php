<?php
session_start();
include 'config.php'; // Підключення до бази даних

// Перевірка, чи користувач авторизований
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

$user_id = $_SESSION['user_id'];

// Отримуємо баланс користувача з бази даних
$sql = "SELECT balance FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

// Перевіряємо, чи є результати
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $balance = $row['user_balance']; // Баланс користувача
} else {
    $balance = "Невідомо"; // Якщо щось пішло не так
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна</title>
</head>
<body>
    <h1>Ласкаво просимо, <?php echo $_SESSION['email']; ?>!</h1>
    <p>Це захищена сторінка для авторизованих користувачів.</p>
    <p>Ваш баланс: <?php echo $balance; ?> грн</p>
    <a href="logout.php">Вийти</a>
</body>
</html>
