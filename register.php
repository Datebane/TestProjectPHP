<?php
session_start();
include 'config.php'; // Підключення до бази даних

// Перевірка, чи вже авторизовано
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Захист від SQL-ін'єкцій
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);

    // Перевірка наявності користувача з таким email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='alert alert-danger' role='alert'>Користувач з таким email вже існує.</div>";
    } else {
        // Хешування пароля
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Запис нових даних користувача в базу
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            // Отримуємо останній вставлений ID
            $user_id = mysqli_insert_id($conn);

            // Зберігаємо сесію
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;

            // Перенаправлення на головну сторінку
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Сталася помилка при реєстрації. Спробуйте ще раз.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
    <!-- Підключення Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Реєстрація на сайт</h2>
                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Ім'я користувача:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Підтвердження пароля:</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                    </div>

                    <button type="submit" name="register" class="btn btn-primary w-100">Зареєструватися</button>
                </form>
                <p class="text-center mt-3">Вже маєш акаунт? <a href="login.php">Увійти</a></p>
            </div>
        </div>
    </div>

    <!-- Підключення Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
