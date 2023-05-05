<?php

global $conn;
require "../PHP/connect.php";

$result = mysqli_query($conn, "SELECT * FROM `patient` WHERE patient_id=1");

if(isset($_POST['save'])) {
    $Full_name = $_POST['Full_name'];
    $email = $_POST['email'];
    $number_phone = $_POST['number_phone'];
    $adress = $_POST['adress'];
    $number_polis = $_POST['number_polis'];

// Запрос на обновление данных в базе данных
    $sql = "UPDATE `patient` SET Full_name='$Full_name', email='$email', number_phone='$number_phone', adress='$adress', number_polis='$number_polis' WHERE patient_id=1";
    if (mysqli_query($conn, $sql)) {
        header('Location: ../HTML/AboutUser.php');
    } else {
        echo "Ошибка при обновлении данных: " . mysqli_error($conn);
    }
}

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
        <li><a href="AboutUser.php"><u>Личные данные</u></a></li>
        <li><a href="appointment.php">Мои записи</a></li>
        <li><a href="#">История болезни</a></li>
        <li><a href="#">Планирование визитов</a></li>
        <li><a href="#">Результаты анализов</a></li>
        <li class="logout"><a href="../PHP/logout.php">Выйти</a></li>
    </ul>
</div>

<main>
    <form method="post">
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <label for="Full_name">ФИО</label>
                <input type="text" id="Full_name" name="Full_name" value="<?php echo $row['Full_name']; ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

                <label for="number_phone">Телефон:</label>
                <input type="tel" id="phone" name="number_phone" value="<?php echo $row['number_phone']; ?>">

                <label for="adress">Адрес:</label>
                <textarea id="adress" name="adress"><?php echo $row['adress']; ?></textarea>

                <label for="number_card">Номер медицинской карты:</label>
                <input type="tel" id="number_card" name="number_card" value="<?php echo $row['number_card']; ?>" READONLY style="background-color: #E1E1E1FF">

                <label for="number_polis">Номер полиса:</label>
                <input type="tel" id="number_polis" name="number_polis" value="<?php echo $row['number_polis']; ?>">

                <label for="date_birthday">Дата рождения:</label>
                <input type="tel" id="date_birthday" name="date_birthday" value="<?php echo $row['date_birthday']; ?>">

                <label for="gender">Пол:</label>
                <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>">
        <?php
            }
        ?>
        <button name="save" type="submit">Сохранить</button>
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