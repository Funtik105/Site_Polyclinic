<?php

$servername = "localhost"; // Имя сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "polyclinic"; // Имя базы данных

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
    die("Connection Failed". mysqli_connect_error());
}
echo "Connected successfully";

$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$sql = "INSERT INTO `users` (email,password) VALUES ('$email', '$password')";

if ($password != $confirm_password) {
    echo "Пароли не совпадают" . $sql . "<br>" . mysqli_error($conn);
} else {
    if (mysqli_query($conn, $sql)) {
        echo "<br>New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<?php
$result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");

// Проверка, найдены ли данные пользователя в базе данных
if (mysqli_num_rows($result) == 1) {
    // Получение идентификатора пользователя из результата SQL-запроса
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];

    // Авторизация пользователя
    session_start();
    $_SESSION['user_id'] = $user_id;

    // Перенаправление пользователя на страницу, доступную только авторизованным пользователям
    header('Location: ');
} else {
    // Вывод сообщения об ошибке, если данные пользователя не найдены
    echo "Incorrect email or password";
}
?>
