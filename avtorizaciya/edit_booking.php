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

$id = $_GET['id']; // Получаем ID записи через GET

// Получение текущих данных записи
$sql = "SELECT * FROM bookings WHERE id = '$id'";
$result = $conn->query($sql);
$booking = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $service = htmlspecialchars(trim($_POST['service']));
    $appointment_date = htmlspecialchars(trim($_POST['appointment_date']));

    // Обновление записи
    $sql = "UPDATE bookings SET name = '$name', phone = '$phone', service = '$service', appointment_date = '$appointment_date' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать запись</title>
</head>
<body>
    <h2>Редактировать запись</h2>
    <form method="POST" action="edit_booking.php?id=<?php echo $id; ?>">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?php echo $booking['name']; ?>" required><br><br>

        <label for="phone">Номер телефона:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $booking['phone']; ?>" required><br><br>

        <label for="service">Услуга:</label>
        <input type="text" id="service" name="service" value="<?php echo $booking['service']; ?>" required><br><br>

        <label for="appointment_date">Дата и время:</label>
        <input type="datetime-local" id="appointment_date" name="appointment_date" value="<?php echo $booking['appointment_date']; ?>" required><br><br>

        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>
