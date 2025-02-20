<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'] ?? null;
$name = "";
$email = "";
$phone = "";

// Если пользователь авторизован, получаем его данные из БД
if ($user_id) {
    $query = "SELECT name, email, phone FROM users WHERE ID_users = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $email = $user['email'];
        $phone = $user['phone'];
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $question = $_POST["question"];

    $query = "INSERT INTO questions (ID_users, name, email, phone, question) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("issss", $user_id, $name, $email, $phone, $question);
    $stmt->execute();
    $stmt->close();
    
    echo "<script>alert('Ваш вопрос успешно отправлен! Мы ответим в течение часа.');history.go(-1);</script>";
    exit();
}
mysqli_close($db);
?>