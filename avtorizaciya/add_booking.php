<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ElegantLady";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $service = htmlspecialchars(trim($_POST['service']));
    $appointment_date = htmlspecialchars(trim($_POST['appointment_date']));

    // Проверка на заполнение всех полей
    if (!empty($name) && !empty($phone) && !empty($service) && !empty($appointment_date)) {
        // SQL-запрос для добавления новой записи
        $sql = "INSERT INTO bookings (name, phone, service, appointment_date)
                VALUES ('$name', '$phone', '$service', '$appointment_date')";

        if ($conn->query($sql) === TRUE) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Пожалуйста, заполните все поля.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить новую запись</title>
</head>
<body>
    <h2>Добавить новую запись</h2>
    <form method="POST" action="add_booking.php">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="phone">Номер телефона:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <script>
          document.addEventListener('DOMContentLoaded', function () {
              var phoneInput = document.getElementById('phone');
  
              phoneInput.addEventListener('input', function (e) {
                  var value = phoneInput.value.replace(/\D/g, ''); // Удаляем все нечисловые символы
                  var formattedValue = '+7 ';
  
                  if (value.length > 1) {
                      formattedValue += '(' + value.substring(1, 4);
                  }
                  if (value.length >= 5) {
                      formattedValue += ') ' + value.substring(4, 7);
                  }
                  if (value.length >= 8) {
                      formattedValue += '-' + value.substring(7, 9);
                  }
                  if (value.length >= 10) {
                      formattedValue += '-' + value.substring(9, 11);
                  }
  
                  phoneInput.value = formattedValue;
              });
  
              // Предварительно задаём маску при загрузке
              phoneInput.value = '+7 ';
          });
      </script>

        <label for="service">Услуга:</label>
        <select class="pole3" id="service" name="service" required>
                  <option value="стрижка">Парикмахерский отдел</option>
                  <option value="укладка">Массажный отдел</option>
                  <option value="маникюр">Косметологический отдел</option>
                  <option value="педикюр">Маникюрный отдел</option>
        </select><br><br>

        <label for="appointment_date">Дата и время:</label>
        <input type="datetime-local" id="appointment_date" name="appointment_date" required><br><br>

        <button type="submit">Добавить запись</button>
    </form>
</body>
</html>
