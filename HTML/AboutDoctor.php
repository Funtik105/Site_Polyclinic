<?php

global $conn;
require "../PHP/connect.php";
session_start();
$id = $_SESSION['id'];

$result = mysqli_query($conn, "SELECT doctor.id, doctor.full_name, doctor.email, doctor.number_phone,
doctor.specialization, doctor.date_birthday FROM doctor WHERE doctor.id = '$id'");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>UserHome</title>
    <link rel="stylesheet" href="../Styles/UserHome.css">
</head>
<body>
<a href="#">
    <img class="iconmenu" src="../iconmenu.png">
</a>
<div class="sidebar">
    <ul class="sidebar-menu">
        <li><a href="AboutDoctor.php"><u>Личные данные</u></a></li>
        <li><a href="app_doctor.php">Мои приемы</a></li>
        <li class="logout"><a href="../PHP/logout.php">Выйти</a></li>
    </ul>
</div>

<main>
    <form method="post">
        <?php
        while($row = mysqli_fetch_assoc($result)) {
        ?>
            <label for="Full_name">ФИО</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo $row['full_name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

            <label for="number_phone">Телефон:</label>
            <input type="tel" id="phone" name="number_phone" value="<?php echo $row['number_phone']; ?>">

            <label for="specialization">Специализация:</label>
            <input type="tel" id="specialization" name="specialization" value="<?php echo $row['specialization']; ?>" style="background-color: #E1E1E1FF">

            <label for="date_birthday">Дата рождения:</label>
            <input type="tel" id="date_birthday" name="date_birthday" value="<?php echo $row['date_birthday']; ?>">
            <?php
        }
        ?>

        <button name="save" type="submit">Сохранить</button>
        <button name="delete" type="submit" style="float: right">Удалить</button>

    </form>
</main>

<script>
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.iconmenu');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('active');
    });

</script>

</body>
</html>