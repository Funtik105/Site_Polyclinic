<?php
global $conn;
session_start();
require "../PHP/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Проверка, что введенные пароли совпадают
    if ($password !== $confirm_password) {
        echo 'Пароли не совпадают';
        exit;
    }

    // Хэширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Выполнение запроса на добавление нового пользователя в базу данных
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

    $id = mysqli_insert_id($conn);
    $pat = "INSERT INTO patient (id, email) VALUES ('$id', '$email')";
    $med = "INSERT INTO medical_card (date_create) VALUES (NOW())";


    if ($conn->query($sql) === TRUE) {
        header('Location: ../HTML/Autorization.php');
    } else {
        echo 'Ошибка при выполнении запроса: ' . $conn->error;
    }

    if ($conn->query($pat) === TRUE) {
        header('Location: ../HTML/Autorization.php');
    } else {
        echo 'Ошибка при выполнении запроса: ' . $conn->error;
    }
    if ($conn -> query($med) === TRUE) {
    } else {
        "NO" . $conn -> error;
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
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
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Введите пароль повторно" required>
        <button name="reg" type="submit">Зарегистрироваться</button>
        <a class="opa_i" href="Autorization.php">Уже зарегистрированы?</a>
    </form>
</div>
<!---------------------------------------------------------------------------------------------------------------------->
</body>
</html>