<?php
// Параметры подключения к базе данных
$servername = "localhost"; // адрес сервера MySQL
$username = "root"; // имя пользователя для подключения к MySQL
$password = ""; // пароль для подключения (обычно пустой)
$dbname = "ElegantLady"; // имя базы данных

// Создание подключения к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверка, что форма была отправлена методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $service = htmlspecialchars(trim($_POST['service']));
    $appointment_date = htmlspecialchars(trim($_POST['date']));

    // Проверка на заполнение всех полей
    if (!empty($name) && !empty($phone) && !empty($service) && !empty($appointment_date)) {
        // SQL-запрос для вставки данных в таблицу
        $sql = "INSERT INTO bookings (name, phone, service, appointment_date)
                VALUES ('$name', '$phone', '$service', '$appointment_date')";

        // Выполнение запроса и проверка результата
        if ($conn->query($sql) === TRUE) {
            // Перенаправление на главную страницу
            header("Location: index.html");
            exit(); // Обязательно добавляем exit после header()
        } else {
            echo "Ошибка: " . $conn->error;
        }
    } else {
        echo "Пожалуйста, заполните все поля.";
    }
}

// Закрываем подключение к базе данных
$conn->close();
?>
