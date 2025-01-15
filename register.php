<?php
// Підключення до бази даних
$servername = "localhost";
$username = "root"; // Замінити на свій логін MySQL
$password = ""; // Замінити на свій пароль MySQL
$dbname = "user_system"; // Назва бази даних

$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// Перевірка, чи була форма надіслана
if (isset($_POST['register'])) {
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Хешування пароля
    $initial_balance = 0.00; // Початковий баланс

    // Перевірка, чи вже існує користувач з таким email
    $sql_check = "SELECT * FROM users WHERE email='$user_email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "Користувач з такою електронною поштою вже існує.";
    } else {
        // Вставка нового користувача у базу даних
        $sql = "INSERT INTO users (username, email, password, balance) VALUES ('$user_name', '$user_email', '$user_password', '$initial_balance')";

        if ($conn->query($sql) === TRUE) {
            echo "Реєстрація успішна! Можете увійти.";
        } else {
            echo "Помилка: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
</head>
<body>
    <h2>Реєстрація користувача</h2>
    <form action="register.php" method="POST">
        <label for="username">Ім'я користувача:</label>
        <input type="text" name="username" required><br>

        <label for="email">Електронна пошта:</label>
        <input type="email" name="email" required><br>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required><br>

        <button type="submit" name="register">Зареєструватися</button>
    </form>
    <p>Вже маєш акаунт? <a href="login.php">Увійди тут</a></p>
</body>
</html>
