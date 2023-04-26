<?php
global $conn;
require "../PHP/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Выполнение запроса на выборку пользователя из базы данных
    $sql = "SELECT id, email, password FROM users WHERE email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        // Получение данных пользователя из результата запроса
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $stored_email = $row['email'];
        $stored_password = $row['password'];

        // Проверка, что введенный пароль соответствует хэшу пароля пользователя
        if (password_verify($password, $stored_password)) {
            // Начало сессии
            session_start();

            // Создание переменной сессии
            $_SESSION['user_id'] = $user_id;

            // Перенаправление на личный кабинет
            header('Location: ../HTML/AboutUser.php');
            exit;
        } else {
            echo 'Неправильный пароль';
        }
    } else {
        echo 'Пользователь с такой почтой не найден';
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма авторизации</title>
    <link rel="stylesheet" href="../Styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
</head>
<body>
<!---------------------------------------------------------------------------------------------------------------------->
<div class="container">
    <a href="Home.html"> <img src="../logo.png" alt="logo"></a>
    <h1>Добро пожаловать</h1>
    <h2>Войдите в свой<br>аккаунт</h2>
    <form method="post">
        <input type="email" id="email" name="email" placeholder="Введите почту" required>
        <input type="password" id="password" name="password" placeholder="Введите пароль" required>
        <button type="submit">Войти</button>
        <a class="opa_i" href="#">Забыли пароль?</a>
        <a class="opa_i" href="Registration.php">Ещё не зарегистрированы?</a>
    </form>
</div>
<!---------------------------------------------------------------------------------------------------------------------->
</body>
</html>