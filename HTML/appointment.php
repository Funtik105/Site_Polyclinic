<?php

global $conn;
require "../PHP/connect.php";
session_start();
$id = $_SESSION['id'];

$doc = mysqli_query($conn, "SELECT full_name FROM doctor");

// Подготовленный SQL-запрос с параметром для идентификатора пациента
$query = "SELECT doctor.full_name AS full_name, doctor.specialization, appointments.date, appointments.time, shedule.cabinet, appointments.status 
          FROM appointments 
          JOIN doctor ON appointments.doctor_id = doctor.id 
          JOIN shedule ON appointments.doctor_id = shedule.doctor_id 
          WHERE appointments.patient_id = ? ORDER BY appointments.date";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();



?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>UserHome</title>
    <link rel="stylesheet" href="../Styles/appointment.css">
</head>
<body>
<a href="#">
    <img class="iconmenu" src="../iconmenu.png">
</a>
<div class="sidebar">
    <ul class="sidebar-menu">
        <li><a href="AboutUser.php">Личные данные</a></li>
        <li><a href="appointment.php"><u>Планирование визитов</u></a></li>
        <li><a href="Report.php">Мои приемы</a></li>
        <li><a href="#">История болезни</a></li>
        <li><a href="#">Результаты анализов</a></li>
        <li class="logout"><a href="../PHP/logout.php">Выйти</a></li>
    </ul>
</div>

<header>
    <h1>Планирование приемов</h1>
    <div class="add">
        <button id="menu-button">Добавить</button>
    </div>
</header>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$date = $_POST['date'];
$time = $_POST['time'];
$doctorId = $_POST['doctor'];

// Валидация данных формы (можете добавить свою собственную логику валидации)

// Здесь предполагается, что у вас есть переменная $conn, которая представляет соединение с базой данных.
    $status = "Запланировано";
// Добавление записи в таблицу appointments
$sql = "INSERT INTO appointments (doctor_id, patient_id, date, time, status) VALUES ('$doctorId', '$id', '$date', '$time', '$status')";

if ($conn->query($sql) === TRUE) {
    echo 'Запись на прием успешно создана';
    header('Location: ../HTML/appointment.php');
} else {
    echo 'Ошибка при выполнении запроса: ' . $conn->error;
    }
}
?>

<form method="post">
    <ul id="menu" class="menu">
        <div id="add-student-form">
            <a href="#">
                <img src="../kres.jpg" class="close" id="close" style="width: 30px; height: 30px; float: right">
            </a>
            <label for="doctor">Выберите врача:</label>
            <select name="doctor" id="doctor">
                <?php
                $docResult = mysqli_query($conn, "SELECT id, full_name FROM doctor");
                while ($row = mysqli_fetch_assoc($docResult)) {
                    echo '<option value="' . $row['id'] . '">' . $row['full_name'] . '</option>';
                }
                ?>
            </select>
            <br><label for="date">Выберите дату:</label>
            <input type="date" name="date" id="date" required><br>
            <label for="time">Выберите время:</label>
            <input type="time" name="time" id="time" required><br>
            <button id="done" type="submit">Сохранить</button>
        </div>
    </ul>
</form>

<main class="parent-element">
    <table>
        <thead>
        <tr>
            <th>ФИО врача</th>
            <th>Специальность врача</th>
            <th>Дата приема</th>
            <th>Время приема</th>
            <th>Статус</th>
            <th>Кабинет</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>". $row['full_name']. "</td>";
            echo "<td>". $row['specialization']. "</td>";
            echo "<td>". $row['date']. "</td>";
            echo "<td>". $row['time']. "</td>";
            echo "<td>". $row['status']. "</td>";
            echo "<td>". $row['cabinet']. "</td>";
        }
        ?>
        </tbody>
    </table>
</main>

<script>
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.iconmenu');

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('active');
    });

    var button = document.getElementById('menu-button');
    var menu = document.getElementById('menu');
    var CloseButton = document.getElementById('close');

    button.addEventListener('click', function () {
        menu.parentNode.classList.toggle('show-menu');
    });
    CloseButton.addEventListener('click', function () {
        menu.parentNode.classList.toggle('show-menu');
        if (isBlurApplied) {
            parentElement.style.filter = '';
            isBlurApplied = false;
        }
    });
    //---------------------------------------------------------------------------------------------------------------------
    const menuButton = document.getElementById('menu-button');
    const parentElement = document.querySelector('.parent-element');
    let isBlurApplied = false;

    menuButton.addEventListener('click', function () {
        if (isBlurApplied) {
            parentElement.style.filter = 'blur(3px)';
            isBlurApplied = false;
        } else {
            parentElement.style.filter = 'blur(3px)';
            isBlurApplied = true;
        }
    });

</script>
