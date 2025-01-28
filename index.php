<?php
session_start();
include 'config.php'; // Підключення до бази даних

// Перевірка, чи користувач авторизований
if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];

    // Перевірка підключення до бази даних
    if ($conn === false) {
        die("Помилка підключення до бази даних: " . mysqli_connect_error());
    }

    // Підготовка та виконання SQL-запиту для отримання балансу
    $stmt = $conn->prepare("SELECT balance FROM users WHERE id = ?");
    if ($stmt) {
        // Прив'язуємо параметр $user_id
        $stmt->bind_param("i", $user_id);

        // Виконуємо запит
        $stmt->execute();

        // Отримуємо результат
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $balance = $row['balance'];
        } else {
            $balance = "Немає даних про баланс.";
        }

        // Закриваємо підготовлений запит
        $stmt->close();
    } else {
        die("Помилка підготовки SQL-запиту: " . $conn->error);
    }
} else {
    // Якщо користувач не авторизований
    $balance = "Ви не авторизовані.";
    $email = "Не вказано";
}

// Закриваємо з'єднання з базою даних
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна сторінка</title>
    <!-- Підключення Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Головна сторінка</h2>

                <div class="alert alert-info" role="alert">
                    <?php 
                    echo "Ласкаво просимо, " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "!"; 
                    ?>
                </div>
                <div class="alert alert-info" role="alert">
                    <?php 
                    echo "Ваш баланс: " . htmlspecialchars($balance, ENT_QUOTES, 'UTF-8') . " грн"; 
                    ?>
                </div>

                <p class="text-center mt-3">
                    <a href="logout.php" class="btn btn-danger w-100">Вийти</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Підключення Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
