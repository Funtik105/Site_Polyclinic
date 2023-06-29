<?php

global $conn;
require "../PHP/connect.php";
session_start();
$id = $_SESSION['id'];

$query = "SELECT patient.full_name AS full_name, appointments.date, appointments.time, appointments.status
          FROM appointments 
          JOIN patient ON appointments.patient_id=patient.id
          WHERE appointments.doctor_id = ?";

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
        <li><a href="AboutDoctor.php">Личные данные</a></li>
        <li><a href="app_doctor.php"><u>Планирование визитов</u></a></li>
        <li class="logout"><a href="../PHP/logout.php">Выйти</a></li>
    </ul>
</div>

<header>
    <h1>Запланированные приемы</h1>
</header>

<main class="parent-element">
    <table>
        <thead>
        <tr>
            <th>ФИО пациента</th>
            <th>Дата приема</th>
            <th>Время приема</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>"; ?>
            <td>
                <a class="menu-button" onclick="openModal()" href="#"><?php echo $row['full_name'] ?></a>
            </td>
        <?php
            echo "<td>". $row['date']. "</td>";
            echo "<td>". $row['time']. "</td>";
            echo "<td>". $row['status']. "</td>";
        }
        ?>
        </tbody>
    </table>
</main>

<div id="modal" class="modal">
    <div id="add-student-form">
        <a href="#" onclick="closeModal()">
            <img src="../kres.jpg" class="close" id="close" style="width: 30px; height: 30px; float: right">
        </a>
        <label for="date">Диагноз:</label>
        <input type="text" name="diagnos" id="diaognos" required><br>
        <label for="date">Лечение:</label>
        <input type="text" name="diagnos" id="diaognos" required><br>
        <label for="date">Рецепт:</label>
        <input type="text" name="diagnos" id="diaognos" required><br>
        <button id="done" type="submit">Сохранить</button>
    </div>
</div>



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
<script>
    function openModal() {
        var modal = document.getElementById("modal");
        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById("modal");
        modal.style.display = "none";
    }
</script>
</body>
</html>
