<?php
$servername = "localhost";
$username = "root"; // Заміни на свій логін для MySQL
$password = ""; // Заміни на свій пароль для MySQL
$dbname = "user_system"; // Заміни на ім'я твоєї бази даних

// Підключення до бази даних
// $conn = mysqli_connect($servername, $username, $password, $dbname);

// // Перевірка підключення
// if (!$conn) {
//     die("Помилка підключення: " . mysqli_connect_error());
// }
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Помилка підключення: " . mysqli_connect_error());
} else {
    echo "Підключення успішне!";
}

?>
