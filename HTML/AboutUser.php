<?php

global $conn;
require "../PHP/connect.php";
session_start();
$id = $_SESSION['id'];

//$result = mysqli_query($conn, "SELECT * FROM `patient` WHERE id='$id'");
$result = mysqli_query($conn, "SELECT patient.id, patient.full_name, patient.email, patient.adress, patient.number_phone,
patient.number_polis, patient.date_birthday, patient.gender FROM patient WHERE patient.id = '$id'");

if (isset($_POST['delete'])) {

    $rep = "DELETE report
        FROM report
        JOIN appointments ON report.appointment_id = appointments.id
        WHERE appointments.patient_id = '$id'";
    $rep_res = $conn->query($rep);
    // Удаление записей из связанных таблиц
    $app = "DELETE FROM appointments WHERE patient_id = '$id'";
    $app_res = $conn->query($app);

    // Удаление записей из таблицы patient
    $pat = "DELETE FROM patient WHERE id = '$id'";
    $pat_res = $conn->query($pat);

    // Удаление записей из таблицы users
    $user = "DELETE FROM users WHERE id = '$id'";
    $user_res = $conn->query($user);



    // Удаление записей из таблицы medical_card

    // Проверка результатов удаления
    if ($user_res === TRUE && $pat_res === TRUE && $app_res === TRUE && $rep_res === TRUE) {
        header('Location: ../HTML/Home.html');
    } else {
        echo "Ошибка при выполнении запроса: " . $conn->error;
    }
}

if(isset($_POST['save'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $number_phone = $_POST['number_phone'];
    $adress = $_POST['adress'];
    $number_polis = $_POST['number_polis'];
    $date_birthday = $_POST['date_birthday'];
    $gender = $_POST['gender'];

// Запрос на обновление данных в базе данных
    $sql = "UPDATE `patient` SET full_name='$full_name', email='$email', number_phone='$number_phone', adress='$adress', number_polis='$number_polis', date_birthday='$date_birthday', gender='$gender' WHERE id='$id'";
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
        <li><a href="appointment.php">Планирование визитов</a></li>
        <li><a href="Report.php">Мои приемы</a></li>
        <li><a href="#">История болезни</a></li>
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
                <input type="text" id="full_name" name="full_name" value="<?php echo $row['full_name']; ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

                <label for="number_phone">Телефон:</label>
                <input type="tel" id="phone" name="number_phone" value="<?php echo $row['number_phone']; ?>">

                <label for="adress">Адрес:</label>
                <textarea id="adress" name="adress"><?php echo $row['adress']; ?></textarea>


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