<?php

global $conn;
require "../PHP/connect.php";

$result = mysqli_query($conn,"SELECT patient.Full_name AS Full_name, doctor.full_name AS
full_name, doctor.specialization, appointments.date, appointments.time, appointments.cabinet, appointments.status
FROM appointments JOIN patient ON appointments.patient_id = patient.patient_id JOIN doctor ON appointments.doctor_id = doctor.doctor_id WHERE patient.patient_id=1");

$pat = mysqli_query($conn, "SELECT * FROM `patient` WHERE patient_id=1");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $medical_card_id = 1;

    $sql = "INSERT INTO appointments (date, time) VALUSES ('$date', '$time', '$medical_card_id')";
    
}

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
        <li><a href="Records.php"><u>Мои записи</u></a></li>
        <li><a href="#">История болезни</a></li>
        <li><a href="#">Планирование визитов</a></li>
        <li><a href="#">Результаты анализов</a></li>
        <li class="logout"><a href="../PHP/logout.php">Выйти</a></li>
    </ul>
</div>

<header>
    <h1>Мои приемы</h1>
    <div class="add">
        <button id="menu-button">Добавить</button>
    </div>
</header>

<form method="post">
    <ul id="menu" class="menu">
        <div id="add-student-form">
            <a href="#">
                <img src="../kres.jpg" class="close" id="close" style="width: 30px; height: 30px; float: right">
            </a>

            <?php
            while($row = mysqli_fetch_assoc($pat)) {
            ?>
                <label for="name">ФИО:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['Full_name']; ?>" READONLY><br>
                <?php
            }
            ?>
            <label>Врач:</label>
            <select id="student-group" name="student-group">
                <option value="Группа 1">Иванов Александ Иванович</option>
                <option value="Группа 2">Горюнов Алесандр Сергеевич</option>
                <option value="Группа 3">Петров Сергей Генадьевич</option>
                <option value="Группа 4">Иванов Витилий Никитич</option>
                <option value="Группа 5">Иванов Константин Викторович</option>
            </select>
            <label for="date"><br>Дата:</label>
            <input type="date" id="date" name="date"><br>
            <label for="time">Время:</label>
            <select id="time" name="time">
                <option value="Группа 1">9:00</option>
                <option value="Группа 2">10:00</option>
                <option value="Группа 3">11:00</option>
                <option value="Группа 4">12:00</option>
                <option value="Группа 5">13:00</option>
            </select>
            <button id="done" type="submit">Сохранить</button>
        </div>
    </ul>
</form>

<main class="parent-element">
    <table>
        <thead>
        <tr>
            <th>ФИО пациента</th>
            <th>ФИО врача</th>
            <th>Специальность врача</th>
            <th>Дата приема</th>
            <th>Время приема</th>
            <th>Кабинет</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>". $row['Full_name']. "</td>";
            echo "<td>". $row['full_name']. "</td>";
            echo "<td>". $row['specialization']. "</td>";
            echo "<td>". $row['date']. "</td>";
            echo "<td>". $row['time']. "</td>";
            echo "<td>". $row['cabinet']. "</td>";
            echo "<td>". $row['status']. "</td>";
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
