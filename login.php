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

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Перевірка пароля
        if (password_verify($password, $user['password'])) {
            // Якщо пароль правильний, зберігаємо сесію
            $_SESSION['user_id'] = $user['id'];  // Використовуємо ID користувача з бази даних
            $_SESSION['email'] = $email;
            
            // Перенаправлення на головну сторінку
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Неправильний пароль.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Користувача з таким email не знайдено.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід</title>
    <!-- Підключення Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Вхід на сайт</h2>
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100">Увійти</button>
                </form>
                <p class="text-center mt-3">Ще не маєш акаунту? <a href="register.php">Зареєструйся тут</a></p>
            </div>
        </div>
    </div>

    <!-- Підключення Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
