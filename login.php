<?php
session_start();
include 'config.php'; // Підключення до бази даних

// Перевірка, чи вже авторизовано
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Захист від SQL-ін'єкцій
    $email = mysqli_real_escape_string($conn, $email);

    // Запит до бази даних для перевірки користувача за email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Запит не вдалося виконати: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Перевірка пароля
        if (password_verify($password, $user['password'])) {
            // Якщо пароль правильний, зберігаємо сесію
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Перенаправлення на головну сторінку
            header("Location: index.php");
            exit();
        } else {
            echo "Неправильний пароль.";
        }
    } else {
        echo "Користувача з таким email не знайдено.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід</title>
</head>
<body>
    <h2>Вхід на сайт</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="login">Увійти</button>
    </form>
    <p>Ще не маєш акаунту? <a href="register.php">Зареєструйся тут</a></p>
</body>
</html>
