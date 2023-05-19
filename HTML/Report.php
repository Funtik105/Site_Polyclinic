<?php
global $conn;
require "../PHP/connect.php";
session_start();
$id = $_SESSION['id'];

$query = "SELECT appointments.date, doctor.full_name AS doctor_name, report.diagnos, report.description
          FROM appointments
          JOIN doctor ON appointments.doctor_id = doctor.id
          JOIN report ON appointments.id = report.appointment_id
          WHERE appointments.patient_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Страница отчетов о приемах</title>
    <link rel="stylesheet" href="../Styles/Report.css">
</head>
<body>
<a href="#">
    <img class="iconmenu" src="../iconmenu.png">
</a>
<div class="sidebar">
    <ul class="sidebar-menu">
        <li><a href="AboutUser.php">Личные данные</a></li>
        <li><a href="appointment.php">Планирование визитов</a></li>
        <li><a href="Report.php"><u>Мои приемы</u></a></li>
        <li><a href="#">История болезни</a></li>
        <li><a href="#">Результаты анализов</a></li>
        <li class="logout"><a href="../PHP/logout.php">Выйти</a></li>
    </ul>
</div>

<h1>Отчеты о приемах</h1>
<table>
    <tr>
        <th>Дата</th>
        <th>Лечащий врач</th>
        <th>Диагноз</th>
        <th>Лечение</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['doctor_name']; ?></td>
            <td><?php echo $row['diagnos']; ?></td>
            <td><?php echo $row['description']; ?></td>
        </tr>
    <?php } ?>
</table>

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

</body>
</html>
