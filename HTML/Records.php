<?php
    //SELECT appointments.date_appointments, appointments.status, doctor.full_name, doctor.specialization
    //FROM appointments
    //JOIN doctor ON appointments.doctor_id = doctor.id_doctor

$servername = "localhost"; // Имя сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "polyclinic"; // Имя базы данных

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
    die("Connection Failed". mysqli_connect_error());
}

$sql = "SELECT appointments.date_appointments, appointments.status, doctor.full_name, doctor.specialization".
    "FROM appointments".
    "JOIN doctor ON appointments.doctor_id = doctor.id_doctor";
$result = mysqli_query($conn, $sql);
?>




<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Records</title>
    <link rel="stylesheet" href="../Styles/Records.css">
</head>
<body>
<a href="#">
    <img class="iconmenu" src="../iconmenu.png">
</a>
<div class="sidebar">
    <ul class="sidebar-menu">
        <li><a href="AboutUser.php">Личные данные</a></li>
        <li><a href="#"><u>Мои записи</u></a></li>
        <li><a href="#">История болезни</a></li>
        <li><a href="#">Планирование визитов</a></li>
        <li><a href="#">Результаты анализов</a></li>
        <li class="logout"><a href="#">Выйти</a></li>
    </ul>
</div>

<h1>Мои приемы</h1>
<table>
    <tr>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
        ?>
        <th><?php echo $row['full_name']; ?></th>
        <th><?php echo $row['specialization']; ?></th>
        <th><?php echo $row['date_appointments']; ?></th>
        <th><?php echo $row['status']; ?></th>
            <?php
        }
        ?>
    </tr>
    <tr>
        <th>Врач</th>
        <th>Специальность</th>
        <th>Дата приема</th>
        <th>Статус</th>
    </tr>
</table>

<script>
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.iconmenu');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('active');
    });
</script>

</body>
</html>