<?php

$servername = "localhost"; // Имя сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "polyclinic"; // Имя базы данных

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
    die("Connection Failed". mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM `doctor` WHERE id_doctor=1");

if(isset($_POST['save'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $number_phone = $_POST['number_phone'];
    $specialization = $_POST['specialization'];
    $date_birthday = $_POST['date_birthday'];

// Запрос на обновление данных в базе данных
    $sql = "UPDATE `patient` SET full_name='$full_name', email='$email', number_phone='$number_phone', specialization='$specialization', date_birthday='$date_birthday' WHERE id_patient=1";
    if (mysqli_query($conn, $sql)) {
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
        <li><a href="AboutUser.html"><u>Личные данные</u></a></li>
        <li><a href="Records.html">Мои записи</a></li>
        <li><a href="#">История болезни</a></li>
        <li><a href="#">Планирование визитов</a></li>
        <li><a href="#">Результаты анализов</a></li>
        <li class="logout"><a href="#">Выйти</a></li>
    </ul>
</div>

<main>
    <form method="post">
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            ?>
            <label for="Full_name">ФИО</label>
            <input type="text" id="Full_name" name="Full_name" value="<?php echo $row['full_name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

            <label for="number_phone">Телефон:</label>
            <input type="tel" id="phone" name="number_phone" value="<?php echo $row['number_phone']; ?>">

            <label for="specialization">Специализация:</label>
            <input type="text" id="specialization" name="specialization" value="<?php echo $row['specialization']; ?>" READONLY style="background-color: #E1E1E1FF">

            <label for="date_birthday">Дата рождения:</label>
            <input type="tel" id="date_birthday" name="date_birthday" value="<?php echo $row['date_birthday']; ?>">
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